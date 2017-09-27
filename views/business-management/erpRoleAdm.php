<?php
use yii\helpers\Html;
use kartik\grid\GridView;
use yii\widgets\Pjax;
use yii\helpers\ArrayHelper;
use app\models\ErpRole;
$this->title = Yii::t('app', 'Administrar Perfis');
$this->params['breadcrumbs'][] = ['label' => 'Perfis', 'url' => ['erp-role']];
$this->params['breadcrumbs'][] = $this->title;
?>
<?php Pjax::begin(); ?>    
<?= GridView::widget([
 		'dataProvider' => $dataProvider,
        'columns' => [
        	[
            	'attribute' => 'STR_ROLE_NAME',
            	'value' => 'STR_ROLE_NAME',
        	],
        	
        	[
        		'attribute' => 'BOO_STATUS',
        		'value' => function($model, $key, $index, $column)
        		{
        			return $model->BOO_STATUS == 0 ? 'Inativo' : 'Ativo';
        		},
        	],
        	[
        	'attribute' => 'TST_CREATION_DATE',
        	'format' => 'dateTime',
        	'value' => 'TST_CREATION_DATE',
        	],
        	[
            	'class' => 'yii\grid\ActionColumn', 
            	'template' => '{update}',
            	'buttons' => 
            	[ 
            		'update' => function ($url, $model) {
				     	return Html::a(
				     		'<span class="glyphicon glyphicon-pencil"></span>', 'erp-role-update?id='.$model->INT_PK_ID_ERP_ROLE, 
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
        		'heading'=>'<h3 class="panel-title"><i class="glyphicon glyphicon-globe"></i> '.'Perfis'.'</h3>',
        		'type'=>'primary',
        ],
        'toolbar'=>
        [
        		[
        				'content'=>
        				html::a(Html::button('<i class="glyphicon glyphicon-plus"></i> '.'Adicionar Perfil', ['type'=>'button', 'title'=>'Adicionar colaborador', 'class'=>'btn btn-success']),['business-management/erp-role-add'])
        		],
        		[
        				'content'=>
        				Html::a('<i class="glyphicon glyphicon-repeat"></i>', ['business-management/erp-role-adm'], ['data-pjax'=>0, 'class'=>'btn btn-default', 'title'=>'Atualizar'])
        		],
        		'{export}',
        		'{toggleData}',
        ],
        'striped'=>false,
    ]); 
?>
<?php Pjax::end(); ?>