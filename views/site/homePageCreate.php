<?php
$this->title = 'Adicionar';
$this->params['breadcrumbs'][] = ['label' =>'Imagens para o banner principal', 'url' => ['site/home-page']]; '';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-home-page-file-create">
    <?= $this->render('_formHomePage', [
        'objSiteHomePageFile' => $objSiteHomePageFile,
    	'objSiteFile' => $objSiteFile,
    	'objErpGobal' => $objErpGobal
    ]) ?>
</div>