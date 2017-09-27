<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\SiteDownload */

$this->title = Yii::t('app', 'Create Site Download');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Site Downloads'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-download-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
