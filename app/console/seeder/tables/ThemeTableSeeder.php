<?php

namespace console\seeder\tables;

use antonyz89\seeder\TableSeeder;
use console\seeder\DatabaseSeeder;
use common\models\Theme;

/**
 * Handles the creation of seeder `{{%theme}}`.
 */
class ThemeTableSeeder extends TableSeeder
{
    public $skipTruncateTables = true;

    /**
     * {@inheritdoc}
     */
    public function run()
    {
        // loop(function ($i) {
        //     $this->insert(Theme::tableName(), [
        //         'name' => $this->faker->name,
        // 		'frontend' => $this->faker->numberBetween(0, 10),
        // 		'active' => $this->faker->numberBetween(0, 10),
        // 		'settings' => $this->faker->text,
        //     ]);
        // }, DatabaseSeeder::THEME_COUNT);
    }

    public function insertBackendThemeSettings()
    {
        $theme = Theme::find()->where(['name' => 'AdminLTE'])->one();

        $settings = '
        {
            "dark-mode": 0,
            "navbar-variants": {
                "navbar-primary navbar-dark": 0,
                "navbar-secondary navbar-dark": 0,
                "navbar-info navbar-dark": 0,
                "navbar-succes navbar-darks": 0,
                "navbar-danger navbar-dark": 0,
                "navbar-indigo navbar-dark": 0,
                "navbar-purple navbar-dark": 0,
                "navbar-pink navbar-dark": 0,
                "navbar-navy navbar-dark": 0,
                "navbar-lightblue navbar-dark": 0,
                "navbar-teal navbar-dark": 0,
                "navbar-cyan navbar-dark": 0,
                "navbar-dark": 0,
                "navbar-gray-dark navbar-dark": 0,
                "navbar-gray navbar-dark": 0,
                "navbar-light": 0,
                "navbar-light navbar-white": 1
            },
            "dark-sidebar-options": {
                "sidebar-dark-primary": 1,
                "sidebar-dark-warning": 0,
                "sidebar-dark-info": 0,
                "sidebar-dark-danger": 0,
                "sidebar-dark-success": 0,
                "sidebar-dark-indigo": 0,
                "sidebar-dark-lightblue": 0,
                "sidebar-dark-navy": 0,
                "sidebar-dark-purple": 0,
                "sidebar-dark-fuchsia": 0,
                "sidebar-dark-pink": 0,
                "sidebar-dark-maroon": 0,
                "sidebar-dark-orange": 0,
                "sidebar-dark-lime": 0,
                "sidebar-dark-teal": 0,
                "sidebar-dark-olive": 0
            },
            "light-sidebar-options": {
                "sidebar-light-primary": 0,
                "sidebar-light-warning": 0,
                "sidebar-light-info": 0,
                "sidebar-light-danger": 0,
                "sidebar-light-success": 0,
                "sidebar-light-indigo": 0,
                "sidebar-light-lightblue": 0,
                "sidebar-light-navy": 0,
                "sidebar-light-purple": 0,
                "sidebar-light-fuchsia": 0,
                "sidebar-light-pink": 0,
                "sidebar-light-maroon": 0,
                "sidebar-light-orange": 0,
                "sidebar-light-lime": 0,
                "sidebar-light-teal": 0,
                "sidebar-light-olive": 0
            }
        }';

        $theme->settings = $settings;
        $theme->sourcePath = "@backend/themes/AdminLTE";

        echo $theme->save() ? "Configuraciones del tema insertados correctamente." : "No se pudieron insertar las configuraciones del tema.";
    }

    public function insertFrontendThemeSettings()
    {
        $theme = Theme::find()->where(['name' => 'simple'])->one();

        $theme->sourcePath = "@frontend/themes/simple";

        echo $theme->save() ? "Configuraciones del tema insertados correctamente." : "No se pudieron insertar las configuraciones del tema.";
    }
}
