<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted Access');
// load tooltip behavior
JHtml::_('behavior.tooltip');
?>
<div class="row-fluid">
	<div class="span3 well" style="text-align:center;height:140px"><a href="<?php echo JRoute::_('index.php?option=com_devcloudmanager&view=ddcclients'); ?>" ><?php echo JText::_('COM_DEVCLOUDMANAGER_CLIENTS')?></a></div>
	<div class="span3 well" style="text-align:center;height:140px"><a href="<?php echo JRoute::_('index.php?option=com_devcloudmanager&view=ddcprojects'); ?>"><?php echo JText::_('COM_DEVCLOUDMANAGER_PROJECTS')?></a></div>
	<div class="span3 well" style="text-align:center;height:140px"><a href="<?php echo JRoute::_('index.php?option=com_devcloudmanager&view=ddcinvoices'); ?>" ><?php echo JText::_('COM_DEVCLOUDMANAGER_INVOICES')?></a></div>
	<div class="span3 well" style="text-align:center;height:140px"><a href="<?php echo JRoute::_('index.php?option=com_devcloudmanager&view=ddcitems'); ?>"><?php echo JText::_('COM_DEVCLOUDMANAGER_ITEMS')?></a></div>
</div>