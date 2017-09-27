<?php
use yii\bootstrap\Html;
$this->title = 'Perfis';
$this->params['breadcrumbs'][] = $this->title;
$this->registerJs("
	//click button plus or minus	
		$(document).on('click','.symbol-expand',function()
		{
			var idPerfil = $(this).attr('id-perfil');
			var strSymbol = $(this).attr('symbol') ;
			$('.table-responsive').hide();
			$('.symbol-expand').attr('symbol','+');
			$('.symbol-expand').html('+');
			if(strSymbol == '+')
			{
				$('#table-responsive-container-menu-'+idPerfil).show();
				strSymbol = '-';	
			}
			else
				strSymbol = '+';
			$(this).attr('symbol',strSymbol);
			$(this).html(strSymbol);
		});	
	//checkbox role: enable, disable	
		$(document).on('change','.role-status', function()
		{
			var intIdRole = $(this).attr('name');
			if($(this).is(':checked'))
			{
				$.post(
					'../ajax-role-administration/set-verify-role-to-disable', 
					{
						intIdRole: intIdRole, intStatus: 1
					},
					function(data)
					{
						$('#text-status-role-'+intIdRole).html('Ativo');
					}
				);	
			}
			else
			{
				$.post(
					'../ajax-role-administration/get-verify-role-to-disable', 
					{
						intIdRole: intIdRole, intStatus: 0
					},
					function(data)
					{
						if(data > 0)
							$('#text-status-role-'+intIdRole).html('Inativo');
						else
						{
							$('#checkbox-role-'+intIdRole).prop('checked', true);
							alert('Esse ação não pode ser realizada, exitem colaboradores ativos que pertecem à esse perfil.');
						}
					}
				);	
			}
		});
	////click Main menu
		$(document).on('click','.id-role-mainmenu',function(){
			var intIdRole = $(this).attr('id');
			var intIdSubMenu = $(this).val();
			if($(this).is(':checked'))
				booAddDelete = 1;
			else
				booAddDelete = 0;
			$.post(
				'../ajax-role-administration/set-menu-role-main-menu', 
				{
					intIdRole: intIdRole, intIdSubMenu: intIdSubMenu, booAddDelete: booAddDelete
				},
				function(data)
				{
					if(data > 0)
						$(this).prop('checked', false);
					else
						$(this).prop('checked', true);
				}
			);
		});
	//click submenu
		$(document).on('click','.input-submenu',function(){
			var intIdRole = $(this).attr('id-role-submenu');
			var intIdMainMenu = $(this).val();
			var intIdSubMenu = $(this).attr('name');
			if($(this).is(':checked'))
				booAddDelete = 1;
			else
				booAddDelete = 0;
			$.post(
				'../ajax-role-administration/set-menu-role-submenu', 
				{
					intIdRole: intIdRole, intIdMainMenu: intIdMainMenu, intIdSubMenu: intIdSubMenu, booAddDelete: booAddDelete
				},
				function(data)
				{
					if(data > 0)
						$(this).prop('checked', false);
					else
						$(this).prop('checked', true);
				}
			);
		});
");	
?>
<div class='panel panel-primary'>
	<div class='panel-heading'>
		<h3 class='panel-title'>
			<i class='glyphicon glyphicon-globe'>
			</i>
				<?= $this->title?>
		</h3>
		<div class='clearfix'></div>
	</div>
	<div class='kv-panel-before-custon'>
		<div class='pull-right'>
			<div class='btn-toolbar kv-grid-toolbar' role='toolbar'>
				<div class='btn-group'>
					<?= html::a(Html::button('<i class="glyphicon glyphicon-plus"></i> '.'Administrar Perfis', ['type'=>'button', 'title'=>'Administrar Perfil', 'class'=>'btn btn-success']),['/business-management/erp-role-adm']) ?>
				</div>	
				<div class='btn-group'>
					<?= html::a(Html::button('<i class="glyphicon glyphicon-plus"></i> '.'Administrar Menu', ['type'=>'button', 'title'=>'Administrar Menu', 'class'=>'btn btn-success']),['/business-management/erp-menu-adm?intTypeMenu=0']) ?>
				</div>	
				<div class='btn-group'>	
					<?= html::a(Html::button('<i class="glyphicon glyphicon-plus"></i> '.'Administrar Submenu', ['type'=>'button', 'title'=>'Administrar Submenu', 'class'=>'btn btn-success']),['/business-management/erp-menu-adm?intTypeMenu=1']) ?>
				</div>
			</div>
		</div>
		<div class='clearfix'></div>
	</div>
	<div id="w0-container" class="table-responsive kv-grid-container">
		
	</div>	
</div> 
<?php foreach ($arrErpRole as $arrRoleLine):?>
	<div class='panel panel-primary'>
		<div class='panel-heading'  id='<?= $arrRoleLine['INT_PK_ID_ERP_ROLE']?>'>
			<div class="pull-right">
				<div class='expand-button'>
					<div class='symbol-expand' id='symbol-expand-max' id-perfil='<?= $arrRoleLine['INT_PK_ID_ERP_ROLE']?>' symbol='+'>
						+
					</div>
				</div>
			</div>
			<div class='pull-right'>
				<div class='summary' >
					<?= html::input('checkbox', $arrRoleLine['INT_PK_ID_ERP_ROLE'], $arrRoleLine['BOO_STATUS'], ['id'=>'checkbox-role-'.$arrRoleLine['INT_PK_ID_ERP_ROLE'], 'checked'=> ($arrRoleLine['BOO_STATUS'] ? true : false), 'class' => 'role-status'])?>
					<span id='text-status-role-<?= $arrRoleLine['INT_PK_ID_ERP_ROLE'] ?>'>
						<?= ($arrRoleLine['BOO_STATUS'] ? 'Ativo' : 'Inativo') ?>
					</span>
				</div>
			</div>
			<h3 class='panel-title'>
				<i class='glyphicon glyphicon-globe'>
				</i>
					<?= $arrRoleLine['STR_ROLE_NAME']?>
			</h3>
		</div>
		
		<div class='kv-panel-before-custon'>
			<div class='clearfix'></div>
		</div>
		<div id="table-responsive-container-menu-<?= $arrRoleLine['INT_PK_ID_ERP_ROLE']?>" class="table-responsive kv-grid-container">
			<?php foreach ($arrErpMainMenu as $arrMainMenuLine):?>
				<div class='table-responsive-header'>
					
					<?php if($arrSelected[$arrRoleLine['INT_PK_ID_ERP_ROLE']][0][$arrMainMenuLine['INT_PK_ID_ERP_MENU']]):?>
						<?= html::input('checkbox', NULL, $arrMainMenuLine['INT_PK_ID_ERP_MENU'], ['checked'=> true, 'class' => 'id-role-mainmenu','id' => $arrRoleLine['INT_PK_ID_ERP_ROLE']])?>
					<?php else:?>
						<?= html::input('checkbox', NULL, $arrMainMenuLine['INT_PK_ID_ERP_MENU'], ['checked'=> false, 'class' => 'id-role-mainmenu','id' => $arrRoleLine['INT_PK_ID_ERP_ROLE']])?>
					<?php endif;?>
					
					<?= $arrMainMenuLine['STR_MENU_NAME']?>
				</div>
				<?php foreach ($arrErpSubMenu as $arrSubMenuLine):?>
					<div class='table-responsive-column'>
						<?php if($arrSelected[$arrRoleLine['INT_PK_ID_ERP_ROLE']][$arrMainMenuLine['INT_PK_ID_ERP_MENU']][$arrSubMenuLine['INT_PK_ID_ERP_MENU']]):?>
							<?= html::input('checkbox', $arrSubMenuLine['INT_PK_ID_ERP_MENU'], $arrMainMenuLine['INT_PK_ID_ERP_MENU'], ['checked'=> true, 'class' => 'input-submenu','id-role-submenu' => $arrRoleLine['INT_PK_ID_ERP_ROLE']])?>
						<?php else:?>
							<?= html::input('checkbox', $arrSubMenuLine['INT_PK_ID_ERP_MENU'], $arrMainMenuLine['INT_PK_ID_ERP_MENU'], ['checked'=> false, 'class' => 'input-submenu','id-role-submenu' => $arrRoleLine['INT_PK_ID_ERP_ROLE']])?>
							<?php 'role -> '.$arrRoleLine['INT_PK_ID_ERP_ROLE']. ' -> main -> '.$arrMainMenuLine['INT_PK_ID_ERP_MENU'].'->'.$arrSubMenuLine['INT_PK_ID_ERP_MENU']?>
						<?php endif;?>	
						
						<?= $arrSubMenuLine['STR_MENU_NAME']?>
					</div>
				<?php endforeach;?>		
			<?php endforeach;?>
		</div>	
	</div> 
<?php endforeach;?>