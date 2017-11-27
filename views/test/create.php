<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\ErpLicense */

$this->title = 'Create Erp License';
$this->params['breadcrumbs'][] = ['label' => 'Erp Licenses', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="erp-license-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
