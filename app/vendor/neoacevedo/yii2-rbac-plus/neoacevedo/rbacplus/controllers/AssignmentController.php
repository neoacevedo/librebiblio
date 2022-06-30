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
use yii\web\Response;
use yii\helpers\Html;
use neoacevedo\rbacplus\Module;
use neoacevedo\rbacplus\models\AssignmentSearch;
use neoacevedo\rbacplus\models\AssignmentForm;

/**
 * AssignmentController is controller for manager user assignment
 *
 * @author John Martin <john.itvn@gmail.com>
 * @since 1.0.0
 */
class AssignmentController extends Controller
{

    /**
     * The current rbac module
     * @var Module $rbacModule
     */
    protected $rbacModule;

    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();
        $this->rbacModule = Yii::$app->getModule('rbac');
    }

    /**
     * Show list of user for assignment
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new AssignmentSearch;
        $dataProvider = $searchModel->search();

        return $this->render('index', [
                    'dataProvider' => $dataProvider,
                    'searchModel' => $searchModel,
                    'idField' => $this->rbacModule->userModelIdField,
                    'usernameField' => $this->rbacModule->userModelLoginField,
        ]);
    }

    /**
     * Assignment roles to user
     * @param mixed $id The user id
     * @return mixed
     */
    public function actionAssignment($id)
    {
        $model = call_user_func($this->rbacModule->userModelClassName . '::findOne', $id);
        $formModel = new AssignmentForm($id);
        $request = Yii::$app->request;

        if ($request->isAjax) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            if ($request->isPost) {
                $formModel->load(Yii::$app->request->post());
                $formModel->save();
            }
            return [
                'title' => $model->{$this->rbacModule->userModelLoginField},
                'forceReload' => "true",
                'content' => $this->renderPartial('assignment', [
                    'model' => $model,
                    'formModel' => $formModel,
                ]),
                'footer' => Html::button(Yii::t('rbac', 'Close'), [
                    'class' => 'btn btn-default pull-left',
                    'data-dismiss' => "modal"]) .
                Html::button(Yii::t('rbac', 'Save'), [
                    'class' => 'btn btn-primary',
                    'type' => "submit"])
            ];
        } else {
            return $this->render('assignment', [
                        'model' => $model,
                        'formModel' => $formModel,
            ]);
        }
    }

}
