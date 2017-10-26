<?php
use yii\helpers\Html;
use kartik\grid\GridView;
use yii\widgets\Pjax;
use app\models\ErpCompany;
use app\models\SiteDownload;
use kartik\date\DatePicker;
use yii\base\Widget;
use kartik\select2\Select2;
use app\models\SiteUserSearch;
use app\models\ErpTypeFile;
use kartik\form\ActiveForm;
use app\models\SiteDownloadSearch;
$this->title = 'Relatório de download';
$this->params['breadcrumbs'][] = ['label' => $this->title];
?>
<div class='panel panel-primary'>
	<div class='panel-heading'>
		<h3 class='panel-title'>
			<i class='glyphicon glyphicon-globe'>
			</i>
				Filtros
		</h3>
		<div class='clearfix'></div>
	</div>
	<div class='kv-panel-before-custon'>
		<div class='pull-left'>
			<?php ActiveForm::begin(['method' => 'get']); ?>
			<div class='btn-toolbar kv-grid-toolbar' role='toolbar'>
				<div class='btn-group'>
					<label class='control-label'>Período: </label>
					<?=
						DatePicker::widget([
							'name' => 'datFrom',
							'value' => Yii::$app->formatter->asDate(Yii::$app->session->get('datDateStart'), 'dd/MM/yyyy'),
							'type' => DatePicker::TYPE_RANGE,
							'name2' => 'datTo',
							'value2' => Yii::$app->formatter->asDate(Yii::$app->session->get('datDateFinish'), 'dd/MM/yyyy'),
							'pluginOptions' => [
								'autoclose' => true,
								'format' => 'dd/mm/yyyy',
							]
						]);
						
					?>
				</div>	
				<div class='btn-group'>
					<label class='control-label'>Cliente: <?= Yii::$app->session->get('intUserId'); ?> </label>
					<?= 
						Select2::widget([
							'name' => 'intUserId',
							'data' => SiteUserSearch::getAllSiteUser(),
							'value' => Yii::$app->request->get('intUserId'),
							'id' => 'id-site-user',
							'pluginOptions' => [
								'allowClear' => true,
								'width' => '200px',
								'placeholder' => 'Selecione um Cliente',
							],
								
						]);
					?>
				</div>	
				<div class='btn-group'>	
					<label class='control-label'>Downloads: </label>
					<?= 
						Select2::widget([
							'name' => 'intIdErpTypeFile',
							'data' =>	ErpTypeFile::getAllTypeFile(),
							'value' => Yii::$app->request->get('intIdErpTypeFile'),
							'id' => 'id-erp-type-file',
							'pluginOptions' => [
								'allowClear' => true,
								'width' => '200px',
								'placeholder' => 'Selecione um tipo de arquivo',
							],	
						]);
					?>
				</div>
				<div class='btn-group' id='button-submit-filter'>	
					<?= Html::submitButton('Procurar', ['class' => 'btn btn-success', 'method' => 'get']); ?>
				</div>
				<div class='btn-group' id='button-submit-filter'>
					<?= html::a(Html::button('Default', ['class'=>'btn btn-default']),['/site/download-report']) ?>
				</div>
			</div>
			<?php ActiveForm::end(); ?>
		</div>
		<div class='clearfix'></div>
	</div>
	<div id="w0-container" class="table-responsive kv-grid-container">
		
	</div>	
