<?php
$this->title = 'Atualizar';
$this->params['breadcrumbs'][] = ['label' =>'Imagens para o banner principal', 'url' => ['site/home-page']]; '';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-home-page-file-update">
    <?= $this->render('_formHomePage', [
        'objSiteHomePageFile' => $objSiteHomePageFile,
    	'objSiteFile' => $objSiteFile,
    	'objFileComponent' => $objFileComponent
    ]) ?>
</div>