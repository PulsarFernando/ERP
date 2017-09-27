<?php
use yii\helpers\Html;
$this->title = 'Atualizar';
$this->params['breadcrumbs'][] = ['label' => 'Perfis', 'url' => ['erp-role']];
$this->params['breadcrumbs'][] = ['label' => 'Administrar menu', 'url' => ['erp-menu-adm?intTypeMenu='.Yii::$app->request->get('intTypeMenu')]];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="erp-menu-update">
    <?= $this->render('_formErpMenu', [
    	'objErpMenu' => $objErpMenu,
    ]) ?>
</div>
