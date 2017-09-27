<?php
$this->title = 'Atualizar cadasto de cliente';
$this->params['breadcrumbs'][] = ['label' =>'Cadastros', 'url' => ['site/site-user']];
$this->params['breadcrumbs'][] = $this->title;		
?>
<div class="site-user-update">
    <?= 
    	$this->render('_formSiteUser', [
        	'objSiteUser' => $objSiteUser,
    		'intPkIdErpState' => $objErpStateResult->INT_PK_ID_ERP_STATE,
    		'intFkErpCountryId' => $objErpStateResult->INT_FK_ERP_COUNTRY_ID,
    	]) 
    ?>
</div>