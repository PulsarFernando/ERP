<?php
use yii\helpers\Html;
use yii\widgets\Pjax;
use kartik\grid\GridView;
use yii\helpers\ArrayHelper;
use app\models\ErpCompany;
$this->title = 'Empresas oficiais';
$this->params['breadcrumbs'][] = ['label' => $this->title];
?>
<?= 
	GridView::widget([
		'dataProvider' => $objDataProvider,
		'filterModel' => $objSearchModel,
		'columns' => [
				[
					'attribute'=>'STR_SOCIAL_REASON',
					'format' => 'raw',
					'value'=> 'erpCompany.STR_SOCIAL_REASON',
					'filterType'=> GridView::FILTER_SELECT2,
					'filter'=> ArrayHelper::map(ErpCompany::find()->asArray()->all(), 'STR_SOCIAL_REASON', 'STR_SOCIAL_REASON'),
					'filterWidgetOptions'=>[
						'pluginOptions'=>['allowClear'=>true],
					],
					'filterInputOptions'=>['placeholder'=>'Razão social'],
				],
				[
					'attribute'=>'STR_CNPJ',
					'format' => 'raw',
					'value'=> 'erpCompany.STR_CNPJ',
					'filterType'=> GridView::FILTER_SELECT2,
					'filter'=> ArrayHelper::map(ErpCompany::find()->asArray()->all(), 'STR_CNPJ', 'STR_CNPJ'),
					'filterWidgetOptions'=>[
						'pluginOptions'=>['allowClear'=>true],
					],
					'filterInputOptions'=>['placeholder'=>'CNPJ'],
				],
				[
	        		'attribute' => 'STR_FANTASY_NAME',
	        		'format' => 'raw',
	        		'value' => 'erpCompany.STR_FANTASY_NAME',
					'filterType'=> GridView::FILTER_SELECT2,
					'filter' => ArrayHelper::map(ErpCompany::find()->asArray()->all(), 'STR_FANTASY_NAME', 'STR_FANTASY_NAME'),
					'filterWidgetOptions'=>[
						'pluginOptions'=>['allowClear'=>true],
					],
						'filterInputOptions'=>['placeholder'=>'Nome Fantasia'],
				],
				[
	        		'attribute'=>'BOO_STATUS',
	        		'format' => 'raw',
	        		'value' => function($objSearchModel, $key, $index, $widget)
	        		{
	        				return $objSearchModel->BOO_STATUS == 0 ? 'Inativo' : 'Ativo';
	        		},
		        	'filterType'=>GridView::FILTER_SELECT2,
		        	'filter'=>ArrayHelper::map(['1' =>['id' => 1, 'name' => 'Ativo'], '0' => [ 'id' => 0, 'name' => 'Inativo']], 'id', 'name'),
		        	'filterWidgetOptions'=>[
		        		'pluginOptions'=>['allowClear'=>true],
	        		],
	        		'filterInputOptions'=>['placeholder'=>'Status'],
	        	],
	        	[
	        		'attribute'=>'TST_CREATION_DATE',
	        		'format' => 'date',
	        		'value' => 'TST_CREATION_DATE',
		        	'filterType'=>GridView::FILTER_DATE,
		        	'filter'=>ArrayHelper::map(['1' =>['id' => 1, 'name' => 'Ativo'], '0' => [ 'id' => 0, 'name' => 'Inativo']], 'id', 'name'),
		        	'filterWidgetOptions'=>[
		        		'pluginOptions'=>['allowClear'=>true],
		        	],
	        		'filterInputOptions'=>['placeholder'=>'Data'],
	        	],
	        
	        	['class' => 'yii\grid\ActionColumn',
	        		'template' => '{update} {delete}',
	        		'buttons' =>
	        		[
	        			'update' => function ($url, $objSearchModel, $key)
	        			{
	        				return Html::a('<span class="glyphicon glyphicon-pencil"></span>', 'erp-customer-update?id='.$objSearchModel->INT_PK_ID_ERP_CUSTOMER);
	        			},
	        			'delete' => function ($url, $objSearchModel, $key)
	        			{
	        				return Html::a('<span class="glyphicon glyphicon-trash"></span>', 'erp-customer-delete?id='.$objSearchModel->INT_PK_ID_ERP_CUSTOMER,
	        					[
	        						'data-confirm' => 'Confirma a exclusão deste item?',
	        						'data-method' => 'post',
	        					]
	        				);
	        			},
	        		],
	        	],
	       ],
	       	'floatHeader'=>true,
	       	'pjax'=>true,
	       	'pjaxSettings'=>
	       	[
	       		'neverTimeout'=>true,
	       	],
	       	'responsive'=>true,
	       	'hover'=>true,
	       	'panel' => 
	       	[
	       		'heading'=>'<h3 class="panel-title"><i class="glyphicon glyphicon-globe"></i> '.'Cadastros'.'</h3>',
	       		'type'=>'primary',
	       	],
	       	'toolbar'=>
	       	[
	       		[
	       			'content'=> html::a(Html::button('<i class="glyphicon glyphicon-plus"></i> '.'Adicionar cliente oficial', ['type'=>'button', 'title'=>'Adicionar cliente oficial', 'class'=>'btn btn-success']),['/administrative/erp-customer-add'])
	       		],
	       		[
	       			'content'=> Html::a('<i class="glyphicon glyphicon-repeat"></i>', ['administrative/erp-customer'], ['data-pjax'=>0, 'class'=>'btn btn-default', 'title'=>'Atualizar'])
	       		],
	       		'{export}',
	       		'{toggleData}',
	       	],
	       	'striped'=>false,
	]);
?>