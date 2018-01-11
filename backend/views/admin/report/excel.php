<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

// take just first model in the list
$model = $dataProvider->models;
if (count($model) > 0) {
    $groupBy = Yii::$app->request->get("groupBy");
    if (null !== $groupBy) {
        if ($groupBy === "biblio") {
            $columns = [];
            foreach ($model[0]->attributes as $key => $value) {
                if ($key === "barcode_nmbr") {
                    continue;
                }

                $columns[$key] = $value;
            }
            $attributes = array_merge([
                ['class' => 'yii\grid\SerialColumn']], array_keys($columns)
            );
        } else {
            $attributes = array_merge([
                ['class' => 'yii\grid\SerialColumn']], array_keys($model[0]->attributes)
            );
        }
    } else {
        $attributes = array_merge([
            ['class' => 'yii\grid\SerialColumn']], array_keys($model[0]->attributes)
        );
    }
} else {
    $attributes = array_merge([
        ['class' => 'yii\grid\SerialColumn']], array_keys($searchModel->attributes)
    );
}
?>

<?php

$gridView = GridView::begin([
            'dataProvider' => $dataProvider,
            'columns' => $attributes,
        ]);

echo $gridView->renderTableHeader();
echo $gridView->renderTableBody();
echo $gridView->renderTableFooter();
?>

