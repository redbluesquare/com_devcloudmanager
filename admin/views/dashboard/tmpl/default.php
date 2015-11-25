<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted Access');
// load tooltip behavior
JHtml::_('behavior.tooltip');
?>
<?php if (!empty( $this->sidebar)) : ?>
<div id="j-sidebar-container" class="span2">
		<?php echo $this->sidebar; ?>
</div>
<div id="j-main-container" class="span10">
<?php else : ?>
<div id="j-main-container">
<?php endif;?>
	<div>
		<form id="updateFilter" action="<?php echo JRoute::_('index.php?option=com_devcloudmanager&controller=edit'); ?>" method="post" name="adminForm">
			<select name="jform[ddcproject]" id="jform_ddcproject">
				<option value=""><?php echo JText::_('COM_DDC_SELECT_PROJECT'); ?></option>
				<?php
				for($i=0;$i<count($this->projects);$i++)
				{ ?>
				<option value="<?php echo $this->projects[$i]->ddc_project_id; ?>"><?php echo $this->projects[$i]->title; ?></option>
				<?php } ?>
			</select>
			<button class="btn pull-right"><?php echo JText::_('COM_DDC_UPDATE');?></button>
			<input type="hidden" name="jform[table]" value="dashboard" />
			<input type="hidden" name="jform[ddcfilter]" value="update" />
		</form>

		</div>
	<div class="row-fluid">
		<div class="span3 well" style="text-align:center;height:140px">
			<a href="<?php echo JRoute::_('index.php?option=com_devcloudmanager&view=ddcclients'); ?>" >
				<?php echo JText::_('COM_DEVCLOUDMANAGER_CLIENTS')?><br/>
				<?php echo JText::_('COM_DDC_TOTAL_CLIENTS')." ".count($this->clients); ?></a></div>
		<div class="span3 well" style="text-align:center;height:140px"><a href="<?php echo JRoute::_('index.php?option=com_devcloudmanager&view=ddcprojects'); ?>"><?php echo JText::_('COM_DEVCLOUDMANAGER_PROJECTS')?></a></div>
		<div class="span3 well" style="text-align:center;height:140px"><a href="<?php echo JRoute::_('index.php?option=com_devcloudmanager&view=ddcinvoices'); ?>" ><?php echo JText::_('COM_DEVCLOUDMANAGER_INVOICES')?></a></div>
		<div class="span3 well" style="text-align:center;height:140px"><a href="<?php echo JRoute::_('index.php?option=com_devcloudmanager&view=ddcitems'); ?>"><?php echo JText::_('COM_DEVCLOUDMANAGER_ITEMS')?></a></div>
	</div>
</div>