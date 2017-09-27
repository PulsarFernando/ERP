<?php
use yii\helpers\Html;
use kartik\grid\GridView;
use yii\widgets\Pjax;
$this->title = 'Administrar menu';
$this->params['breadcrumbs'][] = ['label' => 'Perfis', 'url' => ['erp-role']];
$this->params['breadcrumbs'][] = $this->title;
?>
<?php Pjax::begin(); ?>    
<?= GridView::widget([
 		'dataProvider' => $dataProvider,
		'filterModel' => $searchModel,
        'columns' => [
        	[
            	'attribute' => 'STR_MENU_NAME',
            	'value' => 'STR_MENU_NAME',
        	],
        	[
        		'attribute' => 'STR_URL',
        		'value' => 'STR_URL',
        	],
        	[
        		'attribute' => 'BOO_STATUS',
        		'value' => function($model, $key, $index, $column)
        		{
        			return $model->BOO_STATUS == 0 ? 'Inativo' : 'Ativo';
        		},
        	],
        	[
        		'attribute' => 'BOO_MAIN_MENU',
        		'value' => function($model, $key, $index, $column)
        	{
        		return $model->BOO_MAIN_MENU == 0 ? 'Não' : 'Sim';
        	},
        	],
             	[
            	'class' => 'yii\grid\ActionColumn', 
            	'template' => '{update}',
            	'buttons' => 
            	[ 
            		'update' => function ($url, $model) {
				     	return Html::a(
				     		'<span class="glyphicon glyphicon-pencil"></span>', 'erp-menu-update?id='.$model->INT_PK_ID_ERP_MENU.'&intTypeMenu='.Yii::$app->request->get('intTypeMenu'), 
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
        	'heading'=>'<h3 class="panel-title"><i class="glyphicon glyphicon-globe"></i> '.(Yii::$app->request->get('intTypeMenu') == 0 ? 'Menu principal' : 'Submenu').'</h3>',
        	'type'=>'primary',
        ],
        'toolbar'=>
        [
        		[
        				'content'=>
        				html::a(Html::button('<i class="glyphicon glyphicon-plus"></i> '.'Adicionar '.(Yii::$app->request->get('intTypeMenu') == 0 ? 'Menu principal' : 'Submenu'), ['type'=>'button', 'title'=>'Adicionar '.(Yii::$app->request->get('intTypeMenu') == 0 ? 'Menu principal' : 'Submenu'), 'class'=>'btn btn-success']),['business-management/erp-menu-add?intTypeMenu='.Yii::$app->request->get('intTypeMenu')])
        		],
        		[
        				'content'=>
        				Html::a('<i class="glyphicon glyphicon-repeat"></i>', ['business-management/erp-menu-adm?intTypeMenu='.Yii::$app->request->get('intTypeMenu')], ['data-pjax'=>0, 'class'=>'btn btn-default', 'title'=>'Atualizar'])
        		],
        		'{export}',
        		'{toggleData}',
        ],
        'striped'=>false,
    ]); 
?>
<?php Pjax::end(); ?>