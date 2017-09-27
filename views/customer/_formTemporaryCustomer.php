<?php
use yii\helpers\Html;
use kartik\form\ActiveForm;
$this->registerJS("
	$(document).on('keyup','#siteuser-str_login',function(){
		var strKeyUp = $(this).val();
		var strName = 'Temporário - '+ strKeyUp;
		$('#siteuser-str_name').val(strName);
		$('#siteuser-str_name-send').val(strName);
	});
");
?>
<div class="pulsar-ftp-file-create">
	<div class="pulsar-ftp-file-form">
    	<?php $form = ActiveForm::begin(); ?>
		<div class="form-group-code">
	    	<?= $form->field($objSiteUser, 'STR_LOGIN')->textInput(['maxlength' => true]) ?>
	    </div>
	    <div class="form-group-code">
	    <?= $form->field($objSiteUser, 'STR_NAME')->textInput(['maxlength' => true, 'disabled' => true]) ?>
	    </div>
	    <div class="form-group-code">    
	    <?= $form->field($objSiteUser, 'STR_PASSWORD')->textInput(['maxlength' => true]) ?>
	    </div>
	    <div class="form-group-code">
	    <?= $form->field($objSiteUser, 'STR_EMAIL')->textInput(['maxlength' => true]) ?>
	    </div>
	    <div class="form-group-code">    
	    <?= $form->field($objSiteUser, 'INT_FK_SITE_USER_LANGUAGE_ID')->dropDownList($arrItemsLanguage); ?>
	    </div>
	    <div class="form-group-code">
	    <?= $form->field($objSiteUser, 'INT_FK_SITE_USER_TYPE_NEWSLETTER_ID')->dropDownList($arrItemsTypeNewsletter,['options' => ['2'=> ['selected' => true] ]]) ?>
	    </div>
	    <?= $form->field($objSiteUser, 'STR_NAME')->hiddenInput(['value' => true, 'id' => 'siteuser-str_name-send'])->label(false) ?>
	    <?= $form->field($objSiteUser, 'INT_FK_SITE_TYPE_USER_ID')->hiddenInput(['value' => 2])->label(false) ?>
	    <?= $form->field($objSiteUser, 'INT_FK_SITE_USER_DOWNLOAD_PERMISSION_ID')->hiddenInput(['value' => 3])->label(false) ?>
		<?= $form->field($objSiteUser, 'BOO_TEMPORARY_USER')->hiddenInput(['value' => true])->label(false) ?>
	    <?= $form->field($objSiteUser, 'INT_DOWNLOAD_LIMIT')->hiddenInput(['value' => 0])->label(false) ?>
	    <?= $form->field($objSiteUser, 'BOO_NEWSLETTER')->hiddenInput(['value' => true])->label(false) ?>
	    <?= $form->field($objSiteUser, 'BOO_ACCEPT_TERM')->hiddenInput(['value' => true])->label(false) ?>
	    <?= $form->field($objSiteUser, 'INT_PAGINATION')->hiddenInput(['value' => 50])->label(false) ?>
	    <?= $form->field($objSiteUser, 'BOO_SPECIAL_USER')->hiddenInput(['value' => true])->label(false) ?>
	    <?= $form->field($objSiteUser, 'BOO_STATUS')->hiddenInput(['value' => true])->label(false) ?>
	    <?= $form->field($objSiteUser, 'TST_CREATION_DATE')->hiddenInput(['value' => date('Y-m-d h:i:s')])->label(false) ?>
	    <div class="form-group">
	        <?= Html::submitButton($objSiteUser->isNewRecord ? 'Novo' : 'Atualizar', ['class' => $objSiteUser->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
	    </div>
    	<?php ActiveForm::end(); ?>
	</div>
</div>