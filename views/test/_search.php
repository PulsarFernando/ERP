<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\ErpLicenseSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="erp-license-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'INT_PK_ID_ERP_LICENSE') ?>

    <?= $form->field($model, 'INT_FK_ERP_CUSTOMER_ID') ?>

    <?= $form->field($model, 'INT_FK_ERP_USER_ID') ?>

    <?= $form->field($model, 'INT_FK_ERP_COMPANY_ID') ?>

    <?= $form->field($model, 'STR_DESCRIPTION') ?>

    <?php // echo $form->field($model, 'STR_SOCIAL_REASON') ?>

    <?php // echo $form->field($model, 'STR_FANTASY_NAME') ?>

    <?php // echo $form->field($model, 'STR_STATE_REGISTRATION') ?>

    <?php // echo $form->field($model, 'STR_CNPJ') ?>

    <?php // echo $form->field($model, 'FLO_TOTAL_AMOUNT') ?>

    <?php // echo $form->field($model, 'DAT_CREATION_LICENSE') ?>

    <?php // echo $form->field($model, 'DAT_PAYDAY') ?>

    <?php // echo $form->field($model, 'TST_CREATION_DATE') ?>

    <?php // echo $form->field($model, 'STR_INVOICE') ?>

    <?php // echo $form->field($model, 'BOO_COMPLETED') ?>

    <?php // echo $form->field($model, 'BOO_CLOSED_INVOICE') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
