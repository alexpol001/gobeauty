<?php

/* @var $this yii\web\View */
/* @var $model \backend\models\UserForm */
/* @var $form \yii\widgets\ActiveForm */

?>

<?= $form->field($model, 'email')->textInput(['placeholder' => true, 'value' => $model->email ? $model->email : $model->_user->email]) ?>

<?= $form->field($model, 'password')->passwordInput(['placeholder' => true]) ?>

<?= $form->field($model, 'password_repeat')->passwordInput(['placeholder' => true]) ?>

<?= $form->field($model, 'is_client')->checkbox(['checked ' => (bool)$model->_user->is_client]) ?>

<?= $form->field($model, 'is_master')->checkbox(['checked ' => (bool)$model->_user->is_master]) ?>

<?= $form->field($model, 'is_subscribe')->checkbox(['checked ' => (bool)$model->_user->is_subscribe]) ?>

<?= $form->field($model, 'name')->textInput(['placeholder' => true, 'value' => $model->name ? $model->name : $model->_user->info->name]) ?>

<?= $form->field($model, 'description')->textArea(['placeholder' => true, 'value' => $model->description ? $model->description : $model->_user->info->description]) ?>

<?= $form->field($model, 'phone')->widget(\yii\widgets\MaskedInput::className(), [
    'mask' => '+7-999-999-99-99', 'clientOptions' => ['showMaskOnHover' => false]])
    ->textInput(['placeholder' => true, 'value' => $model->phone ? $model->phone : $model->_user->info->phone]) ?>

<?= $form->field($model, 'city')->textInput(['placeholder' => true, 'value' => $model->city ? $model->city : $model->_user->info->city]) ?>

<?= $form->field($model, 'street')->textInput(['placeholder' => true, 'value' => $model->street ? $model->street : $model->_user->info->street]) ?>

<?= $form->field($model, 'house')->textInput(['placeholder' => true, 'value' => $model->house ? $model->house : $model->_user->info->house]) ?>

<?= $form->field($model, 'room')->textInput(['placeholder' => true, 'value' => $model->room ? $model->room : $model->_user->info->room]) ?>

<?= $form->field($model, 'housing')->textInput(['placeholder' => true, 'value' => $model->housing ? $model->housing : $model->_user->info->housing]) ?>

