<?php
/* @var $this \yii\web\View */

use yii\helpers\Url; ?>
<footer class="page-footer">
    <div class="page-footer__copyright">
        <p class="page-footer__copyright-text">
            © Интернет-сервис «GoBeauty», 2018-<?=date('Y')?>
        </p>
        <a href="<?=Url::to(['site/article', 'slug' => 'politika-konfidencialnosti'])?>" class="page-footer__copyright-link">
            Политика конфидециальности
        </a>
    </div>
</footer>
