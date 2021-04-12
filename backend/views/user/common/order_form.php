<?php

/* @var $model \backend\models\UserForm */

/* @var $this \yii\web\View */

use backend\widgets\GridView;
use common\models\search\Orders;
use kartik\helpers\Html;
use yii\helpers\Url;

$searchModel = new Orders();
$searchModel->client_id = $model->_user->id;
$dataProvider = $searchModel->search(Yii::$app->request->queryParams);
?>
<div style="display:none;" class="sub-grid" data-sub-id="#sub-order">
    <?= $this->render('../../common/order_grid', [
        'user' => $model,
        'searchModel' => $searchModel,
        'dataProvider' => $dataProvider,
    ]) ?>
</div>
