<?php 
use app\models\SiteSpecialUserPrefix;
use yii\helpers\Html;
use kartik\grid\GridView;
use yii\helpers\ArrayHelper;
$this->title = 'FTP';
$this->params['breadcrumbs'][] = ['label' => $this->title, 'url' => '/site/ftp' ];
?>
<?= GridView::widget([
		'dataProvider'=> $objDataProvider,
		'filterModel' => $objSearchModel,
		'columns' =>
		[
			[
				'attribute'=>'STR_LOGIN',
				'width'=>'310px',
				'format' => 'raw',
				'value'=>function ($objSearchModel, $key, $index, $widget) 
				{
					return Html::a(
						$objSearchModel->STR_LOGIN,
						['site/ftp-show-customer-file','SiteFtpFileSearch[INT_FK_SITE_USER_ID]'=>$objSearchModel->INT_PK_ID_SITE_USER],
						['title' => $objSearchModel->STR_LOGIN,'class'=>'no-pjax']
					);
				},
				'filterType'=>GridView::FILTER_SELECT2,
				'filter'=>ArrayHelper::map($objSearchModel->getUserArrayByParam('STR_LOGIN'), 'STR_LOGIN', 'STR_LOGIN'),
				'filterWidgetOptions'=>[
					'pluginOptions'=>['allowClear'=>true],
				],
				'filterInputOptions'=>['placeholder'=>'login do cliente'],
			],
			[
				'attribute'=>'STR_NAME',
				'width'=>'310px',
				'format' => 'raw',
				'value'=>function ($objSearchModel, $key, $index, $widget) 
				{
					return Html::a(
						$objSearchModel->STR_NAME, 
						['site/ftp-show-customer-file','SiteFtpFileSearch[INT_FK_SITE_USER_ID]'=>$objSearchModel->INT_PK_ID_SITE_USER], 
						['title' => $objSearchModel->STR_NAME,'class'=>'no-pjax']
					);
				},
				'filterType'=>GridView::FILTER_SELECT2,
				'filter'=>ArrayHelper::map($objSearchModel->getUserArrayByParam('STR_NAME'), 'STR_NAME', 'STR_NAME'),
				'filterWidgetOptions'=>
				[
					'pluginOptions'=>['allowClear'=>true],
				],
				'filterInputOptions'=>['placeholder'=>'Nome do cliente'],
			],
			[
				'attribute'=>'STR_EMAIL',
				'width'=>'310px',
				'format' => 'raw',
				'value'=>function ($objSearchModel, $key, $index, $widget) 
				{
					return Html::a(
						$objSearchModel->STR_EMAIL, 
						['site/ftp-show-customer-file', 'SiteFtpFileSearch[INT_FK_SITE_USER_ID]'=>$objSearchModel->INT_PK_ID_SITE_USER], 
						['title' => $objSearchModel->STR_EMAIL,'class'=>'no-pjax']
					);
				},
				'filterType'=>GridView::FILTER_SELECT2,
				'filter'=>ArrayHelper::map($objSearchModel->getUserArrayByParam('STR_EMAIL'), 'STR_EMAIL', 'STR_EMAIL'),
				'filterWidgetOptions'=>
				[
					'pluginOptions'=>['allowClear'=>true],
				],
				'filterInputOptions'=>['placeholder'=>'Email do cliente'],
			],
			[
					'attribute' => 'STR_SPECIAL_USER_PREFIX',
					'label' => 'Prefixo',	
					'value' => 'siteSpecialUserPrefix.STR_SPECIAL_USER_PREFIX'
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
					html::a(Html::button('<i class="glyphicon glyphicon-plus"></i> '.'Adicionar cliente temporário', ['type'=>'button', 'title'=>'Adicionar cliente temporário', 'class'=>'btn btn-success']),['/customer/add-temporary-customer'])
			],
			[					
				'content'=>
					Html::a('<i class="glyphicon glyphicon-repeat"></i>', ['site/ftp'], ['data-pjax'=>0, 'class'=>'btn btn-default', 'title'=>'Atualizar'])
			],
			'{export}',
			'{toggleData}',
		],
		'striped'=>false,
    ]); ?>