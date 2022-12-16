<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\OauthClients $model */

$this->title = 'Create Oauth Clients';
$this->params['breadcrumbs'][] = ['label' => 'Oauth Clients', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="oauth-clients-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
