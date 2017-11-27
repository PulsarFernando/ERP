<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\models\ErpCountry;
use kartik\widgets\Select2;
use kartik\widgets\DepDrop;
use yii\helpers\Url;
use yii\base\Widget;
use app\models\ErpState;
use app\models\ErpCity;
$this->registerJs("
	$(document).on('change','#id-erp-city',function(){
		$('#int-erp-customer-city-id').val($(this).val());
	});	
	$(document).on('change','#id-erp-country',function(){	
		changeDdi($(this).val());
	});	
	$(document).on('change','#id-erp-state',function(){	
		changeDdd(0);
	});		
	$(document).on('change','#id-erp-city',function(){	
		changeDdd($(this).val());
	});
	function changeDdi(IntIdCountry)
	{
		$.post(
			'/ajax-return-value/get-ddi',
			{
				intId: IntIdCountry
			},
			function(data)
			{
				$('#erpcustomer-str_ddi_phone').val(data);
				$('#erpcustomer-str_ddi_fax').val(data);
				$('#erpcustomer-str_ddd_phone').val('');
				$('#erpcustomer-str_ddd_fax').val('');
			}
		);
	}
	function changeDdd(IntIdCity)
	{
		if(IntIdCity == 0)
		{
			$('#erpcustomer-str_ddd_phone').val('');
			$('#erpcustomer-str_ddd_fax').val('');
		}
		else
		{
			$.post(
				'/ajax-return-value/get-ddd',
				{
					intId: IntIdCity
				},
				function(data)
				{
					$('#erpcustomer-str_ddd_phone').val(data);
					$('#erpcustomer-str_ddd_fax').val(data);
				}	
			);
		}
	}	
");
?>
<div class="erp-customer-form">
	<div class="pulsar-erp-customer-form">	
    <?php $form = ActiveForm::begin(); ?>
    	<div class="form-group-code">
	    	<?= $form->field($objErpCompany, 'STR_SOCIAL_REASON') ?>
	    </div>
		<div class="form-group-code">
	    	<?= $form->field($objErpCompany, 'STR_FANTASY_NAME') ?>
	    </div>
		<div class="form-group-code">    
			<?= $form->field($objErpCompany, 'STR_CNPJ') ?>
	    </div>
		<div class="form-group-code">
	    	<?= $form->field($objErpCompany, 'STR_STATE_REGISTRATION') ?>
	    </div>
	    <div class="form-group-code">   
		    <label class="control-label" for="sitecustomer-int_pk_erp_country_id">Pais</label> 
			<?= 
				Select2::widget([
					'name' => 'ErpCountry',	
					'value' => (is_object($objResultState) ? $objResultState->INT_FK_ERP_COUNTRY_ID : null),
					'data' =>	ErpCountry::getErpCountry(),
					'id' => 'id-erp-country',		
					'options' => ['placeholder' => 'Selecione um Pais'],	
				]); 
			?>
			<label class="control-label" for="sitecustomer-int_pk_erp_country_id"></label> 
		</div>
		<div class="form-group-code">    
			<label class="control-label" for="sitecustomer-int_pk_erp_state_id">Estado</label> 
			<?= 
				DepDrop::widget([
					'type'=>DepDrop::TYPE_SELECT2,
					'name' => 'ErpState',
					'options'=>['id'=>'id-erp-state'],	
					'data' => (is_object($objResultState) ? ErpState::getErpState(['INT_FK_ERP_COUNTRY_ID' => $objResultState->INT_FK_ERP_COUNTRY_ID]) : null), 	
					'value' => (is_object($objResultState) ? $objResultState->INT_PK_ID_ERP_STATE : null),
					'pluginOptions'=>[
						'depends'=>['id-erp-country'],
						'placeholder'=>'Selecione um estado',
						'url'=>Url::to(['/ajax-dropdown/get-state'])
					]
				]); 
			?>
			<label class="control-label" for="sitecustomer-int_pk_erp_state_id"></label>
		</div>
		<div class="form-group-code">
			<label class="control-label" for="sitecustomer-int_pk_erp_state_id">Cidade</label> 
			<?= 
				DepDrop::widget([
					'type'=>DepDrop::TYPE_SELECT2,
					'name' => 'ErpCity',
					'options'=>['id'=>'id-erp-city'],
					'data' => (is_object($objResultState) ? ErpCity::getErpCityByFkStateId(['INT_FK_ERP_STATE_ID' => $objResultState->INT_PK_ID_ERP_STATE]) : null),
					'value' => (is_object($objResultState) ? $objResultState->erpCity[0]['INT_PK_ID_ERP_CITY'] : null),
					'pluginOptions'=>[
						'depends'=>['id-erp-state'],
						'placeholder'=>'Selecione uma cidade',
						'url'=>Url::to(['/ajax-dropdown/get-city'])
					]
				]);
			?>
			<label class="control-label" for="sitecustomer-int_pk_erp_state_id"></label>
		</div>
		<div class="form-group-code">
	    	<?= $form->field($objErpCustomer, 'STR_ADDRESS')->textInput(['maxlength' => true]) ?>
	    </div>
		<div class="form-group-code">
	   		<?= $form->field($objErpCustomer, 'STR_ZIP_CODE')->textInput(['maxlength' => true]) ?>
	    </div>
	    <div class="form-group-code">
	    	<?= $form->field($objErpCustomer, 'STR_DDI_PHONE')->textInput(['maxlength' => true]) ?>
	    </div>
	    <div class="form-group-code">
	    	<?= $form->field($objErpCustomer, 'STR_DDD_PHONE')->textInput(['maxlength' => true]) ?>
	    </div>
	    <div class="form-group-code">
	   		<?= $form->field($objErpCustomer, 'STR_PHONE')->textInput(['maxlength' => true]) ?>
	    </div>
	    <div class="form-group-code">
	    	<?= $form->field($objErpCustomer, 'STR_DDI_FAX')->textInput(['maxlength' => true]) ?>
	    </div>
	    <div class="form-group-code">
	    	<?= $form->field($objErpCustomer, 'STR_DDD_FAX')->textInput(['maxlength' => true]) ?>
	    </div>
	    <div class="form-group-code">
	    	<?= $form->field($objErpCustomer, 'STR_FAX')->textInput(['maxlength' => true]) ?>
	    </div>
	    <div class="form-group-code">
	    	<?= 
		    	$form->field($objErpCustomer, 'BOO_STATUS')->widget(Select2::classname(), [
			     	'data' => ['1' => 'Ativo', '0' => 'Inativo'],
			    ]);
			?>
	    </div>
	   	<div class="form-group-code">
	    	<?= $form->field($objErpCustomer, 'STR_NOTE')->textarea(['rows' => 6]) ?>
	    </div>
	    <?php if($objErpCustomer->isNewRecord):?>
				<?= $form->field($objErpCustomer, 'BOO_REGISTRATION_FLAG_BY_ERP')->hiddenInput(['value'=>'1'])->label(false) ?>
		    <?php else:?>
		    <div class="form-group-code">
		    	<?= 
		    	$form->field($objErpCustomer, 'BOO_REGISTRATION_FLAG_BY_ERP')->widget(Select2::classname(), [
			     	'data' => ['1' => 'Sim', '0' => 'Não'],
			    ]);
				?>
		    </div>
	    <?php endif;?>
		<?= $form->field($objErpCustomer, 'TST_CREATION_DATE')->hiddenInput(['value' => date('Y-m-d H:i:s')])->label(false) ?>
	    <?= $form->field($objErpCustomer, 'INT_FK_CUSTOMER_ERP_CITY_ID')->hiddenInput(['id' => 'int-erp-customer-city-id'])->label(false)?>
	    <?= $form->field($objErpCustomer, 'FLO_DISCOUNT_VALUE')->hiddenInput()->label(false) ?>
	    <?= $form->field($objErpCustomer, 'FLO_DISCOUNT_PERCENTAGE')->hiddenInput()->label(false) ?>
	    <?php if(!$objErpCustomer->isNewRecord):?>
		    <?= $form->field($objErpCustomer, 'INT_FK_ERP_COMPANY_ID')->hiddenInput()->label(false) ?>
		<?php endif;?>	
		    <div class="form-group">
		        <?= Html::submitButton($objErpCustomer->isNewRecord ? 'Salvar' : 'Atualizar', ['class' => $objErpCustomer->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
		    </div>
    <?php ActiveForm::end(); ?>
    </div>	
</div>