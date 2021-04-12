<?php
/* @var $this \yii\web\View */

use common\components\Common;
use common\models\Orders;
use yii\helpers\Url;

/* @var $user \common\models\User */
/* @var $model \common\models\Orders */

$this->title = 'Мои заявки';
?>
<div class="view__description">
    <div class="view__list">
        <div class="view__list-item">
            <div class="view__list-box">
                <p class="view__list-box-text">
                    <?= $model->description ?>
                </p>
                <span href="" class="view__list-box-link">
                    <span class="data"><?= $model->getDateDate() ?></span>  |  <span
                            class="clock"><?= $model->getDateTime() ?></span>
                </span>
            </div>
            <span href="" class="view__list-item-link">
                Ожидается выбор исполнителя (<?=Common::plural_form(count($model->mOrders), ['предложение', 'предложения', 'предложений'])?>)
            </span>
        </div>
        <div class="view__descr">
            <div class="view__descr-list">
                <div class="view__descr-box">
                    <p class="view__descr-box-name">Место оказания услуги</p>
                    <span class="view__descr-box-ref"><?= $model->getPlaceName() ?></span>
                </div>
                <div class="view__descr-box">
                    <p class="view__descr-box-name">Способ оплаты</p>
                    <span class="view__descr-box-ref"><?= Orders::getPaymentList()[$model->pay_method] ?></span>
                </div>
                <div class="view__descr-box-btn"><?= $model->getFormattedPrice() ?></div>
            </div>
        </div>
        <a href="<?= Url::to(['master-request', 'id' => $model->id]) ?>" class="view__link button_click">Отправить
            преложение</a>
    </div>
    <div class="view__proposal">
        <div class="view__proposal-descr">
            <? if (!$model->master) : ?>
                <? if ($orders = ($model->mOrders)) : ?>
                    <p class="view__proposal-name">
                        Предложения мастеров
                    </p>
                    <? foreach ($orders as $order) : ?>
                        <div class="my-application__user-box">
                            <a href="<?=Url::to(['master-view', 'id' => $order->user->id])?>">
                                <div class="my-application__user-data">
                                    <div class="crop__image">
                                        <? $small_photo = $order->user->info->getSmallPhoto();?>
                                        <img <?= $small_photo ? 'src="' . $small_photo . '?nocache=' . time() .
                                            '"' : 'class="none" src="/img/client-name.svg"' ?> alt="">
                                    </div>
                                    <div class="right-block">
                                        <p class="my-application__user-text">
                                            <?= $order->user->info->name ? $order->user->info->name : 'Без имени' ?>
                                        </p>
                                        <span class="my-application__user-commet">
                                    <?=Common::plural_form(count($order->user->reviews), ['отзыв', 'отзыва', 'отзывов'])?>
								</span>
                                    </div>
                                </div>
                            </a>
                        </div>
                    <? endforeach; ?>
                <? endif; ?>
            <? else: ?>

            <? endif; ?>
        </div>
    </div>
</div>
