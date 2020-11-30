<?php

/**
 * @link https://www.neoacevedo.co
 * @copyright Copyright (c) 2018 Néstor Acevedo
 * @license https://www.neoacevedo.co/license
 */

namespace backend\controllers\cataloging;

use Yii;
use common\models\Biblio;
use common\models\BiblioSearch;
use yii\web\Controller;
use yii\filters\AccessControl;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;
use neoacevedo\yii2\Storage;

/**
 * BiblioController implements the CRUD actions for Biblio model.
 */
class BiblioController extends Controller
{

    /**
     *
     * @var \common\models\UsmarcSubfield 
     */
    private $usmarc = null;

    /**
     * @inheritdoc
     */
    public function behaviors()
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
                            if (\Yii::$app->user->can($route)) {
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
    public function actions()
    {
        \Yii::$app->language = \Yii::$app->request->getPreferredLanguage(Yii::$app->params['preferredLanguages']);
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
    public function actionIndex()
    {
        $searchModel = new BiblioSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        \Yii::$app->language = \Yii::$app->request->getPreferredLanguage(Yii::$app->params['preferredLanguages']);
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
    public function actionView(int $id)
    {
        \Yii::$app->language = \Yii::$app->request->getPreferredLanguage(Yii::$app->params['preferredLanguages']);
        return $this->render('view', [
                    'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Biblio model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Biblio();
        // este método es solo para crear los campos en el formulario
        $this->fillUsMarc();
        // Uploaded file instance.
        //$imageFile = UploadedFile::getInstance($model, 'image_file');
        $storage = new Storage([
            'service' => 'local',
            'config' => [
                'baseUrl' => Yii::$app->request->hostInfo, // ej: http://example.com/
                'directory' => '@frontend/web/images/covers/', // reemplace @webroot por @frontend o @backend según sea el caso
                'extensions' => 'png, jpg, jpeg'
            ]
        ]);
        $fileModel = $storage->getModel();
        $modelBiblioFields[] = new \common\models\BiblioField();
        for ($i = 1; $i < count($this->usmarc); $i++) {
            $modelBiblioFields[] = new \common\models\BiblioField();
        }
        \Yii::$app->language = \Yii::$app->request->getPreferredLanguage(Yii::$app->params['preferredLanguages']);
        if ($model->load(Yii::$app->request->post())) {
            if (null !== $fileModel->uploadedFile) {
                if ($storage->save()) {
                    $model->image_file = $storage->getUrl(Yii::$app->storage->prefix.$fileModel->uploadedFile->name);
                } else {
                    @array_walk_recursive($fileModel->errors, function($v, $k) {
                                Yii::$app->getSession()->setFlash('error', $v);
                            });
                }
            } else {
                @array_walk_recursive($fileModel->errors, function($v, $k) {
                            Yii::$app->getSession()->setFlash('error', $v);
                        });
            }
            if ($model->save()) {
                // file is uploaded successfully
                $materialType = \backend\models\MaterialType::find($model->material_cd)->one();
                $materialType->default_flg = 'Y';
                $materialType->save();
            } else {
                @array_walk_recursive($model->errors, function($v, $k) {
                            Yii::$app->getSession()->setFlash('error', $v);
                        });
                return $this->render('create', [
                            'model' => $model,
                            'modelBiblioFields' => $modelBiblioFields,
                            'usmarc' => $this->usmarc,
                            'fileModel' => $fileModel
                ]);
            }
            #$posts = Yii::$app->request->post('BiblioField', []);

            if ($this->createBiblioField($model->id, $modelBiblioFields)) {
                return $this->redirect(['view', 'id' => $model->id]);
            } else {
                return $this->render('create', [
                            'model' => $model,
                            'modelBiblioFields' => $modelBiblioFields,
                            'usmarc' => $this->usmarc,
                            'fileModel' => $fileModel
                ]);
            }
        } else {
            return $this->render('create', [
                        'model' => $model,
                        'modelBiblioFields' => $modelBiblioFields,
                        'usmarc' => $this->usmarc,
                        'fileModel' => $fileModel
            ]);
        }
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
            array_walk_recursive($modelBiblioField->errors, function($v, $k) {
                Yii::$app->getSession()->setFlash('error', $v);
            });
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
        // Uploaded file instance.
        //$imageFile = UploadedFile::getInstance($model, 'image_file');
        $storage = new Storage([
            'service' => 'local',
            'config' => [
                'directory' => '@frontend/web/images/covers/', // reemplace @webroot por @frontend o @backend según sea el caso
                'extensions' => 'png, jpg, jpeg'
            ]
        ]);
        $fileModel = $storage->getModel();
        $this->fillUsMarc();

        $modelBiblioFields[] = new \common\models\BiblioField();

        $materialType = \backend\models\MaterialType::find($model->material_cd)->one();
        if ($materialType->hasMany(Biblio::class, ['material_cd' => 'id'])->count() == 1) {
            $materialType->default_flg = 'N';
            $materialType->save();
        }
        \Yii::$app->language = \Yii::$app->request->getPreferredLanguage(Yii::$app->params['preferredLanguages']);
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {

            if (null !== $fileModel->uploadedFile) {
                if ($storage->save()) {
                    $model->image_file = $storage->getUrl(Yii::$app->storage->prefix.$fileModel->uploadedFile->name);
                } else {
                    @array_walk_recursive($fileModel->errors, function($v, $k) {
                                Yii::$app->getSession()->setFlash('error', $v);
                            });
                }
                if ($model->save()) {
                    $materialType = \backend\models\MaterialType::find($model->material_cd)->one();
                    $materialType->default_flg = 'Y';
                    $materialType->save();
                } else {
                    @array_walk_recursive($model->errors, function($v, $k) {
                                Yii::$app->getSession()->setFlash('error', $v);
                            });
                    return $this->render('create', [
                                'model' => $model,
                                'modelBiblioFields' => $modelBiblioFields,
                                'usmarc' => $this->usmarc,
                                'fileModel' => $fileModel
                    ]);
                }
            } else {
                $model->image_file = $current_image_file;
                if ($model->save()) {
                    $materialType = \backend\models\MaterialType::find($model->material_cd)->one();
                    $materialType->default_flg = 'Y';
                    $materialType->save();
                } else {
                    @array_walk_recursive($model->errors, function($v, $k) {
                                Yii::$app->getSession()->setFlash('error', $v);
                            });
                    return $this->render('create', [
                                'model' => $model,
                                'modelBiblioFields' => $modelBiblioFields,
                                'usmarc' => $this->usmarc,
                                'fileModel' => $fileModel
                    ]);
                }
            }

            // crear la lista con todos los modelos bibliofield
            for ($i = 1; $i < count($this->usmarc); $i++) {
                $modelBiblioFields[] = new \common\models\BiblioField();
            }
            #$posts = Yii::$app->request->post('BiblioField', []);

            if ($this->createBiblioField($model->id, $modelBiblioFields)) {
                return $this->redirect(['view', 'id' => $model->id]);
            } else {
                return $this->render('update', [
                            'model' => $model,
                            'modelBiblioFields' => $modelBiblioFields,
                            'usmarc' => $this->usmarc,
                            'fileModel' => $fileModel
                ]);
            }

            #return $this->redirect(['view', 'id' => $model->id]);
        } else {
            //dentro del for, buscar si existe un bibliofield con el id de biblio y con el tag del campo marc y asignarlo.
            for ($i = 1; $i < count($this->usmarc); $i++) {
                $biblioField = \common\models\BiblioField::findOne(['bibid' => $id,
                            "tag" => $this->usmarc[$i]->tag, "subfield_cd" => $this->usmarc[$i]->subfield_cd]);
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
                        'fileModel' => $fileModel
            ]);
        }
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
    private function fillUsMarc()
    {
        $this->usmarc = null;
        $this->usmarc = \common\models\UsmarcSubfield::find()
                        ->where(["tag" => 100, "subfield_cd" => "a"])
                        ->orWhere(["tag" => 650, "subfield_cd" => "a"])
                        ->orWhere(["tag" => 250, "subfield_cd" => "a"])
                        ->orWhere(["tag" => 10, "subfield_cd" => 'a'])
                        ->orWhere(["tag" => 20, "subfield_cd" => "a"])
                        ->orWhere(["tag" => 50, "subfield_cd" => ['a', 'b', 'c']])
                        ->orWhere(["tag" => 82, "subfield_cd" => ['a', '2']])
                        ->orWhere(["tag" => 260, "subfield_cd" => ['a', 'b', 'c']])
                        ->orWhere(["tag" => 520, "subfield_cd" => 'a'])
                        ->orWhere(["tag" => 300, "subfield_cd" => ['a', 'b', 'c',
                                'e']])
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
