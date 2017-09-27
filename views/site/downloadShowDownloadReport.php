<?php
use yii\helpers\Html;
use kartik\grid\GridView;
use yii\widgets\Pjax;
use app\models\SiteUser;
use app\models\SiteFile;
use yii\helpers\ArrayHelper;
$this->title = 'Relatório de download';
$this->params['breadcrumbs'][] = ['label' => $this->title];
?>
<div class="site-download-index">
	<?php Pjax::begin(); ?>    
	<?= 
		GridView::widget([
			'id' => 'ActualMonth',
	        'dataProvider' => $objDataProviderActualMonth,
	        'filterModel' => $objSearchModelActualMonth,
	        'columns' => [
	        	[
	        		'attribute' => 'STR_NAME',
	        		'format' => 'raw',
	        		'value' => 'siteUser.STR_NAME',
	        		'group'=>true,
	        	],
	        	[
	        		'attribute' => 'STR_FILE_CODE',
	        		'format' => 'raw',
	        		'value' => 'siteFile.STR_FILE_CODE',
	        		'label' => 'Código do arquivo',
	        	],
	        	[
	        		'attribute'=>'BOO_INVOICE',
	        		'format' => 'raw',
	        		'attribute' => 'BOO_INVOICE',
	        		'value' => function($objSearchModelActualMonth, $key, $index, $widget)
	        		{
	        			return $objSearchModelActualMonth->BOO_INVOICE == 0 ? 'Não faturado' : 'Faturado';
	        		},
	        		'filterType'=>GridView::FILTER_SELECT2,
	        		'filter'=>ArrayHelper::map(['1' =>['id' => 1, 'name' => 'Faturado'], '0' => [ 'id' => 0, 'name' => 'Não Faturado']], 'id', 'name'),
	        		'filterWidgetOptions'=>[
	        				'pluginOptions'=>['allowClear'=>true],
	        		],
	        		'filterInputOptions'=>['placeholder'=>'Status'],
	        	],
	        	[
	        		'attribute'=>'TST_CREATION_DATE',
	        		'format' => 'dateTime',
	        		'value'=> 'TST_CREATION_DATE',
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
				'heading'=>'<h3 class="panel-title"><i class="glyphicon glyphicon-globe"></i> '.'Relatório de downloads: Mês atual'.'</h3>',
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
<div class="site-download-index">
	<?php Pjax::begin(); ?>    
	<?= 
		GridView::widget([
			'id' => 'lastMonth',
	        'dataProvider' => $objDataProviderLastMonth,
	        'filterModel' => $objSearchModelLastMonth,
	        'columns' => [
	        		[
		        		'attribute' => 'STR_NAME',
		        		'format' => 'raw',
		        		'value' => 'siteUser.STR_NAME',
	        			'group'=>true,
	        		],
	        		[
	        			'attribute' => 'STR_FILE_CODE',
	        			'format' => 'raw',
	        			'value' => 'siteFile.STR_FILE_CODE',
	       				'label' => 'Código do arquivo',
	        		],
	        		[
		        		'attribute'=>'BOO_INVOICE',
		        		'format' => 'raw',
		        		'attribute' => 'BOO_INVOICE',
		        		'value' => function($objSearchModelLastMonth, $key, $index, $widget)
			        		{
			        			return $objSearchModelLastMonth->BOO_INVOICE == 0 ? 'Não faturado' : 'Faturado';
			        		},
		        		'filterType'=>GridView::FILTER_SELECT2,
		        		'filter'=>ArrayHelper::map(['1' =>['id' => 1, 'name' => 'Faturado'], '0' => [ 'id' => 0, 'name' => 'Não Faturado']], 'id', 'name'),
		        		'filterWidgetOptions'=>[
		        				'pluginOptions'=>['allowClear'=>true],
		        		],
		        		'filterInputOptions'=>['placeholder'=>'Status'],
	        		],
	        		[
	       				'attribute'=>'TST_CREATION_DATE',
	       				'format' => 'dateTime',
	       				'value'=> 'TST_CREATION_DATE',
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
				'heading'=>'<h3 class="panel-title"><i class="glyphicon glyphicon-globe"></i> '.'Relatório de downloads: Mês anterior'.'</h3>',
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
