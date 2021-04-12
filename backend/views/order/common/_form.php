<?php

use backend\models\UserForm;
use common\models\Orders;
use kartik\helpers\Html;
use yii\bootstrap\Tabs;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model Orders */

?>
<div class="user-form">

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            [
                'attribute' => 'Клиент',
                'value' => function ($data) {
                    /** @var Orders $data */
                   return Html::a(Html::encode($data->client->email), Url::to(['user/update', 'id' => $data->client->id]));
                },
                'format' => 'html'
            ],
            [
                'attribute' => 'Мастер',
                'value' => function ($data) {
                    /** @var Orders $data */
                    return $data->master->email ?
                        Html::a(Html::encode($data->master->email), Url::to(['user/update', 'id' => $data->master->id])) :
                        null;
                },
                'format' => 'html'
            ],
            [
                'attribute' => 'date',
                'value' => function ($data) {
                    /** @var Orders $data */
                    return $data->getDateDate(). ' | ' .$data->getDateTime();
                }
            ],
        ],
    ]) ?>

    <?php $form = ActiveForm::begin(); ?>

    <?= \backend\widgets\FormWidget::widget([]) ?>

    <?
    $items = [
        [
            'label' => 'Основное',
            'content' => $this->render('primary_form', [
                'model' => $model,
                'form' => $form
            ]),
            'options' => [
                'id' => 'sub-basic'
            ],
            'active' => !$tab || ($tab == 'sub-basic'),
        ]
    ];

//    if ($model->getScenario() != UserForm::SCENARIO_CREATE) {
//        if ($model->_user->is_client) {
//            array_push($items, [
//                'label' => 'Задания',
//                'content' => '',
//                'options' => [
//                    'id' => 'sub-order'
//                ],
//                'active' => ($tab == 'sub-order')
//            ]);
//        }
//    }
    ?>

    <?= Tabs::widget([
        'id' => 'tabs',
        'items' => $items
    ]);
    ?>

    <?php ActiveForm::end(); ?>

    <?php
//    if ($model->getScenario() != UserForm::SCENARIO_CREATE) {
//        if ($model->_user->is_client) {
//            echo $this->render('order_form', [
//                    'model' => $model,
//            ]);
//        }
//    }
    ?>
</div>
<? $this->registerJsFile(Yii::getAlias('@web') . '/js/sub-grid.js', ['depends' => [yii\web\JqueryAsset::className()]]) ?>
