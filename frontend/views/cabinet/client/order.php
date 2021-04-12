<?php

/* @var $this \yii\web\View */

use common\models\Orders;
use kartik\form\ActiveForm;
use kartik\helpers\Html;

/* @var $user \common\models\User */
/* @var $model \frontend\models\cabinet\Order */
/* @var $slug string */

$this->title = 'Создание заявки';
?>
<div class="app__description">
    <?php $form = ActiveForm::begin(['id' => 'app-form', 'options' => ['class' => 'app-form']]); ?>
    <fieldset class="app-form__fieldset">
        <div class="app-form__inner">
            <?= $form->field($model, 'category')->dropDownList(Orders::getCategoryList('Выбрать услугу'), ['class' => 'app-form__select'])
                ->label('Выберите категорию услуги') ?>
        </div>
    </fieldset>
    <fieldset class="app-form__fieldset">
        <div class="app-form__inner">
            <?= $form->field($model, 'description')->textarea(['class' => 'app-form__textarea', 'placeholder' => 'Опишите, что именно нужно сделать'])
                ->label('Опишите пожелания и детали') ?>
        </div>
    </fieldset>
    <fieldset class="app-form__fieldset">
        <div class="app-form__inner order-date-time">
									<span class="app-form__name">
										Выберите дату и время
									</span>
            <div class="app-form__blocks">
                <?= $form->field($model, 'date')->input('date', ['class' => 'app-form__input'])->label(false) ?>
                <?= $form->field($model, 'time')->input('time', ['class' => 'app-form__input'])->label(false) ?>
            </div>
        </div>
    </fieldset>
    <fieldset class="app-form__fieldset">
        <div class="app-form__inner">
									<span class="app-form__name">
										Место оказания услуги
									</span>
            <div class="app-form__box order-place">
                <div class="app-form__box-btn<?=!$model->place ?  ' active' : ''?>">
                    У меня
                </div>
                <div class="app-form__box-btn<?=($model->place == 1) ?  ' active' : ''?>">
                    У исполнителя
                </div>
                <div class="app-form__box-btn<?=($model->place == 2) ?  ' active' : ''?>">
                    Неважно
                </div>
            </div>
            <?= $form->field($model, 'place')->hiddenInput(['id' => 'order-place', 'value' => $model->place ? $model->place : 0])->label(false) ?>
            <? $this->registerJs(
                "$('.order-place .app-form__box-btn').on('click', function () {
    $('.order-place .app-form__box-btn').removeClass('active');
    $(this).addClass('active');
    $('#order-place').val($(this).index('.app-form__box-btn'));
  })"
            ) ?>
        </div>
    </fieldset>
    <fieldset class="app-form__fieldset">
        <div class="app-form__inner">
									<span class="app-form__name">
										Ваш адрес
									</span>
            <div class="app-form__block">
                <?= Html::activeTextInput($model, 'street', ['class' => 'app-form__block-input1', 'placeholder' => "Улица", 'value' => $user->info->street]) ?>
                <?= Html::activeTextInput($model, 'house', ['class' => 'app-form__block-input2', 'placeholder' => "Дом", 'value' => $user->info->house]) ?>
                <?= Html::activeTextInput($model, 'room', ['class' => 'app-form__block-input3', 'placeholder' => "Квартира", 'value' => $user->info->room]) ?>
                <?= Html::activeTextInput($model, 'housing', ['class' => 'app-form__block-input4', 'placeholder' => "Корпус", 'value' => $user->info->housing]) ?>
            </div>
        </div>
    </fieldset>
    <fieldset class="app-form__fieldset">
        <div class="app-form__inner">
            <?= $form->field($model, 'pay_method')->dropDownList(Orders::getPaymentList(), ['class' => 'app-form__select'])
                ->label('Выберите способ оплаты') ?>
        </div>
    </fieldset>
    <fieldset class="app-form__fieldset">
        <div class="app-form__inner">
            <?= $form->field($model, 'price')->textInput(['class' => 'app-form__block-input3', 'placeholder' => 'Стоимость']) ?>
        </div>
    </fieldset>
    <?= Html::submitButton('Опубликовать', ['class' => 'app-form__btn button_click']) ?>
    <? ActiveForm::end(); ?>
</div>

