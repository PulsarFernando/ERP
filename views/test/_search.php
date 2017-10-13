<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\SiteDownloadSearch2 */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="site-download-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'INT_PK_ID_SITE_DOWNLOAD') ?>

    <?= $form->field($model, 'INT_FK_ID_SITE_USER') ?>

    <?= $form->field($model, 'INT_FK_ID_SITE_FILE') ?>

    <?= $form->field($model, 'TST_CREATION_DATE') ?>

    <?= $form->field($model, 'STR_IP') ?>

    <?php // echo $form->field($model, 'STR_NAME') ?>

    <?php // echo $form->field($model, 'STR_NOTE') ?>

    <?php // echo $form->field($model, 'BOO_INVOICE') ?>

    <?php // echo $form->field($model, 'INT_FK_ERP_PRICE_ID') ?>

    <?php // echo $form->field($model, 'STR_PROJECT_NAME') ?>

    <?php // echo $form->field($model, 'STR_FORMAT') ?>

    <?php // echo $form->field($model, 'STR_CIRCULATION') ?>

    <?php // echo $form->field($model, 'STR_IMPRESSION') ?>

    <?php // echo $form->field($model, 'BOO_DOWNLOAD_SITE') ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Search'), ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton(Yii::t('app', 'Reset'), ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
