<?php

/* @var $this yii\web\View */
/* @var $model \common\models\Notification */

?>
Здравствуйте, <?=$model->user->info->name ? $model->user->info->name : $model->user->email?></p>

Вам поступило новое уведомление на заказ "<?=$model->order->description?>"</p>

Перейдите на сайт, чтобы увидеть подробную информацию
    <a href="<?=!$model->type ? 'http://gobeauty.pro/cabinet/client-notification' : 'http://gobeauty.pro/cabinet/master-notification'?>">Go beauty</a>


