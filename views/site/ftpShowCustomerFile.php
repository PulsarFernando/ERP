<?php
use yii\helpers\Html;
use kartik\grid\GridView;
use app\models\SiteFile;
$this->registerJS("
//Delete All
	$(document).on('click','#btn-delete-all', function(){
		var arrSelect = '';
		$('.kv-row-checkbox').each(function()
		{
			if($(this).is(':checked'))
		    	arrSelect += ',' + $(this).val();
		});
		if(arrSelect.length > 0)
			$('#href-delete-all').attr('href','/site/ftp-delete?id='+arrSelect.substring(1)+'&intSiteUserId='+'".$objSearchModel->INT_FK_SITE_USER_ID."');
		else
			return false;
	});

");
$this->title = 'Acervo disponível para: '.$objSiteUser->STR_NAME;
$this->params['breadcrumbs'][0] = ['label' => 'FTP', 'url' => '/site/ftp' ];
$this->params['breadcrumbs'][1] = $this->title;
?>
<?= 
	GridView::widget([
		'dataProvider' => $objDataProvider,
		'columns' => [
				[
					'attribute' => 'STR_FILE_CODE',	
					'format' => 'raw',
					'value' => 'siteFile.STR_FILE_CODE',
					'label' => 'Código do arquivo'	
				],
				[
					'attribute'=>'TST_CREATION_DATE',
					'format' => 'dateTime',
					'value'=> $objSearchModel->TST_CREATION_DATE,
				],
				[
					'attribute'=>'INT_SHELF_LIFE',
					'format' => 'raw',
					'value'=> $objSearchModel->INT_SHELF_LIFE,
				],
				[
					'attribute' => 'STR_USER_NAME',	
					'format' => 'raw',
					'value' => 'erpUser.STR_USER_NAME',
					'label' => 'Nome do colaborador',	
				],
				[
					'class' => 'yii\grid\ActionColumn',
					'template' => '{update} {delete}',
					'buttons' =>	
					[
						'update' => function ($url, $objSearchModel, $key) 
						{
							 $objFkType = SiteFile::find()->select('INT_FK_ERP_TYPE_FILE_ID')->where(['INT_PK_ID_SITE_FILE' => $objSearchModel->INT_FK_SITE_FILE_ID])->one(); 
							
							
							return Html::a('<span class="glyphicon glyphicon-pencil"></span>', str_replace('update', 'ftp-update', $url.'&type='.($objFkType->INT_FK_ERP_TYPE_FILE_ID == 1 ? 'picture' : 'video').'&intSiteUserId='.$objSearchModel->INT_FK_SITE_USER_ID.'&intIdSiteFile='.$objSearchModel->INT_FK_SITE_FILE_ID));
						},
						'delete' => function ($url, $objSearchModel, $key) 
						{
							return Html::a('<span class="glyphicon glyphicon-trash"></span>', str_replace('delete', 'ftp-delete', $url.'&intSiteUserId='.$objSearchModel->INT_FK_SITE_USER_ID),[
								'data-confirm' => Yii::t('yii', 'Are you sure you want to delete this item?'),
								'data-method' => 'post',
							]);
						},
					],
				],
				[
					'class' => '\kartik\grid\CheckboxColumn'
				],
		],
		'pjax'=>true,
		'pjaxSettings'=>[
			'neverTimeout'=>true,
		],
		'responsive'=>true,
		'hover'=>true,
		'panel' => [
			'heading'=>'<h3 class="panel-title"><i class="glyphicon glyphicon-globe"></i> '.'Acervo disponível </h3>',
			'type'=>'primary',
		],
		'toolbar'=> 
		[
			['content'=>html::a(Html::button('<i class="glyphicon glyphicon-minus"></i> '.'Apagar selecionados',['type'=>'button', 'title'=>'Apagar selecionados', 'class'=>'btn btn-danger', 'id'=>'btn-delete-all']),['#'],['id'=>'href-delete-all'])],
			['content'=>html::a(Html::button('<i class="glyphicon glyphicon-plus"></i> '.'Adicionar foto', ['type'=>'button', 'title'=>'Adicionar foto', 'class'=>'btn btn-success']),['site/ftp-add?intSiteUserId='.$objSearchModel->INT_FK_SITE_USER_ID.'&type=picture'])],
			['content'=>html::a(Html::button('<i class="glyphicon glyphicon-plus"></i> '.'Adicionar Vídeo', ['type'=>'button', 'title'=>'Adicionar Vídeo', 'class'=>'btn btn-success']),['site/ftp-add?intSiteUserId='.$objSearchModel->INT_FK_SITE_USER_ID.'&type=video'])],
			['content'=>Html::a('<i class="glyphicon glyphicon-repeat"></i>', ['site/ftp-show-customer-file?SiteFtpFileSearch[INT_FK_SITE_USER_ID]='.$objSearchModel->INT_FK_SITE_USER_ID], ['data-pjax'=>0, 'class'=>'btn btn-default', 'title'=>Yii::t('erpGridView', 'Reset Grid')])],
			'{export}',
			'{toggleData}',
		],
		'striped'=>false,
	]); 
?>