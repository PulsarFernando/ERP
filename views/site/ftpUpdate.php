<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\datecontrol\DateControl;
$this->registerJs("
	var booIsPicture = '".(Yii::$app->request->get('type') == 'picture' ? 1 : 0 )."';
	var booChangeDropDown = 0;
	var booChangeDropDownFirst = 1;	
	//Hide DropDown
		function hideDivDropdown(strField)
		{
			$(strField).hide();
		}
	//Show dropdown shelf life
		$.post(
			'../ajax-dropdown/get-shelf-life',
			{
				//Html ids, labels and message
					strClassName: 'form-control',
					strIdName: 'shelf-life',
					strFieldName: 'SHELF-LIFE',
					strLabelName: 'Prazo de expiração',
					strLabelClass: 'control-label',
					intSelected: '".$objValueDownload->siteFtpFile[0]['INT_SHELF_LIFE']."',
				//Variables for combos
					mixDefaultSelected: 0,
			},
			function(data)
			{
				$('#form-group-code-shelf-life').html(data);
			}
		);	
		//function validate dropDown for Price
		function validateDropdown(strId)
		{
			if(typeof($('#'+strId).val()) !== 'undefined')
			{	
				return true;
			}
			else
			{
				return false;	
			}
		}
	//After send Form
		$(document).on('mousemove','#addFtpFile', function()
		{
			if(validateDropdown('description'))
			{
				$.post(
					'../ajax-return-value/get-id-price',
					{
						intProjectType: $('#project-type').val(),
						intUtilization: $('#utilization').val(),
						intFormat: $('#format').val(),
						intDistribution: $('#distribution').val(),
						intPeriodicity: $('#periodicity').val(),
						intDescription: $('#description').val(),
					},
					function(data)
					{
						$('#sitedownload-int_fk_erp_price_id').val(data);
						if($('#format :selected').text() != '')
							$('#sitedownload-str_format').val( $('#format :selected').text() );
						else
							$('#sitedownload-str_format').val( 0 );
						if($('#distribution :selected').text() != '')
							$('#sitedownload-str_circulation').val( $('#distribution :selected').text() );
						else
							$('#sitedownload-str_circulation').val( 0 );
					}
				);
			}
		});
	//Mouseout for front-file-code (insert id code in INT_FK_ID_SITE_FILE)
		$(document).on('mouseout','#front-file-code',function()
		{
			if($(this).val() != '')
			{
				$.post(
					'../ajax-return-value/get-mutiple-id-file-by-str-code-file',
					{
						strCodeFile: $(this).val(),
					},
					function(data)
					{
						if(data != 0)
						{
							$('#front-found-file-code').val(data);
							$('#fileCode').val(1);
						}
						else
						{
							$('#fileCode').val();
							$('#front-found-file-code').val();
						}
					}
				);
			}
		});
	//click for get last download
		$(document).on('click','#import-previous-download',function(){
			if($('#sitedownload-str_project_name').attr('type') == 'text')
				$('#sitedownload-str_project_name').val('".$strProjectName."');
			else
				$('#sitedownload-str_project_name').val('".$strProjectName."').change();
			$('#project-type').val($('#intFkErpProjectTypeId').val()).change();
			setTimeout(
				  function() 
				  {
				    $('#utilization').val($('#intFkErpUtilizationId').val()).change();
					
			}, 200);
			setTimeout(
				  function() 
				  {
				   $('#format').val($('#intFkErpFormatId').val()).change();
			}, 300);
			setTimeout(
				  function() 
				  {
				   $('#distribution').val($('#intFkErpDistributionId').val()).change();
			}, 500);
			setTimeout(
				  function() 
				  {
				  $('#periodicity').val($('#intFkErpPeriodicityId').val()).change();
			 }, 900);
			setTimeout(
				  function() 
				  {
				 $('#description').val($('#intFkErpDescriptionId').val()).change();
			 }, 1300);
		});
	//function for show project-type
		function dropdownProjectType(intDefaultValue, intFileType)
		{	
			hideDivDropdown('#form-group-code-format');
			hideDivDropdown('#form-group-code-distribution');
			hideDivDropdown('#form-group-code-periodicity');
			hideDivDropdown('#form-group-code-description');
			$.post(
				'../ajax-dropdown/get-project-type',
				{
					//Html ids, labels and message
						strClassName: 'form-control',
						strIdName: 'project-type',
						strFieldName: 'PROJECT-TYPE',
						strLabelName: 'Tipo de projeto',
						strLabelClass: 'control-label',
					//Variables for combos
						booIsPicture: intFileType,
				},
				function(data)
				{
					$('#form-group-code-project-type').html(data);
					$('#form-group-code-project-type').fadeIn(400);
					$('#project-type option[value=\"'+intDefaultValue+'\"]').prop('selected', true);
				}
			);
		}
	//function for show utilization		
		function dropdownUtilization(intDefaultValue, intValueProjectType, intFileType)
		{
			hideDivDropdown('#form-group-code-format');
			hideDivDropdown('#form-group-code-distribution');
			hideDivDropdown('#form-group-code-periodicity');
			hideDivDropdown('#form-group-code-description');
			if(intValueProjectType == '0')
			{
				hideDivDropdown('#form-group-code-utilization');
			}
			else
			{
				$.post(
					'../ajax-dropdown/get-utilization',
					{
						//Html ids, labels and message
							strClassName: 'form-control',
							strIdName: 'utilization',
							strFieldName: 'UTILIZATION',
							strLabelName: 'Utilização',
							strLabelClass: 'control-label',
						//Variables for combos
							intProjectType: intValueProjectType,
							booIsPicture: intFileType,	
					},
					function(data)
					{
						$('#form-group-code-utilization').fadeIn(400);
						$('#form-group-code-utilization').html(data);
						$('#utilization option[value=\"'+intDefaultValue+'\"]').prop('selected', true);
					}
				);
			}
		}	
	//function for show format	
		function dropdownFormat(intDefaultValue, intValueProjectType, intUtilization, intFileType)
		{
			hideDivDropdown('#form-group-code-distribution');
			hideDivDropdown('#form-group-code-periodicity');
			hideDivDropdown('#form-group-code-description');	
			if(intUtilization > 0)
			{
				$.post(
					'../ajax-dropdown/get-format',
					{
						//Html ids, labels and message
							strClassName: 'form-control',
							strIdName: 'format',
							strFieldName: 'FORMAT',
							strLabelName: 'Formato',
							strLabelClass: 'control-label',
						//Variables for combos
							intProjectType: intValueProjectType,
							intUtilization: intUtilization,
							booIsPicture: intFileType,
					},
					function(data)
					{
						$('#form-group-code-format').html(data);
						var intFormat = $('#format').val();
						if(intFormat == '')
							intFormat = '0';
						if($('#format').is('input'))
						{
							dropdownDistribution(intDefaultValue, intValueProjectType, intUtilization, intFormat, intFileType);
							hideDivDropdown('#form-group-code-format');
						}	
						else
						{
							$('#form-group-code-format').fadeIn(400);
							$('#format option[value=\"'+intDefaultValue+'\"]').prop('selected', true);
						}
					}
				);
			}
		}	
	//function for show Distribution	
		function dropdownDistribution(intDefaultValue, intValueProjectType, intUtilization, intFormat, intFileType)
		{
			hideDivDropdown('#form-group-code-periodicity');
			hideDivDropdown('#form-group-code-description');	
			$.post(
				'../ajax-dropdown/get-distribution',
				{
				//Html ids, labels and message
					strClassName: 'form-control',
					strIdName: 'distribution',
					strFieldName: 'DISTRIBUTION',
					strLabelName: 'Distribuição',
					strLabelClass: 'control-label',
				//Variables for combos
					intProjectType: intValueProjectType,
					intUtilization: intUtilization,
					intFormat: intFormat,	
					booIsPicture: intFileType,
				},
				function(data)
				{
					$('#form-group-code-distribution').html(data);
					if($('#distribution').is('input'))
					{
						intDistribution = 0;
						dropdownPeriodicity(intDefaultValue, intValueProjectType, intUtilization, intFormat, intDistribution, intFileType);
						hideDivDropdown('#form-group-code-distribution');
					}
					else
					{
 	 					$('#form-group-code-distribution').fadeIn(400);	
						$('#distribution option[value=\"'+intDefaultValue+'\"]').prop('selected', true);
						
					}
				}
			);
		}
	function dropdownPeriodicity(intDefaultValue, intValueProjectType, intUtilization, intFormat, intDistribution, intFileType)
	{		
		hideDivDropdown('#form-group-code-description');	
			$.post(
				'../ajax-dropdown/get-periodicity',
				{
					//Html ids, labels and message
						strClassName: 'form-control',
						strIdName: 'periodicity',
						strFieldName: 'PERIODICITY',
						strLabelName: 'Periodicidade',
						strLabelClass: 'control-label',
					//Variables for combos
						intProjectType: intValueProjectType,
						intUtilization: intUtilization,
						intFormat: intFormat,
						intDistribution: intDistribution,
						booIsPicture: intFileType,
					},
					function(data)
					{
						$('#form-group-code-periodicity').html(data);
						if($('#periodicity').is('input'))
						{
							dropdownDescription(intDefaultValue, intValueProjectType, intUtilization, intFormat, intDistribution, 0, intFileType);
							hideDivDropdown('#form-group-code-periodicity');
						}
						else
						{
							$('#form-group-code-periodicity').fadeIn(400);
							$('#periodicity option[value=\"'+intDefaultValue+'\"]').prop('selected', true);
						}
					}
			);
	}
	function dropdownDescription(intDefaultValue, intValueProjectType, intUtilization, intFormat, intDistribution, intPeriodicity, intFileType)
 	{	
		$.post(
			'../ajax-dropdown/get-description',
			{
				//Html ids, labels and message
					strClassName: 'form-control',
					strIdName: 'description',
					strFieldName: 'DESCRIPTION',
					strLabelName: 'Tamanho',
					strLabelClass: 'control-label',
				//Variables for combos
					intProjectType: intValueProjectType,
					intUtilization: intUtilization,
					intFormat: intFormat,
					intDistribution: intDistribution,
					intPeriodicity: intPeriodicity,
					booIsPicture: intFileType,
			},
			function(data)
			{
				$('#form-group-code-description').html(data);
				if($('#description').is('input'))
				{
					hideDivDropdown('#form-group-code-description');
				}
				else
				{
					$('#form-group-code-description').fadeIn(400);
					$('#description option[value=\"'+intDefaultValue+'\"]').prop('selected', true);
				}			
			}
		);
 	}		
	dropdownProjectType('".$objLastErpPrice->INT_FK_ERP_PROJECT_TYPE_ID."', booIsPicture);
	dropdownUtilization('".$objLastErpPrice->INT_FK_ERP_UTILIZATION_ID."', '".$objLastErpPrice->INT_FK_ERP_PROJECT_TYPE_ID."', booIsPicture);	
	dropdownFormat('".$objLastErpPrice->INT_FK_ERP_FORMAT_ID."', '".$objLastErpPrice->INT_FK_ERP_PROJECT_TYPE_ID."', '".$objLastErpPrice->INT_FK_ERP_UTILIZATION_ID."', booIsPicture);	
	dropdownDistribution('".$objLastErpPrice->INT_FK_ERP_DISTRIBUTION_ID."', '".$objLastErpPrice->INT_FK_ERP_PROJECT_TYPE_ID."', '".$objLastErpPrice->INT_FK_ERP_UTILIZATION_ID."', '".$objLastErpPrice->INT_FK_ERP_FORMAT_ID."', booIsPicture);
	dropdownPeriodicity('".$objLastErpPrice->INT_FK_ERP_PERIODICITY_ID."', '".$objLastErpPrice->INT_FK_ERP_PROJECT_TYPE_ID."', '".$objLastErpPrice->INT_FK_ERP_UTILIZATION_ID."', '".$objLastErpPrice->INT_FK_ERP_FORMAT_ID."', '".$objLastErpPrice->INT_FK_ERP_DISTRIBUTION_ID."', booIsPicture);
	dropdownDescription('".$objLastErpPrice->INT_FK_ERP_DESCRIPTION_ID."', '".$objLastErpPrice->INT_FK_ERP_PROJECT_TYPE_ID."', '".$objLastErpPrice->INT_FK_ERP_UTILIZATION_ID."', '".$objLastErpPrice->INT_FK_ERP_FORMAT_ID."', '".$objLastErpPrice->INT_FK_ERP_DISTRIBUTION_ID."', '".$objLastErpPrice->INT_FK_ERP_PERIODICITY_ID."', booIsPicture);	
	//Show dropdown utilization (change project-type)

		$(document).on('change', '#project-type',function()
		{
			dropdownUtilization('0', $(this).val(), booIsPicture);
		});
	//Show 	dropdown format (change utilization)
		$(document).on('change', '#utilization',function()
		{
			dropdownFormat('0', $('#project-type').val(), $('#utilization').val(), booIsPicture);
		});		
	//Show 	dropdown distribution (change format)
		$(document).on('change', '#format',function()
		{
			dropdownDistribution('0', $('#project-type').val(), $('#utilization').val(), booIsPicture);
		});		
	//Show 	dropdown periodicity (change distribution)
		$(document).on('change', '#distribution',function()
		{
			dropdownPeriodicity('0', $('#project-type').val(), $('#utilization').val(), $('#format').val(), $('#distribution').val(), booIsPicture);							
		});
	//Show 	dropdown description (change periodicity)
		$(document).on('change', '#periodicity',function()
		{
			dropdownDescription('0', $('#project-type').val(), $('#utilization').val(), $('#format').val(), $('#distribution').val(), $('#periodicity').val(),booIsPicture);
		});
");
$this->title = 'Atualizar o acervo disponível';
$this->params['breadcrumbs'][] = ['label' =>'FTP', 'url' => ['site/ftp']];
$this->params['breadcrumbs'][] = ['label' =>'Acervo disponível para cliente', 'url' => ['site/ftp-show-customer-file?SiteFtpFileSearch[INT_FK_SITE_USER_ID]='.Yii::$app->request->get('intSiteUserId')]];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="app-views-site-FtpAdd">
	<div class="pulsar-ftp-file-form">
    <?php 
    	$form = ActiveForm::begin([
    			'options' => [
    				'fieldConfig' => ['errorOptions' => ['encode' => false, 'class' => 'help-block']]
    			]
    		]
    	); 
   	?>
	    <div class="form-group-code">
	    	<?= Html::label('Código(s) da(s) foto(s)' )?>
	    	<?= Html::textarea('front-file-code',$objValueDownload->STR_FILE_CODE,['id'=>'front-file-code', 'class' => 'form-control', 'disabled' => true]);?>
        	<?= $form->field($objSiteDownload, 'INT_FK_ID_SITE_FILE')->hiddenInput(['id' => 'fileCode','value' => $objValueDownload->INT_PK_ID_SITE_FILE])->label(false) ?>
        </div>
        <div class="form-group=code" id="form-group-code-front-found-file-code">
        	<?= Html::hiddenInput('front-file-code',$objValueDownload->STR_FILE_CODE,['id'=>'front-found-file-code', 'class' => 'form-control']);?>
        </div>
	    <div class="form-group=code">
			<div class="form-group-code">
				<?= $form->field($objSiteDownload, 'TST_CREATION_DATE')->widget(DateControl::className(),[
							'type'=>DateControl::FORMAT_DATETIME,
							'ajaxConversion'=>true,
				    		'saveFormat' => 'php:Y-m-d H:i:s',
				    		'language' => 'pt-BR',
							'value' => $objValueDownload->siteFtpFile[0]['TST_CREATION_DATE'],
							'widgetOptions' => [
								'pluginOptions' => [
									'autoclose' => true,
									'starDate' => date('d/m/Y H:i:s'),
							]
						]
					]);
				?>
			</div>	
		</div>
        <div class="form-group-code" id="form-group-code-shelf-life"> 
	    	
	    </div>
	    <div class="form-group-code">    
	        <?= $form->field($objSiteDownload, 'STR_NOTE')->textarea(['value' => $objValueDownload->siteFtpFile[0]['STR_NOTE']]) ?>
	    </div>
	    <div class="form-group-code">    
	    	<?php if($booSpecialUser):?>
	    		<?= $form->field($objSiteDownload, 'STR_PROJECT_NAME')->dropDownList($arrDropdownTitle,['value' => $objValueDownload->siteDownload[0]['STR_PROJECT_NAME']]) ?>	
	    	<?php else: ?>
	    		<?= $form->field($objSiteDownload, 'STR_PROJECT_NAME')->textInput(['value' => $objValueDownload->siteDownload[0]['STR_PROJECT_NAME']]) ?>
	    	<?php endif;?>
	    </div>
	    <div class="form-group-code" id="form-group-code-project-type"> 
	    	
	    </div>
	    <div class="form-group-code" id="form-group-code-utilization">    
	    	
	    </div>
	    <div class="form-group-code" id="form-group-code-format">    
	    	
	    </div>
	    <div class="form-group-code" id="form-group-code-distribution">    
	    	
	    </div>
	    <div class="form-group-code"  id="form-group-code-periodicity">    
	      	
	    </div>
	    <div class="form-group-code"  id="form-group-code-description">    
	         
	    </div>
	    <?= Html::hiddeninput('STR_EMAIL',$strEmail,['id'=>'STR_EMAIL', 'class' => 'form-control']);?>
	    <?= $form->field($objSiteDownload, 'INT_FK_ERP_PRICE_ID')->hiddenInput()->label(false,['id'=>'input-int-fk-erp-price-id']) ?>
	    <?= $form->field($objSiteDownload, 'INT_FK_ID_SITE_USER')->hiddenInput(['value' => Yii::$app->request->queryParams['intSiteUserId']])->label(false) ?>
	    <?= $form->field($objSiteDownload, 'STR_IP')->hiddenInput(['value' =>Yii::$app->request->getUserIP()])->label(false) ?>
	    <?= $form->field($objSiteDownload, 'STR_NAME')->hiddenInput(['value' => Yii::$app->session->get('strUserName')])->label(false) ?>
	    <?= $form->field($objSiteDownload, 'BOO_DOWNLOAD_SITE')->hiddenInput(['value' => 0])->label(false) ?>
	    <?= $form->field($objSiteDownload, 'STR_FORMAT')->hiddenInput()->label(false) ?>
	    <?= $form->field($objSiteDownload, 'STR_CIRCULATION')->hiddenInput()->label(false); ?> 
	    <?= $form->field($objSiteDownload, 'STR_IMPRESSION')->hiddenInput()->label(false) ?>
	    <?= $form->field($objSiteDownload, 'BOO_INVOICE')->hiddenInput(['value' => 0])->label(false) ?>
	    <?php echo Html::hiddenInput('INT_PK_ID_SITE_DOWNLOAD', $objValueDownload->INT_PK_ID_SITE_FILE,['id' => 'intPkIdSiteDownload']);?>
        <div class="form-group">
        	<?php echo  Html::a(Html::button(Yii::t('erp', 'Back'),['class' => 'btn']), 'ftp-show-customer-file?SiteFtpFileSearch[INT_FK_SITE_USER_ID]='.Yii::$app->request->get('intSiteUserId'));?>
        	<?php if($booShowLastDownload):?>
        		<?php 
        			echo Html::hiddenInput('intFkErpProjectTypeId', ($mixLastDownload->INT_FK_ERP_PROJECT_TYPE_ID == NULL ? 0 : $mixLastDownload->INT_FK_ERP_PROJECT_TYPE_ID),['id' => 'intFkErpProjectTypeId']);
        			echo Html::hiddenInput('intFkErpUtilizationId', ($mixLastDownload->INT_FK_ERP_UTILIZATION_ID == NULL ? 0 : $mixLastDownload->INT_FK_ERP_UTILIZATION_ID),['id' => 'intFkErpUtilizationId']);
        			echo Html::hiddenInput('intFkErpFormatId', ($mixLastDownload->INT_FK_ERP_FORMAT_ID == NULL ? 0 : $mixLastDownload->INT_FK_ERP_FORMAT_ID),['id' => 'intFkErpFormatId']);
        			echo Html::hiddenInput('intFkErpDistributionId', ($mixLastDownload->INT_FK_ERP_DISTRIBUTION_ID == NULL ? 0 : $mixLastDownload->INT_FK_ERP_DISTRIBUTION_ID),['id' => 'intFkErpDistributionId']);
        			echo Html::hiddenInput('intFkErpPeriodicityId', ($mixLastDownload->INT_FK_ERP_PERIODICITY_ID == NULL ? 0 : $mixLastDownload->INT_FK_ERP_PERIODICITY_ID),['id' => 'intFkErpPeriodicityId']);
        			echo Html::hiddenInput('intFkErpDescriptionId', ($mixLastDownload->INT_FK_ERP_DESCRIPTION_ID == NULL ? 0 : $mixLastDownload->INT_FK_ERP_DESCRIPTION_ID),['id' => 'intFkErpDescriptionId']);
        			echo Html::button('Copiar dados do download anterior',
	    				[
	    					'class' => 'btn btn-info',
	    					'id' =>'import-previous-download',
	    				]);
        		?>
        	<?php endif;?>
            <?= Html::submitButton('Salvar', ['class' => 'btn btn-primary','id'=>'addFtpFile']) ?>
        </div>
    <?php ActiveForm::end(); ?>
	</div>
</div>
