<?php
/* @var $this \yii\web\View */

use common\components\Common;
use common\models\Orders;
use yii\helpers\Html;
use yii\helpers\Url;

/* @var $user \common\models\User */
/* @var $model \common\models\Orders */

$this->title = 'Мои заявки';
?>
<div class="my-application__description">
    <div class="my-application__inner">
        <div class="my-application__block">
            <p class="my-application__block-name">
                <?= $model->description ?>
            </p>
            <span class="my-application__block-data">
										<?= $model->getDateDate() ?>
									</span>
            |
            <span class="my-application__block-clock">
										<?= $model->getDateTime() ?>
									</span>
        </div>
        <div class="my-application__block-box">
            <div class="my-application__block-box-item">
                <p class="my-application__block-names">
                    Место оказания услуги
                </p>
                <span class="my-application__block-text">
										<?= $model->getPlaceName() ?>
									</span>
            </div>
            <div class="my-application__block-box-item">
                <p class="my-application__block-names">
                    Способ оплаты
                </p>
                <span class="my-application__block-text">
										<?= Orders::getPaymentList()[$model->pay_method] ?>
									</span>
            </div>
            <div class="my-application__block-box-item">
                <div class="my-application__block-btn">
                    <?= $model->getFormattedPrice(); ?>
                </div>
            </div>
        </div>
        <div class="my-application__block-link">
            <a href="<?= Url::to(['update-order', 'id' => $model->id]) ?>"
               class="my-application__ref my-application__ref--transform button_click">
                Изменить
            </a>
            <?=
            Html::a('Удалить', ['delete-order', 'id' => $model->id], [
                'class' => 'my-application__ref my-application__ref--delete button_click',
                'title' => Yii::t('app', 'Удалить'),
                'data' => [
                    'confirm' => 'Вы действительно хотите удалить вабранные объекты?',
                    'method' => 'post',
                ],
            ]);
            ?>
        </div>
    </div>
    <div class="my-application-user-block">
        <div class="my-application__user">
            <? if (!$model->master) : ?>
                <p class="my-application__block-title">
                    Предложения мастеров
                </p>
                <? foreach ($model->getMasters() as $master) : ?>
                    <div class="my-application__user-box">
                        <a href="<?=Url::to(['master-view', 'id' => $master->id])?>">
                            <div class="my-application__user-data">
                                <div class="crop__image">
                                    <? $small_photo = $master->info->getSmallPhoto();?>
                                    <img <?= $small_photo ? 'src="' . $small_photo . '?nocache=' . time() .
                                        '"' : 'class="none" src="/img/client-name.svg"' ?> alt="">
                                </div>
                                <div class="right-block">
                                    <p class="my-application__user-text">
                                        <?= $master->info->name ? $master->info->name : 'Без имени' ?>
                                    </p>
                                    <span class="my-application__user-commet">
                                    <?=Common::plural_form(count($master->reviews), ['отзыв', 'отзыва', 'отзывов'])?>
								</span>
                                </div>
                            </div>
                        </a>
                        <?=
                        Html::a('Выбрать', ['select-order-master', 'id' => $model->id, 'master_id' => $master->id], [
                            'class' => 'my-application__user-link',
                            'title' => Yii::t('app', 'Выбрать'),
                            'data' => [
                                'confirm' => 'Вы действительно хотите выбрать данного мастера в качестве исполнителя?',
                                'method' => 'post',
                            ],
                        ]);
                        ?>
                    </div>
                <? endforeach; ?>
            <? else : ?>
                <p class="my-application__block-title">
                    Исполнитель
                </p>
                <div class="my-application__user-box">
                    <a href="<?=Url::to(['master-view', 'id' => $model->master->id])?>">
                        <div class="my-application__user-data">
                            <div class="crop__image">
                                <? $small_photo = $model->master->info->getSmallPhoto();?>
                                <img <?= $small_photo ? 'src="' . $small_photo . '?nocache=' . time() .
                                    '"' : 'class="none" src="/img/client-name.svg"' ?> alt="">
                            </div>
                            <div class="right-block">
                                <p class="my-application__user-text">
                                    <?= $model->master->info->name ? $model->master->info->name : 'Без имени' ?>
                                </p>
                                <span class="my-application__user-commet">
                                    <?=Common::plural_form(count($model->master->reviews), ['отзыв', 'отзыва', 'отзывов'])?>
								</span>
                            </div>
                        </div>
                    </a>
<!--                    --><?//=
//                    Html::a('Отменить выбор', ['select-order-master', 'id' => $model->id, 'master_id' => $master->id], [
//                        'class' => 'my-application__user-link',
//                        'title' => Yii::t('app', 'Отменить'),
//                        'data' => [
//                            'confirm' => 'Вы действительно хотите отменить данного мастера от исполнения?',
//                            'method' => 'post',
//                        ],
//                    ]);
//                    ?>
                </div>
            <? endif; ?>
        </div>
    </div>
</div>
