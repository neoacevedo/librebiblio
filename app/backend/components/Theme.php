<?php

namespace backend\components;

/**
 * @inheritdoc
 */
class Theme extends \yii\base\Theme
{

    /**
     * Theme folder name
     *
     * @var string
     */
    public $theme = 'AdminLTE';

    public function init()
    {
        parent::init();

        $theme = \common\models\Theme::find()->where(['active' => 1, 'frontend' => 0])->one();
        if (!$theme) {
            $this->theme = 'AdminLTE';
        } else {
            $this->theme = $theme->name;
        }

        $this->basePath = '@app/themes/' . $this->theme;
        $this->baseUrl = '@web/themes/' . $this->theme;
        $this->pathMap = [
            '@app/views' => '@app/themes/' . $this->theme,
        ];

        // configurar el tema en la sesión
        \Yii::$app->session->set('backend-skin', $theme->skin);
    }
}
