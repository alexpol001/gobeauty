<?php
/* @var $this \yii\web\View */

/* @var $user \common\models\User */
/* @var $files_add array */

$this->title = 'Портфолио';
$small_photo = $user->info->getSmallPhoto();

use common\components\Common; ?>
<div class="cabinet__description">
        <div class="portfolio">
            <p>
                Вы можете загрузить до 5 фотографий своих работ
            </p>
            <?=
            \kartik\file\FileInput::widget([
                'name' => 'portfolio',
                'options' => [
                    'accept' => 'image/*',
                    'multiple' => true,
                ],
                'pluginOptions' => [
                    'uploadUrl' => \yii\helpers\Url::to(['portfolio-upload']),
                    'maxFileSize' => 2048,
                    'maxFileCount' => 5,
                    'overwriteInitial' => false,
                    'allowedFileExtensions' =>  ['jpg'],
                    'initialPreview' => $files_add,
                    'initialPreviewConfig' => Common::getUserPortfolioFileArray($user->info->getPortfolioFiles()),
                    'showUpload' => true,
                    'showRemove' => false,
                    'showFooterCaption' => false,
                    'msgUploadError' => 'Ну удалось загрузить файл',
                ]
            ]);
            ?>
        </div>
</div>
