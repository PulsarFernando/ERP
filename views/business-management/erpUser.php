<?php
use yii\helpers\Html;
use kartik\grid\GridView;
use yii\widgets\Pjax;
use yii\helpers\ArrayHelper;
use app\models\ErpRole;
$this->title = 'Colaboradores';
$this->params['breadcrumbs'][] = $this->title;
?>
<?php Pjax::begin(); ?>    
<?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
        	[
        		'attribute' => 'STR_USER_NAME',
        		'value' => 'STR_USER_NAME',
        		'filterType'=>GridView::FILTER_SELECT2,
        		'filter'=>ArrayHelper::map($searchModel->getFilter('STR_USER_NAME'), 'STR_USER_NAME', 'STR_USER_NAME'),
        		'filterWidgetOptions'=>[
        				'pluginOptions'=>['allowClear'=>true],
        		],
        		'filterInputOptions'=>['placeholder'=>'Nome do colaborador'],
        	],
            [
            	//'width'=>'20px',
            	'label' => 'Id',	
            	'attribute' => 'INT_PK_ID_ERP_USER',
            	'value' => 'INT_PK_ID_ERP_USER',
            	'filterType'=>GridView::FILTER_SELECT2,
            	'filter'=>ArrayHelper::map($searchModel->getFilter('INT_PK_ID_ERP_USER'), 'INT_PK_ID_ERP_USER', 'INT_PK_ID_ERP_USER'),
            	'filterWidgetOptions'=>[
            		'pluginOptions'=>['allowClear'=>true],
            	],
            	'filterInputOptions'=>['placeholder'=>'Id'],
        	],
        	[
        		//'width' => '130px',
        		'label' => 'Perfil',
        		'attribute' => 'erpRole',
        		'value' => 'erpRole.STR_ROLE_NAME',
        		'filterType'=>GridView::FILTER_SELECT2,
        			'filter'=>ArrayHelper::map($searchModel->getFilter(ErpRole::tableName().'.STR_ROLE_NAME'), 'erpRole.STR_ROLE_NAME', 'erpRole.STR_ROLE_NAME'),
        		'filterWidgetOptions'=>[
        				'pluginOptions'=>['allowClear'=>true],
        		],
        		'filterInputOptions'=>['placeholder'=>'Tipo'],	
        	],
        	[
        		//'width' => '80px',
        		'attribute' => 'STR_LOGIN',
        		'value' => 'STR_LOGIN',
        		'filterType'=>GridView::FILTER_SELECT2,
        		'filter'=>ArrayHelper::map($searchModel->getFilter('STR_LOGIN'), 'STR_LOGIN', 'STR_LOGIN'),
        		'filterWidgetOptions'=>[
        				'pluginOptions'=>['allowClear'=>true],
        		],
        		'filterInputOptions'=>['placeholder'=>'Login'],	
        	],
        	[
        		//'width' => '80px',
        		'attribute' => 'STR_PASSWORD',
        		'value' => 'STR_PASSWORD',
        		'filterType'=>GridView::FILTER_SELECT2,
        		'filter'=>ArrayHelper::map($searchModel->getFilter('STR_PASSWORD'), 'STR_PASSWORD', 'STR_PASSWORD'),
        		'filterWidgetOptions'=>[
        				'pluginOptions'=>['allowClear'=>true],
        		],
        		'filterInputOptions'=>['placeholder'=>'Password'],	
			],
        	[
        		//'width'=>'30px',
        		'attribute' => 'BOO_ERP_USER_STATUS',
        		'value' => function($model, $key, $index, $column) 
        		{ 
					return $model->BOO_ERP_USER_STATUS == 0 ? 'Inativo' : 'Ativo';
				},
        		'filterType'=>GridView::FILTER_SELECT2,
        		'filter'=>['1' => 'Ativo','0' => 'Inativo'],
        		'filterWidgetOptions'=>[
        				'pluginOptions'=>['allowClear'=>true],
        		],
        		'filterInputOptions'=>['placeholder'=>'Status'],	
			],
			[
				'attribute' => 'STR_EMAIL',
				'value' => 'STR_EMAIL',
				'filterType'=>GridView::FILTER_SELECT2,
				'filter'=>ArrayHelper::map($searchModel->getFilter('STR_EMAIL'), 'STR_EMAIL', 'STR_EMAIL'),
				'filterWidgetOptions'=>[
						'pluginOptions'=>['allowClear'=>true],
				],
				'filterInputOptions'=>['placeholder'=>'E-mail'],
			],

            [
            	'class' => 'yii\grid\ActionColumn', 
            	'template' => '{update}',
            	'buttons' => 
            	[ 
            		'update' => function ($url, $model) {
				     	return Html::a(
				     		'<span class="glyphicon glyphicon-pencil"></span>', 'erp-user-update?id='.$model->INT_PK_ID_ERP_USER, 
				     		[
				        		'title' => Yii::t('app', 'lead-update'),
				        	]
				     	);
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
        		'heading'=>'<h3 class="panel-title"><i class="glyphicon glyphicon-globe"></i> '.'FTP'.'</h3>',
        		'type'=>'primary',
        ],
        'toolbar'=>
        [
        		[
        				'content'=>
        				html::a(Html::button('<i class="glyphicon glyphicon-plus"></i> '.'Adicionar colaborador', ['type'=>'button', 'title'=>'Adicionar colaborador', 'class'=>'btn btn-success']),['business-management/erp-user-add'])
        		],
        		[
        				'content'=>
        				Html::a('<i class="glyphicon glyphicon-repeat"></i>', ['business-management/erp-user'], ['data-pjax'=>0, 'class'=>'btn btn-default', 'title'=>'Atualizar'])
        		],
        		'{export}',
        		'{toggleData}',
        ],
        'striped'=>false,
    ]); 
?>
<?php Pjax::end(); ?>