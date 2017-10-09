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
use app\models\SiteUser;
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
					<label class='control-label'>Peíodo: </label>
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
			'filterModel' => $objSiteUserSearch,	
	        'columns' => [
	        	[
	        		'attribute' => 'STR_NAME',
	        		'format' => 'raw',
	        		'value' => function($objSiteUserSearch, $key, $index, $widget)
	        		{
	        			return $objSiteUserSearch->STR_NAME . '-' . $objSiteUserSearch->INT_FK_SITE_TYPE_USER_ID;
	        		},
	        	],
	        	[
	        		'attribute'	=> 'STR_USER_TYPE_NAME_PT',
	        		'format' => 'raw',
	        		'value' => 'siteUserType.STR_USER_TYPE_NAME_PT',
	        		'label' => 'Tipo de cliente',
	        	],
	        	[
	        		'attribute' => 'STR_SOCIAL_REASON',
	        		'format' => 'raw',
	        		'value' => 	'erpCompany.STR_SOCIAL_REASON',
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
 	        	],
 	        	[
 	        		'attribute' => 'INT_PK_ID_SITE_USER',
 	        		'format' => 'raw',
 	        		'value' => 	function ($objSiteUserSearch, $key, $index, $widget)
 	        		{ 
 	        			return SiteDownload::find()->where(['INT_FK_ID_SITE_USER' => $objSiteUserSearch->INT_PK_ID_SITE_USER])->andWhere(['between','TST_CREATION_DATE',Yii::$app->session->get('datDateStart').'%',Yii::$app->session->get('datDateFinish').'%'])->andWhere(['BOO_INVOICE' => 1])->count();
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
				'heading'=>'<h3 class="panel-title"><i class="glyphicon glyphicon-globe"></i> '.'Relatório de downloads: mês atual</h3>',
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
	        		'value' => 'STR_NAME',
	        	],
	        	[
	        		'attribute'	=> 'STR_USER_TYPE_NAME_PT',
	        		'format' => 'raw',
	        		'value' => 'siteUserType.STR_USER_TYPE_NAME_PT',
	        		'label' => 'Tipo de cliente'
	        	],
	        	[
	        		'attribute' => 'STR_SOCIAL_REASON',
	        		'format' => 'raw',
	        		'value' => 	'erpCompany.STR_SOCIAL_REASON',
	        		'label' => 'Empresa',
	        	],
 	        	[
 	        		'attribute' => 'INT_PK_ID_SITE_USER',
 	        		'format' => 'raw',
 	        		'value' => 	function ($objSiteUserSearch, $key, $index, $widget)
 	        		{ 
 	        			return SiteDownload::find()->where(['INT_FK_ID_SITE_USER' => $objSiteUserSearch->INT_PK_ID_SITE_USER])->andWhere(['between','TST_CREATION_DATE',Yii::$app->session->get('datDateStartLastMonth').'%',Yii::$app->session->get('datDateFinishLastMonth').'%'])->count('INT_FK_ID_SITE_USER');
 	        		},
 	        		'label' => 'Downloads',
 	        	],
 	        	[
 	        		'attribute' => 'INT_PK_ID_SITE_USER',
 	        		'format' => 'raw',
 	        		'value' => 	function ($objSiteUserSearch, $key, $index, $widget)
 	        		{ 
 	        			return SiteDownload::find()->where(['INT_FK_ID_SITE_USER' => $objSiteUserSearch->INT_PK_ID_SITE_USER])->andWhere(['between','TST_CREATION_DATE',Yii::$app->session->get('datDateStartLastMonth').'%',Yii::$app->session->get('datDateFinishLastMonth').'%'])->andWhere(['BOO_INVOICE' => 1])->count('INT_FK_ID_SITE_USER');
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
				'heading'=>'<h3 class="panel-title"><i class="glyphicon glyphicon-globe"></i> '.'Relatório de downloads: Mês anterior</h3>',
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