<?php
	use kartik\form\ActiveForm;
	use yii\helpers\Html;
	$this->title = Yii::$app->name;
?>
<div class="site-index">
	<div class="jumbotron">
		<?php 
			echo Html::img('\images\logo.png');
		?>
	</div>
	<div class="body-content">
		<div class="index">
			<?php 
				$objForm = ActiveForm::begin();
				echo $objForm->field($objModelErpLogin, 'strLogin');
				echo $objForm->field($objModelErpLogin, 'strPassword')->passwordInput();
			?>
			<div class="form-group">
				<?php echo HTML::submitButton( 'Login', ['class' => 'btn btn-primary', 'name'	=> 'login-button' ]); ?>
			</div>
			<?php ActiveForm::end(); ?>
		</div>
	</div>
</div>		