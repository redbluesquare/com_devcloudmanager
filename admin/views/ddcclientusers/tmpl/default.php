<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted Access');
// load tooltip behavior
JHtml::_('behavior.tooltip');
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
                		<th width="10%"><?php echo JText::_('COM_DDC_STATUS'); ?></th>
        				<th width="10%"><?php echo JText::_('COM_DDC_ID'); ?></th>
						<th width="30%" style="text-align:left;"><?php echo JText::_('COM_DDC_CONTACT_NAME'); ?></th>
						<th width="30%" style="text-align:left;"><?php echo JText::_('COM_DDC_BUSINESS_NAME'); ?></th>
					</tr>
                </thead>
                <tfoot>

                </tfoot>
                <tbody>
                <?php foreach($this->items as $i => $item): ?>
        			<tr class="row<?php echo $i % 2; ?>">
                		<td>
        					<?php echo JHtml::_('jgrid.published', $item->state, 'ddc_client_users'); ?>
        				</td>
                		<td>
                	        <?php echo $item->ddc_client_user_id; ?>
                		</td>
                		<td>
                	        <a href="<?php echo JRoute::_('index.php?option=com_devcloudmanager&view=ddcclientusers&layout=edit&clientuser_id='.$item->ddc_client_user_id); ?>"><?php echo $item->name; ?></a>
                		</td>
                		<td style="">
                	        <?php echo $item->business_name; ?>
                		</td>
        			</tr>
				<?php endforeach; ?>
                </tbody>
        </table>
        <div>
                <input type="hidden" name="jform[table]" value="ddcclientuser" />
                <input type="hidden" name="task" value="" />
                <input type="hidden" name="boxchecked" value="0" />
                <?php echo JHtml::_('form.token'); ?>
        </div>
	</div>
</form>