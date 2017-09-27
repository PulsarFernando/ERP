<?php
$this->title = 'Novo cadasto de cliente';
$this->params['breadcrumbs'][] = ['label' =>'Cadastros', 'url' => ['site/site-user']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-user-create">
    <?= 
    $this->render('_formSiteUser', [
        	'objSiteUser' => $objSiteUser,
    	]) 
    ?>
</div>