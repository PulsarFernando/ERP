<?php
$this->title = 'Adicionar empresa oficial';
$this->params['breadcrumbs'][] = ['label' => 'Empresas oficiais', 'url' => ['erp-customer']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="erp-customer-create">
    <?= 
    	$this->render('_formErpCustomer', [
        	'objErpCustomer' => $objErpCustomer,
    		'objErpCompany' => $objErpCompany,
    	]) 
    ?>
</div>