<?php
/* @var $this \yii\web\View */
/* @var $user \common\models\User */
/* @var $model \frontend\models\ContactForm */

$this->title = 'Поддержка';

use yii\bootstrap\ActiveForm;
use yii\helpers\Html;

?>
<div class="support__description">
    <div class="support__description-text">
        <p>
            Сообщите нам, если у Вас возникли какие-либо трудности или вопросы!
        </p>
        <span>
								Мы рещим их для Вас!
							</span>
    </div>
    <? $form = ActiveForm::begin(['class' => 'support-form']) ?>
    <div class="support-form__text">
        <label  class="support-form__list support-form__list--textarea">
									<span class="support-form__name">
										Опишите вашу проблему
									</span>
            <?= $form->field($model, 'body')->label(false)->textarea(['class' => 'support-form__input form-control', 'placeholder' => 'Опишите, что нужно решить']) ?>
        </label>
    </div>
    <?=Html::submitButton('связаться', [
            'class' => 'support__link button_click',
    ])?>
    <? ActiveForm::end();?>
</div>

