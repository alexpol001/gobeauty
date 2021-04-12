<?php

/* @var $this yii\web\View */
/* @var $model \frontend\models\ContactForm */

?>
Пользователь: <a href="http://gobeauty.pro/admin/user/update?id=<?=$model->user->id?>"><?=$model->user->info->name ? $model->user->info->name : 'Без имени'?></a>,

Email: <a href=":mailto<?=$model->user->email?>"><?=$model->user->email?></a>,

Сообщение: <?=$model->body?>


