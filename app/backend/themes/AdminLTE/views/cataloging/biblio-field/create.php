<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/* @var $biblio common\models\Biblio */
/* @var $marcBlocks marcBlocks */

$this->title = Yii::t('cataloging', 'Create Biblio Field');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Biblios'), 'url' => ['cataloging/biblio/index']];
$this->params['breadcrumbs'][] = $this->title;

$js = <<<JS
(function (\$bs) {
    const CLASS_NAME = 'has-child-dropdown-show';
    \$bs.Dropdown.prototype.toggle = function (_orginal) {
        return function () {
            document.querySelectorAll('.' + CLASS_NAME).forEach(function (e) {
                e.classList.remove(CLASS_NAME);
            });
            let dd = this._element.closest('.dropdown').parentNode.closest('.dropdown');
            for (; dd && dd !== document; dd = dd.parentNode.closest('.dropdown')) {
                dd.classList.add(CLASS_NAME);
            }
            return _orginal.call(this);
        }
    }(\$bs.Dropdown.prototype.toggle);

    document.querySelectorAll('.dropdown').forEach(function (dd) {
        dd.addEventListener('hide.bs.dropdown', function (e) {
            if (this.classList.contains(CLASS_NAME)) {
                this.classList.remove(CLASS_NAME);
                e.preventDefault();
            }
            e.stopPropagation(); // do not need pop in multi level mode
        });
    });
})(bootstrap);
JS;

$this->registerJs($js, yii\web\View::POS_END);

?>
<div class="biblio-field-create">
    <div class="card">
        <div class="card-body">
            <?= $this->render('_form', [
                'model' => $model,
                'marcBlocks' => $marcBlocks
            ]) ?>
        </div>
    </div>
</div>