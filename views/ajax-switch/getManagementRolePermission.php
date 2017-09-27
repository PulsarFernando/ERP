<?php 
use yii\helpers\Html;
foreach ($arrErpMainMenu as $arrMainMenuLine):
?>
	<div class='table-responsive-header'>
		<?= Html::input('checkbox');?>
		<?= $arrMainMenuLine['STR_MENU_NAME']?>
	</div>
<?php 
	foreach ($arrErpSubMenu as $arrSubMenuLine):
?>
		<div class='table-responsive-column'>
			<?= $arrSubMenuLine['STR_MENU_NAME']?>
		</div>
<?php 
	endforeach;
endforeach;
?>