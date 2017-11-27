<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\ErpLicense */

$this->title = 'Update Erp License: ' . $model->INT_PK_ID_ERP_LICENSE;
$this->params['breadcrumbs'][] = ['label' => 'Erp Licenses', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->INT_PK_ID_ERP_LICENSE, 'url' => ['view', 'id' => $model->INT_PK_ID_ERP_LICENSE]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="erp-license-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
