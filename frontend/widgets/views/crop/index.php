<?php
\frontend\widgets\assets\PhotoAsset::register($this);

/* @var $this yii\web\View */

/* @var $model \frontend\widgets\models\PhotoForm */

use yii\bootstrap\ActiveForm;
use yii\helpers\Html; ?>
<?php if (Yii::$app->session->hasFlash('photoUpdated')) { ?>

    <?php
    $this->registerJs(
        "$('#modalCrop').modal('show');",
        yii\web\View::POS_READY
    );
    ?>

<?php } ?>
<div class="modal fade image-modal" id="modalCrop" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">х</span></button>
                <div class="modal-title">
                    <h3 class="modal-title-text" id="myModalCrop">Выберите миниатюру</h3>
                </div>
            </div>
            <div class="modal-body">
                <p>
                    Выберите область фотографии, которая будет отображаться в вашем профиле.
                </p>
                <? if ($photo = $model->user->info->getPhoto()) : ?>
                    <?php $form = ActiveForm::begin(['options' => ['id' => 'cropform']]) ?>
                    <div class="image-crop" data-points="<?=$model->user->info->photo_points?>">
                        <img src="<?= $photo . '?nocache=' . time() ?>" alt="">
                    </div>
                    <?=$form->field($model, 'photo_points')->label(false)->hiddenInput(['id' => 'crop-points'])?>
                    <div class="form-group">
                        <?= Html::submitButton('Сохранить изменения', ['class' => 'button_click', 'name' => 'crop', 'value' => 'crop']) ?>
                    </div>
                    <? ActiveForm::end(); ?>
                <? endif; ?>
            </div>
        </div>
    </div>
</div>
