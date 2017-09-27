<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\models\ErpCompany;
use kartik\widgets\Select2;
use app\models\ErpCustomer;
use app\models\SiteUserType;
use app\models\SiteSpecialUserPrefix;
use app\models\SiteUserTypeNewsletter;
use app\models\SiteUserDownloadPermission;
use kartik\widgets\DepDrop;
use yii\base\Widget;
use app\models\ErpCountry;
use yii\helpers\Url;
$this->registerJs("
//Temporary user is true		
	$(document).on('change','#siteuser-boo_temporary_user',function(){
			var booTemporaryUser = $(this).val();
			if(booTemporaryUser == 1)
			{
				$('#siteuser-int_fk_site_type_user_id').val('2').change();
				$('#siteuser-boo_special_user_administrator').val('0').change();
				$('#siteuser-boo_special_user').val('0');
				$('#siteuser-int_fk_site_special_user_prefix_id').val('').change();
				$('.dependent-user-temporary').prop('disabled', true);
				$('#siteuser-str_name').val('Temporário -' + ' ' +$('#siteuser-str_name').val());
			}
			else if(booTemporaryUser == 0)
			{
				$('#siteuser-str_name').val($('#siteuser-str_name').val().replace('Temporário - ', ''));
				$('.dependent-user-temporary').prop('disabled', false);
			}		
		}
	);	
//Special customers
	$(document).on('change','#siteuser-int_fk_site_type_user_id',function(){
			var strId = $(this).attr('id');
			var intType = $(this).val();
			if(intType == 1)
			{
				$('#siteuser-boo_temporary_user').val(0);
				$('#siteuser-boo_special_user').val('1');
				$('#siteuser-boo_special_user').prop('disabled', true);
				$('.dependent-especial-customer').prop('disabled', true);
				$('#siteuser-str_login').val($('#siteuser-int_fk_site_special_user_prefix_id :selected').text() + '_' +$('#siteuser-str_name').val());
			}
			else
			{
				$('.dependent-especial-customer').prop('disabled', false);
				$('#siteuser-boo_special_user').val('0')
				$('#siteuser-str_login').val($('#siteuser-str_login').val().replace($('#siteuser-int_fk_site_special_user_prefix_id :selected').text()+'_', ''));
				$('#siteuser-int_fk_site_special_user_prefix_id').val('').change();
			}
			
		}
	);
//submit 
	$(document).on('click','.btn',function(){
			$('.dependent-especial-customer, .dependent-user-temporary, #siteuser-boo_special_user').prop('disabled', false);
		}
	);
			
");
?>
<div class="site-user-form">
	<div class="pulsar-ftp-file-form">
    	<?php $form = ActiveForm::begin(); ?>
    	<div class="form-group-code">
	    	<?= $form->field($objSiteUser, 'STR_NAME')->textInput(['maxlength' => true]) ?>
	    </div>
		<div class="form-group-code">
	    	<?= $form->field($objSiteUser, 'STR_EMAIL')->textInput(['maxlength' => true]) ?>
	    </div>
	    <div class="form-group-code">
	    	<?= $form->field($objSiteUser, 'STR_LOGIN')->textInput(['maxlength' => true]) ?>
	    </div>
		<div class="form-group-code">
	    	<?= $form->field($objSiteUser, 'STR_PASSWORD')->textInput(['maxlength' => true]) ?>
	    </div>
	    <div class="form-group-code">
		    <?= 
		    	$form->field($objSiteUser, 'INT_FK_ERP_COMPANY_ID')->widget(Select2::classname(), [
				    'data' => ErpCompany::getErpCompany(),
			    	'options' => ['placeholder' => 'Selecione uma empresa'],
			    ]);
			?>
	    </div>
	    <div class="form-group-code">
	    	<?= 
		    	$form->field($objSiteUser, 'INT_FK_ERP_CUSTOMER_ID')->widget(Select2::classname(), [
				    'data' => ErpCustomer::getErpCustomer(),
		    		'options' => ['placeholder' => 'Selecione uma empresa do ERP'],
			    ]);
			?>
	    </div>    
	    <div class="form-group-code">
	    	<?= 
	    		$form->field($objSiteUser, 'BOO_TEMPORARY_USER')->widget(Select2::classname(), [
			     	'data' => ['0' => 'Não', '1' => 'Sim'],
	    			'options' => ['class' => 'dependent-especial-customer'],
			    ]);
			?>
	    </div>
	    <div class="form-group-code">  
	    	<?= 
	    		$form->field($objSiteUser, 'INT_FK_SITE_TYPE_USER_ID')->widget(Select2::classname(), [
			    	'data' => SiteUserType::getSiteUserType(),
	    			'options' => ['class' => 'dependent-user-temporary'],
			    ]);
			?>
	    </div>	
	    <div class="form-group-code">
	    	<?= 
	    		$form->field($objSiteUser, 'BOO_SPECIAL_USER_ADMINISTRATOR')->widget(Select2::classname(), [
					'data' => ['0' => 'Não', '1' => 'Sim'],
	    			'options' => ['class' => 'dependent-user-temporary'],
			    ]);
			?>
	   	</div>
	    <div class="form-group-code">
	    	<?= 
	    		$form->field($objSiteUser, 'INT_FK_SITE_SPECIAL_USER_PREFIX_ID')->widget(Select2::classname(), [
					'data' => SiteSpecialUserPrefix::getSiteSpecialUserPrefix(),
		    		'options' => ['placeholder' => 'Se o cliente for "C.E", selecione um prefixo', 'class' => 'dependent-user-temporary'],
			    ]);
			?>
	   	</div>
	    <div class="form-group-code">    
	    	<?= 
	    		$form->field($objSiteUser, 'INT_FK_SITE_USER_DOWNLOAD_PERMISSION_ID')->widget(Select2::classname(), [
			    	'data' => SiteUserDownloadPermission::getDownloadPermission(),
		    		//'options' => ['placeholder' => 'Selecione o tipo de permissão de download'],
			    ]);
			?>
	    </div>
	    <div class="form-group-code">
	    	<?= $form->field($objSiteUser, 'INT_DOWNLOAD_LIMIT')->textInput() ?>
	    </div>	
	    <div class="form-group-code">
	    	<?= 
	    		$form->field($objSiteUser, 'INT_FK_SITE_USER_LANGUAGE_ID')->widget(Select2::classname(), [
			    	'data' => ['1' => 'Português', '2' => 'Inglês'],
			    ]);
			?>
	   	</div>
	    <div class="form-group-code">
	    	<?= 
	    		$form->field($objSiteUser, 'BOO_STATUS')->widget(Select2::classname(), [
			    	'data' => ['1' => 'Ativo', '0' => 'Inativo'],
			    ]);
			?>
	   	</div>
		<div class="form-group-code">
			<?= 
		    	$form->field($objSiteUser, 'BOO_NEWSLETTER')->widget(Select2::classname(), [
			    	'data' => ['1' => 'Sim', '0' => 'Não'],
			    ]);
			?>
	    </div>
		<div class="form-group-code">
			<?= 
		    	$form->field($objSiteUser, 'INT_FK_SITE_USER_TYPE_NEWSLETTER_ID')->widget(Select2::classname(), [
			     	'data' => SiteUserTypeNewsletter::getSiteUserTypeNewsletter(),
			    ]);
			?>
	    </div>
		<div class="form-group-code">
	    	<?= 
		    	$form->field($objSiteUser, 'BOO_ACCEPT_TERM')->widget(Select2::classname(), [
			     	'data' => ['1' => 'Sim', '0' => 'Não'],
			    ]);
			?>
	    </div>
		<div class="form-group-code">
	    	<?= 
		    	$form->field($objSiteUser, 'INT_PAGINATION')->widget(Select2::classname(), [
			     	'data' => ['50' => '50 por página (default)', '100' => '100 por página', '150' => '150 por página'],
			    ]);
			?>
	    </div>
	    <?php if($objSiteUser->isNewRecord):?>
		    <div class="form-group-code">   
		    	<label class="control-label" for="siteuser-int_pk_erp_country_id">Pais</label> 
				<?= 
					Select2::widget([
						'name' => 'ErpCountry',	
						'data' =>	ErpCountry::getErpCountry(),
						'id' => 'id-erp-country',	
						'options' => ['placeholder' => 'Selecione um Pais'],	
					]); 
				?>
				<label class="control-label" for="siteuser-int_pk_erp_country_id"></label> 
		    </div>
		    <div class="form-group-code">    
				<label class="control-label" for="siteuser-int_pk_erp_state_id">Estado</label> 
				<?= 
					DepDrop::widget([
						'name' => 'ErpState',
						'options'=>['id'=>'id-erp-state'],	
						'pluginOptions'=>[
							'depends'=>['id-erp-country'],
							'placeholder'=>'Selecione um estado',
							'url'=>Url::to(['/ajax-dropdown/get-state'])
						]
					]); 
				?>
				<label class="control-label" for="siteuser-int_pk_erp_state_id"></label>
		    </div>
		    <div class="form-group-code">
				<?= 
					$form->field($objSiteUser, 'INT_FK_ERP_CITY_ID')->widget(
						DepDrop::classname(), [
							'pluginOptions'=>[
								'depends'=>['id-erp-state'],
								'placeholder'=>'Selecione uma cidade',
								'url'=>Url::to(['/ajax-dropdown/get-city'])
							]
						]
					);
				?>
		    </div>
		<?php 
			  else:
					$form->field($objSiteUser, 'INT_FK_ERP_CITY_ID')->hiddenInput()->label(false);
			  endif;
		?>   
		<div class="form-group-code">
	    	<?= $form->field($objSiteUser, 'STR_ADDRESS')->textInput(['maxlength' => true]) ?>
	    </div>
	    <div class="form-group-code">
	    	<?= $form->field($objSiteUser, 'STR_ADDRESS_COMPLEMENT')->textInput(['maxlength' => true]) ?>
	    </div>
		<div class="form-group-code">
	    	<?= $form->field($objSiteUser, 'STR_NUMBER')->textInput(['maxlength' => true]) ?>
	    </div>
		<div class="form-group-code">
	    	<?= $form->field($objSiteUser, 'STR_ZIP_CODE')->textInput(['maxlength' => true]) ?>
	    </div>
		<div class="form-group-code">
	    	<?= $form->field($objSiteUser, 'STR_CPF')->textInput(['maxlength' => true]) ?>
	    </div>
		<div class="form-group">
	        <?= Html::submitButton($objSiteUser->isNewRecord ? 'Salvar' : 'Atualizar', ['class' => $objSiteUser->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
	    </div>
	    <?=$form->field($objSiteUser, 'BOO_SPECIAL_USER')->hiddenInput()->label(false); ?>
	    <?= $form->field($objSiteUser, 'INT_PK_ID_SITE_USER')->hiddenInput()->label(false) ?>
	    <?php 
	    	if($objSiteUser->isNewRecord):
	    ?>
		    <?= $form->field($objSiteUser, 'TST_CREATION_DATE')->hiddenInput(['value' => date('Y-m-d H:i:s')])->label(false) ?>
			<?= $form->field($objSiteUser, 'TST_LAST_ACESS')->hiddenInput(['value' => date('Y-m-d H:i:s')])->label(false) ?>
		<?php else: ?>	
			<?= $form->field($objSiteUser, 'TST_CREATION_DATE')->hiddenInput()->label(false) ?>
			<?= $form->field($objSiteUser, 'TST_LAST_ACESS')->hiddenInput()->label(false) ?>
		<?php endif; ?>		
    	<?php ActiveForm::end(); ?>
    </div>
</div>