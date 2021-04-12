<?php

/* @var $this yii\web\View */
/* @var $model \frontend\models\ContactForm */

?>
<div class="send">
    <table style="width: 100%">
        <tr>
            <td style='padding: 10px; border: #e9e9e9 1px solid;'><b>Пользователь</b></td>
            <td style='padding: 10px; border: #e9e9e9 1px solid;'><a
                        href="http://gobeauty.pro/admin/user/update?id=<?= $model->user->id ?>"><?= $model->user->info->name ? $model->user->info->name : 'Без имени' ?></a>
            </td>
        </tr>
        <tr>
            <td style='padding: 10px; border: #e9e9e9 1px solid;'><b>Email</b></td>
            <td style='padding: 10px; border: #e9e9e9 1px solid;'><a href="mailto:<?= $model->user->email ?>"><?= $model->user->email ?></a></td>
        </tr>
        <tr>
            <td style='padding: 10px; border: #e9e9e9 1px solid;'><b>Сообщение</b></td>
            <td style='padding: 10px; border: #e9e9e9 1px solid;'><?= $model->body ?></td>
        </tr>
    </table>
</div>
