<?php
use yii\helpers\Html;
$this->title = 'Atualizar perfil';
$this->params['breadcrumbs'][] = ['label' => 'Perfis', 'url' => ['erp-role']];
$this->params['breadcrumbs'][] = $this->title.': '.$objErpRole->STR_ROLE_NAME;
?>
<div class="erp-role-update">
	<?= 
		$this->render('_formErpRole', [
	        'objErpRole' => $objErpRole,
	    ]) 
	?>
</div>