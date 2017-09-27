<?php 
use yii\helpers\Html;
if(count($arrDropdown) > 1):
?>
	<div class="form-group field-sitedownload-str_project_type required">   	
		<?= Html::label($strLabelName, $strFieldName,['class'=>$strLabelClass])?>
		<?= Html::dropDownList($strFieldName, $intSelected, $arrDropdown, ['class' => $strClassName,'id' => $strIdName])?>
	</div>
<?php 
else:
	echo Html::hiddenInput($strFieldName, $intSelected, ['class' => $strClassName,'id' => $strIdName]);
endif;
?>	