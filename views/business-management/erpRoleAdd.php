<?php
use yii\helpers\Html;
$this->title = 'Adicionar perfil';
$this->params['breadcrumbs'][] = ['label' => 'Perfis', 'url' => ['erp-role']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="erp-role-create">
	<?= 
		$this->render('_formErpRole', [
	        'objErpRole' => $objErpRole,
	    ]) 
	?>
</div>