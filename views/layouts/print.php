<?php
use yii\helpers\Html;
use app\assets\AppAsset;
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
		echo $this->registerCssFile('../css/print.css'); 
	?>
</head>
<body>
<?php 
	$this->beginBody() 
?>
<div class="wrap">
    <div class="container">
            <?php echo $content ?>
    </div>
</div>
<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>