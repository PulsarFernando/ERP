<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel app\models\SiteDownloadSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Site Downloads');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-download-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a(Yii::t('app', 'Create Site Download'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>
<?php Pjax::begin(); ?>    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'INT_PK_ID_SITE_DOWNLOAD',
            'INT_FK_ID_SITE_USER',
            'INT_FK_ID_SITE_FILE',
            'TST_CREATION_DATE',
            'STR_IP',
            // 'STR_NAME',
            // 'STR_NOTE',
            // 'BOO_INVOICE',
            // 'INT_FK_ERP_PRICE_ID',
            // 'STR_PROJECT_NAME',
            // 'STR_FORMAT',
            // 'STR_CIRCULATION',
            // 'STR_IMPRESSION',
            // 'BOO_DOWNLOAD_SITE',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
<?php Pjax::end(); ?></div>
