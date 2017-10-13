<?php
use yii\helpers\Html;
use kartik\form\ActiveForm;
use kartik\grid\GridView;
use yii\widgets\Pjax;
use app\models\SiteDownload;
use kartik\select2\Select2;
use app\models\ErpCompany;
use app\models\ErpCustomer;
use app\models\ErpAuthor;
$this->title = 'Cliente';
$this->params['breadcrumbs'][] = ['label' =>'Relatório de download', 'url' => ['site/download-report-customer']];
$this->params['breadcrumbs'][] = ['label' => $this->title];
// echo '<pre>';
// print_r(Yii::$app->request->get());
// echo '</pre>';
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
	 	        	'label' => 'Período do relatório',
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
			],
			'toolbar'=> false,
			'striped'=>false,
	    ]); 
	?>
	<?php Pjax::end(); ?>
</div>
<div class='panel panel-primary'>
	<div class='panel-heading'>
		<h3 class='panel-title'>
			<i class='glyphicon glyphicon-globe'>
			</i>
				Ações
		</h3>
		<div class='clearfix'></div>
	</div>
	<div class='kv-panel-before-custon'>
		<div class='pull-left'>
			<?php ActiveForm::begin(['method' => 'get']); ?>
			<div class='btn-toolbar kv-grid-toolbar' role='toolbar'>
				<div class='btn-group' id='button-submit-filter'>
					<?= html::a(Html::button('Voltar', ['class'=>'btn btn-default']),['/site/download-report?datFrom='.Yii::$app->formatter->asDate(Yii::$app->request->get('datDateStart'),'dd/MM/yyyy').'&datTo='.Yii::$app->formatter->asDate(Yii::$app->request->get('datDateFinish'),'dd/MM/yyyy').'&intIdErpTypeFile='.Yii::$app->request->get('intIdErpTypeFile').'&sort='.Yii::$app->request->get('sort').'&page='.Yii::$app->request->get('page')]); ?>
				</div>	
				<div class='btn-group' id='button-submit-filter'>
					<?= html::a(Html::button('Faturar todas', ['class'=>'btn btn-danger']),['#']); ?>
				</div>
				<div class='btn-group' id='button-submit-filter'>
					<?= html::a(Html::button('Faturar selecionadas', ['class'=>'btn btn-danger']),['#']); ?>
				</div>
				<div class='btn-group' id='button-submit-filter'>
					<?= html::a(Html::button('Imprimir', ['class'=>'btn btn-primary']),['#']); ?>
				</div>
				<div class='btn-group' id='button-submit-filter'>
					<?= html::a(Html::button('Exportar para excel', ['class'=>'btn btn-warning']),['#']); ?>
				</div>
			</div>
			<?php ActiveForm::end(); ?>
		</div>
		<div class='clearfix'></div>
	</div>
</div> 
<div class="site-download-index">
	<?php Pjax::begin(); ?>    
	<?= 
		GridView::widget([
			'id' => 'ReportDownloadByCustomer',
	        'dataProvider' => $objDataProviderDownloadByCustomer,
	        'columns' => [
	        	[
	        		'class' => 'kartik\grid\ExpandRowColumn',
	        		'value' => function($objSiteDownloadSearch, $key, $index, $column)
	        		{
	        			return GridView::ROW_COLLAPSED;
	        		},
	        		'detail' => function($objSiteDownloadSearch, $key, $index, $column)
	        		{
	        			return Yii::$app->controller->renderPartial('test');
	        		},
	        			
	        	],
// 	        	[
// 	        		'attribute' => 'STR_FILE_CODE',
// 	        		'format' => 'raw',
// 	        		'value' => 'siteFile.STR_FILE_CODE',
// 	        		'label' => 'Thumb',
// 	        	],
	        	[
	        		'attribute' => 'STR_FILE_CODE',
	        		'format' => 'raw',
	        		'value' => 'siteFile.STR_FILE_CODE',
	        		'label' => 'Código',
	        	],
	        	[
	        		'attribute' => 'INT_FK_ERP_AUTHOR_ID',
	        		'format' => 'raw',
	        		'value' => function($objSiteDownloadSearch, $key, $index, $column)
	        		{
	        			$objAuthorName = ErpAuthor::find()->select('STR_NAME_AUTHOR')->where(['INT_PK_ID_SITE_AUTHOR' => $objSiteDownloadSearch->siteFile->INT_FK_ERP_AUTHOR_ID])->one();
	        			return $objAuthorName->STR_NAME_AUTHOR;
	        		},
	        		'label' => 'Autor',
	        	],
	        	[
	        		'attribute' => 'STR_MAIN_SUBJECT_PT',
	        		'format' => 'raw',
	        		'value' => 'siteFile.STR_MAIN_SUBJECT_PT',
	        		'label' => 'Assunto',
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
	        		'attribute' => 'STR_PROJECT_NAME',
	        		'format' => 'raw',
	        		'value' => $objSiteDownloadSearch->STR_PROJECT_NAME,
	        		'label' => 'Título',
	        	],
	        	[
	        		'attribute' => 'INT_FK_ERP_PRICE_ID',
	        		'format' => 'raw',
	        		'value' => $objSiteDownloadSearch->INT_FK_ERP_PRICE_ID,
	        		'label' => 'Utilização',
	        	],
	        	[
	        		'attribute' => 'INT_FK_ERP_PRICE_ID',
	        		'format' => 'raw',
	        		'value' => $objSiteDownloadSearch->INT_FK_ERP_PRICE_ID,
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
			],
			'toolbar'=>
			[
				[
					'content'=>
						Html::a('<i class="glyphicon glyphicon-repeat"></i>', ['site/user'], ['data-pjax'=>0, 'class'=>'btn btn-default', 'title'=>'Atualizar'])
				],
				'{export}',
				'{toggleData}',
			],
			'striped'=>false,
	    ]); 
	?>
	<?php Pjax::end(); ?>
</div>