<?php
use yii\helpers\Html;
use yii\widgets\Pjax;
use kartik\grid\GridView;
use yii\helpers\ArrayHelper;
use app\models\SiteUser;
use app\models\ErpUser;
$this->title = 'Cotações';
$this->params['breadcrumbs'][] = $this->title;
?>
<?php Pjax::begin(); ?>    
	<?= 
		GridView::widget([
	        'dataProvider' => $dataProvider,
	        'filterModel' => $searchModel,
	        'columns' => [
	            [
	        		'attribute' => 'STR_NAME',
	        		'format' => 'raw',
	        		'value' => 'siteUser.STR_NAME',	
	        		'filterType' => GridView::FILTER_SELECT2,
	        		'filter' => ArrayHelper::map(SiteUser::find()->asArray()->all(), 'STR_NAME', 'STR_NAME'),
	        		'filterWidgetOptions'=>[
        				'pluginOptions'=>['allowClear'=>true],
        			],
        			'filterInputOptions'=>['placeholder'=>'Cliente'],
	        		'label' => 'Nome do cliente',
	        	],
	        	[
	        		'attribute' => 'STR_USER_NAME',
	        		'format' => 'raw',
	        		'value' => 'erpUser.STR_USER_NAME',
	        		'filterType' => GridView::FILTER_SELECT2,
	        		'filter' => ArrayHelper::map(ErpUser::find()->asArray()->all(), 'STR_USER_NAME', 'STR_USER_NAME'),
	        		'filterWidgetOptions'=>[
	        				'pluginOptions'=>['allowClear'=>true],
	        		],
	        		'filterInputOptions'=>['placeholder'=>'Colaborador'],
	        		'label' => 'Nome do colaborador',	
	        	],
	        	[
	        		'attribute'=>'BOO_ATTENDED',
	        		'format' => 'raw',
	        		'attribute' => 'BOO_ATTENDED',
	        		'value' => function($searchModel, $key, $index, $widget)
	        		{
	        			return $searchModel->BOO_ATTENDED == 0 ? 'Não' : 'Sim';
	        		},
	        		'filterType'=>GridView::FILTER_SELECT2,
	        		'filter'=>ArrayHelper::map(['1' =>['id' => 1, 'name' => 'Sim'], '0' => [ 'id' => 0, 'name' => 'Não']], 'id', 'name'),
	        		'filterWidgetOptions'=>[
	        				'pluginOptions'=>['allowClear'=>true],
	        		],
	        		'filterInputOptions'=>['placeholder'=>'Status'],
	        	],
	        	[
	        		'attribute' => 'STR_SERVICE_DATE',
	        		'format' => 'dateTime',
	        		'filterType' => GridView::FILTER_DATE,
	        		'filterWidgetOptions'=>[
	        			'pluginOptions'=>
	        			[
	        				'allowClear'=>true, 
	        				'autoclose'=>true,		
	        			],
	        		],
	        	],
	        	[
	        		'class' => 'yii\grid\ActionColumn',
	        		'template' => '{update}',
	        		'buttons' =>
	        		[
	        			'update' => function ($url, $objSearchModel, $key)
	        			{
	        				return Html::a('<span class="glyphicon glyphicon-pencil"></span>', 'customer-quotation-answer?SiteQuoteSentSearch[INT_PK_ID_SITE_QUOTE_SENT]='.$objSearchModel->INT_PK_ID_SITE_QUOTE_SENT);
	        			},
	        		],
	        	],
	        ],
			'floatHeader'=>true,
			'pjax'=>true,
			'pjaxSettings'=>[
				'neverTimeout'=>true,
			],
			'responsive'=>true,
			'hover'=>true,
			'panel' =>
			[
				'heading'=>'<h3 class="panel-title"><i class="glyphicon glyphicon-globe"></i> Cotações</h3>',
				'type'=>'primary',
			],
			'toolbar'=>
			[
				[
					'content'=>
					Html::a('<i class="glyphicon glyphicon-repeat"></i>', ['site/customer-quotation'], ['data-pjax'=>0, 'class'=>'btn btn-default', 'title'=>'Atualizar'])
				],
				'{export}',
				'{toggleData}',
			],
			'striped'=>false,
 	   ]); 
	?>
<?php Pjax::end(); ?>