<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted Access');
// load tooltip behavior
JHtml::_('behavior.tooltip');
$params = JComponentHelper::getParams('com_devcloudmanager');
$workkey = $params->get('item_id');
$invhrs = new DevcloudmanagerModelsDdcinvoices();
$tskhrs = new DevcloudmanagerModelsDdcprojects();
?>
<form action="<?php echo JRoute::_('index.php?option=com_devcloudmanager&controller=edit'); ?>" method="post" name="adminForm" id="adminForm">
<?php if (!empty( $this->sidebar)) : ?>
	<div id="j-sidebar-container" class="span2">
		<?php echo $this->sidebar; ?>
	</div>
	<div id="j-main-container" class="span10">
<?php else : ?>
	<div id="j-main-container">
<?php endif;?>
        <table class="adminlist table table-striped">
                <thead>
                	<tr>
                		<th width="5%"><?php echo JText::_('COM_DDC_STATUS'); ?></th>
        				<th width="5%"><?php echo JText::_('COM_DDC_ID'); ?></th>
						<th style="text-align:left;"><?php echo JText::_('COM_DDC_BUSINESS_NAME'); ?></th>
						<th style="text-align:left;"><?php echo JText::_('COM_DDC_NO_OF_PROJECTS'); ?></th>
						<th style="text-align:left;"><?php echo JText::_('COM_DDC_TIME_BOUGHT'); ?></th>
						<th style="text-align:left;"><?php echo JText::_('COM_DDC_TIME_SPENT'); ?></th>
						<th style="text-align:left;"><?php echo JText::_('COM_DDC_BALANCE'); ?></th>
					</tr>
                </thead>
                <tfoot>

                </tfoot>
                <tbody>
                <?php foreach($this->items as $i => $item): ?>
                <?php $timebought = $invhrs->getHours($item->ddc_client_id);?>
                <?php $timespent = $tskhrs->getTaskHours($item->ddc_client_id);?>
        			<tr class="row<?php echo $i % 2; ?>">
                		<td>
        					<?php echo JHtml::_('jgrid.published', $item->state, 'ddc_clients'); ?>
        				</td>
                		<td>
                	        <?php echo $item->ddc_client_id; ?>
                		</td>
                		<td>
                	        <a href="<?php echo JRoute::_('index.php?option=com_devcloudmanager&view=ddcclients&layout=edit&client_id='.$item->ddc_client_id); ?>"><?php echo $item->business_name; ?></a>
                		</td>
                		<td style="text-align: center;">
                	        <?php echo $item->no_of_projects; ?>
                		</td>
                		<td style="text-align: center;">
                	        <?php echo number_format($timebought->hours,2); ?>
                		</td>
                		<td style="text-align: center;">
                	        <?php echo number_format($timespent->hours,2); ?>
                		</td>
                		<td style="text-align: center;">
                	        <?php echo number_format($timebought->hours-$timespent->hours,2); ?>
                		</td>
        			</tr>
				<?php endforeach; ?>
                </tbody>
        </table>
        <div>
                <input type="hidden" name="jform[table]" value="ddcclient" />
                <input type="hidden" name="task" value="" />
                <input type="hidden" name="boxchecked" value="0" />
                <?php echo JHtml::_('form.token'); ?>
        </div>
     </div>
</form>