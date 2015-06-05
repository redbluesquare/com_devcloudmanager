<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted Access');
// load tooltip behavior
JHtml::_('behavior.tooltip');
?>
<form action="<?php echo JRoute::_('index.php?option=com_devcloudmanager&controller=update'); ?>" method="post" name="adminForm" id="adminForm">
        <table class="adminlist">
                <thead>
                	<tr>
                		<th width="5%"><?php echo JText::_('COM_DDC_STATUS'); ?></th>
        				<th width="5%"><?php echo JText::_('COM_DDC_ID'); ?></th>
						<th width="55%" style="text-align:left;"><?php echo JText::_('COM_DDC_BUSINESS_NAME'); ?></th>
						<th width="35%" style="text-align:left;"><?php echo JText::_('COM_DDC_NO_OF_PROJECTS'); ?></th>
					</tr>
                </thead>
                <tfoot>

                </tfoot>
                <tbody>
                <?php foreach($this->items as $i => $item): ?>
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
                	        <?php //echo $item->num_apartments; ?>
                		</td>
        			</tr>
				<?php endforeach; ?>
                </tbody>
        </table>
        <div>
                <input type="hidden" name="jform[table]" value="ddcclients" />
                <input type="hidden" name="task" value="" />
                <input type="hidden" name="boxchecked" value="0" />
                <?php echo JHtml::_('form.token'); ?>
        </div>
</form>