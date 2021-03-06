<?php  defined('C5_EXECUTE') or die("Access Denied."); ?>

<table class="ccm-permission-grid">
<?php 
$permissions = PermissionKey::getList('block_type');

foreach($permissions as $pk) { 
	?>
	<tr>
	<td class="ccm-permission-grid-name" id="ccm-permission-grid-name-<?php echo $pk->getPermissionKeyID()?>"><strong><a dialog-title="<?php echo $pk->getPermissionKeyName()?>" data-pkID="<?php echo $pk->getPermissionKeyID()?>" data-paID="<?php echo $pk->getPermissionAccessID()?>" onclick="ccm_permissionLaunchDialog(this)" href="javascript:void(0)"><?php echo $pk->getPermissionKeyName()?></a></td>
	<td id="ccm-permission-grid-cell-<?php echo $pk->getPermissionKeyID()?>" class="ccm-permission-grid-cell"><?php echo Loader::element('permission/labels', array('pk' => $pk))?></td>
</tr>
<?php  } ?>
</table>


	<script type="text/javascript">
	ccm_permissionLaunchDialog = function(link) {
		jQuery.fn.dialog.open({
			title: $(link).attr('dialog-title'),
			href: '<?php echo REL_DIR_FILES_TOOLS_REQUIRED?>/permissions/dialogs/block_type?pkID=' + $(link).attr('data-pkID') + '&paID=' + $(link).attr('data-paID'),
			modal: false,
			width: 500,
			height: 380
		});		
	}
	</script>
