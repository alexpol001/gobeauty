<?php
/* @var $this \yii\web\View */

$user = \common\models\User::findOne(Yii::$app->user->id);
use yii\helpers\Url;

$this->registerLinkTag(['rel' => 'icon', 'type' => 'image/png', 'href' => Url::to(['/img/favicon.png'])]);
?>
<header class="page-header">
    <div class="page-header__inner">
        <a href="/" class="page-header__logo">
            <img src="/img/Logo.png" width="285" height="56" alt="Логотип" class="page-header__img">
        </a>
        <button class="page-header__mob-open"></button>
        <div class="user">
            <ul class="user__list<?= Yii::$app->user->isGuest ? '' : ' user__authered'?>">
                <? if (Yii::$app->user->isGuest) : ?>
                    <li class="user__item">
                        <a href="<?= Url::to(['site/login']) ?>" class="user__link">Вход</a>
                    </li>
                    <li class="user__item">
                        <a href="<?= Url::to(['site/signup']) ?>" class="user__link">Регистрация</a>
                    </li>
                <? else : ?>
                    <li class="user__item">
                        <a href="<?= Url::to([$user->is_master ? 'cabinet/master' : 'cabinet/client']) ?>" class="user__link to-cabinet">Кабинет</a>
                    </li>
                    <li class="user__item">
                        <a href="<?= Url::to(['site/logout']) ?>" class="user-exit__link">
                            Выйти
                        </a>
                    </li>
                <? endif; ?>
            </ul>
            <a href="<?=Url::to(['cabinet/create-order'])?>" class="user__btn button_click">Создать задание</a>
        </div>
    </div>
</header>
