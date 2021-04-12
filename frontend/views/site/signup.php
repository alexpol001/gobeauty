<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \frontend\models\SignupForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\helpers\Url;

$this->title = 'Зарегистрироваться';
?>
<section class="exit">
    <div class="exit__inner">
        <h2 class="exit__title">
            <?= Html::encode($this->title) ?>
        </h2>
        <div class="exit-box">
            <? $form = ActiveForm::begin(['id' => 'form-signup', 'options' => ['class' => 'exit-form']]); ?>
            <?= $form->field($model, 'email')->textInput(['class' => 'exit-form__input', 'placeholder' => true])->label(false) ?>
            <?= $form->field($model, 'password')->passwordInput(['class' => 'exit-form__input', 'placeholder' => true])->label(false) ?>
            <?= $form->field($model, 'repassword')->passwordInput(['class' => 'exit-form__input', 'placeholder' => true])->label(false) ?>
            <div class="exit-form__wrapper">
                <label>
                    <?= Html::activeCheckbox($model, 'is_subscribe', ['class' => 'exit-form__chechbox', 'label' => null, 'checked' => true]) ?>
                    <span class="exit-form__icon"></span>
                </label>
                <p class="exit-form__text">
                    Получать Email-уведомления
                </p>
            </div>
            <div class="exit-form__wrapper">
                <label>
                    <?= Html::activeCheckbox($model, 'is_client', ['class' => 'exit-form__chechbox', 'label' => null, 'checked' => true]) ?>
                    <span class="exit-form__icon"></span>
                </label>
                <p class="exit-form__text">
                    Клиент
                </p>
            </div>
            <div class="exit-form__wrapper">
                <label>
                    <?= Html::activeCheckbox($model, 'is_master', ['class' => 'exit-form__chechbox', 'label' => null]) ?>
                    <span class="exit-form__icon"></span>
                </label>
                <p class="exit-form__text">
                    Мастер
                </p>
            </div>
            <div class="exit-form__wrapper">
                    <p class="exit-form__text">
                        <br>
                        <span>Уже есть аккаунт?<a href="<?=Url::to(['site/login'])?>" class="exit-form__link">Войдите.</a></span>
                    </p>
            </div>
            <?= Html::submitButton('Зарегистрироваться', ['class' => 'exit-form__submit register', 'name' => 'signup-button']) ?>
            <?php ActiveForm::end(); ?>
        </div>
    </div>
</section>
