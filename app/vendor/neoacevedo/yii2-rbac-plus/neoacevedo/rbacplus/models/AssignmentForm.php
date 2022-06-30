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
use yii\base\Model;

/**
 * @author John Martin <john.itvn@gmail.com>
 * @since 1.0.0
 */
class AssignmentForm extends Model
{

    public $userId;
    public $roles = [];
    public $authManager;

    /**
     * 
     * @param mixed $userId The id of user use for assign
     * @param array $config 
     */
    public function __construct($userId, $config = array())
    {
        parent::__construct($config);
        $this->userId = $userId;
        $this->authManager = Yii::$app->authManager;
        foreach ($this->authManager->getRolesByUser($userId) as $role) {
            $this->roles[] = $role->name;
        }
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [
                [
                    'userId'],
                'required'],
            [
                [
                    'roles'],
                'default'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'userId' => Yii::t('rbac', 'User ID'),
            'roles' => Yii::t('rbac', 'Roles'),
        ];
    }

    /**
     * Save assignment data
     * @return boolean whether assignment save success
     */
    public function save()
    {
        $this->authManager->revokeAll(intval($this->userId));
        if ($this->roles != null) {
            foreach ($this->roles as $role) {
                $this->authManager->assign($this->authManager->getRole($role), $this->userId);
            }
        }
        return true;
    }

}
