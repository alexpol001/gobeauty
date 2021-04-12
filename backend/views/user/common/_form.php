<?php

use backend\models\UserForm;
use yii\bootstrap\Tabs;
use yii\widgets\ActiveForm;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model \backend\models\UserForm */

?>
<div class="user-form">

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

    if ($model->getScenario() != UserForm::SCENARIO_CREATE) {
        if ($model->_user->is_client) {
            array_push($items, [
                'label' => 'Задания',
                'content' => '',
                'options' => [
                    'id' => 'sub-order'
                ],
                'active' => ($tab == 'sub-order')
            ]);
        }
    }
    ?>

    <?= Tabs::widget([
        'id' => 'tabs',
        'items' => $items
    ]);
    ?>

    <?php ActiveForm::end(); ?>

    <?php
    if ($model->getScenario() != UserForm::SCENARIO_CREATE) {
        if ($model->_user->is_client) {
            echo $this->render('order_form', [
                'model' => $model,
            ]);
        }
    }
    ?>
</div>
<? $this->registerJsFile(Yii::getAlias('@web') . '/js/sub-grid.js', ['depends' => [yii\web\JqueryAsset::className()]]) ?>
