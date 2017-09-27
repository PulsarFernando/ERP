<?php
$this->title = 'Adicionar cliente temporário';
$this->params['breadcrumbs'][] = ['label' =>'FTP', 'url' => ['site/ftp']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-user-create">
    <?= $this->render('_formTemporaryCustomer', [
        'objSiteUser' => $objSiteUser,
    	'arrItemsLanguage' => $arrItemsLanguage,	
    	'arrItemsTypeNewsletter' => $arrItemsTypeNewsletter,	
    ]) ?>
</div>