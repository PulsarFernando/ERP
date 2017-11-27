<?php
use yii\helpers\Html;
use kartik\grid\GridView;
use yii\widgets\Pjax;
use app\components\ErpGlobal;
use app\models\SiteFile;
$this->registerJs("
		$(document).on('click','#add-picture-home-button',function(){
			var strFileCode = $('#add-picture-home-code').val();
			$.post(
				'home-page-verify-code-file',
				{
					strFileCode: strFileCode,
				},
				function(data)
				{
					$('#add-picture-home-code').val('');
					switch(data)
					{
						case '0':
							$('#add-picture-home-code').attr('placeholder','Código não encontrado.');
							break;
						case '1':		
							$('#add-picture-home-code').attr('placeholder','A foto não pode ser vertical.');
							break;	
						default:
							$('.form-group').attr('class', 'form-group add-picture-home required has-error');
							$('#add-picture-home-code').attr('placeholder','O código é obrigatório');
							break;	
					}
				}
			);
			return false;
		});
");
$this->title = 'Imagens para o banner principal';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-home-page-file-index">
	<?php Pjax::begin(); ?>    
		<?= 
			GridView::widget([
		        'dataProvider' => $objDataProvider,
		        'columns' => [
		            'siteAuthor.STR_AUTHOR_ACRONYM',
		        	'siteAuthor.STR_NAME_AUTHOR',
		        	'siteFile.STR_FILE_CODE',
		        	[
		        		'attribute' => 'TST_CREATION_DATE',
		        		'format' => 'dateTime',
		        		'value'=> $objSiteHomePageSearch->TST_CREATION_DATE,
		        	],
		        	[
		        		'attribute' => 'siteFile.STR_FILE_CODE',
		        		'format' => 'raw',
		        		'value' => function($objDataProvider, $key, $index, $widget)
		        		{
		        			return Html::img(Yii::$app->erpGlobal->getUrlPreviewImage($objDataProvider->siteFile->STR_FILE_CODE).Yii::$app->erpGlobal->getExtensionJpg(),['class' => 'show-image-home']);
		        		},
		        		'label' => 'Imagem',
		        		'contentOptions' => ['class' => 'container-show-image-home'],
		        	],	
		        	[
		        		'class' => 'yii\grid\ActionColumn',
		        		'template' => '{update} {delete}',
		        		'buttons' =>
		        		[
		        			'update' => function ($url, $objSiteHomePageSearch, $key)
		        			{
		        				return Html::a('<span class="glyphicon glyphicon-pencil"></span>', str_replace('update', 'home-page-update', $url));
		        			},
		        			'delete' => function ($url, $objSiteHomePageSearch, $key)
		        			{
			        			return Html::a('<span class="glyphicon glyphicon-trash"></span>', str_replace('delete', 'home-page-delete', $url),[
			        				'data-confirm' => Yii::t('yii', 'Are you sure you want to delete this item?'),
			        				'data-method' => 'post',
			        			]);
		        			},
		        		],
		        	],
		        ],
				'pjax'=>true,
				'pjaxSettings'=>[
					'neverTimeout'=>true,
				],
				'responsive'=>true,
				'hover'=>true,
				'panel' => [
					'heading'=>'<h3 class="panel-title"><i class="glyphicon glyphicon-globe"></i> '.$this->title.' ds home</h3>',
					'type'=>'primary',
				],
				'toolbar'=>
				[
					[
						'content'=>
							'<div class="form-group add-picture-home required">'.	
								Html::input('text','add-picture-home-code',null,['id' => 'add-picture-home-code','placeholder' =>'Digite o código da foto','class' => 'form-control']).
							'</div>'
					],
					[
						'content' => html::a(Html::button('<i class="glyphicon glyphicon-plus"></i> '.'Adicionar foto', ['type'=>'button', 'title'=>'Adicionar foto', 'class'=>'btn btn-success','id'=>'add-picture-home-button']),['site/add-homePage'])
		        	]	
				],
				'striped'=>false,
		    ]); 
		?>
	<?php Pjax::end(); ?>
</div>