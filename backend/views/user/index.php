<?php

use backend\widgets\GridView;
use yii\helpers\Html;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $searchModel common\models\search\User */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Пользователи';
$this->params['breadcrumbs'][] = $this->title;
?>
<?= GridView::widget([
    'dataProvider' => $dataProvider,
    'filterModel' => $searchModel,
    'columns' => [
        ['class' => 'kartik\grid\CheckboxColumn'],
        [
            'attribute' => 'email',
            'value' => function ($data) {
                return Html::a(Html::encode($data->email), Url::to(['update', 'id' => $data->id]));
            },
            'format' => 'html'
        ],
        [
            'class' => 'kartik\grid\BooleanColumn',
            'attribute' => 'is_client',
            'vAlign' => 'middle'
        ],
        [
            'class' => 'kartik\grid\BooleanColumn',
            'attribute' => 'is_master',
            'vAlign' => 'middle'
        ],
        [
            'class' => 'kartik\grid\BooleanColumn',
            'attribute' => 'is_subscribe',
            'vAlign' => 'middle'
        ],
    ],
]); ?>
