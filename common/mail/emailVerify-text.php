<?php

/* @var $this yii\web\View */
/* @var $user common\models\User */

$verifyLink = Yii::$app->urlManager->createAbsoluteUrl(['site/verify-email', 'token' => $user->verification_token]);
?>
Hello,

Follow the link below to verify your email:

<?= $verifyLink ?>
Здравствуйте, <?=$user->email?>

Перейдите по ссылке, чтобы сбросить ваш пароль:

<?= $verifyLink ?>