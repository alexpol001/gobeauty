<?php
/* @var $this \yii\web\View */

use common\models\Orders;

/* @var $user \common\models\User */
$orders = $user->getMasterOrders($slug);
$this->title = 'Мои заявки';
?>
<div class="demand__description">
    <h2 class="demand__name">
        Выберите категорию заявок
    </h2>
    <div class="demand__select">
        <select id="filter-master-orders" class="demand__select-list">
            <option value="">Все заявки (<?= count($user->getMasterOrders()) ?>)</option>
            <? foreach (Orders::getCategories() as $category) : ?>
                <option value="<?= $category->slug ?>"<?= ($category->slug == $slug) ? ' selected' : '' ?>><?= $category->title ?></option>
            <? endforeach; ?>
        </select>
    </div>
    <div class="demand__list">
        <? foreach ($orders as $order) : ?>
            <div class="demand__list-block">
                <div class="demand__list-item">
                    <div class="demand-box">
                        <p class="demand-box__text"><?= $order->description ?></p>
                        <p href="" class="demand-box__data"><span class="data"><?= $order->getDateDate() ?></span> |
                            <span class="clock"><?= $order->getDateTime() ?></span></p>
                        <? if (!$order->master): ?>
                            <span class="demand-box__color demand-box__color--expectat">Ожидается выбор</span>
                        <? elseif ($order->date > time()) : ?>
                            <span class="demand-box__color demand-box__color--execution ">В исполнении</span>
                        <? else: ?>
                            <span class="request__block-ref">Завершено</span>
                        <? endif; ?>
                    </div>
                    <div class="demand-box__btn"><?= $order->getFormattedPrice() ?></div>
                </div>
                <? if ($order->master) : ?>
                    <div class="notify-box">
                        <div class="notify-box__list">
                            <div class="crop__image">
                                <? $small_photo = $order->master->info->getSmallPhoto();?>
                                <img <?= $small_photo ? 'src="' . $small_photo . '?nocache=' . time() .
                                    '"' : 'class="none" src="/img/client-name.svg"' ?> alt="">
                            </div>
                            <div class="right-block">
                                <?
                                $name = $order->client->info->name;
                                $phone = $order->client->info->phone;
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
                <? endif; ?>
            </div>
        <? endforeach; ?>
    </div>
</div>

