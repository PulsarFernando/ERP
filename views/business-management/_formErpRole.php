<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
?>
<div class="erp-role-form">
    <?php $form = ActiveForm::begin(); ?>
    <?= $form->field($objErpRole, 'STR_ROLE_NAME')->textInput(['maxlength' => true]) ?>
    <?= $form->field($objErpRole, 'TST_CREATION_DATE')->hiddenInput()->label(false) ?>	
    <?= $form->field($objErpRole, 'BOO_STATUS')->textInput()->hiddenInput()->label(false) ?>
    <div class="form-group">
        <?= Html::submitButton($objErpRole->isNewRecord ? 'Salvar' : 'Atualizar', ['class' => $objErpRole->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>
    <?php ActiveForm::end(); ?>
</div>