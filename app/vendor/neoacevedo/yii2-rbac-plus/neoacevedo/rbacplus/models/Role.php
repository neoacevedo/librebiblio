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
use yii\rbac\Item;

/**
 * @author John Martin <john.itvn@gmail.com>
 * @since 1.0.0
 */
class Role extends AuthItem
{

    public $permissions = [];

    public function init()
    {
        parent::init();
        if (!$this->isNewRecord) {
            $permissions = [];
            foreach (static::getPermistions($this->item->name) as $permission) {
                $permissions[] = $permission->name;
            }
            $this->permissions = $permissions;
        }
    }

    public function scenarios()
    {
        $scenarios = parent::scenarios();
        $scenarios['default'][] = 'permissions';
        return $scenarios;
    }

    protected function getType()
    {
        return Item::TYPE_ROLE;
    }

    public function afterSave($insert, $changedAttributes)
    {
        $authManager = Yii::$app->authManager;
        $role = $authManager->getRole($this->item->name);
        if (!$insert) {
            $authManager->removeChildren($role);
        }
        if ($this->permissions != null && is_array($this->permissions)) {
            foreach ($this->permissions as $permissionName) {
                $permistion = $authManager->getPermission($permissionName);
                $authManager->addChild($role, $permistion);
            }
        }
    }

    public function attributeLabels()
    {
        $labels = parent::attributeLabels();
        $labels['name'] = Yii::t('rbac', 'Role name');
        $labels['permissions'] = Yii::t('rbac', 'Permissions');
        return $labels;
    }

    public static function find($name)
    {
        $authManager = Yii::$app->authManager;
        $item = $authManager->getRole($name);
        return new self($item);
    }

    public static function getPermistions($name)
    {
        $authManager = Yii::$app->authManager;
        return $authManager->getPermissionsByRole($name);
    }

}
