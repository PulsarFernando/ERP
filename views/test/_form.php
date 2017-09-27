<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\SiteDownload */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="site-download-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'INT_PK_ID_SITE_DOWNLOAD')->textInput() ?>

    <?= $form->field($model, 'INT_FK_ID_SITE_USER')->textInput() ?>

    <?= $form->field($model, 'INT_FK_ID_SITE_FILE')->textInput() ?>

    <?= $form->field($model, 'TST_CREATION_DATE')->textInput() ?>

    <?= $form->field($model, 'STR_IP')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'STR_NAME')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'STR_NOTE')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'BOO_INVOICE')->textInput() ?>

    <?= $form->field($model, 'INT_FK_ERP_PRICE_ID')->textInput() ?>

    <?= $form->field($model, 'STR_PROJECT_NAME')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'STR_FORMAT')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'STR_CIRCULATION')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'STR_IMPRESSION')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'BOO_DOWNLOAD_SITE')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
