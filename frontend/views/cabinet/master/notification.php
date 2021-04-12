<?php
/* @var $this \yii\web\View */

use common\models\Notification;
use common\models\Orders;
use yii\helpers\Url;

/* @var $user \common\models\User */
/* @var $slug string */

$this->title = 'Уведомления';
?>
<div class="notify__description">
    <h2 class="notify__name">
        Выберите категорию уведомлений
    </h2>
    <div class="notify__select">
        <select id="filter-master-notification" class="notify__select-list">
            <option value="">Все уведомления</option>
            <? foreach (Orders::getCategories() as $category) : ?>
                <option value="<?= $category->slug ?>"<?= ($category->slug == $slug) ? ' selected' : ''?>><?= $category->title ?></option>
            <? endforeach; ?>
        </select>
    </div>
    <div class="notify__list">
        <? foreach (Notification::getMasterNotification($user, $slug) as $notification) : ?>
            <div class="notify__list-item">
                <p class="notify__list-item-text">
                    Вас выбрали в качестве исполнителя заявки <a
                            href="<?= Url::to(['master-order-view', 'id' => $notification->order_id]) ?>"><?= $notification->order->description ?></a>
                </p>
                <span>
									Вы можете связаться с клиентом
								</span>
            </div>
            <div class="notify-box">
                <div class="notify-box__list">
                    <div class="crop__image">
                        <? $small_photo = $notification->order->client->info->getSmallPhoto();?>
                        <img <?= $small_photo ? 'src="' . $small_photo . '?nocache=' . time() .
                            '"' : 'class="none" src="/img/client-name.svg"' ?> alt="">
                    </div>
                    <div class="right-block">
                        <?
                        $name = $notification->order->client->info->name;
                        $phone = $notification->order->client->info->phone;
                        ?>
                        <p class="notify-box__name"><?= $name ? $name : 'Без имени' ?></p>
                        <!--                            <a href="" class="notify-box__response">10 отзывов</a>-->
                        <p class="notify-box__tel"><?= $phone ? $phone : 'Не указан' ?></p>
                    </div>
                </div>
                <? if ($phone) : ?>
                    <div class="notify-box__btn">
                        <a href="tel:<?=str_replace('-', '', $phone)?>" class="notify-box__link button_click">Позвонить</a>
                    </div>
                <? endif; ?>
            </div>
        <? endforeach; ?>
        <!--        <div class="notify-report">-->
        <!--            <div class="notify-report__list">-->
        <!--                <p class="notify-report__text">-->
        <!--                    Поздравляе! Вы отлично справились с работой! Заказчик оставил положительный отзыв.-->
        <!--                </p>-->
        <!--                <span class="notify-report__data"><a href="">12/12/2019</a></span>-->
        <!--            </div>-->
        <!--            <a href="" class="notify-report__link">Посмотреть</a>-->
        <!--        </div>-->
    </div>
</div>

