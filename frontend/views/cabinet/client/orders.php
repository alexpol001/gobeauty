<?php
/* @var $this \yii\web\View */

use common\components\Common;
use common\models\Orders;
use yii\helpers\Url;

/* @var $user \common\models\User */
/* @var $slug string */

$this->title = 'Мои заявки';
$orders = $user->getClientOrders($slug);
?>
<div class="request__description">
    <div class="request-select">
        <p class="request-select-name">Выберите категорию заявок</p>
        <select id="filter-client-orders" class="request-select-list">
            <option value="">Все заявки (<?= count($user->getClientOrders()) ?>)</option>
            <? foreach (Orders::getCategories() as $category) : ?>
                <option value="<?= $category->slug ?>"<?= ($category->slug == $slug) ? ' selected' : '' ?>><?= $category->title ?></option>
            <? endforeach; ?>
        </select>
    </div>
    <div class="request__list">
        <? foreach ($orders as $order) : ?>
            <a href="<?= Url::to(['cabinet/client-order-view', 'id' => $order->id]) ?>" class="request__inner">
                <div class="request__block">
                    <div class="request__block-box">
                        <p class="request__block-name">
                            <?= $order->description ?>
                        </p>
                        <span class="request__block-data">
                            <?= $order->getDateDate() ?>
										</span>
                        |
                        <span class="request__block-clock">
                            <?= $order->getDateTime() ?>
										</span>
                    </div>
                    <div class="request__block__link">
                        <? if ($order->status) : ?>
                            <? if (!$order->master && $order->date > time()): ?>
                                <span class="request__block-ref request__block-ref--expect">Ожидается выбор</span>
                            <? elseif ($order->date > time()) : ?>
                                <a href="" class="request__block-ref request__block-ref--execut">В исполнении</a>
                            <? else: ?>
                                <a href="" class="request__block-ref">Завершено</a>
                            <? endif; ?>
                        <? else: ?>
                            <span class="request__block-ref">На модерации</span>
                        <? endif; ?>
                    </div>
                </div>
                <div class="request__block-user">
                    <div class="request__block-user-box">
                        <div>
                            <p class="request__block-user-title">
                                Исполнитель
                            </p>
                            <? if ($order->master) : ?>
                                <div class="notify-box__list">
                                    <div class="crop__image">
                                        <? $small_photo = $order->master->info->getSmallPhoto(); ?>
                                        <img <?= $small_photo ? 'src="' . $small_photo . '?nocache=' . time() .
                                            '"' : 'class="none" src="/img/client-name.svg"' ?> alt="">
                                    </div>
                                    <div class="right-block">
                                        <?
                                        $name = $order->master->info->name;
                                        ?>
                                        <p class="notify-box__name"><?= $name ? $name : 'Без имени' ?></p>
                                    </div>
                                </div>
                            <? else: ?>
                                <p class="request__block-user-proposal">
                                    <?= Common::plural_form(count($order->getMasters()), ['предложение', 'предложения', 'предложений']) ?>
                                </p>
                            <? endif; ?>
                        </div>
                        <div class="request__block-user-link">
                            <?= $order->getFormattedPrice(); ?>
                        </div>
                    </div>
                </div>
            </a>
        <? endforeach; ?>
    </div>
</div>
