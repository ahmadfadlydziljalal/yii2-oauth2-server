<?php

/** @var yii\web\View $this */

$this->title = Yii::$app->name;
?>
<div class="site-index">
    <h1>Welcome ... <?= !Yii::$app->user->isGuest ? Yii::$app->user->identity->username : '' ?></h1>
</div>