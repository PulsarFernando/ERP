<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
$this->registerJs("
		var booIsPicture = '".(Yii::$app->request->get('type') == 'picture' ? 1 : 0 )."';
	//Hide DropDown
		function hideDivDropdown(strField)
		{
			$(strField).hide();
		}
	//function for show shelf-life
		function dropdownShelfLife(strValueDefault)
		{
			$.post(
				'../ajax-dropdown/get-shelf-life',
				{
					//Html ids, labels and message
						strClassName: 'form-control',
						strIdName: 'shelf-life',
						strFieldName: 'SHELF-LIFE',
						strLabelName: 'Prazo de expiração',
						strLabelClass: 'control-label',
					//Variables for combos
						mixDefaultSelected: strValueDefault,
				},
				function(data)
				{
					$('#form-group-code-shelf-life').html(data);
				}
			);
		}
	//function for show project-type
		function dropdownProjectType(intFileType)
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
					$('#project-type').val('0').change();
				}
			);
		}	
	//function for show utilization	
		function dropdownUtilization(intValueProjectType, intFileType)
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
						$('#utilization').val('0').change();
					}
				);
			}
		}	
	//function for show format	
		function dropdownFormat(intValueProjectType, intUtilization, intFileType)
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
							dropdownDistribution(intValueProjectType, intUtilization, intFormat, intFileType);
							hideDivDropdown('#form-group-code-format');
						}	
						else
						{
							$('#form-group-code-format').fadeIn(400);
							$('#format').val('0').change();
						}
					}
			);
		}
	}	
	//function for show Distribution	
		function dropdownDistribution(intValueProjectType, intUtilization, intFormat, intFileType)
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
						dropdownPeriodicity(intValueProjectType, intUtilization, intFormat, intDistribution, intFileType);
						hideDivDropdown('#form-group-code-distribution');
					}
					else
					{
 	 					$('#form-group-code-distribution').fadeIn(400);	
						$('#distribution').val('0').change();
					}
				}
			);
		}
	function dropdownPeriodicity(intValueProjectType, intUtilization, intFormat, intDistribution, intFileType)
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
							dropdownDescription(intValueProjectType, intUtilization, intFormat, intDistribution, 0, intFileType);
							hideDivDropdown('#form-group-code-periodicity');
						}
						else
						{
							$('#form-group-code-periodicity').fadeIn(400);
							$('#periodicity').val('0').change();
						}
					}
			);
	}
	function dropdownDescription(intValueProjectType, intUtilization, intFormat, intDistribution, intPeriodicity, intFileType)
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
					hideDivDropdown('#form-group-code-description');
				else
				{
					$('#form-group-code-description').fadeIn(400);
					$('#description').val('0').change();
				}			
			}
		);
 	}
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
		$(document).on('click','#import-previous-download',function()
		{
			if($('#sitedownload-str_project_name').attr('type') == 'text')
				$('#sitedownload-str_project_name').val('".$strProjectName."');
			else
				$('#sitedownload-str_project_name').val('".$strProjectName."').change();
			$('#project-type').val($('#intFkErpProjectTypeId').val()).change();
			setTimeout(
				function() 
				{
					$('#utilization').val($('#intFkErpUtilizationId').val()).change();
				}, 
			200);
			setTimeout(
				function() 
				{
				 	$('#format').val($('#intFkErpFormatId').val()).change();
				}, 
			300);
			setTimeout(
				function() 
				{
				 	$('#distribution').val($('#intFkErpDistributionId').val()).change();
				}, 
			500);
			setTimeout(
				function() 
				{
				 	$('#periodicity').val($('#intFkErpPeriodicityId').val()).change();
				}, 
			900);
			setTimeout(
				function() 
				{
					$('#description').val($('#intFkErpDescriptionId').val()).change();
				}, 
			1800);
		});
	//show dropdown shelfLife
		dropdownShelfLife(0);
	//show dropdown projectType
		dropdownProjectType(booIsPicture);	
	//Show dropdown utilization (change project-type)
		$(document).on('change', '#project-type',function()
		{
			dropdownUtilization($(this).val(), booIsPicture);
		});
	//Show 	dropdown format (change utilization)
		$(document).on('change', '#utilization',function()
		{
			dropdownFormat($('#project-type').val(), $(this).val(), booIsPicture);
		});		
	//Show 	dropdown distribution (change format)
		$(document).on('change', '#format',function()
		{
			dropdownDistribution($('#project-type').val(), $('#utilization').val(), $(this).val(), booIsPicture);
		});		
	//Show 	dropdown periodicity (change distribution)
		$(document).on('change', '#distribution',function()
		{
			dropdownPeriodicity($('#project-type').val(), $('#utilization').val(), $('#format').val(), $(this).val(), booIsPicture);
		});
	//Show 	dropdown description (change periodicity)
		$(document).on('change', '#periodicity',function()
		{
			dropdownDescription($('#project-type').val(), $('#utilization').val(), $('#format').val(), $('#distribution').val(),$(this).val(), booIsPicture);
		});	
