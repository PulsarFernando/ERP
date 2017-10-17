<?php 
use yii\helpers\Html;
use app\components\ErpGlobal;
?>
<div class='container-picture-information'>
	<div class='container-picture'>
		<?php echo Html::img( Yii::$app->erpGlobal->getUrlPreviewImage($objSiteDownloadSearch->siteFile->STR_FILE_CODE).Yii::$app->erpGlobal->getExtensionJpg()); ?>
	</div>
	<div class='container-information'>
		<div class='line'>
			<div class='label'>
				Autor:
			</div>
			<div class='information'>
				<?= $objAuthorName->STR_NAME_AUTHOR?>
			</div>
		</div>
		<div class='line'>
			<div class='label'>
				Data da foto:
			</div>
			<div class='information'>
				<?= Yii::$app->systemComponent->getDataSiteFile($objSiteDownloadSearch->siteFile->INT_FILE_DATE)?>
			</div>
		</div>
		<div class='line'>
			<div class='label'>
				Titulo:
			</div>
			<div class='information'>
				<?= $objSiteDownloadSearch->siteFile->STR_MAIN_SUBJECT_PT?>
			</div>
		</div>
	</div>
</div>