</div> 
<div class="site-download-index">
	<?php Pjax::begin(); ?>    
	<?= 
		GridView::widget([
			'id' => 'ActualMonth',
	        'dataProvider' => $objDataProviderThisMonth,
	        'columns' => [
	        	[
	        		'attribute' => 'STR_NAME',
	        		'format' => 'raw',
	        		'value' => function($objSiteUserSearch, $key, $index, $widget)
	        		{
	        			return Html::a($objSiteUserSearch->STR_NAME, ['site/download-report-customer?booSpecialCustomer=0&intUserId='.$objSiteUserSearch->INT_PK_ID_SITE_USER.'&datDateStart='.Yii::$app->session->get('datDateStart').'&datDateFinish='.Yii::$app->session->get('datDateFinish').'&intIdErpTypeFile='.Yii::$app->request->get('intIdErpTypeFile').'&sort='.Yii::$app->request->get('sort').'&page='.Yii::$app->request->get('page')]);
	        		},
	        	],
	        	[
	        		'attribute'	=> 'STR_USER_TYPE_NAME_PT',
	        		'format' => 'raw',
	        		'value' => function($objSiteUserSearch, $key, $index, $widget)
	        		{
	        			if($objSiteUserSearch->INT_FK_SITE_TYPE_USER_ID == 1)
	        				$booSpecialCustomer = 1;
	        			else
	        				$booSpecialCustomer = 0;
	        			return Html::a($objSiteUserSearch->siteUserType->STR_USER_TYPE_NAME_PT, ['site/download-report-customer?booSpecialCustomer='.$booSpecialCustomer.'&intUserId='.$objSiteUserSearch->INT_PK_ID_SITE_USER.'&datDateStart='.Yii::$app->session->get('datDateStart').'&datDateFinish='.Yii::$app->session->get('datDateFinish').'&intIdErpTypeFile='.Yii::$app->request->get('intIdErpTypeFile').'&sort='.Yii::$app->request->get('sort').'&page='.Yii::$app->request->get('page')]);
	        		},
	        		'label' => 'Tipo de cliente',
	        	],
	        	[
		        	'attribute'	=> 'STR_SPECIAL_USER_PREFIX',
		        	'format' => 'raw',
		        	'value' => function($objSiteUserSearch, $key, $index, $widget)
	        		{
	        			if($objSiteUserSearch->INT_FK_SITE_TYPE_USER_ID == 1)
	        				return Html::a($objSiteUserSearch->siteSpecialUserPrefix->STR_SPECIAL_USER_PREFIX, ['site/download-report-customer?booSpecialCustomer=1&intUserId='.$objSiteUserSearch->INT_PK_ID_SITE_USER.'&datDateStart='.Yii::$app->session->get('datDateStart').'&datDateFinish='.Yii::$app->session->get('datDateFinish').'&intIdErpTypeFile='.Yii::$app->request->get('intIdErpTypeFile').'&sort='.Yii::$app->request->get('sort').'&page='.Yii::$app->request->get('page')]);
	        			else
	        				return '';
	        		},	
		        	'label' => 'Prefixo C.E',
	        	],
	        	[
	        		'attribute' => 'STR_SOCIAL_REASON',
	        		'format' => 'raw',
	        		'value' => 	 function($objSiteUserSearch, $key, $index, $widget)
	        		{
	        			return Html::a($objSiteUserSearch->erpCompany->STR_SOCIAL_REASON, ['site/download-report-customer?booSpecialCustomer=0&intUserId='.$objSiteUserSearch->INT_PK_ID_SITE_USER.'&datDateStart='.Yii::$app->session->get('datDateStart').'&datDateFinish='.Yii::$app->session->get('datDateFinish').'&intIdErpTypeFile='.Yii::$app->request->get('intIdErpTypeFile').'&sort='.Yii::$app->request->get('sort').'&page='.Yii::$app->request->get('page')]);
	        		},
	        		'label' => 'Empresa (Cadastro)',
	        	],	
 	        	[
 	        		'attribute' => 'INT_PK_ID_SITE_USER',
 	        		'format' => 'raw',
 	        		'value' => 	function ($objSiteUserSearch, $key, $index, $widget)
 	        		{ 
	        			return SiteDownloadSearch::getCountDownloadByPeriodAndUserIdOrTypeFile(Yii::$app->session->get('datDateStart'), Yii::$app->session->get('datDateFinish'), $objSiteUserSearch->INT_PK_ID_SITE_USER, Yii::$app->request->get('intIdErpTypeFile'));
 	        		},
 	        		'label' => 'Downloads'.(Yii::$app->request->get('intIdErpTypeFile') < 1 ? '' : (Yii::$app->request->get('intIdErpTypeFile') == 1 ? ' de foto' : ' de vídeo') ),
 	        	],
 	        	[
 	        		'attribute' => 'INT_PK_ID_SITE_USER',
 	        		'format' => 'raw',
 	        		'value' => 	function ($objSiteUserSearch, $key, $index, $widget)
 	        		{ 
 	        			return SiteDownloadSearch::getCountDownloadByPeriodAndUserIdAndInvoiceOrTypeFile(Yii::$app->session->get('datDateStart'), Yii::$app->session->get('datDateFinish'), $objSiteUserSearch->INT_PK_ID_SITE_USER, 1, Yii::$app->request->get('intIdErpTypeFile'));
 	        		},
 	        		'label' => 'Faturados',
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
				'heading'=>'<h3 class="panel-title"><i class="glyphicon glyphicon-globe"></i> '.'Relatório de downloads do período selecionado</h3>',
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
<?php if($objDataProviderLastMonth):?>
<div class="site-download-index">
	<?php Pjax::begin(); ?>    
	<?= 
		GridView::widget([
			'id' => 'LastMonth',
	        'dataProvider' => $objDataProviderLastMonth,
	        'columns' => [
	        	[
	        		'attribute' => 'STR_NAME',
	        		'format' => 'raw',
	        		'value' => function($objSiteUserSearch, $key, $index, $widget)
	        		{
	        			return Html::a($objSiteUserSearch->STR_NAME, ['site/download-report-customer?booSpecialCustomer=0&intUserId='.$objSiteUserSearch->INT_PK_ID_SITE_USER.'&datDateStart='.Yii::$app->session->get('datDateStartLastMonth').'&datDateFinish='.Yii::$app->session->get('datDateFinishLastMonth').'&intIdErpTypeFile='.Yii::$app->request->get('intIdErpTypeFile').'&sort='.Yii::$app->request->get('sort').'&page='.Yii::$app->request->get('page')]);
	        		},
	        	],
	        	[
	        		'attribute'	=> 'STR_USER_TYPE_NAME_PT',
	        		'format' => 'raw',
	        		'value' => 'siteUserType.STR_USER_TYPE_NAME_PT',
	        		'value' => 	 function($objSiteUserSearch, $key, $index, $widget)
	        		{
	        			if($objSiteUserSearch->INT_FK_SITE_TYPE_USER_ID == 1)
	        				$booSpecialCustomer = 1;
	        			else
	        				$booSpecialCustomer = 0;
	        			return Html::a($objSiteUserSearch->siteUserType->STR_USER_TYPE_NAME_PT, ['site/download-report-customer?booSpecialCustomer='.$booSpecialCustomer.'&intUserId='.$objSiteUserSearch->INT_PK_ID_SITE_USER.'&datDateStart='.Yii::$app->session->get('datDateStartLastMonth').'&datDateFinish='.Yii::$app->session->get('datDateFinishLastMonth').'&intIdErpTypeFile='.Yii::$app->request->get('intIdErpTypeFile').'&sort='.Yii::$app->request->get('sort').'&page='.Yii::$app->request->get('page')]);
	        		},
	        		'label' => 'Tipo de cliente'
	        	],
	        	[
	        	'attribute'	=> 'STR_SPECIAL_USER_PREFIX',
		        	'format' => 'raw',
		        	'value' => function($objSiteUserSearch, $key, $index, $widget)
		        	{
		        		if($objSiteUserSearch->INT_FK_SITE_TYPE_USER_ID == 1)
		        			return Html::a($objSiteUserSearch->siteSpecialUserPrefix->STR_SPECIAL_USER_PREFIX, ['site/download-report-customer?booSpecialCustomer=1&intUserId='.$objSiteUserSearch->INT_PK_ID_SITE_USER.'&datDateStart='.Yii::$app->session->get('datDateStart').'&datDateFinish='.Yii::$app->session->get('datDateFinish').'&intIdErpTypeFile='.Yii::$app->request->get('intIdErpTypeFile').'&sort='.Yii::$app->request->get('sort').'&page='.Yii::$app->request->get('page')]);
		        			else
		        				return '';
	        	},
	        	'label' => 'Prefixo C.E',
	        	],
	        	[
	        		'attribute' => 'STR_SOCIAL_REASON',
	        		'format' => 'raw',
	        		'value' => 	 function($objSiteUserSearch, $key, $index, $widget)
	        		{
	        			return Html::a($objSiteUserSearch->erpCompany->STR_SOCIAL_REASON, ['site/download-report-customer?booSpecialCustomer=0&intUserId='.$objSiteUserSearch->INT_PK_ID_SITE_USER.'&datDateStart='.Yii::$app->session->get('datDateStartLastMonth').'&datDateFinish='.Yii::$app->session->get('datDateFinishLastMonth').'&intIdErpTypeFile='.Yii::$app->request->get('intIdErpTypeFile').'&sort='.Yii::$app->request->get('sort').'&page='.Yii::$app->request->get('page')]);
	        		},
	        		'label' => 'Empresa (Cadastro)',
	        	],
 	        	[
 	        		'attribute' => 'INT_PK_ID_SITE_USER',
 	        		'format' => 'raw',
 	        		'value' => 	function ($objSiteUserSearch, $key, $index, $widget)
 	        		{ 
 	        			return SiteDownloadSearch::getCountDownloadByPeriodAndUserIdOrTypeFile(Yii::$app->session->get('datDateStartLastMonth'), Yii::$app->session->get('datDateFinishLastMonth'), $objSiteUserSearch->INT_PK_ID_SITE_USER);
	        		},
 	        		'label' => 'Downloads'.(Yii::$app->request->get('intIdErpTypeFile') < 1 ? '' : (Yii::$app->request->get('intIdErpTypeFile') == 1 ? ' de foto' : ' de vídeo') ),
 	        	],
 	        	[
 	        		'attribute' => 'INT_PK_ID_SITE_USER',
 	        		'format' => 'raw',
 	        		'value' => 	function ($objSiteUserSearch, $key, $index, $widget)
 	        		{ 
 	        			return SiteDownloadSearch::getCountDownloadByPeriodAndUserIdAndInvoiceOrTypeFile(Yii::$app->session->get('datDateStartLastMonth'), Yii::$app->session->get('datDateFinishLastMonth'), $objSiteUserSearch->INT_PK_ID_SITE_USER, 1);
 	        		},
 	        		'label' => 'Faturados',
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
				'heading'=>'<h3 class="panel-title"><i class="glyphicon glyphicon-globe"></i> '.'Relatório de downloads do mês passado</h3>',
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
<?php endif;?>