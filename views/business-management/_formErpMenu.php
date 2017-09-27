<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
?>
<div class="erp-menu-form">
    <?php $form = ActiveForm::begin(); ?>
    <?= $form->field($objErpMenu, 'STR_MENU_NAME')->textInput(['maxlength' => true]) ?>
    <?= $form->field($objErpMenu, 'STR_URL')->textInput(['maxlength' => true]) ?>
    <?= $form->field($objErpMenu, 'BOO_STATUS')->dropDownList(['1' => 'Ativo', '0' => 'Inativo']) ?>
    <?php if(Yii::$app->request->get('intTypeMenu') == 0):?>
    	<?= $form->field($objErpMenu, 'BOO_MAIN_MENU')->hiddenInput(['value' => 1 ])->label(false); ?>
    <?php else: ?>
    	<?= $form->field($objErpMenu, 'BOO_MAIN_MENU')->hiddenInput(['value' => 0 ])->label(false); ?>
    <?php endif;?>	
    <div class="form-group">
        <?= Html::submitButton($objErpMenu->isNewRecord ? Yii::t('app', 'Salvar') : Yii::t('app', 'Atualizar'), ['class' => $objErpMenu->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>
    <?php ActiveForm::end(); ?>
</div>