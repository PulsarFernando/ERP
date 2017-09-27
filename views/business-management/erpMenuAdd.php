<?php
use yii\helpers\Html;
$this->title = 'Adicionar '.(Yii::$app->request->get('intTypeMenu') == 0 ? 'menu principal' : 'submenu');
$this->params['breadcrumbs'][] = ['label' => 'Perfis', 'url' => ['erp-role']];
$this->params['breadcrumbs'][] = ['label' => 'Administrar menu', 'url' => ['erp-menu-adm?intTypeMenu='.Yii::$app->request->get('intTypeMenu')]];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="erp-menu-create">
    <?= $this->render('_formErpMenu', [
    	'objErpMenu' => $objErpMenu,
    ]) ?>
</div>
