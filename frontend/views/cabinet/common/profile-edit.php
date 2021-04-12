<?php

/* @var $this \yii\web\View */

use kartik\form\ActiveForm;
use kartik\helpers\Html;

/* @var $user \common\models\User */
/* @var $model \frontend\models\cabinet\UserEditForm */

$this->title = 'Редактирование';
?>
<div class="app__description">
    <?php $form = ActiveForm::begin(['id' => 'app-form', 'options' => ['class' => 'app-form']]); ?>
    <fieldset class="app-form__fieldset">
        <div class="app-form__inner">
            <?= $form->field($model, 'name')->textInput(['class' => 'app-form__input', 'placeholder' => true]) ?>
        </div>
    </fieldset>
    <fieldset class="app-form__fieldset">
        <div class="app-form__inner">
            <?= $form->field($model, 'description')->textarea(['class' => 'app-form__textarea', 'placeholder' => true]) ?>
        </div>
    </fieldset>
    <fieldset class="app-form__fieldset">
        <div class="app-form__inner">
									<span class="app-form__name">
										Местоположение
									</span>
            <div class="app-form__block">
                <?= Html::activeTextInput($model, 'city', ['class' => 'form-control app-form__block-input1', 'placeholder' => "Город", 'value' => $model->city]) ?>
                <?= Html::activeTextInput($model, 'street', ['class' => 'form-control app-form__block-input1', 'placeholder' => "Улица", 'value' => $model->street]) ?>
                <?= Html::activeTextInput($model, 'house', ['class' => 'form-control app-form__block-input2', 'placeholder' => "Дом", 'value' => $model->house]) ?>
                <?= Html::activeTextInput($model, 'room', ['class' => 'form-control app-form__block-input3', 'placeholder' => "Квартира", 'value' => $model->room]) ?>
                <?= Html::activeTextInput($model, 'housing', ['class' => 'form-control app-form__block-input4', 'placeholder' => "Корпус", 'value' => $model->housing]) ?>
            </div>
        </div>
    </fieldset>
    <fieldset class="app-form__fieldset">
        <div class="app-form__inner">
            <?= $form->field($model, 'phone')->widget(\yii\widgets\MaskedInput::className(), [
                'mask' => '+7-999-999-99-99', 'clientOptions' => ['showMaskOnHover' => false]
            ])->textInput(['class' => 'app-form__input', 'placeholder' => true]) ?>
        </div>
    </fieldset>
    <fieldset class="app-form__fieldset">
        <div class="exit-form__wrapper">
            <label>
                <?= Html::activeCheckbox($model, 'is_subscribe', ['class' => 'exit-form__chechbox', 'label' => null]) ?>
                <span class="exit-form__icon"></span>
            </label>
            <p class="exit-form__text">
                Получать Email-уведомления
            </p>
        </div>
        <div class="exit-form__wrapper">
            <label>
                <?= Html::activeCheckbox($model, 'is_client', ['class' => 'exit-form__chechbox', 'label' => null]) ?>
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
    </fieldset>
    <? if (!$this->context->is_client) :?>
        <fieldset class="app-form__fieldset">
            <div class="app-form__inner">
                <?= $form->field($model, 'categories')->multiselect(\common\models\Orders::getCategoryList()) ?>
            </div>
        </fieldset>
    <? endif;?>
    <?= Html::submitButton('Сохранить изменения', ['class' => 'app-form__btn button_click']) ?>
    <? ActiveForm::end(); ?>
</div>

