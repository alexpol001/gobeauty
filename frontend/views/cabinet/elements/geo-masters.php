<?php
/* @var $this \yii\web\View */

/* @var $user \common\models\User */
/* @var $masters \common\models\User[] */
?>
<? foreach ($masters as $key => $master) : ?>
    <? if ($key !== 'finish') : ?>
        <? $small_photo = $master->info->getSmallPhoto(); ?>
        <div class="cabinet-profile" data-master-id="<?= $master->id ?>">
            <div class="cabinet-main">
                <div class="cabinet__name">
                    <div class="crop__image">
                        <img <?= $small_photo ? 'src="' . $small_photo .
                            '"' : 'class="none" src="/img/client-name.svg"' ?> alt="">
                    </div>
                </div>
                <div class="cabinet-info">
                    <div class="profile-name">
                        <?= $master->info->name ? $master->info->name : 'Без имени' ?>
                        <span class="distance">
                                    <? if (($distance = $master->getDistance($user)) !== null) : ?>
                                        (<?= $distance ?> км)
                                    <? else: ?>
                                        (Расстояние не определено)
                                    <? endif; ?>
                                </span>
                    </div>
                    <div class="cabinet-description">
                        <?= $master->info->description ?>
                    </div>
                </div>
                <div class="clearfix"></div>
            </div>
            <hr>
            <div class="cabinet-add">
                <div class="left-block">
                    <div class="cabinet__description-block">
                        <p class="cabinet__description-info">
                            Портфолио
                        </p>
                        <? if ($images = $master->info->getPortfolioImages()) : ?>
                            <div class="cabinet__description-promo">
                                <? foreach ($images as $image) : ?>
                                    <div class="cabinet__description-promo-item">
                                        <?= $image ?>
                                    </div>
                                <? endforeach; ?>
                            </div>
                        <? else : ?>
                            <p>Портфолио не заполнено</p>
                        <? endif; ?>
                    </div>
                </div>
                <div class="right-block">
                    <div class="cabinet__description-block">
                        <p class="cabinet__description-info">
                            Адрес
                        </p>
                        <p class="cabinet-local">
                            <? if ($city = $master->info->city) : ?>
                                <? $street = $master->info->street; ?>
                                <? $house = $master->info->house; ?>
                                <?=
                                'г. ' . $city .
                                ($street ? ', ул. ' . $street : '') .
                                (($street && $house) ? ', д. ' . $house : '')
                                ?>
                            <? else: ?>
                                Не указан
                            <? endif; ?>
                        </p>
                    </div>
                    <div class="cabinet__description-block">
                        <p class="cabinet__description-info">
                            Номер телефона
                        </p>
                        <? if ($phone = $master->info->phone) : ?>
                            <p class="notify-box__tel"><?= $phone ?></p>
                            <a href="tel:<?= str_replace('-', '', $phone) ?>" class="notify-box__link button_click">Позвонить</a>
                        <? else: ?>
                            <p class="notify-box__tel">Не указан</p>
                        <? endif; ?>
                    </div>
                </div>
            </div>
            <div class="clearfix"></div>
        </div>
        <hr>
    <? else : ?>
        <div id="masters-end"></div>
    <? endif; ?>
<? endforeach; ?>
