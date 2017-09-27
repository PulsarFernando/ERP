<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use app\models\ErpRoleSearch;
?>
<div class="erp-user-form">
    <?php $form = ActiveForm::begin(); ?>
   	<?= $form->field($objErpUser, 'STR_USER_NAME')->textInput(['maxlength' => true]) ?>
   	<?= $form->field($objErpUser, 'STR_EMAIL')->textInput(['maxlength' => true]) ?>
    <?= $form->field($objErpUser, 'STR_LOGIN')->textInput(['maxlength' => true]) ?>
    <?= $form->field($objErpUser, 'STR_PASSWORD')->textInput(['maxlength' => true]) ?>
    <?= $form->field($objErpUser, 'INT_FK_ERP_ROLE_ID')->dropDownList(ArrayHelper::map(ErpRoleSearch::getFilter('STR_ROLE_NAME'),'INT_PK_ID_ERP_ROLE','STR_ROLE_NAME')) ?>
    <?= $form->field($objErpUser, 'BOO_ERP_USER_STATUS')->dropDownList(['1' => 'Ativo', '0' => 'Inativo']) ?>
    <div class="form-group">
        <?= Html::submitButton($objErpUser->isNewRecord ? 'Salvar' : 'Atualizar', ['class' => $objErpUser->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>
    <?php ActiveForm::end(); ?>
</div>