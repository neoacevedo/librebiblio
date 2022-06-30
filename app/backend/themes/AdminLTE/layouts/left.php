<?php
/* @var $directoryAsset string */
$picture = Yii::$app->user->identity->picture ?? "$directoryAsset/img/user2-160x160.jpg";

?>
<aside class="main-sidebar">

    <section class="sidebar">

        <!-- Sidebar user panel -->
        <div class="user-panel">
            <div class="pull-left image">
                <img src="<?= $picture ?>" class="img-circle" alt="User Image"/>
            </div>
            <div class="pull-left info">
                <p><?= Yii::$app->user->identity->username ?></p>
                <a href="<?= yii\helpers\Url::to(['/user/view', 'id' => Yii::$app->user->identity->id]) ?>">Perfil</a>
            </div>
        </div>

        <?=
        dmstr\widgets\Menu::widget(
                [
                    'options' => ['class' => 'sidebar-menu tree', 'data-widget' => 'tree'],
                    'items' => [
                        ['label' => Yii::t('app', 'Circulation'), 'url' => ['#'],
                            'options' => ['class' => 'treeview menu'],
                            'template' => '<a href="{url}" ><i class="fa fa-address-book-o"></i><span>{label}</span></a>',
                            'items' => [
                                ['label' => Yii::t('app', 'Home'), 'url' => ['circulation/index']],
                                ['label' => Yii::t('app', 'New Member'), 'url' => ['member/create']],
                                ['label' => Yii::t('app', 'Check in'), 'url' => ['circulation/reception']],
                            ], 
                        ],
                        ['label' => Yii::t('app', 'Cataloging'), 'url' => ['#'],
                            'options' => ['class' => 'treeview menu'],
                            'template' => '<a href="{url}" ><i class="fa fa-book"></i><span>{label}</span></a>',
                            'items' => [
                                ['label' => Yii::t('app', 'Home'), 'url' => ['/cataloging/biblio']],
                                ['label' => Yii::t('app', 'Create Biblio'), 'url' => ['/cataloging/biblio/create']],
                            ], 
                        ],
                        [
                            'template' => '<a href="{url}" ><i class="fa fa-bar-chart"></i><span>{label}</span></a>',
                            'label' => Yii::t('app/reports', 'Reports'), 'url' => ['admin/report/index'],
                            'items' => [], 
                        ]
                    ],
                ]
        )
        ?>

    </section>

</aside>
