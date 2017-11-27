<?php
use yii\helpers\Html;
use yii\widgets\Pjax;
use kartik\grid\GridView;
$this->title = 'Download de LUI';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="erp-license-file-index">
	<?php Pjax::begin(); ?>    
		<?= 
			GridView::widget([
		        'dataProvider' => $objDataProvider,
		        'filterModel' => $objSearchModel,
		        'columns' => [
		        	[
		        		'attribute'=>'INT_FK_ERP_LICENSE_ID',
		        		'group' => true,
		        		'format' => 'raw',	
		        		'value' => function($objSearchModel, $key, $index, $widget){
							return html::a($objSearchModel->INT_FK_ERP_LICENSE_ID, 'adminitrative/erp-download-lui-by-lr?id='.$objSearchModel->INT_FK_ERP_LICENSE_ID);
						}	
		        	],
		        	[
		        		'attribute'=>'STR_FILE_CODE',
		       			'format' => 'raw',
		        		'value' => function($objSearchModel, $key, $index, $widget){
		        		
							return html::a($objSearchModel->STR_FILE_CODE, 'adminitrative/erp-download-lui-by-file?id='.$objSearchModel->INT_FK_ERP_LICENSE_ID.'&idFileCode'.$objSearchModel->STR_FILE_CODE);
						}	
		        	]
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
						'content'=> Html::a('<i class="glyphicon glyphicon-repeat"></i>', ['administrative/download-lui'], ['data-pjax'=>0, 'class'=>'btn btn-default', 'title'=>'Atualizar'])
					],
					'{export}',
					'{toggleData}',
				],
				'striped'=>false,
	    	]
		); 
		?>
	<?php Pjax::end(); ?>
</div>
