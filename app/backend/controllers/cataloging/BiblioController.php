<?php

/**
 * @copyright Copyright (c) 2020 Néstor Acevedo
 * 
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program.  If not, see <http://www.gnu.org/licenses/>.
 */

namespace backend\controllers\cataloging;

use Yii;
use common\models\Biblio;
use common\models\BiblioSearch;
use yii\web\Controller;
use yii\filters\AccessControl;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\Response;
use yii\web\UploadedFile;
use neoacevedo\yii2\Storage;
use common\models\MaterialType;
use backend\models\Collection;
use common\models\UsmarcSubfield;

/**
 * BiblioController implements the CRUD actions for Biblio model.
 */
class BiblioController extends Controller
{
    /** @var \common\models\UsmarcSubfield[] */
    private $usmarc;

    /**
     * @inheritdoc
     */
    public function behaviors(): array
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'rules' => [
                    [
                        'actions' => ['login', 'error'],
                        'allow' => true,
                    ],
                    [
                        'allow' => true,
                        'roles' => ['@'],
                        'matchCallback' => function () {
                            $action = Yii::$app->controller->action->id;
                            $controller = Yii::$app->controller->id;
                            $route = "$controller/$action";
                            $roles = (array) Yii::$app->authManager->getRolesByUser(\Yii::$app->user->getId());
                            if (array_key_exists("admin", $roles)) {
                                return true;
                            }
                            //$post = Yii::$app->request->post();
                            if (Yii::$app->user->can($route)) {
                                return true;
                            }
                        },
                    ],
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@']
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Gestión de errores
     * @return mixed
     */
    public function actions(): array
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
        ];
    }

    /**
     * Lists all Biblio models.
     * @return mixed
     */
    public function actionIndex(): string
    {
        $searchModel = new BiblioSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        // \Yii::$app->language = \Yii::$app->request->getPreferredLanguage(Yii::$app->params['preferredLanguages']);
        #if (\Yii::$app->user->can('view')) {
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
        #}
    }

    /**
     * Displays a single Biblio model.
     * @param integer $id
     * @return mixed
     */
    public function actionView(int $id): string
    {
        // \Yii::$app->language = \Yii::$app->request->getPreferredLanguage(Yii::$app->params['preferredLanguages']);
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Registra el material bibliográfico.
     * Primero llena los atributos USMarc del controlador, asigna el tipo de material
     * y luego realiza el registro.
     * @return string|\yii\web\Response
     */
    public function actionCreate(): string|Response
    {
        $model = new Biblio();
        // este método es solo para crear los campos en el formulario
        $this->usmarc = $this->getUsMarc();
        // Uploaded file instance.
        $fileModel = Yii::$app->storage->getFileManager();

        Yii::$app->storage->prefix .= "covers/";

        $modelBiblioFields[] = new \common\models\BiblioField();

        for ($i = 1; $i < count($this->usmarc); $i++) {
            $modelBiblioFields[] = new \common\models\BiblioField();
        }
        // \Yii::$app->language = \Yii::$app->request->getPreferredLanguage(Yii::$app->params['preferredLanguages']);
        if ($model->load(Yii::$app->request->post())) {
            if (null !== $fileModel->uploadedFile) {
                if (Yii::$app->storage->save($fileModel)) {
                    $model->image_file = Yii::$app->storage->getUrl(Yii::$app->storage->prefix . $fileModel->uploadedFile->name);
                } else {
                    $message = "<ul>";
                    foreach ($fileModel->errors as $key => $error) {
                        $message .= "<li>{$error[0]}</li>";
                    }
                    $message .= "</ul>";

                    Yii::$app->session->setFlash('error', $message);
                }
            } else {
                $message = "<ul>";
                foreach ($fileModel->errors as $key => $error) {
                    $message .= "<li>{$error[0]}</li>";
                }
                $message .= "</ul>";

                Yii::$app->session->setFlash('error', $message);
            }
            if ($model->save()) {
                // file is uploaded successfully
                $materialType = MaterialType::find()->where(['id' => $model->material_cd])->one();
                $materialType->default_flg = 'Y';
                $materialType->save();
            } else {
                $message = "<ul>";
                foreach ($model->errors as $key => $error) {
                    $message .= "<li>{$error[0]}</li>";
                }
                $message .= "</ul>";

                Yii::$app->session->setFlash('error', $message);
            }

            if ($this->createBiblioField($model->id, $modelBiblioFields)) {
                return $this->redirect(['view', 'id' => $model->id]);
            }
        }

        return $this->render('create', [
            'model' => $model,
            'modelBiblioFields' => $modelBiblioFields,
            'usmarc' => $this->usmarc,
            'fileModel' => $fileModel,
            'materialType' => MaterialType::find()->all(),
            'collection' => Collection::find()->all()
        ]);
    }

    /**
     * Registra el material bibliográfico, usando los datos de uno existente.
     * @param int $id ID del material original.
     * @return string|Response
     */
    public function actionCreateFromThis(int $id): Response|string
    {
        $model = new Biblio();

        // este método es solo para crear los campos en el formulario
        $this->usmarc = $this->getUsMarc();
        // Uploaded file instance.
        $fileModel = Yii::$app->storage->getFileManager();

        Yii::$app->storage->prefix .= "covers/";

        $modelBiblioFields[] = new \common\models\BiblioField();

        for ($i = 1; $i < count($this->usmarc); $i++) {
            $modelBiblioFields[] = new \common\models\BiblioField();
        }
        // \Yii::$app->language = \Yii::$app->request->getPreferredLanguage(Yii::$app->params['preferredLanguages']);
        if ($model->load(Yii::$app->request->post())) {
            if (null !== $fileModel->uploadedFile) {
                if (Yii::$app->storage->save($fileModel)) {
                    $model->image_file = Yii::$app->storage->getUrl(Yii::$app->storage->prefix . $fileModel->uploadedFile->name);
                } else {
                    $message = "<ul>";
                    foreach ($fileModel->errors as $key => $error) {
                        $message .= "<li>{$error[0]}</li>";
                    }
                    $message .= "</ul>";

                    Yii::$app->session->setFlash('error', $message);
                }
            } else {
                $message = "<ul>";
                foreach ($fileModel->errors as $key => $error) {
                    $message .= "<li>{$error[0]}</li>";
                }
                $message .= "</ul>";

                Yii::$app->session->setFlash('error', $message);
            }
            if ($model->save()) {
                // file is uploaded successfully
                $materialType = MaterialType::find()->where(['id' => $model->material_cd])->one();
                $materialType->default_flg = 'Y';
                $materialType->save();
            } else {
                $message = "<ul>";
                foreach ($model->errors as $key => $error) {
                    $message .= "<li>{$error[0]}</li>";
                }
                $message .= "</ul>";

                Yii::$app->session->setFlash('error', $message);
            }

            if ($this->createBiblioField($model->id, $modelBiblioFields)) {
                return $this->redirect(['view', 'id' => $model->id]);
            }
        }

        $model->load($this->findModel($id)->getAttributes(null, ['id', 'created_at', 'updated_at']), '');
        if (!$model->validate()) {
            $message = "<ul>";
            foreach ($model->errors as $key => $error) {
                $message .= "<li>{$error[0]}</li>";
            }
            $message .= "</ul>";

            Yii::$app->session->setFlash('error', $message);
        }

        return $this->render('create', [
            'model' => $model,
            'modelBiblioFields' => $modelBiblioFields,
            'usmarc' => $this->usmarc,
            'fileModel' => $fileModel,
            'materialType' => MaterialType::find()->all(),
            'collection' => Collection::find()->all()
        ]);
    }

    /**
     * Importa masivamente datos de un archivo CSV para crear modelos BiblioField.
     * If creation is successful, the browser will be redirected to the 'index' page.
     * @return mixed
     */
    public function actionBulkCreate(): Response|string
    {
        $models = [];
        if ($this->request->isPost) {
            $importer = UploadedFile::getInstanceByName('usmarc_data');
            if ($importer !== null) {
                $handle = fopen($importer->tempName, "r");
                $fieldId = \common\models\BiblioField::find()->orderBy(["fieldid" => SORT_DESC])->one()->fieldid + 1 ?? 1;
                if ($this->request->post("test") == 0) {
                    while (($fileop = fgetcsv($handle, 0, ",")) !== false) {
                        $biblio = new Biblio();
                        $biblio->material_cd = $this->request->post('material_cd');
                        $biblio->collection_cd = $this->request->post('collection_cd');
                        $biblio->call_nmbr1 = @$fileop[0];
                        $biblio->call_nmbr2 = @$fileop[1];
                        $biblio->call_nmbr3 = @$fileop[2];
                        $biblio->opac_flg = $this->request->post('opac_flg', 0);
                        $biblio->title = @$fileop[3];
                        $biblio->title_remainder = @$fileop[4];
                        $biblio->responsibility_stmt = @$fileop[5];
                        $biblio->author = @$fileop[6];
                        $biblio->topic1 = @$fileop[7];
                        $biblio->topic2 = @$fileop[8];
                        $biblio->topic3 = @$fileop[9];
                        $biblio->topic4 = @$fileop[10];
                        $biblio->topic5 = @$fileop[11];

                        if (!$biblio->validate()) {
                            $message = "<ul>";
                            foreach ($biblio->errors as $key => $error) {
                                $message .= "<li>{$error[0]}</li>";
                            }
                            $message .= "</ul>";

                            Yii::$app->session->setFlash('error', $message);
                            break;
                        }

                        if (!$biblio->save()) {
                            $message = "<ul>";
                            foreach ($biblio->errors as $key => $error) {
                                $message .= "<li>{$error[0]}</li>";
                            }
                            $message .= "</ul>";

                            Yii::$app->session->setFlash('error', $message);
                            break;
                        }

                        if (array_key_exists(12, $fileop)) {
                            $marc_data = explode("|", $fileop[12]);
                            /** @var UsmarcSubfield */
                            $usmarc_subfield = UsmarcSubfield::find()
                                ->where(["tag" => $marc_data[0], "subfield_cd" => $marc_data[3]])->one();
                            $model = new \common\models\BiblioField();
                            $model->bibid = $biblio->id;
                            $model->fieldid = $fieldId;
                            $model->tag = $marc_data[0];
                            $model->ind1_cd = $marc_data[1];
                            $model->ind2_cd = $marc_data[2];
                            $model->subfield_cd = $usmarc_subfield->subfield_cd;
                            $model->field_data = $marc_data[4];

                            if (!$model->validate()) {
                                $message = "<ul>";
                                foreach ($model->errors as $key => $error) {
                                    $message .= "<li>{$error[0]}</li>";
                                }
                                $message .= "</ul>";

                                Yii::$app->session->setFlash('error', $message);
                                break;
                            }

                            if (!$model->save()) {
                                $message = "<ul>";
                                foreach ($model->errors as $key => $error) {
                                    $message .= "<li>{$error[0]}</li>";
                                }
                                $message .= "</ul>";

                                Yii::$app->session->setFlash('error', $message);
                                break;
                            }
                        }

                        if (array_key_exists(13, $fileop)) {
                            $marc_data = explode("|", $fileop[13]);
                            /** @var UsmarcSubfield */
                            $usmarc_subfield = UsmarcSubfield::find()
                                ->where(["tag" => $marc_data[0], "subfield_cd" => $marc_data[3]])->one();
                            $model = new \common\models\BiblioField();
                            $model->bibid = $biblio->id;
                            $model->fieldid = $fieldId;
                            $model->tag = $marc_data[0];
                            $model->ind1_cd = $marc_data[1];
                            $model->ind2_cd = $marc_data[2];
                            $model->subfield_cd = $usmarc_subfield->subfield_cd;
                            $model->field_data = $marc_data[4];

                            if (!$model->validate()) {
                                $message = "<ul>";
                                foreach ($model->errors as $key => $error) {
                                    $message .= "<li>{$error[0]}</li>";
                                }
                                $message .= "</ul>";

                                Yii::$app->session->setFlash('error', $message);
                                break;
                            }

                            if (!$model->save()) {
                                $message = "<ul>";
                                foreach ($model->errors as $key => $error) {
                                    $message .= "<li>{$error[0]}</li>";
                                }
                                $message .= "</ul>";

                                Yii::$app->session->setFlash('error', $message);
                                break;
                            }
                        }

                        if (array_key_exists(14, $fileop)) {
                            $marc_data = explode("|", $fileop[14]);
                            /** @var UsmarcSubfield */
                            $usmarc_subfield = UsmarcSubfield::find()
                                ->where(["tag" => $marc_data[0], "subfield_cd" => $marc_data[3]])->one();
                            $model = new \common\models\BiblioField();
                            $model->bibid = $biblio->id;
                            $model->fieldid = $fieldId;
                            $model->tag = $marc_data[0];
                            $model->ind1_cd = $marc_data[1];
                            $model->ind2_cd = $marc_data[2];
                            $model->subfield_cd = $usmarc_subfield->subfield_cd;
                            $model->field_data = $marc_data[4];

                            if (!$model->validate()) {
                                $message = "<ul>";
                                foreach ($model->errors as $key => $error) {
                                    $message .= "<li>{$error[0]}</li>";
                                }
                                $message .= "</ul>";

                                Yii::$app->session->setFlash('error', $message);
                                break;
                            }

                            if (!$model->save()) {
                                $message = "<ul>";
                                foreach ($model->errors as $key => $error) {
                                    $message .= "<li>{$error[0]}</li>";
                                }
                                $message .= "</ul>";

                                Yii::$app->session->setFlash('error', $message);
                                break;
                            }
                        }

                        if (array_key_exists(15, $fileop)) {
                            $marc_data = explode("|", $fileop[15]);
                            /** @var UsmarcSubfield */
                            $usmarc_subfield = UsmarcSubfield::find()
                                ->where(["tag" => $marc_data[0], "subfield_cd" => $marc_data[3]])->one();
                            $model = new \common\models\BiblioField();
                            $model->bibid = $biblio->id;
                            $model->fieldid = $fieldId;
                            $model->tag = $marc_data[0];
                            $model->ind1_cd = $marc_data[1];
                            $model->ind2_cd = $marc_data[2];
                            $model->subfield_cd = $usmarc_subfield->subfield_cd;
                            $model->field_data = $marc_data[4];

                            if (!$model->validate()) {
                                $message = "<ul>";
                                foreach ($model->errors as $key => $error) {
                                    $message .= "<li>{$error[0]}</li>";
                                }
                                $message .= "</ul>";

                                Yii::$app->session->setFlash('error', $message);
                                break;
                            }

                            if (!$model->save()) {
                                $message = "<ul>";
                                foreach ($model->errors as $key => $error) {
                                    $message .= "<li>{$error[0]}</li>";
                                }
                                $message .= "</ul>";

                                Yii::$app->session->setFlash('error', $message);
                                break;
                            }
                        }

                        if (array_key_exists(16, $fileop)) {
                            $marc_data = explode("|", $fileop[16]);
                            /** @var UsmarcSubfield */
                            $usmarc_subfield = UsmarcSubfield::find()
                                ->where(["tag" => $marc_data[0], "subfield_cd" => $marc_data[3]])->one();
                            $model = new \common\models\BiblioField();
                            $model->bibid = $biblio->id;
                            $model->fieldid = $fieldId;
                            $model->tag = $marc_data[0];
                            $model->ind1_cd = $marc_data[1];
                            $model->ind2_cd = $marc_data[2];
                            $model->subfield_cd = $usmarc_subfield->subfield_cd;
                            $model->field_data = $marc_data[4];

                            if (!$model->validate()) {
                                $message = "<ul>";
                                foreach ($model->errors as $key => $error) {
                                    $message .= "<li>{$error[0]}</li>";
                                }
                                $message .= "</ul>";

                                Yii::$app->session->setFlash('error', $message);
                                break;
                            }

                            if (!$model->save()) {
                                $message = "<ul>";
                                foreach ($model->errors as $key => $error) {
                                    $message .= "<li>{$error[0]}</li>";
                                }
                                $message .= "</ul>";

                                Yii::$app->session->setFlash('error', $message);
                                break;
                            }
                        }
                    }
                    Yii::$app->session->setFlash('success', Yii::t("cataloging", "Data imported successfully."));
                    return $this->redirect(['index']);
                } else {
                    while (($fileop = fgetcsv($handle, 0, ",")) !== false) {
                        $biblio = [];
                        $biblio['material_cd'] = $this->request->post('material_cd');
                        $biblio['collection_cd'] = $this->request->post('collection_cd');
                        $biblio['call_nmbr1'] = @$fileop[0];
                        $biblio['call_nmbr2'] = @$fileop[1];
                        $biblio['call_nmbr3'] = @$fileop[2];
                        $biblio['opac_flg'] = $this->request->post('opac_flg', 0);
                        $biblio['title'] = @$fileop[3];
                        $biblio['title_remainder'] = @$fileop[4];
                        $biblio['responsibility_stmt'] = @$fileop[5];
                        $biblio['author'] = @$fileop[6];
                        $biblio['topic1'] = @$fileop[7];
                        $biblio['topic2'] = @$fileop[8];
                        $biblio['topic3'] = @$fileop[9];
                        $biblio['topic4'] = @$fileop[10];
                        $biblio['topic5'] = @$fileop[11];

                        $model = new Biblio($biblio);

                        if (!$model->validate()) {
                            $message = "<ul>";
                            foreach ($model->errors as $key => $error) {
                                $message .= "<li>{$error[0]}</li>";
                            }
                            $message .= "</ul>";

                            Yii::$app->session->setFlash('error', $message);
                            break;
                        }

                        $biblio['material_cd'] = MaterialType::findOne($this->request->post('material_cd'))->description;
                        $biblio['collection_cd'] = Collection::findOne($this->request->post('collection_cd'))->description;

                        if (array_key_exists(12, $fileop)) {
                            $marc_data = explode("|", $fileop[12]);
                            /** @var UsmarcSubfield */
                            $usmarc_subfield = UsmarcSubfield::find()
                                ->where(["tag" => $marc_data[0], "subfield_cd" => $marc_data[3]])->one();
                            $biblio['usmarc'] = [];
                            $biblio['usmarc'][0]['tag'] = $marc_data[0];
                            $biblio['usmarc'][0]['ind1_cd'] = $marc_data[1];
                            $biblio['usmarc'][0]['ind2_cd'] = $marc_data[2];
                            $biblio['usmarc'][0]['subfield_cd'] = $usmarc_subfield->subfield_cd;
                            $biblio['usmarc'][0]['field_data'] = $marc_data[4];

                            // if (!$biblio->biblioFields[0]->validate()) {
                            //     $message = "<ul>";
                            //     foreach ($biblio->biblioFields[0]->errors as $key => $error) {
                            //         $message .= "<li>{$error[0]}</li>";
                            //     }
                            //     $message .= "</ul>";

                            //     Yii::$app->session->setFlash('error', $message);
                            //     break;
                            // }
                        }

                        if (array_key_exists(13, $fileop)) {
                            $marc_data = explode("|", $fileop[13]);
                            /** @var UsmarcSubfield */
                            $usmarc_subfield = UsmarcSubfield::find()
                                ->where(["tag" => $marc_data[0], "subfield_cd" => $marc_data[3]])->one();
                            $biblio['usmarc'][1]['tag'] = $marc_data[0];
                            $biblio['usmarc'][1]['ind1_cd'] = $marc_data[1];
                            $biblio['usmarc'][1]['ind2_cd'] = $marc_data[2];
                            $biblio['usmarc'][1]['subfield_cd'] = $usmarc_subfield->subfield_cd;
                            $biblio['usmarc'][1]['field_data'] = $marc_data[4];
                        }

                        if (array_key_exists(14, $fileop)) {
                            $marc_data = explode("|", $fileop[14]);
                            /** @var UsmarcSubfield */
                            $usmarc_subfield = UsmarcSubfield::find()
                                ->where(["tag" => $marc_data[0], "subfield_cd" => $marc_data[3]])->one();
                            $biblio['usmarc'][1]['tag'] = $marc_data[0];
                            $biblio['usmarc'][1]['ind1_cd'] = $marc_data[1];
                            $biblio['usmarc'][1]['ind2_cd'] = $marc_data[2];
                            $biblio['usmarc'][1]['subfield_cd'] = $usmarc_subfield->subfield_cd;
                            $biblio['usmarc'][1]['field_data'] = $marc_data[4];
                        }

                        if (array_key_exists(15, $fileop)) {
                            $marc_data = explode("|", $fileop[15]);
                            /** @var UsmarcSubfield */
                            $usmarc_subfield = UsmarcSubfield::find()
                                ->where(["tag" => $marc_data[0], "subfield_cd" => $marc_data[3]])->one();
                            $biblio['usmarc'][1]['tag'] = $marc_data[0];
                            $biblio['usmarc'][1]['ind1_cd'] = $marc_data[1];
                            $biblio['usmarc'][1]['ind2_cd'] = $marc_data[2];
                            $biblio['usmarc'][1]['subfield_cd'] = $usmarc_subfield->subfield_cd;
                            $biblio['usmarc'][1]['field_data'] = $marc_data[4];
                        }

                        if (array_key_exists(16, $fileop)) {
                            $marc_data = explode("|", $fileop[16]);
                            /** @var UsmarcSubfield */
                            $usmarc_subfield = UsmarcSubfield::find()
                                ->where(["tag" => $marc_data[0], "subfield_cd" => $marc_data[3]])->one();
                            $biblio['usmarc'][1]['tag'] = $marc_data[0];
                            $biblio['usmarc'][1]['ind1_cd'] = $marc_data[1];
                            $biblio['usmarc'][1]['ind2_cd'] = $marc_data[2];
                            $biblio['usmarc'][1]['subfield_cd'] = $usmarc_subfield->subfield_cd;
                            $biblio['usmarc'][1]['field_data'] = $marc_data[4];
                        }

                        array_push($models, $biblio);
                    }
                }
            } else {
                Yii::$app->session->setFlash('error', "Error");
            }
        }

        $arrayDataProvider = new \yii\data\ArrayDataProvider([
            'allModels' => $models,
        ]);

        $searchAttributes = ['material_cd', 'collection_cd', 'title', 'title_remainder'];
        $searchModel = [];
        $searchColumns = [];

        foreach ($searchAttributes as $searchAttribute) {
            $filterName = $searchAttribute;
            $filterValue = Yii::$app->request->getQueryParam($filterName, '');
            $searchModel[$searchAttribute] = $filterValue;
            $searchColumns[] = [
                'attribute' => $searchAttribute,
                'filter' => '<input class="form-control" name="' . $filterName . '" value="' . $filterValue . '" type="text">',
                'value' => $searchAttribute,
            ];
            $models = array_filter($models, function ($item) use ($filterValue, $searchAttribute) {
                return strlen($filterValue) > 0 ? stripos('/^' . strtolower($item[$searchAttribute]) . '/', strtolower($filterValue)) : true;
            });

            Yii::debug($models);
        }

        return $this->render('bulk-create', ['dataProvider' => $arrayDataProvider, 'searchModel' => $searchModel, 'searchColumns' => $searchColumns]);
    }

    /**
     * Borra los registros si los hay de la tabla BiblioField de acuerdo al id del
     * campo bibid el cual es la relación con la tabla Biblio y procede a crear nuevos
     * para ese mismo modelo.
     * @param int $bibid
     * @param mixed $models
     * @return boolean
     */
    private function createBiblioField(int $bibid, $models)
    {
        $i = 1; // fieldid
        $modelBiblioField = \common\models\BiblioField::findAll(['bibid' => $bibid]);
        if (count($modelBiblioField) > 0) {
            \common\models\BiblioField::deleteAll(['bibid' => $bibid]);
        }
        if (\yii\base\Model::loadMultiple($models, Yii::$app->request->post())) {
            foreach ($models as $model) {
                if ($model->field_data !== '') {
                    $model->bibid = $bibid;
                    $model->fieldid = $i;
                    $model->save(false);
                    $i++;
                }
            }
            return true;
        } else {
            $message = "<ul>";
            foreach ($modelBiblioField as $biblioField) {
                foreach ($biblioField->errors as $error) {
                    $message .= "<li>{$error[0]}</li>";
                }
            }

            $message .= "</ul>";

            Yii::$app->session->setFlash('error', $message);
        }

        return false;
    }

    /**
     * Updates an existing Biblio model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate(int $id)
    {
        $model = $this->findModel($id);
        $current_image_file = $model->image_file;

        $fileModel = Yii::$app->storage->getFileManager();
        Yii::$app->storage->prefix .= "covers/";

        $this->usmarc = $this->getUsMarc();

        $modelBiblioFields[] = new \common\models\BiblioField();

        $materialType = MaterialType::find()->where(['id' => $model->material_cd])->one();
        if ($materialType->hasMany(Biblio::class, ['material_cd' => 'id'])->count() == 1) {
            $materialType->default_flg = 'N';
            $materialType->save();
        }
        // Yii::$app->language = \Yii::$app->request->getPreferredLanguage(Yii::$app->params['preferredLanguages']);
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if (null !== $fileModel->uploadedFile) {
                if (Yii::$app->storage->save($fileModel)) {
                    $model->image_file = Yii::$app->storage->getUrl(Yii::$app->storage->prefix . $fileModel->uploadedFile->name);
                } else {
                    array_walk_recursive(Yii::$app->storage->errors, function ($v, $k) {
                        Yii::$app->session->setFlash('error', $v);
                    });
                }
                if ($model->save()) {
                    $materialType = MaterialType::find()->where(['id' => $model->material_cd])->one();
                    $materialType->default_flg = 'Y';
                    $materialType->save();
                } else {
                    @array_walk_recursive($model->errors, function ($v, $k) {
                        Yii::$app->session->setFlash('error', $v);
                    });
                }
            } else {
                $model->image_file = $current_image_file;
                if ($model->save()) {
                    $materialType = MaterialType::find()->where(['id' => $model->material_cd])->one();
                    $materialType->default_flg = 'Y';
                    $materialType->save();
                } else {
                    @array_walk_recursive($model->errors, function ($v, $k) {
                        Yii::$app->session->setFlash('error', $v);
                    });
                }
            }

            // crear la lista con todos los modelos bibliofield
            for ($i = 1; $i < count($this->usmarc); $i++) {
                $modelBiblioFields[] = new \common\models\BiblioField();
            }
            #$posts = Yii::$app->request->post('BiblioField', []);

            if ($this->createBiblioField($model->id, $modelBiblioFields)) {
                return $this->redirect(['view', 'id' => $model->id]);
            }

            #return $this->redirect(['view', 'id' => $model->id]);
        }

        //dentro del for, buscar si existe un bibliofield con el id de biblio y con el tag del campo marc y asignarlo.
        for ($i = 1; $i < count($this->usmarc); $i++) {
            $biblioField = \common\models\BiblioField::findOne([
                'bibid' => $id,
                "tag" => $this->usmarc[$i]->tag,
                "subfield_cd" => $this->usmarc[$i]->subfield_cd
            ]);
            if ($biblioField !== null) {
                $modelBiblioFields[] = $biblioField;
            } else {
                $modelBiblioFields[] = new \common\models\BiblioField();
            }
        }

        return $this->render('update', [
            'model' => $model,
            'modelBiblioFields' => $modelBiblioFields,
            'usmarc' => $this->usmarc,
            'fileModel' => $fileModel,
            'materialType' => MaterialType::find()->all(),
            'collection' => Collection::find()->all()
        ]);
    }

    /**
     * Deletes an existing Biblio model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete(int $id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Llena el atributo @usmarc del controlador.
     *
     * Estos son los datos adicionales "básicos" de la bibliografía.
     */
    private function getUsMarc()
    {
        return \common\models\UsmarcSubfield::find()
            ->where(["tag" => 100, "subfield_cd" => "a"])
            ->orWhere(["tag" => 650, "subfield_cd" => "a"])
            ->orWhere(["tag" => 250, "subfield_cd" => "a"])
            ->orWhere(["tag" => 10, "subfield_cd" => 'a'])
            ->orWhere(["tag" => 20, "subfield_cd" => "a"])
            ->orWhere(["tag" => 50, "subfield_cd" => ['a', 'b', 'c']])
            ->orWhere(["tag" => 82, "subfield_cd" => ['a', '2']])
            ->orWhere(["tag" => 260, "subfield_cd" => ['a', 'b', 'c']])
            ->orWhere(["tag" => 520, "subfield_cd" => 'a'])
            ->orWhere([
                "tag" => 300,
                "subfield_cd" => [
                    'a',
                    'b',
                    'c',
                    'e'
                ]
            ])
            ->orWhere(["tag" => 541, "subfield_cd" => 'h'])->all();
    }

    /**
     * Finds the Biblio model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Biblio the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel(int $id)
    {
        if (($model = Biblio::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
