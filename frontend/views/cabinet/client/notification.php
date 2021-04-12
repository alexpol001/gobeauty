-<?php
/* @var $this \yii\web\View */

use common\components\Common;
use common\models\Notification;
use common\models\Orders;
use yii\helpers\Url;

/* @var $user \common\models\User */
/* @var $slug string */

$this->title = 'Уведомления';
?>
<div class="notice__description">
    <form action="" method="" class="app-form">
        <div class="app-form__inner">
									<span class="app-form__name">
										Выберите категорию уведомлений
									</span>
            <select id="filter-client-notification" class="app-form__select">
                <option value="">Все уведомления</option>
                <? foreach (Orders::getCategories() as $category) : ?>
                    <option value="<?= $category->slug ?>"<?= ($category->slug == $slug) ? ' selected' : ''?>><?= $category->title ?></option>
                <? endforeach; ?>
            </select>
        </div>
    </form>
    <div class="notice__list">
        <? foreach (Notification::getClientNotification($user, $slug) as $notification) :?>
            <div class="notice__item">
									<span class="notice__item__text">
										<?=Common::plural_form($notification->value, ['новое предложение', 'новых предложения', 'новых предложений'])?> от мастеров на вашу заявку<a href="<?=Url::to(['client-order-view', 'id' => $notification->order->id]);?>"><?=$notification->order->description?></a>
									</span>
                <div class="notice__item-descr">
                    <p class="notice__item-data">
                        <span><?=$notification->getCreateDate()?></span>
                    </p>
                    <a href="<?=Url::to(['client-order-view', 'id' => $notification->order->id]);?>" class="notice__item-link">Посмотреть</a>
                </div>
            </div>
        <? endforeach;?>
    </div>
</div>

