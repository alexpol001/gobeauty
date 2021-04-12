<?php
/* @var $this \yii\web\View */
/* @var $user \common\models\User */
/* @var $slug string */
/* @var $orders \common\models\Orders[] */

$this->title = 'Поиск заказов';

use common\models\Orders;
use yii\helpers\Url; ?>
<div class="order__description">
    <h2 class="order__name">
        Выберите категорию заказа
    </h2>
    <div class="order__select">
        <select id="filter-search-orders" class="order__select-list">
            <option value="">Все категории</option>
            <? foreach (Orders::getCategories() as $category) :?>
                <option value="<?=$category->slug?>"<?= ($category->slug == $slug) ? ' selected' : ''?>><?=$category->title?></option>
            <? endforeach; ?>
        </select>
    </div>
    <div class="order__list">
        <? foreach ($orders as $order) :?>
            <div class="order__descr">
                <div class="order__descr-data">
                    <div class="order__descr-text">
                        <p><?=$order->description?></p>
                        <a><span class="data"><?=$order->getDateDate()?></span>  |  <span class="clock"><?=$order->getDateTime()?></span></a>
                    </div>
                    <a href="<?=Url::to(['master-order-view', 'id' => $order->id])?>" class="order__descr-choice">Ожидается выбор</a>
                </div>
                <div class="order__descr-service">
                    <div class="order__descr-name">
                        <p>Категория:</p>
                        <a class="order__descr-name-link" href="<?=Url::to(['search-order', 'slug' => $order->getCategory()->slug])?>"><?=$order->getCategory()->title?></a>
                    </div>
                    <div class="order__btn-summ"><?=$order->getFormattedPrice()?></div>
                </div>
            </div>
        <?endforeach;?>
    </div>
</div>

