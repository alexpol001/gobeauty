<?php

/* @var $this yii\web\View */
/* @var $model \common\models\Orders */

?>
<div class="send">
    <table style="width: 100%">
        <tr>
            <td style='padding: 10px; border: #e9e9e9 1px solid;'><b>Клиент</b></td>
            <td style='padding: 10px; border: #e9e9e9 1px solid;'><a
                        href="http://gobeauty.pro/admin/user/update?id=<?= $model->client->id ?>"><?= $model->client->info->name ? $model->client->info->name : 'Без имени' ?></a>
            </td>
        </tr>
        <tr>
            <td style='padding: 10px; border: #e9e9e9 1px solid;'><b>Заказ</b></td>
            <td style='padding: 10px; border: #e9e9e9 1px solid;'><a
                        href="http://gobeauty.pro/admin/order/update?id=<?= $model->id ?>"><?= $model->description ?></a>
            </td>
        </tr>
    </table>
</div>
