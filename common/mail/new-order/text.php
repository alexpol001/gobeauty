<?php

/* @var $this yii\web\View */
/* @var $model \common\models\Orders */

?>
Клиент: <a
        href="http://gobeauty.pro/admin/user/update?id=<?= $model->client->id ?>"><?= $model->client->info->name ? $model->client->info->name : 'Без имени' ?></a>,

Заказ: <a href="http://gobeauty.pro/admin/order/update?id=<?= $model->id ?>"><?= $model->description ?></a>


