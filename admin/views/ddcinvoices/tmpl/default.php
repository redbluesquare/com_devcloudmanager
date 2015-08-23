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
                		<th width="5%"><?php echo JText::_('COM_DDC_STATUS'); ?></th>
        				<th width="5%"><?php echo JText::_('COM_DDC_ID'); ?></th>
						<th width="15%" style="text-align:left;"><?php echo JText::_('COM_DDC_REFERENCE'); ?></th>
						<th width="15%" style="text-align:left;"><?php echo JText::_('COM_DDC_CUSTOMER_PURCHASE_ORDER'); ?></th>
						<th width="20%" style="text-align:left;"><?php echo JText::_('COM_DDC_CLIENT'); ?></th>
						<th width="10%" style="text-align:left;"><?php echo JText::_('COM_DDC_COST_LABEL'); ?></th>
						<th width="15%" style="text-align:left;"><?php echo JText::_('COM_DDC_POSTED_DATE'); ?></th>
						<th width="15%" style="text-align:left;"><?php echo JText::_('COM_DDC_CLOSED_DATE'); ?></th>
					</tr>
                </thead>
                <tfoot>

                </tfoot>
                <tbody>
                <?php foreach($this->items as $i => $item): ?>
        			<tr class="row<?php echo $i % 2; ?>">
                		<td>
        					<?php echo JHtml::_('jgrid.published', $item->state, 'ddc_invoice_headers'); ?>
        				</td>
                		<td>
                	        <?php echo $item->ddc_invoice_header_id; ?>
                		</td>
                		<td>
                	        <a href="<?php echo JRoute::_('index.php?option=com_devcloudmanager&view=ddcinvoices&layout=edit&ddcinvh_id='.$item->ddc_invoice_header_id); ?>"><?php echo $item->reference; ?></a>
                		</td>
                		<td style="text-align: center;">
                	        <?php echo $item->purchase_order; ?>
                		</td>
                		<td style="text-align: left;">
                	        <?php echo $item->business_name; ?>
                		</td>
                		<td style="text-align: center;">
                	        <?php echo number_format($item->total,2); ?>
                		</td>
                		<td style="text-align: center;">
                	        <?php echo JHtml::date($item->posteddate,'d-M-Y'); ?>
                		</td>
                		<td style="text-align: center;">
                			<?php if($item->closeddate>1):?>
                	        <?php echo JHtml::date($item->closeddate,'d-M-Y'); ?>
                	        <?php endif; ?>
                		</td>
        			</tr>
				<?php endforeach; ?>
                </tbody>
        </table>
        <div>
                <input type="hidden" name="jform[table]" value="ddcinvoice" />
                <input type="hidden" name="task" value="" />
                <input type="hidden" name="boxchecked" value="0" />
                <?php echo JHtml::_('form.token'); ?>
        </div>
	</div>
</form>