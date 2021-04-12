<?php

/* @var $this yii\web\View */
/* @var $model \common\models\Notification */

?>
<div class="notification">
    <p>Здравствуйте, <?=$model->user->info->name ? $model->user->info->name : $model->user->email?></p>

    <p>Вам поступило новое уведомление на заказ "<?=$model->order->description?>"</p>

    <p>Перейдите на сайт, чтобы увидеть подробную информацию
        <a href="<?=!$model->type ? 'http://gobeauty.pro/cabinet/client-notification' : 'http://gobeauty.pro/cabinet/master-notification'?>">Go beauty</a>
    </p>
</div>

