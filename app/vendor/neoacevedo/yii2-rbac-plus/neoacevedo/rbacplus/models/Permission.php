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
use yii\base\Module;
use yii\base\Controller;
use yii\helpers\VarDumper;
use yii\caching\TagDependency;

/**
 * Description of Permistion
 *
 * @author John Martin <john.itvn@gmail.com>
 * @since 1.0.0
 */
class Permission extends AuthItem
{

    /**
     * @var string cache tag
     */
    const CACHE_TAG = 'neoacevedo.rbacplus.permission';

    /**
     * @var int cache duration
     */
    public $cacheDuration = 3600;

    /**
     * @var array list of module IDs that will be excluded
     */
    public $excludeModules = [];

    protected function getType()
    {
        return Item::TYPE_PERMISSION;
    }

    public function attributeLabels()
    {
        $labels = parent::attributeLabels();
        $labels['name'] = Yii::t('rbac', 'Permission name');
        return $labels;
    }

    public static function find($name)
    {
        $authManager = Yii::$app->authManager;
        $item = $authManager->getPermission($name);
        return new self($item);
    }

    /**
     * Get available and assigned routes
     *
     * @return array
     */
    public function getAvailableAndAssignedRoutes(): array
    {
        $routes = $this->getAppRoutes();
        $exists = [];
        foreach (array_keys(Yii::$app->authManager->getPermissions()) as $name) {
            if ($name[0] !== '/') {
                continue;
            }
            $exists[] = $name;
            unset($routes[$name]);
        }
        return [
            'available' => array_keys($routes),
            'assigned' => $exists,
        ];
    }

    /**
     * Get list of application routes
     *
     * @param null|string $module
     *
     * @return array
     */
    public function getAppRoutes(string $module = null): array
    {
        if ($module === null) {
            $module = Yii::$app;
        } else {
            $module = Yii::$app->getModule($module);
        }
        $key = [__METHOD__, $module->getUniqueId()];
        $result = ((Yii::$app->cache !== null) ? Yii::$app->cache->get($key) : false);
        if ($result === false) {
            $result = [];
            $this->getRouteRecursive($module, $result);
            if (Yii::$app->cache !== null) {
                Yii::$app->cache->set($key, $result, $this->cacheDuration, new TagDependency([
                    'tags' => self::CACHE_TAG,
                ]));
            }
        }
        return $result;
    }

    /**
     * Invalidate the cache
     */
    public function invalidate()
    {
        if (Yii::$app->cache !== null) {
            TagDependency::invalidate(Yii::$app->cache, self::CACHE_TAG);
        }
    }

    /**
     * Get route(s) recursive
     *
     * @param Module $module
     * @param array $result
     */
    protected function getRouteRecursive(Module $module, &$result)
    {
        if (!in_array($module->id, $this->excludeModules)) {
            $token = "Get Route of '" . get_class($module) . "' with id '" . $module->uniqueId . "'";
            Yii::beginProfile($token, __METHOD__);
            try {
                foreach ($module->getModules() as $id => $child) {
                    if (($child = $module->getModule($id)) !== null) {
                        $this->getRouteRecursive($child, $result);
                    }
                }
                foreach ($module->controllerMap as $id => $type) {
                    $this->getControllerActions($type, $id, $module, $result);
                }
                $namespace = trim($module->controllerNamespace, '\\') . '\\';
                $this->getControllerFiles($module, $namespace, '', $result);
                $all = '/' . ltrim($module->uniqueId . '/*', '/');
                $result[$all] = $all;
            } catch (\Exception $exc) {
                Yii::error($exc->getMessage(), __METHOD__);
            }
            Yii::endProfile($token, __METHOD__);
        }
    }

    /**
     * Get list controllers under module
     *
     * @param Module $module
     * @param string $namespace
     * @param string $prefix
     * @param mixed $result
     */
    protected function getControllerFiles(Module $module, string $namespace, string $prefix, &$result)
    {
        $path = Yii::getAlias('@' . str_replace('\\', '/', $namespace), false);
        $token = "Get controllers from '$path'";
        Yii::beginProfile($token, __METHOD__);
        try {
            if (!is_dir($path)) {
                return;
            }
            foreach (scandir($path) as $file) {
                if ($file == '.' || $file == '..') {
                    continue;
                }
                if (is_dir($path . '/' . $file) && preg_match('%^[a-z0-9_/]+$%i', $file . '/')) {
                    $this->getControllerFiles($module, $namespace . $file . '\\', $prefix . $file . '/', $result);
                } elseif (strcmp(substr($file, -14), 'Controller.php') === 0) {
                    $baseName = substr(basename($file), 0, -14);
                    $name = strtolower(preg_replace('/(?<![A-Z])[A-Z]/', ' \0', $baseName));
                    $id = ltrim(str_replace(' ', '-', $name), '-');
                    $className = $namespace . $baseName . 'Controller';
                    if (strpos($className, '-') === false && class_exists($className) && is_subclass_of($className, 'yii\base\Controller')) {
                        $this->getControllerActions($className, $prefix . $id, $module, $result);
                    }
                }
            }
        } catch (\Exception $exc) {
            Yii::error($exc->getMessage(), __METHOD__);
        }
        Yii::endProfile($token, __METHOD__);
    }

    /**
     * Get list actions of controller
     *
     * @param mixed $type
     * @param string $id
     * @param Module $module
     * @param mixed $result
     */
    protected function getControllerActions($type, $id, Module $module, &$result)
    {
        $token = 'Create controller with config=' . VarDumper::dumpAsString($type) . " and id='$id'";
        Yii::beginProfile($token, __METHOD__);
        try {
            /* @var $controller Controller */
            $controller = Yii::createObject($type, [$id, $module]);
            $this->getActionRoutes($controller, $result);
            $all = "/{$controller->uniqueId}/*";
            $result[$all] = $all;
        } catch (\Exception $exc) {
            Yii::error($exc->getMessage(), __METHOD__);
        }
        Yii::endProfile($token, __METHOD__);
    }

    /**
     * Get route of action
     *
     * @param Controller $controller
     * @param array $result all controller action
     */
    protected function getActionRoutes(Controller $controller, &$result)
    {
        $token = "Get actions of controller '" . $controller->uniqueId . "'";
        Yii::beginProfile($token, __METHOD__);
        try {
            $prefix = '/' . $controller->uniqueId . '/';
            foreach ($controller->actions() as $id => $value) {
                $result[$prefix . $id] = $prefix . $id;
            }
            $class = new \ReflectionClass($controller);
            foreach ($class->getMethods() as $method) {
                $name = $method->getName();
                if ($method->isPublic() && !$method->isStatic() && strpos($name, 'action') === 0 && $name !== 'actions') {
                    $name = strtolower(preg_replace('/(?<![A-Z])[A-Z]/', ' \0', substr($name, 6)));
                    $id = $prefix . ltrim(str_replace(' ', '-', $name), '-');
                    $result[$id] = $id;
                }
            }
        } catch (\Exception $exc) {
            Yii::error($exc->getMessage(), __METHOD__);
        }
        Yii::endProfile($token, __METHOD__);
    }

}
