<?php
use yii\helpers\Html;
use kartik\grid\GridView;
use yii\widgets\Pjax;
//use app\models\SiteDownload;
use kartik\select2\Select2;
use app\models\ErpCustomer;
use app\models\ErpAuthor;
use app\models\ErpPrice;
use yii\base\Widget;
use app\models\SiteDownloadSearch;
use yii\helpers\Url;
use app\models\SiteSpecialUserPrefix;
use kartik\export\ExportMenu;
use app\models\SiteFilePromotion;
use app\components\SystemComponent;
use Symfony\Component\Console\Input\Input;
use app\models\ErpPriceSearch;
$this->title = 'Cliente';
$this->params['breadcrumbs'][] = ['label' =>'Relatório de download', 'url' => ['site/download-report-customer']];
$this->params['breadcrumbs'][] = ['label' => $this->title];
$this->registerJs(
	"
		$(document).on('change','#id-site-user',function(){
			$.post(
				'change-id-company-and-id-customer',
				{
					intIdCustomer: $(this).val(), intUserId: '".Yii::$app->request->get('intUserId')."'
				},
				function(data)
				{
					if(data)
						var strMessage = 'A empresa do cliente foi alterada.';
					else
						var strMessage = 'Não foi possível alterar a empresa do cliente.';
					alert(strMessage);
				}
			);
		});	
		$(document).on('change','#filter-title',function(){
			$(location).attr('href', '".URL::CURRENT()."'+'&strProjectName='+$(this).val());
		});
		$(document).on('click','#button-edit-title',function(){
			var strIdDownload = '';
			var booEdit = false;
			$('.danger').each(function(){
				if($(this).attr('data-key') > 0)
				{
					strIdDownload = strIdDownload+','+$(this).attr('data-key');
					booEdit = true;
				}
			});
			if(booEdit)
			{
				$('#form-id-edit-title').val(strIdDownload.substring(1,strIdDownload.length));
				$('.kv-row-checkbox').attr('disabled', true);
				$('.btn-toolbar .btn-group').hide();
				$('#container-form-edit-title, #container-form-abort-title, #container-form-save-title').show();
			}
			else
				alert('Selecione ao menos um titulo para editar');
			return false;
		});
		$(document).on('click','#button-abort-title',function(){
			$('.btn-toolbar .btn-group').show();
			$('#container-form-edit-title, #container-form-abort-title, #container-form-save-title').hide();
			$('.kv-row-checkbox').removeAttr('disabled');
			$('#form-id-edit-title').val('');
			return false;
		});
		$(document).on('click','#button-save-title',function(){
			$.post(
				'change-download-title-by-string-ids',
				{
					strIdDownload: $('#form-id-edit-title').val(), strRedirect: '".URL::CURRENT()."', strTitle: $('#form-edit-title').val()
				},
			);	
			return false;
		});
		$(document).on('click','#button-invoice',function(){
			var booStartInvoice = false;
			var strIdDownload = '';
			$('.danger').each(function(){
				if($(this).attr('data-key') > 0)
				{
					strIdDownload = strIdDownload+','+$(this).attr('data-key');
					booStartInvoice = true;
				}
			});
			if(booStartInvoice)
			{
				$.post(
					'change-invoice-download',
					{
						strIdDownload: strIdDownload.substring(1,strIdDownload.length)
					},
					function(data){
						alert(data);
					}
				);
			}
			else
				alert('Selecione ao menos um item para iniciar a fatura');
			return false;
		});
		$(document).on('change', '.form-control', function(){
			$.post(
				'change-price-download',
				{
					intIdDownload: $(this).attr('download-id'), intIdPrice: $(this).val(), strRedirect: '".URL::CURRENT()."'
				},
				function(data){
					alert(data);
				}
			);
		});
	"
);
?>
<div class="site-download-index">
<?php if(Yii::$app->request->get('booSpecialCustomer')):?>
	<?php Pjax::begin(); ?>    
	<?= 
		GridView::widget([
			'id' => 'ReportByCustomer',
	        'dataProvider' => $objDataProviderByCustomer,
	        'columns' => [
	        	[
	        		'attribute' => 'STR_NAME',
	        		'format' => 'raw',
	        		'value' => $objSiteUserSearch->STR_NAME,
	        		'pageSummary' => 'Total',
	        	],
	        	[
	        		'attribute' => 'INT_FK_SITE_SPECIAL_USER_PREFIX_ID',
	        		'format' => 'raw',
	        		'value' => function ($objSiteUserSearch, $key, $index, $widget)
	        		{
	        			$objSiteSpecialUserPrefix = SiteSpecialUserPrefix::find()->where(['INT_PK_ID_SITE_SPECIAL_USER_PREFIX' => $objSiteUserSearch->INT_FK_SITE_SPECIAL_USER_PREFIX_ID])->one();
	        			return $objSiteSpecialUserPrefix->STR_SPECIAL_USER_PREFIX;
	        		},
	        		'label' => 'Sigla',
	        	],
	        	[
	        		'attribute' => 'STR_LOGIN',
	        		'format' => 'raw',
	        		'value' => $objSiteUserSearch->STR_LOGIN,
	        	],
 	        	[
 	        		'attribute' => 'INT_PK_ID_SITE_USER',
 	        		'format' => 'raw',
 	        		'value' => 	function ($objSiteUserSearch, $key, $index, $widget)
 	        		{
 	        			return SiteDownloadSearch::getCountDownloadByPeriodAndUserIdOrTypeFile(Yii::$app->session->get('datDateStart'), Yii::$app->session->get('datDateFinish'), $objSiteUserSearch->INT_PK_ID_SITE_USER, Yii::$app->request->get('intIdErpTypeFile'));
 	        		},
 	        		'label' => 'Downloads',
 	        		'headerOptions' => [
 	        				'style' => 'width:80px'
 	        		],
 	        		'pageSummary' => true,
 	        	],
 	        	[
	 	        	'attribute' => 'TST_CREATION_DATE',
	 	        	'format' => 'raw',
	 	        	'value' => 	function ($objSiteUserSearch, $key, $index, $widget)
	 	        	{
	 	        		return Yii::$app->formatter->asdate(Yii::$app->session->get('datDateStart'), 'dd/MM/yyyy').' até '.Yii::$app->formatter->asdate(Yii::$app->session->get('datDateFinish'), 'dd/MM/yyyy');
	 	        	},
	 	        	'label' => 'Período',
	 	        	'headerOptions' => [
	 	        			'style' => 'width:200px'
	 	        	],
 	        	],
	        ],	
			'floatHeader'=>false,
			'pjax'=>true,
			'pjaxSettings'=>[
				'neverTimeout'=>true,
			],
			'responsive'=>true,
			'hover'=>true,
			'panel' =>
			[
				'heading'=>'<h3 class="panel-title"><i class="glyphicon glyphicon-globe"></i> '.'Informações gerais</h3>',
				'type'=>'primary',
				'footer' => false,
			],
			'toolbar'=> false,
			'striped'=>false,
			'showPageSummary' => true
	    ]); 
	?>
	<?php Pjax::end(); ?>
