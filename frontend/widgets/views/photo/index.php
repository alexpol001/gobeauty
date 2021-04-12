<?php
\frontend\widgets\assets\PhotoAsset::register($this);

use yii\bootstrap\ActiveForm;
use yii\helpers\Html; ?>
<div class="modal fade image-modal" id="modalPhoto" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">х</span></button>
                <div class="modal-title">
                    <h3 class="modal-title-text" id="myModalPhoto">Изменить фотографию</h3>
                </div>
            </div>
            <div class="modal-body">
                <p>
                    Загрузите фотографию, которая будет отображаться в вашем профиле.
                </p>
                <?php $form = ActiveForm::begin(['options' => ['id' => 'photoform', 'enctype' => 'multipart/form-data']]) ?>

                <?= $form->field($model, 'file')->label(false)->fileInput(['id' => 'photoform-file', 'style' => 'display: none;']) ?>

                <div class="form-group">
                    <?=Html::submitButton('Выбрать файл', ['class' => 'button_click', 'name' => 'upload', 'value' => 'upload'])?>
                </div>

                <? ActiveForm::end();?>
            </div>
        </div>
    </div>
</div>
