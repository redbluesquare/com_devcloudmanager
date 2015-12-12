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
        				<th width="5%"><?php echo JText::_('COM_DDC_ID'); ?></th>
						<th width="10%" style="text-align:left;"><?php echo JText::_('COM_DDC_ITEM'); ?></th>
						<th width="20%" style="text-align:left;"><?php echo JText::_('COM_DDC_TITLE'); ?></th>
						<th width="10%" style="text-align:left;"><?php echo JText::_('COM_DDC_COST_LABEL'); ?></th>
						<th width="10%" style="text-align:left;"><?php echo JText::_('COM_DDC_EXPIRY_DATE'); ?></th>
						<th width="5%"><?php echo JText::_('COM_DDC_STATUS'); ?></th>
					</tr>
                </thead>
                <tfoot>

                </tfoot>
                <tbody>
                <?php foreach($this->items as $i => $item): ?>
        		<?php 
        		$status = null;
        		for($i=-2; $i < 4; $i++)
        		{
        			if(($i==-2) And ($item->state==-2))
        			{
        				$status = JText::_('COM_DDC_TRASHED');
        			}
        			if(($i==0) And ($item->state==0))
        			{
        				$status = JText::_('COM_DDC_NOT_ACTIVE');
        			}
        			if(($i==1) And ($item->state==1))
        			{
        				$status = JText::_('COM_DDC_ACTIVE');
        			}
        			if(($i==2) And ($item->state==2))
        			{
        				$status = JText::_('COM_DDC_ARCHIVED');
        			}
        		}
        		?>
        			<tr class="row<?php echo $i % 2; ?>">
                		<td style="text-align: center;">
                	        <?php echo $item->ddc_item_id; ?>
                		</td>
                		<td style="text-align: center;">
                	        <?php echo $item->item_code; ?>
                		</td>
                		<td>
                	        <a href="<?php echo JRoute::_('index.php?option=com_devcloudmanager&view=ddcitems&layout=edit&ddcitem_id='.$item->ddc_item_id); ?>"><?php echo $item->title; ?></a>
                		</td>
                		<td style="text-align: center;">
                	        <?php echo number_format($item->cost,2); ?>
                		</td>
                		<td style="text-align: center;">
                	        <?php echo JHtml::date($item->expiry_date,'d M Y'); ?>
                		</td>
                		<td>
        					<?php echo $status; ?>
        				</td>
        			</tr>
 	
				<?php endforeach; ?>
                </tbody>
        </table>
        <div>
                <input type="hidden" name="jform[table]" value="ddcitem" />
                <input type="hidden" name="task" value="" />
                <input type="hidden" name="boxchecked" value="0" />
                <?php echo JHtml::_('form.token'); ?>
        </div>
	</div>
</form>