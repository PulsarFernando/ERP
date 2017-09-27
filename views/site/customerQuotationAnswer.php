<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\grid\GridView;
use dosamigos\ckeditor\CKEditor;
$this->title = 'Respondendo cotação';
$this->params['breadcrumbs'][] = $this->title;
?>
<?= 
	GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            [
        		'attribute' => 'STR_NAME',
        		'format' => 'raw',
        		'value' => 'siteUser.STR_NAME',	
            	'label' => 'Nome do cliente',	
        	],
        	[
        		'attribute' => 'STR_EMAIL',
        		'format' => 'raw',
        		'value' => 'siteUser.STR_EMAIL',
        		'label' => 'Email',	
        	],
        	[
        		'attribute' => 'STR_USER_NAME',
        		'format' => 'raw',
        		'value' => 'erpUser.STR_USER_NAME',
        		'label' => 'Nome do colaborador'	
        	],
        ],
		'pjaxSettings'=>[
			'neverTimeout'=>true,
		],
		'responsive'=>true,
		'hover'=>false,
		'toolbar' => false, 	
		'panel' =>
		[
			'heading'=>'<h3 class="panel-title"><i class="glyphicon glyphicon-globe"></i> Responder Cotação</h3>',
			'type'=>'primary',
			'after' => false,
			'footer' => false,
		],
		'striped'=>false,
   ]); 
?>
<div class="site-customer-quotation-form">
	<div class="pulsar-customer-quotation-answer-form">
		<?php $form = ActiveForm::begin(); ?>
    	<div class="form-group-code">
    		<?= $form->field($objSiteQuoteSent, 'STR_CUSTOMER_MESSAGE')->textarea(['rows' => 6,'disabled' => true]) ?>
    	</div>
    	<div class="form-group-code">
    		<?= $form->field($objSiteQuoteSent, 'STR_PULSAR_MESSAGE')->widget(CKEditor::className(), [
		        		'options' => ['rows' => 6],
	    				'preset' => 'basic'
		   			 ]
    			) 
    		?>
    	</div>
    	<div class="form-group-code">
			<?= Html::submitButton('Responder e salvar', ['class' => $objSiteQuoteSent->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
			<?= $form->field($objSiteQuoteSent, 'INT_FK_SITE_USER_ID')->hiddenInput()->label(false); ?>
			<?= $form->field($objSiteQuoteSent, 'INT_FK_ERP_USER_ID')->hiddenInput()->label(false); ?>
			<?= $form->field($objSiteQuoteSent, 'TST_LAST_ACESS')->hiddenInput(['value' => date('Y-m-d H:s:i')])->label(false); ?>
			<?= $form->field($objSiteQuoteSent, 'BOO_ATTENDED')->hiddenInput(['value' => '1'])->label(false); ?>
			<?= $form->field($objSiteQuoteSent, 'STR_SERVICE_DATE')->hiddenInput()->label(false); ?>
    	</div>
    	<?php ActiveForm::end(); ?>
    </div>
</div>    	