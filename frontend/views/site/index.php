<?php
/* @var $this \yii\web\View */
/* @var $user \common\models\User */

    use common\models\Orders;
    use common\models\swp\Group;use yii\helpers\Url;

    $this->title = "Главная";
?>
<section class="banner">
    <div class="banner__inner">
        <h1 class="banner__title">
            Экспресс-сервис <span>твоей красоты</span>
        </h1>
        <p class="banner__text">
            Наша главная цель - помощь в поиске мастеров красоты и стилистов в вашем городе. Разместите свое задание и выберите понравившегося мастера.
        </p>
        <div>
            <? if (!$user || ($user->is_client || !$user->is_master)) :?>
                <a class="banner__link button_click" href="<?= Url::to(['cabinet/create-order'])?>">Найти мастера</a>
            <? else : ?>
                <a class="banner__link button_click" href="<?= Url::to(['cabinet/search-order'])?>">Найти клиента</a>
            <? endif; ?>
        </div>
    </div>
</section>
<section class="service">
    <h2 class="service__title">
        Категории предлагаемых услуг
    </h2>
    <p class="service__text">
        Выберите интересующий раздел
    </p>
    <ul class="service__list">
        <? for ($i = 0, $categories = Orders::getCategories(); ($i < 6 && $categories[$i]); $i++) :?>
        <li class="service__item">
            <div class="service__block">
                <img src="<?=$categories[$i]->getValue(17)?>" width="260" height="387" alt="Картинка" class="service__img">
                <h3 class="service__name">
                    <?=$categories[$i]->title?>
                </h3>
                <a href="<?=Url::to(['cabinet/'.(($user->is_client || !$user->is_master) ? 'create-order' : 'search-order'), 'slug' => $categories[$i]->slug])?>" class="service__link">
                    Перейти
                </a>
            </div>
        </li>
        <? endfor;?>
    </ul>
</section>
<section class="advantage">
    <h2 class="advantage__title">
        Преимущества нашего сервиса
    </h2>
    <p class="advantage__text">
        Почему стоит выбирать именно нас
    </p>
    <ul class="advantage__list">
        <li class="advantage__item">
            <div class="advantage__picture advantage__picture--one">
                <img src="img/wizard.svg" width="72" height="72" alt="" class="advantage__img">
            </div>
            <div class="advantage__block">
                <h3 class="advantage__name">
                    Профессиональные мастера
                </h3>
                <p>
                    Мы с максимальной ответственностью подходим к выбору мастеров, работающих на нашем сервисе
                </p>
            </div>
        </li>
        <li class="advantage__item">
            <div class="advantage__picture advantage__picture--two">
                <img src="img/transactions.svg" width="72" height="72" alt="" class="advantage__img">
            </div>
            <div class="advantage__block">
                <h3 class="advantage__name">
                    Безопасная сделка
                </h3>
                <p>
                    Найдя специалиста на нашем сервисе, вы можете совершить оплату без риска с гарантией возврата
                </p>
            </div>
        </li>
        <li class="advantage__item">
            <div class="advantage__picture advantage__picture--three">
                <img src="img/price.svg" width="72" height="72" alt="" class="advantage__img">
            </div>
            <div class="advantage__block">
                <h3 class="advantage__name">
                    Низкие цены
                </h3>
                <p>
                    Опубликовав задание, заказчик самостоятельно выбирает специалиста и цену оказываемой услуги
                </p>
            </div>
        </li>
    </ul>
</section>
<section class="work">
    <div class="work__wrraper">
        <h2 class="work__title">
            Этапы работы на сервисе
        </h2>
        <p class="work__text">
            Каждый этап простой и понятный
        </p>
        <ul class="work__list">
            <div class="work__inner work__inner--one">
                <li class="work__item">
                    <div class="work__block">
                        <img src="img/one_work.jpg" width="136" height="123" alt="Первый этап" class="work__img">
                        <p class="work__name">
                            Регистрируетесь на сайте и формируете задание
                        </p>
                    </div>
                </li>
                <line class="work__line work__line--one">
                </line>
                </line>
                <li class="work__item">
                    <div class="work__block">
                        <img src="img/two_work.jpg" width="169" height="123" alt="Второй этап" class="work__img">
                        <p class="work__name">
                            Выбираете понравившегося вам исполнителя
                        </p>
                    </div>
                </li>
            </div>
            <div class="work__inner work__inner--two">
                <li class="work__item">
                    <div class="work__block">
                        <img src="img/three_work.jpg" width="169" height="123" alt="Третий этап" class="work__img">
                        <p class="work__name">
                            Назначается удобное время встречи с мастером
                        </p>
                    </div>
                </li>
                <line class="work__line work__line--two">
                </line>
                <li class="work__item">
                    <div class="work__block">
                        <img src="img/four_work.jpg" width="180" height="123" alt="Четвертый этап" class="work__img">
                        <p class="work__name">
                            Вы получаете услуги и оплачиваете её мастеру
                        </p>
                    </div>
                </li>
            </div>
        </ul>
    </div>
</section>
<? if ($reviews = Group::findOne(9)->materials) :?>
<section class="reviews">
    <h2 class="reviews__title">
        Отзывы клиентов
    </h2>
    <p class="reviews__text">
        Мнение о нашем сервисе
    </p>
    <div class="reviews__slider">
        <? foreach ($reviews as $review) :?>
        <blockquote class="reviews__item">
            <div class="reviews__wrraper">
                <div class="reviews__picture">
                    <img src="<?=$review->getValue(21)?>" width="80" height="80" alt="" class="reviews__img">
                </div>
                <div class="reviews__inner">
                    <b class="reviews__name">
                        <?=$review->title?>
                    </b>
                    <p>
                        <?=$review->getValue(20)?>
                    </p>
                </div>
            </div>
        </blockquote>
        <? endforeach; ?>
    </div>
</section>
<? endif; ?>
<section class="application">
    <div class="application__wrraper">
        <div class="application__picture">
            <img src="img/smartfon.png" width="390" height="551" alt="Смартфон" class="application__img">
        </div>
        <div class="application__inner">
            <h2 class="application__title">
                Приложение для смартфонов
            </h2>
            <div class="application__description">
                <p>
                    Для более удобного поиска исполнителей или поиска заказчиков мы разработали приложение. Благодаря этому, все задачи можно сделать прямо в телефоне.
                </p>
            </div>
            <p class="application__name">
                Доступно для скачивания:
            </p>
            <ul class="application__list">
                <li class="application__item">
                    <a class="application__link" href="">
                        <div class="application__link--google"></div>
                    </a>
                </li>
                <li class="application__item">
                    <a class="application__link" href="">
                        <div class="application__link--app"></div>
                    </a>
                </li>
            </ul>
        </div>
    </div>
</section>
