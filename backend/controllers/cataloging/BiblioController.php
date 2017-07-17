<?php

namespace backend\controllers\cataloging;

use Yii;
use common\models\Biblio;
use common\models\BiblioSearch;
use yii\web\Controller;
use yii\filters\AccessControl;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * BiblioController implements the CRUD actions for Biblio model.
 */
class BiblioController extends Controller {

    /**
     * @inheritdoc
     */
    public function behaviors() {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'actions' => ['login', 'error'],
                        'allow' => true,
                    ],
                    [
                        'actions' => ['index', 'view', 'create', 'update', 'delete'],
                        'allow' => true,
                        'roles' => ['@'],
                        'matchCallback' => function ($action) {
                            #$roles = \Yii::$app->authManager->getRolesByUser(\Yii::$app->user->getId());
                            if (Yii::$app->user->can('view') || Yii::$app->user->can('create') || Yii::$app->user->can('update') || Yii::$app->user->can('delete')) {
                                return true;
                            }
                            return false;
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
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all Biblio models.
     * @return mixed
     */
    public function actionIndex() {
        $searchModel = new BiblioSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        \Yii::$app->language = \Yii::$app->request->getPreferredLanguage(['es-CO', 'es-ES', 'en-GB']);
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
    public function actionView($id) {
        return $this->render('view', [
                    'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Biblio model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate() {
        $model = new Biblio();
        // este modelo es solo para crear los campos en el formulario
        $modelBiblioField = new \app\models\BiblioField();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            $materialType = \backend\models\MaterialType::find($model->material_cd)->one();
            $materialType->default_flg = 'Y';
            $materialType->save();
            $posts = Yii::$app->request->post('BiblioField', []);
            for ($i = 0; $i < count($posts); $i++) {
                $biblioFields[] = new \app\models\BiblioField();
            }

            if ($this->createBiblioField($model->id, $biblioFields, $posts)) {
                return $this->redirect(['view', 'id' => $model->id]);
            } else {
                return $this->render('create', [
                            'model' => $model,
                            'modelBiblioField' => $modelBiblioField
                ]);
            }
        } else {
            return $this->render('create', [
                        'model' => $model,
                        'modelBiblioField' => $modelBiblioField
            ]);
        }
    }

    /**
     * Borra los registros si los hay de la tabla BiblioField de acuerdo al id del 
     * campo bibid el cual es la relación con la tabla Biblio y procede a crear nuevos 
     * para ese mismo modelo.
     * @param int $bibid
     * @param mixed $models
     * @param mixed $posts
     * @return boolean
     */
    private function createBiblioField($bibid, $models, $posts) {
       /*foreach ($models as $model) {
            foreach ($posts as $key => $value) {
                $model->$key = $value;
        }
        
        if (\yii\base\Model::loadMultiple($models, $posts) &&
                \yii\base\Model::validateMultiple($models)) {
            foreach ($models as $model) {
                // populate and save records for each model
                $model->bibid = $bibid;
            if (!$model->save()) {
                foreach ($model->errors as $error) {
                    $msg .= implode(", ", $error) . "<br />";
            }
                Yii::$app->session->setFlash("error", $msg);
                return false;
        }
        }*/
        $array = [];
        for ($i = 0; $i < count($posts); $i++) {
            if($posts["field_data"][$i] != "") {
                $array["BiblioField"][$i]['bibid'] = $bibid;
                $array["BiblioField"][$i]['field_data'] = $posts["field_data"][$i];
                $array["BiblioField"][$i]['tag'] = $posts["tag"][$i];
                $array["BiblioField"][$i]['subfield_cd'] = $posts["subfield_cd"][$i];
                $array["BiblioField"][$i]['fieldid'] = $posts["fieldid"][$i];
                $array["BiblioField"][$i]['ind1_cd'] = $posts["ind1_cd"][$i];
                $array["BiblioField"][$i]['ind2_cd'] = $posts["ind2_cd"][$i];
            }
        }
        $modelBiblioField = \app\models\BiblioField::findAll(['bibid' => $bibid]);
        if (count($modelBiblioField) > 0) {
            \app\models\BiblioField::deleteAll(['bibid' => $bibid]);
        }
        if (\yii\base\Model::loadMultiple($models, $array)) {
            foreach ($models as $model) {
                // populate and save records for each model
                if(!$model->save()) {
                    Yii::trace(var_export($model->errors));
                }
            }
        }

        return true;
    }

    /**
     * Updates an existing Biblio model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id) {
        $model = $this->findModel($id);
        $modelBiblioField = \app\models\BiblioField::findOne(['bibid' => $id]);
        if ($modelBiblioField === null) {
            $modelBiblioField = new \app\models\BiblioField();
        }
        $materialType = \backend\models\MaterialType::find($model->material_cd)->one();
        if ($materialType->hasMany(Biblio::className(), ['material_cd' => 'id'])->count() == 1) {
            $materialType->default_flg = 'N';
            $materialType->save();
        }
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            $materialType = \backend\models\MaterialType::find($model->material_cd)->one();
            $materialType->default_flg = 'Y';
            $materialType->save();
            $posts = Yii::$app->request->post('BiblioField', []);
            for ($i = 0; $i < count($posts); $i++) {
                #if (\yii\base\Model::loadMultiple($biblioFields, Yii::$app->request->post('BiblioField', []))) {
                $biblioFields[] = new \app\models\BiblioField();
            }
            if ($this->createBiblioField($model->id, $biblioFields, $posts)) {
                return $this->redirect(['view', 'id' => $model->id]);
            } else {
                return $this->render('update', [
                            'model' => $model,
                            'modelBiblioField' => $modelBiblioField
                ]);
            }

            #return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('update', [
                        'model' => $model,
                        'modelBiblioField' => $modelBiblioField
            ]);
        }
    }

    /**
     * Deletes an existing Biblio model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id) {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Biblio model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Biblio the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id) {
        if (($model = Biblio::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

}
