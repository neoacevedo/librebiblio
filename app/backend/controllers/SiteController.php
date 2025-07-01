<?php

/**
 * @copyright Copyright (c) 2020 Néstor Acevedo
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

namespace backend\controllers;

use Yii;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use backend\models\LoginForm;
use yii\web\Response;

/**
 * Site controller
 */
class SiteController extends Controller
{
    /**
     * Define la clase CSS de la etiqueta body
     * @var string
     */
    public $bodyClass;

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'rules' => [
                    [
                        'actions' => ['login', 'error'],
                        'allow' => true,
                    ],
                    [
                        'actions' => ['index'],
                        'allow' => true,
                        'roles' => ['@']
                    ],
                    [
                        'actions' => ['flush-cache', 'settings', 'library-settings'],
                        'allow' => true,
                        'roles' => ['admin'],
                    ],
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@']
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * Gestión de errores
     * @return mixed
     */
    public function actions()
    {
        // \Yii::$app->language = \Yii::$app->request->getPreferredLanguage(Yii::$app->params['preferredLanguages']);
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {
        $copy_count = \common\models\BiblioCopy::find()->where(['status_cd' => 'out'])->count();
        $bills = \common\models\MemberAccount::find()->where(["transaction_type_cd" => "+c"])->sum('amount');
        $new_members_count = \common\models\Member::find()->where(['>=', 'created_at', strtotime(date('Y-m-d'))])->count();
        // gráfica
        if (Yii::$app->db->driverName === "mysql") {
            $checkout_stats = (new \yii\db\Query())
                ->select(["date_format(created_at, '%Y-%m-%d') as checkoutsPerDay", 'count(*) as checkoutCount'])
                ->from("{{%biblio_status_hist}}")
                ->where(['status_cd' => 'out'])
                ->andWhere([">=", "created_at", new \yii\db\Expression('(NOW() - INTERVAL 1 WEEK)')])
                ->groupBy(['checkoutsPerDay'])
                ->limit(5)
                ->all();
        } elseif (Yii::$app->db->driverName === "pgsql") {
            $checkout_stats = (new \yii\db\Query())
                ->select(['to_char(created_at, \'YYYY-MM_DD\') as "checkoutsPerDay"', 'count(*) as "checkoutCount"'])
                ->from("{{%biblio_status_hist}}")
                ->where(['status_cd' => 'out'])
                ->andWhere([">=", "created_at", new \yii\db\Expression("(NOW() - INTERVAL '1 WEEK')")])
                ->groupBy(['"checkoutsPerDay"'])
                ->limit(5)
                ->all();
        }

        // Esto es temporal e irá junto con el widget como parte del widget de yii2-auditing
        $logs = new \yii\data\ActiveDataProvider([
            'query' => \neoacevedo\auditing\models\Auditing::find()
                ->select(["description", "created_at"])
                ->groupBy(["event", "model", "created_at"])
                ->orderBy(['id' => SORT_DESC])
                ->limit(5),
            'pagination' => false,
            'sort' => false
        ]);

        // \Yii::$app->language = \Yii::$app->request->getPreferredLanguage(Yii::$app->params['preferredLanguages']);
        return $this->render('index', [
            'checkouts' => $copy_count,
            'bills' => $bills,
            'new_members' => $new_members_count,
            'checkout_stats' => $checkout_stats,
            "logs" => $logs,
        ]);
    }

    /**
     * Login action.
     *
     * @return Response|string
     */
    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        // $this->layout = 'main-login';

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        } else {
            $model->password = '';

            return $this->render('login', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Logout action.
     *
     * @return string
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    /**
     * Borra la caché.
     *
     * @return mixed
     */
    public function actionFlushCache()
    {
        $frontendAssetPath = Yii::getAlias("@webroot") . "/../../assets/";
        $backendAssetPath = Yii::getAlias('@webroot') . '/assets/';

        self::recursiveDelete($frontendAssetPath);
        self::recursiveDelete($backendAssetPath);

        if (!is_dir($frontendAssetPath)) {
            mkdir($frontendAssetPath) or Yii::debug("No es un directorio: $frontendAssetPath");
        }

        if (!is_dir($backendAssetPath)) {
            mkdir($backendAssetPath) or Yii::debug("No es un directorio: $backendAssetPath");
        }

        // \Yii::$app->language = \Yii::$app->request->getPreferredLanguage(Yii::$app->params['preferredLanguages']);
        if (\Yii::$app->cache->flush()) {
            \Yii::$app->getSession()->setFlash('success', \Yii::t('app', 'Cache has been flushed.'));
        } else {
            \Yii::$app->getSession()->setFlash('error', \Yii::t('app', 'Failed to flush cache.'));
        }

        return $this->redirect(\Yii::$app->request->referrer);
    }

    /**
     * Describe las configuraciones disponibles de la biblioteca.
     * @return mixed
     */
    public function actionSettings()
    {
        // \Yii::$app->language = \Yii::$app->request->getPreferredLanguage(Yii::$app->params['preferredLanguages']);
        return $this->render('settings/index');
    }

    /**
     * Carga/guarda las configuraciones de la biblioteca.
     *
     * Algunas configuraciones específicas de la plataforma se crean/guardan desde los diferentes archivos de configuración.
     * @return mixed
     */
    public function actionLibrarySettings()
    {
        $model = $this->findSettingsModel();
        // \Yii::$app->language = \Yii::$app->request->getPreferredLanguage(Yii::$app->params['preferredLanguages']);
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->render('settings/library_settings', ['model' => $model]);
        } else {
            array_walk_recursive($model->errors, function ($v, $k) {
                Yii::$app->getSession()->setFlash('error', $v);
            });

            return $this->render('settings/library_settings', ['model' => $model]);
        }
    }

    /**
     * Remove file or directory
     *
     * @param string $path
     * @return boolean
     */
    private static function recursiveDelete($path)
    {
        if (is_file($path)) {
            return unlink($path);
        } elseif (is_dir($path)) {
            $scan = glob(rtrim($path, '/') . '/*');
            foreach ($scan as $index => $newPath) {
                self::recursiveDelete($newPath);
            }

            return @rmdir($path);
        }
    }
}
