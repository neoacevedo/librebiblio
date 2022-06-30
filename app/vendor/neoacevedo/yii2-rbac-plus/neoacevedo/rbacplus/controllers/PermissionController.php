<?php

/*
 * Copyright (C) 2018 Néstor Acevedo <soporte at neoacevedo.co>
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

namespace neoacevedo\rbacplus\controllers;

use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\Response;
use yii\helpers\Html;
use neoacevedo\rbacplus\models\Permission;
use neoacevedo\rbacplus\models\PermissionSearch;

/**
 * PermissionController is controller for manager permissions
 * @author John Martin <john.itvn@gmail.com>
 * @since 1.0.0
 */
class PermissionController extends Controller
{

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'delete' => [
                        'post'],
                    'bulk-delete' => [
                        'post'],
                ],
            ],
        ];
    }

    /**
     * Lists all Permission models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new PermissionSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Permission model.
     * @param string $name
     * @return mixed
     */
    public function actionView($name)
    {
        $request = Yii::$app->request;

        if ($request->isAjax) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            return [
                'title' => $name,
                'content' => $this->renderPartial('view', [
                    'model' => $this->findModel($name),
                ]),
                'footer' => Html::button(Yii::t('rbac', 'Close'), [
                    'class' => 'btn btn-default pull-left',
                    'data-dismiss' => "modal"]) .
                Html::a(Yii::t('rbac', 'Edit'), [
                    'update',
                    'name' => $name], [
                    'class' => 'btn btn-primary',
                    'role' => 'modal-remote'])
            ];
        } else {
            return $this->render('view', [
                        'model' => $this->findModel($name),
            ]);
        }
    }

    /**
     * Creates a new Permission model.
     * For ajax request will return json object
     * and for non-ajax request if creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $request = Yii::$app->request;
        $model = new Permission(null);

        if ($request->isAjax) {
            /*
             *   Process for ajax request
             */
            Yii::$app->response->format = Response::FORMAT_JSON;
            if ($request->isGet) {
                return [
                    'title' => Yii::t('rbac', "Create new {0}", [
                        "Permission"]),
                    'content' => $this->renderPartial('create', [
                        'model' => $model,
                    ]),
                    'footer' => Html::button(Yii::t('rbac', 'Close'), [
                        'class' => 'btn btn-default pull-left',
                        'data-dismiss' => "modal"]) .
                    Html::button(Yii::t('rbac', 'Save'), [
                        'class' => 'btn btn-primary',
                        'type' => "submit"])
                ];
            } else if ($model->load($request->post()) && $model->save()) {
                return [
                    'forceReload' => 'true',
                    'title' => Yii::t('rbac', "Create new {0}", [
                        "Permission"]),
                    'content' => '<span class="text-success">' . Yii::t('rbac', "Have been create new {0} success", [
                        "Permission"]) . '</span>',
                    'footer' => Html::button(Yii::t('rbac', 'Close'), [
                        'class' => 'btn btn-default pull-left',
                        'data-dismiss' => "modal"]) .
                    Html::a(Yii::t('rbac', 'Create More'), [
                        'create'], [
                        'class' => 'btn btn-primary',
                        'role' => 'modal-remote'])
                ];
            } else {
                return [
                    'title' => Yii::t('rbac', "Create new {0}", [
                        "Permission"]),
                    'content' => $this->renderPartial('create', [
                        'model' => $model,
                    ]),
                    'footer' => Html::button(Yii::t('rbac', 'Close'), [
                        'class' => 'btn btn-default pull-left',
                        'data-dismiss' => "modal"]) .
                    Html::button(Yii::t('rbac', 'Save'), [
                        'class' => 'btn btn-primary',
                        'type' => "submit"])
                ];
            }
        } else {
            /*
             *   Process for non-ajax request
             */
            if ($model->load($request->post()) && $model->save()) {
                return $this->redirect([
                            'view',
                            'name' => $model->name]);
            } else {
                return $this->render('create', [
                            'model' => $model,
                ]);
            }
        }
    }

    /**
     * Updates an existing Permission model.
     * For ajax request will return json object
     * and for non-ajax request if update is successful, the browser will be redirected to the 'view' page.
     * @param string $name
     * @return mixed
     */
    public function actionUpdate($name)
    {
        $request = Yii::$app->request;
        $model = $this->findModel($name);

        if ($request->isAjax) {
            /*
             *   Process for ajax request
             */
            Yii::$app->response->format = Response::FORMAT_JSON;
            if ($request->isGet) {
                return [
                    'title' => Yii::t('rbac', "Update {0}", [
                        '"' . $name . '" Permission']),
                    'content' => $this->renderPartial('update', [
                        'model' => $this->findModel($name),
                    ]),
                    'footer' => Html::button(Yii::t('rbac', 'Close'), [
                        'class' => 'btn btn-default pull-left',
                        'data-dismiss' => "modal"]) .
                    Html::button(Yii::t('rbac', 'Save'), [
                        'class' => 'btn btn-primary',
                        'type' => "submit"])
                ];
            } else if ($model->load($request->post()) && $model->save()) {
                return [
                    'forceReload' => 'true',
                    'title' => $name,
                    'content' => $this->renderPartial('view', [
                        'model' => $this->findModel($name),
                    ]),
                    'footer' => Html::button(Yii::t('rbac', 'Close'), [
                        'class' => 'btn btn-default pull-left',
                        'data-dismiss' => "modal"]) .
                    Html::a(Yii::t('rbac', 'Edit'), [
                        'update',
                        'name' => $name], [
                        'class' => 'btn btn-primary',
                        'role' => 'modal-remote'])
                ];
            } else {
                return [
                    'title' => Yii::t('rbac', "Update {0}", [
                        '"' . $name . '" Permission']),
                    'content' => $this->renderPartial('update', [
                        'model' => $model,
                    ]),
                    'footer' => Html::button(Yii::t('rbac', 'Close'), [
                        'class' => 'btn btn-default pull-left',
                        'data-dismiss' => "modal"]) .
                    Html::button(Yii::t('rbac', 'Save'), [
                        'class' => 'btn btn-primary',
                        'type' => "submit"])
                ];
            }
        } else {
            /*
             *   Process for non-ajax request
             */
            if ($model->load($request->post()) && $model->save()) {
                return $this->redirect([
                            'view',
                            'name' => $model->name]);
            } else {
                return $this->render('update', [
                            'model' => $model,
                ]);
            }
        }
    }

    /**
     * Delete an existing Permission model.
     * For ajax request will return json object
     * and for non-ajax request if deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $name
     * @return mixed
     */
    public function actionDelete($name)
    {
        $request = Yii::$app->request;
        $this->findModel($name)->delete();

        if ($request->isAjax) {
            /*
             *   Process for ajax request
             */
            Yii::$app->response->format = Response::FORMAT_JSON;
            return [
                'forceClose' => 'true',
                'forceReload' => 'true'
            ];
        } else {
            /*
             *   Process for non-ajax request
             */
            return $this->redirect([
                        'index']);
        }
    }

    /**
     * Finds the Permission model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $name
     * @return Permission the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($name)
    {
        if (($model = Permission::find($name)) !== null) {
            return $model;
        } else {

            throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
        }
    }

}
