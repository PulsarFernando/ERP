<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use newerton\jcrop\jCrop;
$this->registerJs("
	$('#crop-send-button').hide();		
	$(document).on('click','#start_imageId',function(){
		$('#crop-send-button').show();	
	});	
");
?>
<div class="site-home-page-file-form">
    <?php $form = ActiveForm::begin(); ?>
    <?= $form->field($objSiteHomePageFile, 'INT_FK_SITE_FILE_ID')->hiddenInput()->label(false) ?>
    <?= $form->field($objSiteHomePageFile, 'INT_FK_SITE_AUTHOR_ID')->hiddenInput()->label(false) ?>
    <?= $form->field($objSiteHomePageFile, 'TST_CREATION_DATE')->hiddenInput()->label(false) ?>
    <div class="form-group" id="form-group-crop">
	<?php
		echo jCrop::widget([
		    'url' => '/images/copyS3/'.$objSiteFile->STR_FILE_CODE.'.jpg',
		    'imageOptions' => [
		        'id' => 'imageId',
		        'width' => $objSiteFile->INT_HORIZANTAL_SIZE/4,
		    	'height' => $objSiteFile->INT_VERTICAL_SIZE/4,	
		        'alt' => 'Crop this image'
		    ],
		    'jsOptions' => [
		        'minSize' => [$objSiteFile->INT_HORIZANTAL_SIZE/4, 132.5],
		        'aspectRatio' => ($objSiteFile->INT_HORIZANTAL_SIZE/2) / 530,
		        'onRelease' => new yii\web\JsExpression("function() {ejcrop_cancelCrop(this);}"),
		        'bgColor' => '#000000',
		        'bgOpacity' => 0.1,
		        'selection' => true,
		        'theme' => 'light',
		    ],
		    'buttons' => [
		        'start' => [
		            'label' => 'Editar Imagem',
		            'htmlOptions' => [
		                'class' => $objSiteHomePageFile->isNewRecord ? 'btn btn-success' : 'btn btn-primary',
		            ]
		        ],
		    ],
		]);
	?>
	</div>
    <div class="form-group"  id="form-group-crop">
        <?= Html::submitButton('Salvar',['class' => $objSiteHomePageFile->isNewRecord ? 'btn btn-success' : 'btn btn-primary', 'id' => 'crop-send-button']) ?>
    </div>
</div>
<?php ActiveForm::end(); ?>