<?php

/* @var $this \yii\web\View */

/* @var $content string */

use common\models\Notification;
use frontend\assets\CabinetAsset;
use frontend\components\Frontend;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\Breadcrumbs;
use frontend\assets\AppAsset;
use common\widgets\Alert;

AppAsset::register($this);
CabinetAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?php $this->registerCsrfMetaTags();
    $base_setting = \common\models\setting\Base::instance();
    $user = \common\models\User::findOne(Yii::$app->user->id);
    $notification_count = $this->context->is_client ? Notification::getClientCount($user) : Notification::getMasterCount($user);
    ?>
    <title><?= Html::encode($this->title) . ($base_setting->title ? (" | " . $base_setting->title) : '') ?></title>
    <?php $this->head() ?>
</head>
<body>
<?php $this->beginBody() ?>

<?= $this->render('header') ?>

<main class="main">
    <?= Breadcrumbs::widget([
        'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
    ]) ?>
    <section class="cabinet">
        <?= Alert::widget() ?>
        <div class="cabinet__wrapper">
            <h1 class="cabinet__title">
                <?= Html::encode($this->title) ?>
            </h1>
            <div class="cabinet__inner">
                <aside class="cabinet__separate">
                    <div class="cabinet__descr">
                        <div class="cabinet__block">
                            <a href="<?= Url::to(['cabinet/client']) ?>"
                               class="cabinet__user<?= $this->context->is_client ? ' cabinet__type--active' : '' ?> button_click">
                                Клиент
                            </a>
                            <a href="<?= Url::to(['cabinet/master']) ?>"
                               class="cabinet__user<?= !$this->context->is_client ? ' cabinet__type--active' : '' ?> button_click">
                                Мастер
                            </a>
                        </div>
                        <nav class="menu">
                            <ul class="menu__list">
                                <li class="menu__item">
                                    <a href="<?= Url::to([($this->context->is_client ? 'client' : 'master') . '-notification']) ?>"
                                       class="menu__link menu__link--bell<?= (Frontend::checkAction('cabinet', 'client-notification', $this)
                                           || (Frontend::checkAction('cabinet', 'master-notification', $this))) ? ' active' : '' ?>">
                                        <i class="fa fa-bell"></i> Уведомления <?= '('.$notification_count.')'?>
                                    </a>
                                </li>
                                <? if ($this->context->is_client) :?>
                                    <li class="menu__item">
                                        <a href="<?= Url::to(['geo-masters'])?>"
                                           class="menu__link menu__link--request<?= Frontend::checkAction('cabinet', 'geo-masters', $this) ? ' active' : '' ?>">
                                            <i class="fa fa-search"></i> Поиск мастера
                                        </a>
                                    </li>
                                <? endif; ?>
                                <li class="menu__item">
                                    <a href="<?= Url::to([($this->context->is_client ? 'client' : 'master') . '-orders']) ?>"
                                       class="menu__link menu__link--request<?= (Frontend::checkAction('cabinet', 'client-orders', $this)
                                           || (Frontend::checkAction('cabinet', 'master-orders', $this))) ? ' active' : '' ?>">
                                        <i class="fa fa-list"></i> Мои заявки
                                    </a>
                                </li>
                                <li class="menu__item">
                                    <a href="<?= Url::to([($this->context->is_client ? 'client' : 'master') . '-service']) ?>"
                                       class="menu__link menu__link--service<?= (Frontend::checkAction('cabinet', 'client-service', $this)
                                           || (Frontend::checkAction('cabinet', 'master-service', $this))) ? ' active' : '' ?>">
                                        <i class="fa fa-info-circle"></i> О сервисе
                                    </a>
                                </li>
                                <li class="menu__item">
                                    <a href="<?= Url::to(['support', 'type' => ($this->context->is_client ? null : 'master')]) ?>"
                                       class="menu__link menu__link--support<?= (Frontend::checkAction('cabinet', 'support', $this)) ? ' active' : '' ?>">
                                        <i class="fa fa-question-circle"></i> Поддержка
                                    </a>
                                </li>
                            </ul>
                        </nav>
                    </div>
                    <? if ($this->context->is_client) : ?>
                        <a href="<?= Url::to(['cabinet/create-order']) ?>" class="cabinet__btn button_click">
                            Создать задание
                        </a>
                    <? else : ?>
                        <a href="<?= Url::to(['cabinet/search-order']) ?>" class="cabinet__btn button_click">
                            Поиск заказов
                        </a>
                    <? endif; ?>
                </aside>
                <?= $content ?>
            </div>
        </div>
    </section>
</main>

<?= $this->render('footer') ?>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
