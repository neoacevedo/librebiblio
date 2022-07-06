<?php

namespace frontend\components;

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
    public $theme;

    public function init()
    {
        parent::init();
        
        $theme = \common\models\Theme::find()->where(['active' => 1, 'frontend' => 1])->one();
        if (!$theme) {
            $this->theme = 'simple';
        } else {
            $this->theme = $theme->name;
        }

        $this->basePath = '@app/themes/' . $this->theme;
        $this->baseUrl = '@web/themes/' . $this->theme;
        $this->pathMap = [
            '@app/views' => '@app/themes/' . $this->theme . "/views",
        ];

        // configurar el tema en la sesión
        \Yii::$app->session->set('frontend-skin', $theme->skin);
    }
}
