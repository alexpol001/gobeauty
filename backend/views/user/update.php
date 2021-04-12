<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model \backend\models\UserForm */
/* @var $form yii\widgets\ActiveForm */

$this->title = 'Пользователи';
$this->params['breadcrumbs'][] = ['label' => $this->title, 'url' => ['index']];
$this->params['breadcrumbs'][] = 'Редактирование';
?>
<div class="user-update">

    <h2><?= Html::encode('Редактирование') ?></h2>

    <?=$this->render('common/_form', [
            'model' => $model,
            'tab' => $tab,
    ]);?>

</div>
