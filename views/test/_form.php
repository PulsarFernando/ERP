<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\ErpLicense */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="erp-license-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'INT_FK_ERP_CUSTOMER_ID')->textInput() ?>

    <?= $form->field($model, 'INT_FK_ERP_USER_ID')->textInput() ?>

    <?= $form->field($model, 'INT_FK_ERP_COMPANY_ID')->textInput() ?>

    <?= $form->field($model, 'STR_DESCRIPTION')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'STR_SOCIAL_REASON')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'STR_FANTASY_NAME')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'STR_STATE_REGISTRATION')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'STR_CNPJ')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'FLO_TOTAL_AMOUNT')->textInput() ?>

    <?= $form->field($model, 'DAT_CREATION_LICENSE')->textInput() ?>

    <?= $form->field($model, 'DAT_PAYDAY')->textInput() ?>

    <?= $form->field($model, 'TST_CREATION_DATE')->textInput() ?>

    <?= $form->field($model, 'STR_INVOICE')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'BOO_COMPLETED')->textInput() ?>

    <?= $form->field($model, 'BOO_CLOSED_INVOICE')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
