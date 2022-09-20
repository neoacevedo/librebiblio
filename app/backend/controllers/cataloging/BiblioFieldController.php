<?php

/**
 * @link https://www.neoacevedo.co
 * @copyright Copyright (c) 2020 Néstor Acevedo
 * @license https://www.neoacevedo.co/license
 */

namespace backend\controllers\cataloging;

use Yii;
use yii\filters\AccessControl;
use common\models\BiblioField;
use common\models\BiblioFieldSearch;
use common\models\Usmarc;
use yii\db\Expression;
use yii\db\Query;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;

/**
 * BiblioFieldController implements the CRUD actions for BiblioField model.
 */
class BiblioFieldController extends Controller
{
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
                        //'actions' => ['index', 'view', 'create', 'update', 'delete'],
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
        // \Yii::$app->language = \Yii::$app->request->getPreferredLanguage(Yii::$app->params['preferredLanguages']);
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
        ];
    }

    /**
     * Lists all BiblioField models.
     * @return mixed
     */
    public function actionIndex($bibid)
    {
        $searchModel = new BiblioFieldSearch();
        $model = \common\models\Biblio::findOne($bibid);
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        // \Yii::$app->language = \Yii::$app->request->getPreferredLanguage(Yii::$app->params['preferredLanguages']);
        return $this->render('index', [
            'model' => $model,
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single BiblioField model.
     * @param integer $bibid
     * @param integer $fieldid
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($bibid, $fieldid)
    {
        // \Yii::$app->language = \Yii::$app->request->getPreferredLanguage(Yii::$app->params['preferredLanguages']);
        return $this->render('view', [
            'model' => $this->findModel($bibid, $fieldid),
        ]);
    }

    /**
     * Creates a new BiblioField model.
     * If creation is successful, the browser will be redirected to the 'index' page.
     * @param integer $bibid
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new BiblioField();
        // $marcBlocks = (new Query())
        //     ->select([
        //         "{{%usmarc_block_dm}}.block_mbr",
        //         "{{%usmarc_block_dm}}.description as block_description",
        //         "{{%usmarc_tag_dm}}.tag",
        //         "{{%usmarc_tag_dm}}.description as tag_description",
        //         "{{%usmarc_subfield_dm}}.subfield_cd",
        //         "{{%usmarc_subfield_dm}}.description as subfield_description",
        //     ])
        //     ->from(["{{%usmarc_block_dm}}", "{{%usmarc_tag_dm}}", "{{%usmarc_subfield_dm}}"])
        //     ->where([
        //         "{{%usmarc_tag_dm}}.block_nmbr" => new Expression("{{%usmarc_block_dm}}.block_mbr"),
        //         "{{%usmarc_subfield_dm}}.tag" => new Expression("{{%usmarc_tag_dm}}.tag")
        //         ])
        //     ->all();

        $marcBlocks = Usmarc::find()->all();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['index']);
        } else {
            if ($model->errors) {
                $message = "<ul>";
                foreach ($model->errors as $key => $error) {
                    $message .= "<li>{$error[0]}</li>";
                }
                $message .= "</ul>";

                Yii::$app->session->setFlash('error', $message);
            }
        }
        // \Yii::$app->language = \Yii::$app->request->getPreferredLanguage(Yii::$app->params['preferredLanguages']);
        return $this->render('create', [
            'model' => $model, 'marcBlocks' => $marcBlocks
        ]);
    }

    /**
     * Importa masivamente datos de un archivo CSV para crear modelos BiblioField.
     * If creation is successful, the browser will be redirected to the 'index' page.
     * @return mixed
     */
    public function actionBulkCreate()
    {
        if (($importer = UploadedFile::getInstanceByName('usmarc_data')) !== null) {
            $handle = fopen($importer, "r");
            while (($fileop = fgetcsv($handle, 0, ",")) !== false) {
                $model = new \common\models\BiblioField();
                $model->bibid = $fileop[0];
                $model->fieldid = $fileop[1];
                $model->ind1_cd = $fileop[2];
                $model->ind2_cd = $fileop[3];
                $model->subfield_cd = $fileop[4];
                $model->field_data = $fileop[4];

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
            Yii::$app->session->setFlash('success', Yii::t("cataloging", "Data imported successfully."));
            return $this->redirect(['index']);
        }

        return $this->render('bulk-create');
    }

    /**
     * Updates an existing BiblioField model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $bibid
     * @param integer $fieldid
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($bibid, $fieldid)
    {
        $model = $this->findModel($bibid, $fieldid);
        $biblio = \common\models\Biblio::findOne($bibid);
        $marcBlocks = \common\models\Usmarc::find()->all();
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect([
                'index',
                'bibid' => $model->bibid
            ]);
        }
        // \Yii::$app->language = \Yii::$app->request->getPreferredLanguage(Yii::$app->params['preferredLanguages']);
        return $this->render('update', [
            'model' => $model,
            'biblio' => $biblio,
            'marcBlocks' => $marcBlocks
        ]);
    }

    /**
     * Deletes an existing BiblioField model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $bibid
     * @param integer $fieldid
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($bibid, $fieldid)
    {
        $this->findModel($bibid, $fieldid)->delete();

        return $this->redirect(['cataloging/biblio/view', 'index' => $bibid]);
    }

    public function actionUsmarcTagsOptions(int $block)
    {
        $usmarTags = \common\models\UsmarcTagDm::findAll(['block_nmbr' => $block]);
        if (count($usmarTags) > 0) {
            foreach ($usmarTags as $tag) {
                echo "<option value='{$tag->tag}'>{$tag->description}</option>";
            }
        } else {
            echo "<option value=''>" . Yii::t('app', 'No results found.') . "</option>";
        }
    }

    public function actionUsmarcSubfieldsOptions(int $tag)
    {
        $usmarcSubfields = \common\models\UsmarcSubfield::findAll(['tag' => $tag]);
        if (count($usmarcSubfields) > 0) {
            foreach ($usmarcSubfields as $sf) {
                echo "<option value='{$sf->subfield_cd}'>{$sf->description}</option>";
            }
        } else {
            echo "<option value=''>" . Yii::t('app', 'No results found.') . "</option>";
        }
    }

    /**
     * Finds the BiblioField model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $bibid
     * @param integer $fieldid
     * @return BiblioField the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($bibid, $fieldid = null)
    {
        if ($fieldid !== null) {
            if (($model = BiblioField::findOne(['bibid' => $bibid, 'fieldid' => $fieldid])) !== null) {
                return $model;
            }
        } else {
            if (($model = BiblioField::findOne(['bibid' => $bibid])) !== null) {
                return $model;
            }
        }

        throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
    }
}
