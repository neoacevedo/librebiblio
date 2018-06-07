<?php

/**
 * @link https://www.neoacevedo.co
 * @copyright Copyright (c) 2018 Néstor Acevedo
 * @license https://www.neoacevedo.co/license
 */

namespace backend\controllers;

use Yii;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use backend\models\LoginForm;
use backend\models\ResetPasswordForm;
use backend\reports;

/**
 * Site controller
 */
class SiteController extends Controller 
{

    public $bodyClass;

    /**
     * @inheritdoc
     */
    public function behaviors() {
        return [
            'access' => [
                'class' => AccessControl::class,
                'rules' => [
                    [
                        'actions' => ['reset-password'],
                        'allow' => true,
                        'roles' => ['?']
                    ],
                    [
                        'actions' => ['login', 'error'],
                        'allow' => true,
                    ],
                    [
                        'actions' => ['index'],
                        'allow' => true,
                        'roles' => ['@'],
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
    public function actions() {
        \Yii::$app->language = \Yii::$app->request->getPreferredLanguage(Yii::$app->params['preferredLanguages']);
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
    public function actionIndex() {
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

        \Yii::$app->language = \Yii::$app->request->getPreferredLanguage(Yii::$app->params['preferredLanguages']);
        return $this->render('index', [
                    'checkouts' => $copy_count,
                    'bills' => $bills,
                    'new_members' => $new_members_count,
                    'checkout_stats' => $checkout_stats
        ]);
    }

    /**
     * Login action.
     *
     * @return string
     */
    public function actionLogin() {
        $this->bodyClass = "hold-transition login-page";
        \Yii::$app->language = \Yii::$app->request->getPreferredLanguage(Yii::$app->params['preferredLanguages']);
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        } else {
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
    public function actionLogout() {
        Yii::$app->user->logout();

        return $this->goHome();
    }

}
