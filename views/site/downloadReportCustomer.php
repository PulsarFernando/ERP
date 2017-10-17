<?php
use yii\helpers\Html;
use kartik\grid\GridView;
use yii\widgets\Pjax;
use app\models\SiteDownload;
use kartik\select2\Select2;
use app\models\ErpCustomer;
use app\models\ErpAuthor;
use app\models\ErpPrice;
use yii\base\Widget;
use app\models\SiteDownloadSearch;
$this->title = 'Cliente';
$this->params['breadcrumbs'][] = ['label' =>'Relatório de download', 'url' => ['site/download-report-customer']];
$this->params['breadcrumbs'][] = ['label' => $this->title];
?>
<div class="site-download-index">
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
	        		'value' => 	 function($objSiteUserSearch, $key, $index, $widget)
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
	        		'label' => 'Empresa',
	        	],	
 	        	[
 	        		'attribute' => 'INT_PK_ID_SITE_USER',
 	        		'format' => 'raw',
 	        		'value' => 	function ($objSiteUserSearch, $key, $index, $widget)
 	        		{ 
 	        			return SiteDownload::find()->where(['INT_FK_ID_SITE_USER' => $objSiteUserSearch->INT_PK_ID_SITE_USER])->andWhere(['between','TST_CREATION_DATE',Yii::$app->session->get('datDateStart').'%',Yii::$app->session->get('datDateFinish').'%'])->count();
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
	        			return $objSiteDownloadSearch->BOO_DOWNLOAD_SITE == 0 ? 'Não' : 'Sim';
	        		},
	        		'label' => 'FTP',
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
	        			return $objSiteDownloadSearch->BOO_INVOICE == 0 ? 'Não' : 'Sim';
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
					Html::a('Voltar', ['/site/download-report?datFrom='.Yii::$app->formatter->asDate(Yii::$app->request->get('datDateStart'),'dd/MM/yyyy').'&datTo='.Yii::$app->formatter->asDate(Yii::$app->request->get('datDateFinish'),'dd/MM/yyyy').'&intIdErpTypeFile='.Yii::$app->request->get('intIdErpTypeFile').'&sort='.Yii::$app->request->get('sort').'&page='.Yii::$app->request->get('page')], ['class'=>'btn btn-default', 'title'=>'Voltar'])
				],
				[
					'content'=>
					Html::a('Faturar todas', ['#'], ['class'=>'btn btn-danger', 'title'=>'Faturar todas'])
				],
				[
					'content'=>
					Html::a('Faturar selecionadas', ['#'], ['data-pjax'=>0, 'class'=>'btn btn-danger', 'title'=>'Faturar selecionadas'])
				],
				[
					'content'=>
					Html::a('Imprimir', ['#'], ['class'=>'btn btn-primary', 'title'=>'Imprimir'])
				],
				[
					'content'=>
					Select2::widget([
							'name' => 'filter-title',
							'data' => SiteDownloadSearch::getTitleByCustomer(Yii::$app->request->get(),Yii::$app->request->get('booSpecialCustomer'), $arrIdsSpecialUser),
							'id' => 'filter-title',
							'options' => [
									'placeholder' => 'Filtrar por titulo',
							],
							'pluginOptions' => [
									'width' => '500px',
							]
					])
				],
				[
					'content'=>
						Html::a('<i class="glyphicon glyphicon-repeat"></i>', ['site/user'], ['data-pjax'=>0, 'class'=>'btn btn-default', 'title'=>'Atualizar'])
				],
				[
					'content'=>
					Html::a('<i class="glyphicon glyphicon-repeat"></i>', ['site/user'], ['data-pjax'=>0, 'class'=>'btn btn-default', 'title'=>'Atualizar'])
				],
				'{export}',
			],
			'striped'=>false,
	    ]); 
	?>
	<?php Pjax::end(); ?>
</div>