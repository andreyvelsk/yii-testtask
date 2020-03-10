<?php

/* @var $this yii\web\View */
use yii\helpers\Html;

$this->title = 'Test task';
?>
<div class="site-index">
    <h1><?= Html::encode($this->title) ?></h1>
    <?php if (Yii::$app->user->isGuest): ?>
        You are Guest
    <?php else: ?>
    <div>
        You login:  <?=Yii::$app->user->identity->username ?>
    </div>
    <div>
        You email status: <?=Yii::$app->user->identity->getStatus() ?>
    </div>
    <?php endif; ?>
</div>
