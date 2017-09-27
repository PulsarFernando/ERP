<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\SiteDownload */

$this->title = $model->INT_PK_ID_SITE_DOWNLOAD;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Site Downloads'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-download-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a(Yii::t('app', 'Update'), ['update', 'id' => $model->INT_PK_ID_SITE_DOWNLOAD], ['class' => 'btn btn-primary']) ?>
        <?= Html::a(Yii::t('app', 'Delete'), ['delete', 'id' => $model->INT_PK_ID_SITE_DOWNLOAD], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => Yii::t('app', 'Are you sure you want to delete this item?'),
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'INT_PK_ID_SITE_DOWNLOAD',
            'INT_FK_ID_SITE_USER',
            'INT_FK_ID_SITE_FILE',
            'TST_CREATION_DATE',
            'STR_IP',
            'STR_NAME',
            'STR_NOTE',
            'BOO_INVOICE',
            'INT_FK_ERP_PRICE_ID',
            'STR_PROJECT_NAME',
            'STR_FORMAT',
            'STR_CIRCULATION',
            'STR_IMPRESSION',
            'BOO_DOWNLOAD_SITE',
        ],
    ]) ?>

</div>
