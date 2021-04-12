<?php

/* @var $user \backend\models\UserForm */

use backend\widgets\GridView;
use common\models\search\Orders;
use kartik\helpers\Html;
use yii\helpers\Url;

?>
<?= GridView::widget([
        'create' => false,
        'delete' => ['order/multi-delete', 'id' => $user ? $user->_user->id : null],
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'kartik\grid\CheckboxColumn'],
            [
                'attribute' => 'description',
                'value' => function ($data) {
                    return Html::a(Html::encode($data->description), Url::to(['order/update', 'id' => $data->id]));
                },
                'format' => 'html'
            ],
            [
                'attribute' => 'date',
                'value' => function ($data) {
                    /** @var Orders $data */
                    return $data->getDateDate() . " | " . $data->getDateTime();
                },
                'format' => 'html'
            ],
            [
                'attribute' => 'place',
                'filter' => Orders::getPlaces(),
                'value' => function ($data) {
                    /** @var Orders $data */
                    return $data->getPlaceName();
                },
                'format' => 'html'
            ],
            [
                'attribute' => 'pay_method',
                'filter' => Orders::getPaymentList(),
                'value' => function ($data) {
                    /** @var Orders $data */
                    return $data->getPaymentName();
                },
                'format' => 'html'
            ],
            [
                'attribute' => 'status',
                'filter' => Orders::getStatuses(),
                'value' => function ($data) {
                    /** @var Orders $data */
                    return $data->getStatusName();
                },
                'format' => 'html'
            ]
        ],
    ]); ?>
