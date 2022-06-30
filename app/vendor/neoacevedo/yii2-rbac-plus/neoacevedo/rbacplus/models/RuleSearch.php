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
use yii\data\ArrayDataProvider;

/**
 * @author John Martin <john.itvn@gmail.com>
 * @since 1.0.0
 */
class RuleSearch extends Rule
{

    /**
     *
     * @var string 
     */
    public $name;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name'], 'safe']
        ];
    }

    /**
     * Search authitem
     * @param array $params
     * @return \yii\data\ActiveDataProvider|\yii\data\ArrayDataProvider
     */
    public function search($params)
    {
        $this->load($params);
        $authManager = Yii::$app->authManager;
        $models = [];
        foreach ($authManager->getRules() as $name => $item) {
            if ($this->name == null || empty($this->name)) {
                $models[$name] = new Rule($item);
            } else if (strpos($name, $this->name) !== FALSE) {
                $models[$name] = new Rule($item);
            }
        }
        return new ArrayDataProvider([
            'allModels' => $models,
        ]);
    }

}
