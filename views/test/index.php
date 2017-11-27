<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel app\models\ErpLicenseSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Erp Licenses';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="erp-license-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Erp License', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
<?php Pjax::begin(); ?>    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'INT_PK_ID_ERP_LICENSE',
            'INT_FK_ERP_CUSTOMER_ID',
            'INT_FK_ERP_USER_ID',
            'INT_FK_ERP_COMPANY_ID',
            'STR_DESCRIPTION:ntext',
            // 'STR_SOCIAL_REASON',
            // 'STR_FANTASY_NAME',
            // 'STR_STATE_REGISTRATION',
            // 'STR_CNPJ',
            // 'FLO_TOTAL_AMOUNT',
            // 'DAT_CREATION_LICENSE',
            // 'DAT_PAYDAY',
            // 'TST_CREATION_DATE',
            // 'STR_INVOICE',
            // 'BOO_COMPLETED',
            // 'BOO_CLOSED_INVOICE',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
<?php Pjax::end(); ?></div>
