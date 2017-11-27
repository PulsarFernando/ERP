<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\ErpLicense */

$this->title = $model->INT_PK_ID_ERP_LICENSE;
$this->params['breadcrumbs'][] = ['label' => 'Erp Licenses', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="erp-license-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->INT_PK_ID_ERP_LICENSE], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->INT_PK_ID_ERP_LICENSE], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'INT_PK_ID_ERP_LICENSE',
            'INT_FK_ERP_CUSTOMER_ID',
            'INT_FK_ERP_USER_ID',
            'INT_FK_ERP_COMPANY_ID',
            'STR_DESCRIPTION:ntext',
            'STR_SOCIAL_REASON',
            'STR_FANTASY_NAME',
            'STR_STATE_REGISTRATION',
            'STR_CNPJ',
            'FLO_TOTAL_AMOUNT',
            'DAT_CREATION_LICENSE',
            'DAT_PAYDAY',
            'TST_CREATION_DATE',
            'STR_INVOICE',
            'BOO_COMPLETED',
            'BOO_CLOSED_INVOICE',
        ],
    ]) ?>

</div>
