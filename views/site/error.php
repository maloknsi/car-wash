<?php

/* @var $this yii\web\View */
/* @var $name string */
/* @var $message string */
/* @var $exception Exception */

use yii\helpers\Html;
?>
<div class="site-error">
    <h1><?= Html::encode($this->title) ?></h1>

    <div class="alert alert-danger">
	    [ERROR CODE: <strong><?= nl2br(Html::encode($exception->statusCode)) ?></strong>]
        <?= nl2br(Html::encode($exception->getMessage())) ?>
    </div>
</div>