");
$this->title = 'Disponibilizar acervo';
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
	    	<?= Html::textarea('front-file-code',null,['id'=>'front-file-code', 'class' => 'form-control']);?>
        	<?= $form->field($objSiteDownload, 'INT_FK_ID_SITE_FILE')->hiddenInput(['id' => 'fileCode'])->label(false) ?>
        </div>
        <div class="form-group=code" id="form-group-code-front-found-file-code">
        	<?= Html::hiddenInput('front-file-code',null,['id'=>'front-found-file-code', 'class' => 'form-control']);?>
        </div>
        <div class="form-group-code" id="form-group-code-shelf-life"> 
	    	
	    </div>
	    <div class="form-group-code">    
	        <?= $form->field($objSiteDownload, 'STR_NOTE')->textarea() ?>
	    </div>
	    <div class="form-group-code">    
	    	<?php if($booSpecialUser):?>
	    		<?= $form->field($objSiteDownload, 'STR_PROJECT_NAME')->dropDownList($arrDropdownTitle) ?>	
	    	<?php else: ?>
	    		<?= $form->field($objSiteDownload, 'STR_PROJECT_NAME')->textInput() ?>
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
	    <?php if($booShowEmail):?>
	    	<div class="form-group-code"> 
	    		<?= Html::label('Enviar para o e-mail' )?>
	    		<?= Html::textInput('STR_EMAIL',$strEmail,['id'=>'STR_EMAIL', 'class' => 'form-control']);?>
	   		</div>
	    <?php endif;?>
	    <?= $form->field($objSiteDownload, 'INT_FK_ERP_PRICE_ID')->hiddenInput()->label(false,['id'=>'input-int-fk-erp-price-id']) ?>
	    <?= $form->field($objSiteDownload, 'INT_FK_ID_SITE_USER')->hiddenInput(['value' => Yii::$app->request->queryParams['intSiteUserId']])->label(false) ?>
	    <?= $form->field($objSiteDownload, 'TST_CREATION_DATE')->hiddenInput(['value' => date('Y-m-d h:i:s')])->label(false) ?>
	    <?= $form->field($objSiteDownload, 'STR_IP')->hiddenInput(['value' =>Yii::$app->request->getUserIP()])->label(false) ?>
	    <?= $form->field($objSiteDownload, 'STR_NAME')->hiddenInput(['value' => Yii::$app->session->get('strUserName')])->label(false) ?>
	    <?= $form->field($objSiteDownload, 'BOO_DOWNLOAD_SITE')->hiddenInput(['value' => 0])->label(false) ?>
	    <?= $form->field($objSiteDownload, 'STR_FORMAT')->hiddenInput()->label(false) ?>
	    <?= $form->field($objSiteDownload, 'STR_CIRCULATION')->hiddenInput()->label(false); ?> 
	    <?= $form->field($objSiteDownload, 'STR_IMPRESSION')->hiddenInput()->label(false) ?>
	    <?= $form->field($objSiteDownload, 'BOO_INVOICE')->hiddenInput(['value' => 0])->label(false) ?>
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
