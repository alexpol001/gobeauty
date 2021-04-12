<?php

use common\models\search\Orders;

/* @var $this yii\web\View */
/* @var $searchModel Orders*/
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Заказы';
$this->params['breadcrumbs'][] = $this->title;
?>
<?= $this->render('../common/order_grid', [
    'searchModel' => $searchModel,
    'dataProvider' => $dataProvider,
]) ?>
