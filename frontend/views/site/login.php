<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */

/* @var $model \common\models\LoginForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\helpers\Url;

$this->title = 'Войти';
?>
<div class="site-login">
    <section class="login">
        <div class="login__inner">
            <h2 class="login__title">
                <?= Html::encode($this->title) ?>
            </h2>
            <div class="login-box">
                <?php $form = ActiveForm::begin(['id' => 'login-form', 'options' => ['class' => 'login-form']]); ?>
                <?= $form->field($model, 'email')->textInput(['class' => 'login-form__input', 'placeholder' => 'E-mail'])->label(false) ?>
                <?= $form->field($model, 'password')->passwordInput(['class' => 'login-form__input', 'placeholder' => 'Пароль'])->label(false) ?>
                <div class="login-form__wrapper">
                    <label>
                        <?= Html::activeCheckbox($model, 'rememberMe', ['class' => 'login-form__chechbox', 'label' => null]) ?>
                        <span class="login-form__icon"></span>
                    </label>
                    <p class="login-form__text">
                        Запомнить меня
                    </p>
                </div>
                <div class="exit-form__wrapper">
                    <p>
                        <br>
                        <span><a href="<?=Url::to(['site/request-password-reset'])?>" class="exit-form__link">Забыли пароль?</a></span>
                    </p>
                </div>
                <div class="exit-form__wrapper">
                    <p class="exit-form__text">
                        <span>Еще нет аккаунта?<a href="<?=Url::to(['site/signup'])?>" class="exit-form__link">Зарегистрируйтесь.</a></span>
                    </p>
                </div>
                <?= Html::submitButton('Войти', ['class' => 'login-form__submit', 'name' => 'login-button']) ?>
                <?php ActiveForm::end(); ?>
            </div>
        </div>
    </section>
</div>
