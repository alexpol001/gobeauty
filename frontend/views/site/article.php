<?php

/* @var $this yii\web\View */
/* @var \common\models\swp\Material $model */

$this->title = $model->title;

use yii\helpers\Html; ?>
<div class="article">
    <div class="container">
        <h2><?= Html::encode($model->title) ?></h2>
        <hr>
        <?= $model->getValue(23) ?>
    </div>
</div>
