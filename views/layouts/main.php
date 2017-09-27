<?php
use yii\helpers\Html;
use yii\widgets\Breadcrumbs;
use app\assets\AppAsset;
use yii\bootstrap\NavBar;
use yii\bootstrap\Nav;
AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<<?php echo Yii::$app->language ?>">
<head>
    <meta charset="<<?php echo Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="robots" content="noindex">
    <?php 
    	echo Html::csrfMetaTags() 
    ?>
    <title>
    	<?php 
    		echo Html::encode($this->title) 
    	?>
    </title>
    <?php 
    	$this->head(); 
    ?>
    <link rel="shortcut icon" href="../images/favicon.ico" type="image/x-icon" />	
	<?php 
		echo $this->registerCssFile('../css/custon.css'); 
	?>
</head>
<body>
<?php 
	$this->beginBody() 
?>
<div class="wrap">
    <div class="container">
        <?php 
        	echo Breadcrumbs::widget([
            'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
        	]);
		    NavBar::begin([
		        'options' => [
		            'class' => 'navbar-inverse navbar-fixed-top',
		        ],
		    ]);
		    echo Nav::widget([
		        'options' => ['class' => 'navbar-nav navbar-right'],
		        'items' => app\components\MenuComponent::getMainMenu(),
		    ]);
    		NavBar::end();
    	?>
    <div class="container">
        <?php Breadcrumbs::widget([
            'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
        ]) ?>
        <?php echo $content ?>
    </div>
</div>
<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>