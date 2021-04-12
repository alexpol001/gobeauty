<?php
/* @var $this \yii\web\View */

use common\components\Common;
use yii\helpers\Html;
use yii\helpers\Url;

/* @var $user \common\models\User */
/* @var $nocache string */

$this->title = 'Клиент';
$small_photo = $user->info->getSmallPhoto();
?>
<div class="cabinet__description">
    <? if ($user->is_client) : ?>
        <div class="cabinet__description__list">
            <div class="cabinet__name">
                <div class="crop__image">
                    <img <?= $small_photo ? 'src="' . $small_photo . '?nocache=' . time() .
                        '"' : 'class="none" src="/img/client-name.svg"' ?> alt="">
                </div>
                <a href="#" class="cabinet__name-text" data-toggle="modal" data-target="#modalPhoto">Изменить фото</a>
                <? if ($small_photo) : ?>
                    <a href="#" class="cabinet__name-text" data-toggle="modal" data-target="#modalCrop">Изменить
                        Миниатюру</a>
                <? endif; ?>
            </div>
            <?= \frontend\widgets\PhotoWidget::widget([
                'user' => $user,
                'controller' => $this->context,
            ]) ?>
            <? if ($small_photo) : ?>
                <?= \frontend\widgets\CropWidget::widget([
                    'user' => $user,
                    'controller' => $this->context,
                ]) ?>
            <? endif; ?>
            <div class="cabinet__description-inner">
                <div class="cabinet__description-block">
                    <div class="cabinet__description__text">
                        <p class="cabinet__description__title"><?= $user->info->name ? $user->info->name : 'Без имени' ?></p>
                        <a href="<?= Url::to(['client-orders']) ?>"
                           class="cabinet-description__app">Клиент, <?= Common::plural_form(count($user->getClientOrders()), ['заявка', 'заявки', 'заявок']) ?></a>
                    </div>
                </div>
                <a href="<?= Url::to(['profile-edit']) ?>" class="cabinet__description__link">Редактировать</a>
            </div>
            <div class="cabinet__description-inner">
                <div class="cabinet__description-block">
                    <div class="cabinet__description__text">
                        <p class="cabinet__description-story">
                            <?= $user->info->description ? $user->info->description : 'Нет описания' ?>
                        </p>
                        <a href="" class="cabinet-local">
                            <?=
                            $user->info->city . ', ' .
                            $user->info->street . ', ' .
                            $user->info->house
                            ?>
                        </a>
                    </div>
                </div>
                <a href="<?= Url::to(['profile-edit']) ?>" class="cabinet__description__link">Редактировать</a>
            </div>
            <div class="cabinet__description-inner">
                <div class="cabinet__description-block">
                    <p class="cabinet__description-info">
                        Контактные данные
                    </p>
                    <span class="cabinet-tel"><?= $user->info->phone ?></span>
                    <span class="cabinet-email"><?= $user->email ?></span>
                </div>
                <a href="<?= Url::to(['profile-edit']) ?>" class="cabinet__description__link">Редактировать</a>
            </div>
<!--            <div class="cabinet__description-inner">-->
<!--                <div class="cabinet__description-block">-->
<!--                    <p class="cabinet__description-balance">-->
<!--                        Баланс-->
<!--                    </p>-->
<!--                    <a href="" class="cabinet-summ">-->
<!--                        3 500 рублей-->
<!--                    </a>-->
<!--                </div>-->
<!--                <a href="balance.html" class="cabinet__description__link"><span class="color">Пополнить</span><br>или-->
<!--                    вывести</a>-->
<!--            </div>-->
        </div>
    <? else: ?>
        <div class="become">
            <p>
                Данный раздел предназначен только для клиентов. Вы хотите им стать?
            </p>
            <?=
            Html::a('Стать клиентом', ['become-client'], [
                'title' => Yii::t('app', 'Стать клиентом'),
                'class' => 'button_click',
                'data' => [
                    'confirm' => 'Вы действительно хотите стать клиентом?',
                    'method' => 'post',
                ],
            ]);
            ?>
        </div>
    <? endif; ?>
</div>
