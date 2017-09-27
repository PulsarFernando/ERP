<?php
$this->title = Yii::t('app', 'Atualizar colaborador');
$this->params['breadcrumbs'][] = ['label' => 'Colaboradores', 'url' => ['erp-user']];
$this->params['breadcrumbs'][] = 'Atualizar';
$this->params['breadcrumbs'][] = ['label' => $objErpUser->STR_USER_NAME];
?>
<div class="erp-user-update">
	<?= 
		$this->render('_formErpUser', [
        	'objErpUser' => $objErpUser,
    	]) 
	?>
</div>