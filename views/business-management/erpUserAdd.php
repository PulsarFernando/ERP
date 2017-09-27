<?php
$this->title = Yii::t('app', 'Adicionar colaborador');
$this->params['breadcrumbs'][] = ['label' => 'Colaboradores', 'url' => ['erp-user']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="erp-user-create">
	<?= 
		$this->render('_formErpUser', [
        	'objErpUser' => $objErpUser,
    	]) 
	?>
</div>