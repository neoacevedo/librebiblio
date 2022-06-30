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

namespace neoacevedo\rbacplus\models;

use Yii;
use yii\data\ActiveDataProvider;
use neoacevedo\rbacplus\Module;

/**
 * @author John Martin <john.itvn@gmail.com>
 * @since 1.0.0
 * 
 */
class AssignmentSearch extends \yii\base\Model
{

    /**
     * @var Module $rbacModule
     */
    protected $rbacModule;

    /**
     *
     * @var mixed $id
     */
    public $id;

    /**
     *
     * @var string $login
     */
    public $login;

    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();
        $this->rbacModule = Yii::$app->getModule('rbac');
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [
                [
                    'id',
                    'login'],
                'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('rbac', 'ID'),
            'login' => $this->rbacModule->userModelLoginFieldLabel,
        ];
    }

    /**
     * Create data provider for Assignment model.    
     */
    public function search()
    {
        $query = call_user_func($this->rbacModule->userModelClassName . "::find");
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);
        $params = Yii::$app->request->getQueryParams();

        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        $query->andFilterWhere([
            $this->usersModule->userModelIdField => $this->id]);
        $query->andFilterWhere([
            'like',
            $this->rbacModule->userModelLoginField,
            $this->login]);

        return $dataProvider;
    }

}
