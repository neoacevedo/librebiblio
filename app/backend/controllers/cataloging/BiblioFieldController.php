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

use common\models\Biblio;
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
                            $roles = (array) Yii::$app->authManager->getRolesByUser(Yii::$app->user->getId());
                            if (array_key_exists("admin", $roles)) {
                                return true;
                            }
                            //$post = Yii::$app->request->post();
                            return Yii::$app->user->can($route);
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

        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
        ];
    }

    /**
     * Lists all BiblioField models.
     * @return string
     */
    public function actionIndex($bibid)
    {
        $searchModel = new BiblioFieldSearch();
        $model = Biblio::findOne($bibid);
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

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
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($bibid, $fieldid)
    {

        return $this->render('view', [
            'model' => $this->findModel($bibid, $fieldid),
        ]);
    }

    /**
     * Creates a new BiblioField model.
     * If creation is successful, the browser will be redirected to the 'index' page.
     * @param integer $bibid
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $model = new BiblioField();

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

        return $this->render('create', [
            'model' => $model,
            'marcBlocks' => $marcBlocks
        ]);
    }

    /**
     * Updates an existing BiblioField model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $bibid
     * @param integer $fieldid
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($bibid, $fieldid)
    {
        $model = $this->findModel($bibid, $fieldid);
        $biblio = Biblio::findOne($bibid);
        $marcBlocks = Usmarc::find()->all();
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect([
                'index',
                'bibid' => $model->bibid
            ]);
        }

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
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($bibid, $fieldid)
    {
        $this->findModel($bibid, $fieldid)->delete();

        return $this->redirect(['cataloging/biblio/view', 'index' => $bibid]);
    }

    /**
     * Genera las opciones HTML para los tags de USMARC basados en un número de bloque.
     *
     * Este método recupera los tags USMARC de la base de datos que corresponden al
     * número de bloque especificado y genera una lista de opciones HTML para un
     * elemento `<select>`. Si no se encuentran resultados, se muestra una opción
     * indicando que no hay resultados.
     *
     * @param int $block El número de bloque USMARC para filtrar los tags.
     * @return void Este método imprime directamente las opciones HTML en la salida.
     */
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

    /**
     * Genera las opciones HTML para los subcampos de USMARC basados en un tag.
     *
     * Este método recupera los subcampos USMARC de la base de datos que corresponden al
     * tag especificado y genera una lista de opciones HTML para un elemento `<select>`.
     * Si no se encuentran resultados, se muestra una opción indicando que no hay resultados.
     *
     * @param int $tag El tag USMARC para filtrar los subcampos.
     * @return void Este método imprime directamente las opciones HTML en la salida.
     */
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
