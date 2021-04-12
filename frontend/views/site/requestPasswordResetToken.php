<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \frontend\models\PasswordResetRequestForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = 'Восстановление пароля';
?>
<div class="site-request-password-reset">
    <section class="login">
        <div class="login__inner">
            <h1 class="login__title">
                <?= Html::encode($this->title) ?>
            </h1>
            <div class="login-box">
                <?php $form = ActiveForm::begin(['id' => 'login-form', 'options' => ['class' => 'login-form']]); ?>
                <?= $form->field($model, 'email')->textInput(['class' => 'login-form__input', 'placeholder' => 'E-mail'])->label(false) ?>
                <?= Html::submitButton('Отправить', ['class' => 'login-form__submit', 'name' => 'login-button', 'style' =>'margin-top: 10px']) ?>
                <?php ActiveForm::end(); ?>
            </div>
        </div>
    </section>
</div>
