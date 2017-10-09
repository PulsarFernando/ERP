<?php
use yii\helpers\Html;
use yii\widgets\Pjax;
use kartik\grid\GridView;
use yii\helpers\ArrayHelper;
use app\models\ErpCompany;
$this->title = 'Cadastros';
$this->params['breadcrumbs'][] = ['label' => $this->title];
?>
<?php Pjax::begin(); ?>    
<?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
        	[
        		'attribute'=>'STR_LOGIN',
        		'format' => 'raw',
        		'value'=>function ($searchModel, $key, $index, $widget){ return $searchModel->STR_LOGIN; },
        		'filterType'=>GridView::FILTER_SELECT2,
        		'filter'=>ArrayHelper::map($searchModel->getUserArrayByParam('STR_LOGIN'), 'STR_LOGIN', 'STR_LOGIN'),
        		'filterWidgetOptions'=>[
        				'pluginOptions'=>['allowClear'=>true],
        		],
        		'filterInputOptions'=>['placeholder'=>'login'],
        	],
        	[
        		'attribute'=>'STR_NAME',
        		'format' => 'raw',
        		'value'=>function ($searchModel, $key, $index, $widget){ return $searchModel->STR_NAME; },
        		'filterType'=>GridView::FILTER_SELECT2,
        		'filter'=>ArrayHelper::map($searchModel->getUserArrayByParam('STR_NAME'), 'STR_NAME', 'STR_NAME'),
        		'filterWidgetOptions'=>[
        				'pluginOptions'=>['allowClear'=>true],
        		],
        		'filterInputOptions'=>['placeholder'=>'Nome'],
        	],
        	[
	        	'attribute' => 'STR_SOCIAL_REASON',
	        	'format' => 'raw',
	        	'value' => 'erpCompany.STR_SOCIAL_REASON',
        		'filterType'=>GridView::FILTER_SELECT2,
        		'filter'=>ArrayHelper::map(ErpCompany::find()->asArray()->all(), 'STR_SOCIAL_REASON', 'STR_SOCIAL_REASON'),
        		'filterWidgetOptions'=>[
        			'pluginOptions'=>['allowClear'=>true],
        		],
        		'filterInputOptions'=>['placeholder'=>'Empresa'],
        		'label' => 'Empresa',
        	],
        	[
	        	'attribute'=>'STR_EMAIL',
	        	'format' => 'raw',
	        	'value'=>function ($searchModel, $key, $index, $widget){ return $searchModel->STR_EMAIL; },
	        	'filterType'=>GridView::FILTER_SELECT2,
	        	'filter'=>ArrayHelper::map($searchModel->getUserArrayByParam('STR_EMAIL'), 'STR_EMAIL', 'STR_EMAIL'),
	        	'filterWidgetOptions'=>[
	        			'pluginOptions'=>['allowClear'=>true],
	        	],
	        	'filterInputOptions'=>['placeholder'=>'Email'],
        	],
        	[
	        	'attribute'=>'BOO_STATUS',
	        	'format' => 'raw',
        		'attribute' => 'BOO_STATUS',
        		'value' => function($searchModel, $key, $index, $widget)
	        		{
	        			return $searchModel->BOO_STATUS == 0 ? 'Inativo' : 'Ativo';
	        		},
	        	'filterType'=>GridView::FILTER_SELECT2,
	        	'filter'=>ArrayHelper::map(['1' =>['id' => 1, 'name' => 'Ativo'], '0' => [ 'id' => 0, 'name' => 'Inativo']], 'id', 'name'),
	        	'filterWidgetOptions'=>[
	        			'pluginOptions'=>['allowClear'=>true],
	        	],
	        	'filterInputOptions'=>['placeholder'=>'Status'],
        	],
        	['class' => 'yii\grid\ActionColumn',
        		'template' => '{update} {delete}',
				'buttons' =>	
				[
					'update' => function ($url, $objSearchModel, $key) 
					{
						return Html::a('<span class="glyphicon glyphicon-pencil"></span>', 'site-user-update?id='.$objSearchModel->INT_PK_ID_SITE_USER);
					},
					'delete' => function ($url, $objSearchModel, $key) 
					{
						return Html::a('<span class="glyphicon glyphicon-trash"></span>', 'site-user-delete',
							[
								'data-confirm' => Yii::t('yii', 'Are you sure you want to delete this item?'),
								'data-method' => 'post',
							]);
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
        	'heading'=>'<h3 class="panel-title"><i class="glyphicon glyphicon-globe"></i> '.'Cadastros'.'</h3>',
        	'type'=>'primary',
        ],
        'toolbar'=>
        [
        	[
        		'content'=>
        		html::a(Html::button('<i class="glyphicon glyphicon-plus"></i> '.'Adicionar cadastro', ['type'=>'button', 'title'=>'Adicionar cadastro', 'class'=>'btn btn-success']),['/site/site-user-add'])
        	],
        	[
        		'content'=>
        		Html::a('<i class="glyphicon glyphicon-repeat"></i>', ['site/user'], ['data-pjax'=>0, 'class'=>'btn btn-default', 'title'=>'Atualizar'])
        	],
        	'{export}',
        	'{toggleData}',
        ],
        'striped'=>false,
    ]); ?>
<?php Pjax::end(); ?>
