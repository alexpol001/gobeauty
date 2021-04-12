<?php

/* @var $this yii\web\View */
/* @var $model \common\models\Orders */
/* @var $form \yii\widgets\ActiveForm */

use common\models\Orders;
?>

<?= $form->field($model, 'status')->dropDownList(Orders::getStatuses()) ?>

<?= $form->field($model, 'description')->textArea() ?>

<?= $form->field($model, 'category_id')->dropDownList(Orders::getCategoryArray()) ?>

<?= $form->field($model, 'place')->dropDownList(Orders::getPlaces()) ?>

<?= $form->field($model, 'pay_method')->dropDownList(Orders::getPaymentList()) ?>

<?= $form->field($model, 'price')->textInput(); ?>

