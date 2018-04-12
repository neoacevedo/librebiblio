<?php

namespace johnitvn\rbacplus\models;

use Yii;
use yii\rbac\Item;

/**
 * Description of Permistion
 *
 * @author John Martin <john.itvn@gmail.com>
 * @since 1.0.0
 */
class Permission extends AuthItem {

    protected function getType() {
        return Item::TYPE_PERMISSION;
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels() {
        $labels = parent::attributeLabels();
        $labels['name'] = Yii::t('app/rbac', 'Permission name');
        return $labels;
    }

    /**
     * 
     * @param string $name
     * @return \self
     */
    public static function find(string $name) {
        $authManager = Yii::$app->authManager;
        $item = $authManager->getPermission($name);
        return new self($item);
    }

}