<?php else:?>
<?php Pjax::begin(); ?>
	<?= 
		GridView::widget([
			'id' => 'ReportByCustomer',
	        'dataProvider' => $objDataProviderByCustomer,
	        'columns' => [
	        	[
	        		'attribute' => 'STR_NAME',
	        		'format' => 'raw',
	        		'value' => $objSiteUserSearch->STR_NAME,
	        	],		
	        	[
	        		'attribute'	=> 'STR_USER_TYPE_NAME_PT',
	        		'format' => 'raw',
	        		'value' => 	 function($objSiteUserSearch, $key, $index, $widget)
	        		{
	        			if($objSiteUserSearch->INT_FK_SITE_TYPE_USER_ID == 1)
	        				$booSpecialCustomer = 1;
	        			else
	        				$booSpecialCustomer = 0;
	        			return Html::a($objSiteUserSearch->siteUserType->STR_USER_TYPE_NAME_PT, ['site/download-report-customer?booSpecialCustomer='.$booSpecialCustomer.'&intIdUser='.$objSiteUserSearch->INT_PK_ID_SITE_USER.'&datDateStart='.Yii::$app->session->get('datDateStart').'&datDateFinish='.Yii::$app->session->get('datDateFinish').'&intIdErpTypeFile='.Yii::$app->request->get('intIdErpTypeFile').'&sort='.Yii::$app->request->get('sort').'&page='.Yii::$app->request->get('page')]);
	        		},
	        		'label' => 'Tipo de cliente',
	        		'headerOptions' => [
	        				'style' => 'width:120px'
	        		],
	        	],
	        	[
	        		'attribute' => 'STR_SOCIAL_REASON',
	        		'format' => 'raw',
	        		'value' => function($objSiteUserSearch, $key, $index, $widget)
	        		{
	        			return Select2::widget([
	        				'name' => 'intIdErpCustomer',
	        				'data' => ErpCustomer::getErpCustomer(),
	        				'value' => $objSiteUserSearch->INT_FK_ERP_CUSTOMER_ID,
	        				'id' => 'id-site-user',
	        				'pluginOptions' => [
	        						'allowClear' => true,
	        						'width' => '100%',
	        						'placeholder' => 'Selecione uma empresa',
	        				],
	        			]);
	        		},
	        		'headerOptions' => [
	        				'style' => 'min-width:180px'
	        		],
	        		'label' => 'Empresa (ERP)',
	        	],	
 	        	[
 	        		'attribute' => 'INT_PK_ID_SITE_USER',
 	        		'format' => 'raw',
 	        		'value' => 	function ($objSiteUserSearch, $key, $index, $widget)
 	        		{ 
 	        			return SiteDownloadSearch::getCountDownloadByPeriodAndUserIdOrTypeFile(Yii::$app->session->get('datDateStart'), Yii::$app->session->get('datDateFinish'), $objSiteUserSearch->INT_PK_ID_SITE_USER, Yii::$app->request->get('intIdErpTypeFile'));
 	        		},
 	        		'label' => 'Downloads',
 	        		'headerOptions' => [
 	        			'style' => 'width:80px'
 	        		],
 	        	],
 	        	[
	 	        	'attribute' => 'TST_CREATION_DATE',
	 	        	'format' => 'raw',
	 	        	'value' => 	function ($objSiteUserSearch, $key, $index, $widget)
	 	        	{
	 	        		return Yii::$app->formatter->asdate(Yii::$app->session->get('datDateStart'), 'dd/MM/yyyy').' até '.Yii::$app->formatter->asdate(Yii::$app->session->get('datDateFinish'), 'dd/MM/yyyy');
	 	        	},
	 	        	'label' => 'Período',
	 	        	'headerOptions' => [
	 	        		'style' => 'width:200px'
	 	        	],
 	        	],
	        ],	
			'floatHeader'=>false,
			'pjax'=>true,
			'pjaxSettings'=>[
				'neverTimeout'=>true,
			],
			'responsive'=>true,
			'hover'=>true,
			'panel' =>
			[
				'heading'=>'<h3 class="panel-title"><i class="glyphicon glyphicon-globe"></i> '.'Informações gerais</h3>',
				'type'=>'primary',
				'footer' => false,
			],
			'toolbar'=> false,
			'striped'=>false,
	    ]); 
	?>
	<?php Pjax::end(); ?>
