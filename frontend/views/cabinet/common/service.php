<?php
/* @var $this \yii\web\View */
/* @var $user \common\models\User */

$this->title = 'О сервисе';

use common\models\swp\Material;
use yii\helpers\Url; ?>
<div class="about-us__description">
    <div class="about-us__description-logo">
        <img src="/img/about-logo.png" width="285" height="56" alt="Логотип">
    </div>
    <ul class="about-us__description-list">
        <li class="about-us__description-item">
            <div class="about-us__description-name">
                <?=Material::findOne(22)->getValue(23)?>
            </div>
            <a href="<?=Url::to(['cabinet/create-order'])?>" class="about-us__description-link button_click">
                Создать заявку
            </a>
        </li>
        <li class="about-us__description-item">
            <div class="about-us__description-name">
                <?=Material::findOne(23)->getValue(23)?>
            </div>
            <a href="<?=Url::to(['cabinet/search-order'])?>" class="about-us__description-link button_click">
                Искать заказы
            </a>
        </li>
    </ul>
</div>

