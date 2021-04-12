<?php
/* @var $this \yii\web\View */

/* @var $user \common\models\User */
/* @var $masters \common\models\User[] */
/* @var $slug string */

$this->title = 'Поиск мастера';

use common\models\Orders;
use yii\helpers\Html; ?>
<div class="cabinet__description geo-search">
    <div class="app-form__inner">
        <select id="filter-client-geo-search" class="app-form__select">
        <span class="app-form__name">
			Выберите категорию услуг
		</span>
            <option value="">Все услуги</option>
            <? foreach (Orders::getCategories() as $category) : ?>
                <option value="<?= $category->slug ?>"<?= ($category->slug == $slug) ? ' selected' : '' ?>><?= $category->title ?></option>
            <? endforeach; ?>
        </select>
    </div>
    <? if (count($masters) > 1) : ?>
        <div class="cabinet-list">
            <div class="list-wrap">
                <?= $this->render('../elements/geo-masters', [
                    'user' => $user,
                    'masters' => $masters,
                ]) ?>
            </div>
            <?=
            Html::a('Показать еще', ['become-client'], [
                'title' => Yii::t('app', 'Показать еще'),
                'class' => 'button_click',
                'id' => 'more-geo',
            ]);
            ?>
        </div>
    <? endif; ?>
</div>
