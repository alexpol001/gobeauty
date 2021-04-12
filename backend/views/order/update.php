<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model \common\models\Orders */
/* @var $form yii\widgets\ActiveForm */

$this->title = 'Заказ от ' . $model->client->email;
$this->params['breadcrumbs'][] = ['label' => $this->title, 'url' => ['user/update', 'id' => $model->client->id]];
$this->params['breadcrumbs'][] = 'Редактирование';
?>
<div class="user-update">

    <h2><?= Html::encode('Редактирование') ?></h2>

    <?=$this->render('common/_form', [
            'model' => $model,
            'tab' => $tab,
    ]);?>

</div>
