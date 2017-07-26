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

    private $usmarc = null;

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
        // este método es solo para crear los campos en el formulario
        $this->fillUsMarc();

        $modelBiblioFields[] = new \app\models\BiblioField();
        for ($i = 1; $i < count($this->usmarc); $i++) {
            $modelBiblioFields[] = new \app\models\BiblioField();
        }

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            $materialType = \backend\models\MaterialType::find($model->material_cd)->one();
            $materialType->default_flg = 'Y';
            $materialType->save();
            #$posts = Yii::$app->request->post('BiblioField', []);

            if ($this->createBiblioField($model->id, $modelBiblioFields)) {
                return $this->redirect(['view', 'id' => $model->id]);
            } else {

                return $this->render('create', [
                            'model' => $model,
                            'modelBiblioFields' => $modelBiblioFields,
                            'usmarc' => $this->usmarc
                ]);
            }
        } else {
            return $this->render('create', [
                        'model' => $model,
                        'modelBiblioFields' => $modelBiblioFields,
                        'usmarc' => $this->usmarc
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
    private function createBiblioField($bibid, $models) {
        $i = 1; // fieldid
        $modelBiblioField = \app\models\BiblioField::findAll(['bibid' => $bibid]);
        if (count($modelBiblioField) > 0) {
            \app\models\BiblioField::deleteAll(['bibid' => $bibid]);
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
            Yii::$app->session->setFlash("error", implode("<br />", $models->errors));
        }

        return false;
    }

    /**
     * Updates an existing Biblio model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id) {
        $model = $this->findModel($id);

        $this->fillUsMarc();

        $modelBiblioFields[] = new \app\models\BiblioField();

        $materialType = \backend\models\MaterialType::find($model->material_cd)->one();
        if ($materialType->hasMany(Biblio::className(), ['material_cd' => 'id'])->count() == 1) {
            $materialType->default_flg = 'N';
            $materialType->save();
        }

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            $materialType = \backend\models\MaterialType::find($model->material_cd)->one();
            $materialType->default_flg = 'Y';
            $materialType->save();
            // crear la lista con todos los modelos bibliofield
            for ($i = 1; $i < count($this->usmarc); $i++) {
                $modelBiblioFields[] = new \app\models\BiblioField();
            }
            #$posts = Yii::$app->request->post('BiblioField', []);

            if ($this->createBiblioField($model->id, $modelBiblioFields)) {
                return $this->redirect(['view', 'id' => $model->id]);
            } else {
                return $this->render('update', [
                            'model' => $model,
                            'modelBiblioFields' => $modelBiblioFields,
                            'usmarc' => $this->usmarc
                ]);
            }

            #return $this->redirect(['view', 'id' => $model->id]);
        } else {
            //dentro del for, buscar si existe un bibliofield con el id de biblio y con el tag del campo marc y asignarlo.
            for ($i = 1; $i < count($this->usmarc); $i++) {
                $biblioField = \app\models\BiblioField::findOne(['bibid' => $id, "tag" => $this->usmarc[$i]->tag, "subfield_cd" => $this->usmarc[$i]->subfield_cd]);
                if ($biblioField !== null) {
                    $modelBiblioFields[] = $biblioField;
                } else {
                    $modelBiblioFields[] = new \app\models\BiblioField();
                }
            }
            return $this->render('update', [
                        'model' => $model,
                        'modelBiblioFields' => $modelBiblioFields,
                        'usmarc' => $this->usmarc
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

    private function fillUsMarc() {
        $this->usmarc = null;
        $this->usmarc = \backend\models\UsmarcSubfield::find()
                        ->where(["tag" => 100, "subfield_cd" => "a"])
                        ->orWhere(["tag" => 650, "subfield_cd" => "a"])
                        ->orWhere(["tag" => 250, "subfield_cd" => "a"])
                        ->orWhere(["tag" => 10, "subfield_cd" => 'a'])
                        ->orWhere(["tag" => 20, "subfield_cd" => "a"])
                        ->orWhere(["tag" => 50, "subfield_cd" => ['a', 'b', 'c']])
                        ->orWhere(["tag" => 82, "subfield_cd" => ['a', '2']])
                        ->orWhere(["tag" => 260, "subfield_cd" => ['a', 'b', 'c']])
                        ->orWhere(["tag" => 520, "subfield_cd" => 'a'])
                        ->orWhere(["tag" => 300, "subfield_cd" => ['a', 'b', 'c', 'e']])
                        ->orWhere(["tag" => 541, "subfield_cd" => 'h'])->all();
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
