<?php
/* @var $this \yii\web\View */

use common\components\Common;
use kartik\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\helpers\Url;

/* @var $user \common\models\User */
/* @var $is_view boolean */
/* @var $review \common\models\Review */

$this->title = $is_view ? 'Просмотр мастера' : 'Мастер';
$small_photo = $user->info->getSmallPhoto();
?>
<div class="cabinet__description">
    <? if ($user->is_master) : ?>
        <div class="cabinet__description__list">
            <div class="cabinet__name">
                <div class="crop__image">
                    <img <?= $small_photo ? 'src="' . $small_photo . '?nocache=' . time() .
                        '"' : 'class="none" src="/img/client-name.svg"' ?> alt="">
                </div>
                <? if (!$is_view) : ?>
                    <a href="#" class="cabinet__name-text" data-toggle="modal" data-target="#modalPhoto">Изменить
                        фото</a>
                    <? if ($small_photo) : ?>
                        <a href="#" class="cabinet__name-text" data-toggle="modal" data-target="#modalCrop">Изменить
                            Миниатюру</a>
                    <? endif; ?>
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
                    <div class="client__description__text">
                        <p class="cabinet__description__title"><?= $user->info->name ? $user->info->name : 'Без имени' ?></p>
                        <a href=""
                           class="cabinet-description__app">Мастер, <?= Common::plural_form(count($user->getMasterOrders()), ['заказ', 'заказа', 'заказов']) ?></a>
                    </div>
                </div>
                <? if (!$is_view) : ?>
                    <a href="<?= Url::to(['profile-edit', 'type' => 'master']) ?>" class="cabinet__description__link">Редактировать</a>
                <? endif; ?>
            </div>
            <div class="cabinet__description-inner">
                <div class="cabinet__description-block">
                    <div class="client__description__text">
                        <p class="cabinet__description-story">
                            <?= $user->info->description ? $user->info->description : 'Нет описания' ?>
                        </p>
                        <a href class="cabinet-local">
                            <?=
                            $user->info->city . ', ' .
                            $user->info->street . ', ' .
                            $user->info->house
                            ?>
                        </a>
                    </div>
                </div>
                <? if (!$is_view) : ?>
                    <a href="<?= Url::to(['profile-edit', 'type' => 'master']) ?>" class="cabinet__description__link">Редактировать</a>
                <? endif; ?>
            </div>
            <div class="cabinet__description-inner">
                <div class="cabinet__description-block">
                    <p class="cabinet__description-info">
                        Портфолио
                    </p>
                    <? if ($images = $user->info->getPortfolioImages()) : ?>
                        <div class="cabinet__description-promo">
                            <? foreach ($user->info->getPortfolioImages() as $image) : ?>
                                <div class="cabinet__description-promo-item">
                                    <?= $image ?>
                                </div>
                            <? endforeach; ?>
                        </div>
                    <? endif; ?>
                </div>
                <? if (!$is_view) : ?>
                    <a href="<?= Url::to(['master-portfolio']) ?>" class="cabinet__description__link">Редактировать</a>
                <? endif; ?>
            </div>
            <div class="cabinet__description-inner">
                <div class="cabinet__description-block">
                    <p class="cabinet__description-info">
                        Контактные данные
                    </p>
                    <span class="cabinet-tel"><?= $user->info->phone ?></span>
                    <span class="cabinet-email"><?= $user->email ?></span>
                </div>
                <? if (!$is_view) : ?>
                    <a href="<?= Url::to(['profile-edit', 'type' => 'master']) ?>" class="cabinet__description__link">Редактировать</a>
                <? endif; ?>
            </div>
            <div class="cabinet__description-inner">
                <div class="cabinet__description-block review">
                    <p class="cabinet__description-info">
                        Отзывы
                    </p>
                    <? if ($review) : ?>
                        <? $form = ActiveForm::begin() ?>
                        <?= $form->field($review, 'text')->textarea() ?>
                        <div class="form-group">
                            <?= Html::submitButton('Оставить отзыв', ['class' => 'button_click']) ?>
                        </div>
                        <? ActiveForm::end() ?>
                    <? endif; ?>
                    <? if ($reviews = $user->reviews) : ?>
                        <? foreach ($reviews as $review) : ?>
                            <div class="client__description__text">
                                <p class="cabinet__description-story">
                                    <?=$review->text?>
                                </p>
                                <? if (!$is_view) : ?>
                                    <?=
                                    Html::a('Удалить', ['delete-review', 'id' => $review->id], [
                                        'class' => 'cabinet__description__link',
                                        'title' => Yii::t('app', 'Удалить'),
                                        'data' => [
                                            'confirm' => 'Вы действительно хотите удалить отзыв?',
                                            'method' => 'post',
                                        ],
                                    ]);
                                    ?>
                                <? endif; ?>
                                <div class="clearfix"></div>
                            </div>
                        <? endforeach; ?>
                    <? else : ?>
                        <div class="client__description__text">
                            Никто пока не оставил отзыв
                        </div>
                    <? endif; ?>
                </div>
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
            <!--                <a href="" class="cabinet__description__link">Вывести</a>-->
            <!--            </div>-->
        </div>
    <? else : ?>
        <div class="become">
            <p>
                Данный раздел предназначен только для мастеров. Вы хотите им стать?
            </p>
            <?=
            Html::a('Стать мастером', ['become-master'], [
                'title' => Yii::t('app', 'Стать мастером'),
                'class' => 'button_click',
                'data' => [
                    'confirm' => 'Вы действительно хотите стать мастером?',
                    'method' => 'post',
                ],
            ]);
            ?>
        </div>
    <? endif; ?>
</div>