<?php endif;?>	
</div>
<div class="site-download-index">
	<?php Pjax::begin(); ?>    
	<?=
		GridView::widget([
			'id' => 'ReportDownloadByCustomer',
	        'dataProvider' => $objDataProviderDownloadByCustomer,
	        'columns' => [
	        	[
	        		'class' => '\kartik\grid\CheckboxColumn',
	        	],
	        	[
	        		'attribute' => 'STR_PROJECT_NAME',
	        		'format' => 'raw',
	        		'group' => true,
	        		'value' => $objSiteDownloadSearch->STR_PROJECT_NAME,
	        		'label' => 'Título',
	        	],
	        	[
	        		'class' => 'kartik\grid\ExpandRowColumn',
	        		'value' => function($objSiteDownloadSearch, $key, $index, $column)
	        		{
	        			return GridView::ROW_COLLAPSED;
	        		},
	        		'detail' => function($objSiteDownloadSearch, $key, $index, $column)
	        		{
	        			return Yii::$app->controller->renderPartial('downloadReportShowFileInformationCustomer',[
	        				'objSiteDownloadSearch' => $objSiteDownloadSearch,	
	        				'objAuthorName' => ErpAuthor::find()->select('STR_NAME_AUTHOR')->where(['INT_PK_ID_SITE_AUTHOR' => $objSiteDownloadSearch->siteFile->INT_FK_ERP_AUTHOR_ID])->one(),	
	        			]);
	        		},
	        			
	        	],
	        	[
	        		'attribute' => 'STR_FILE_CODE',
	        		'format' => 'raw',
	        		'value' => 'siteFile.STR_FILE_CODE',
	        		'label' => 'Código',
	        	],
	        	[
	        		'attribute' => 'STR_NAME',
	        		'format' => 'raw',
	        		'value' => $objSiteDownloadSearch->STR_NAME,
	        		'label' => 'Login',	
	        	],
	        	[
	        		'attribute' => 'TST_CREATION_DATE',
	        		'format' => 'date',
	        		'value' => $objSiteDownloadSearch->TST_CREATION_DATE,
	        		'label' => 'Data',	
	        	],
	        	[
	        		'attribute' => 'BOO_DOWNLOAD_SITE',
	        		'format' => 'raw',
	        		'value' => function($objSiteDownloadSearch, $key, $index, $column)
	        		{
	        			return $objSiteDownloadSearch->BOO_DOWNLOAD_SITE == 0 ? Html::tag('span', ' ', ['class' => 'label label-primary glyphicon glyphicon-ok text-success']) : '' ;
	        		},
	        		'label' => 'FTP',
	        	],
	        	[
	        		'attribute' => 'INT_FK_ERP_PRICE_ID',
	        		'format' => 'raw',
	        		'value' => function($objSiteDownloadSearch, $key, $index, $column)
	        		{
	        			return Select2::widget([
	        				'name' => 'intIdErpUtilization',
	        				'data' => ErpPriceSearch::getPriceUtilization(),
	        				'value' => $objSiteDownloadSearch->INT_FK_ERP_PRICE_ID,
	        				'id' => 'id-price-utilization-'.$objSiteDownloadSearch->INT_PK_ID_SITE_DOWNLOAD,
	        				'options' => [
	        					'download-id' => $objSiteDownloadSearch->INT_PK_ID_SITE_DOWNLOAD,
	        				],	
	        				'pluginOptions' => [
	        					'allowClear' => true,
	        					'width' => '300px',
	        				],
	        			]);
	        		},
	        		'label' => 'Utilização',
	        	],
	        	[
	        		'attribute' => 'INT_FK_ERP_PRICE_ID',
	        		'format' => 'raw',
	        		'value' => function($objSiteDownloadSearch, $key, $index, $column)
	        		{
	        			$objErpPrice = ErpPrice::find()->joinWith('erpDescription')->where(['INT_PK_ID_ERP_PRICE' => $objSiteDownloadSearch->INT_FK_ERP_PRICE_ID])->one();
	        			return $objErpPrice->erpDescription->STR_DESCRIPTION_PT;
	        		},
	        		'label' => 'Tamanho',	
	        	],
	        	[
	        		'attribute' => 'INT_FK_ERP_PRICE_ID',
	        		'format' => 'raw',
	        		'value' => function($objSiteDownloadSearch, $key, $index, $column)
	        		{
	        			return $objSiteDownloadSearch->BOO_INVOICE == 0 ? '' : Html::tag('span', ' ', ['class' => 'label label-primary glyphicon glyphicon-ok text-success']);
	        		},
	        		'label' => 'Faturado',
	        	],
	        	
	        ],	
			'floatHeader'=>false,
			'pjax'=>true,
			'pjaxSettings'=>[
				'neverTimeout'=>true,
			],
			'responsive'=>true,
			'hover'=>true,
			'panel' =>
			[
				'heading'=>'<h3 class="panel-title"><i class="glyphicon glyphicon-globe"></i> '.'Relatório detalhado</h3>',
				'type'=>'primary',
				'footer' => false,
			],
			'toolbar'=>
			[
				[
					'content'=>
					Select2::widget([
						'name' => 'filter-title',
						'data' => SystemComponent::getDropdownValue(SiteDownloadSearch::getTitleByCustomer(Yii::$app->request->get(),Yii::$app->request->get('booSpecialCustomer'), $arrIdsSpecialUser), 'STR_PROJECT_NAME','STR_PROJECT_NAME'),
						'id' => 'filter-title',
						'value' => Yii::$app->request->get('strProjectName'),
						'options' => [
							'placeholder' => 'Filtrar por titulo',
						],
						'pluginOptions' => [
								'width' => '500px',
								'allowClear' => true,
						]
					])
				],
				[
					'content'=>
					Html::a('Voltar', ['/site/download-report?datFrom='.Yii::$app->formatter->asDate(Yii::$app->request->get('datDateStart'),'dd/MM/yyyy').'&datTo='.Yii::$app->formatter->asDate(Yii::$app->request->get('datDateFinish'),'dd/MM/yyyy').'&intIdErpTypeFile='.Yii::$app->request->get('intIdErpTypeFile').'&sort='.Yii::$app->request->get('sort').'&page='.Yii::$app->request->get('page')], ['class'=>'btn btn-default', 'title'=>'Voltar'])
				],
				[
					'content'=>
					Html::a('Faturar', ['#'], ['class'=>'btn btn-danger', 'title'=>'Faturar todas', 'id'=>'button-invoice'])
				],
				[
					'content'=>
					Html::a('Editar Título', [''], ['data-pjax'=>0, 'class'=>'btn btn-primary', 'title'=>'Editar Titulo', 'id'=>'button-edit-title'])
				],
				[
					'content'=>
					Html::hiddenInput('str-id-edit-title',null, ['id' => 'form-id-edit-title']),
					'options' => [
							'id' => 'container-form-edit-title',
					],
				],
				[
					'content'=>
					Html::textInput('str-edit-title',null, ['id' => 'form-edit-title', 'placeholder' => 'Digite o novo titulo']),
					'options' => [
						'id' => 'container-form-edit-title',
					],
				],
				[
					'content'=>
					Html::a('Salvar', [''], ['data-pjax'=>0, 'class'=>'btn btn-primary', 'title'=>'Salvar', 'id'=>'button-save-title']),
					'options' => [
						'id' => 'container-form-save-title',
					],
				],
				[
					'content'=>
					Html::a('Cancelar', [''], ['data-pjax'=>0, 'class'=>'btn btn-warning', 'title'=>'Cancelar', 'id'=>'button-abort-title']),
					'options' => [
							'id' => 'container-form-abort-title',
					],
				],
				[
					'content' =>  ExportMenu::widget([
						'dataProvider' => $objDataProviderDownloadByCustomer,
						'columns' => [
						[
							'attribute' => 'STR_NAME',
							'format' => 'raw',
							'value' => $objSiteDownloadSearch->STR_NAME,
							'label' => 'Login',
						],
						[
							'attribute' => 'STR_FILE_CODE',
							'format' => 'raw',
							'value' => 'siteFile.STR_FILE_CODE',
							'label' => 'Código',
						],
						[
							'attribute' => 'siteFile.INT_FK_SITE_IMAGE_RIGHT_ID',
							'format' => 'raw',
							'value' => function($objSiteDownloadSearch, $key, $index, $column)
							{
	        					return ($objSiteDownloadSearch->siteFile->INT_FK_SITE_IMAGE_RIGHT_ID == 2 ? 'X' : '');
							},
							'label' => 'Acréscimo de 100%',	
	        			],	
						[
							'attribute' => 'STR_FILE_CODE',
							'format' => 'raw',
							'value' => function($objSiteDownloadSearch, $key, $index, $column)
							{
	        					$objSiteFilePromotion = SiteFilePromotion::find()->where(['INT_PK_ID_SITE_FILE' => $objSiteDownloadSearch->INT_FK_ID_SITE_FILE])->one();
								return ($objSiteFilePromotion->BOO_FILE_PROMOTION == 1 ? 'X' : '');
							},
							'label' => 'V.D.',	
	        			],		
						[
							'attribute' => 'TST_CREATION_DATE',
							'format' => 'date',
							'value' => $objSiteDownloadSearch->TST_CREATION_DATE,
							'label' => 'Data',
						],
						[
							'attribute' => 'siteFile.STR_MAIN_SUBJECT_PT',
							'format' => 'raw',
							'value' => $objSiteDownloadSearch->siteFile->STR_MAIN_SUBJECT_PT,
							'label' => 'Assunto',
	        			],
						[
							'attribute' => 'STR_PROJECT_NAME',
							'format' => 'raw',
							'value' => $objSiteDownloadSearch->STR_PROJECT_NAME,
							'label' => 'Título',
						],
						[
							'attribute' => 'siteFile.INT_FILE_DATE',
							'format' => 'raw',
							'value' => $objSiteDownloadSearch->siteFile->INT_FILE_DATE,
							'label' => 'Data da foto',
						],
						[
							'attribute' => 'INT_FK_ERP_PRICE_ID',
							'format' => 'raw',
							'value' => function($objSiteDownloadSearch, $key, $index, $column)
							{
								$objErpPrice = ErpPrice::find()->joinWith('erpUtilization')->where(['INT_PK_ID_ERP_PRICE' => $objSiteDownloadSearch->INT_FK_ERP_PRICE_ID])->one();
								return $objErpPrice->erpUtilization->STR_UTILIZATION_PT;
							},
							'label' => 'Utilização',
						],
						[
							'attribute' => 'INT_FK_ERP_PRICE_ID',
							'format' => 'raw',
							'value' => function($objSiteDownloadSearch, $key, $index, $column)
							{
								$objErpPrice = ErpPrice::find()->joinWith('erpDescription')->where(['INT_PK_ID_ERP_PRICE' => $objSiteDownloadSearch->INT_FK_ERP_PRICE_ID])->one();
								return $objErpPrice->erpDescription->STR_DESCRIPTION_PT;
							},
							'label' => 'Tamanho',
						],
						[
							'attribute' => 'INT_FK_ERP_PRICE_ID',
							'format' => 'raw',
							'value' => function($objSiteDownloadSearch, $key, $index, $column)
							{
								return $objSiteDownloadSearch->BOO_INVOICE == 0 ? '' : 'X';
							},
							'label' => 'Faturado',
						],
					],	
					'dropdownOptions' => [
						'class' => 'btn btn-default'
					]
				])	
	        ],
		],
		'striped'=>false,
    	]); 
	?>
	<?php Pjax::end(); ?>
</div>