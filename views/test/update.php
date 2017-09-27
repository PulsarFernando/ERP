<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\SiteDownload */

$this->title = Yii::t('app', 'Update {modelClass}: ', [
    'modelClass' => 'Site Download',
]) . $model->INT_PK_ID_SITE_DOWNLOAD;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Site Downloads'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->INT_PK_ID_SITE_DOWNLOAD, 'url' => ['view', 'id' => $model->INT_PK_ID_SITE_DOWNLOAD]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="site-download-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
