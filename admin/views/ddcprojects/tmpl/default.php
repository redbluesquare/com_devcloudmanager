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
		<form action="<?php echo JRoute::_('index.php?option=com_devcloudmanager&controller=edit'); ?>" method="post" name="adminForm" id="adminForm">
		<table class="adminlist table table-striped">
                <thead>
                	<tr>
                		<th width="5%"><?php echo JText::_('COM_DDC_STATUS'); ?></th>
        				<th width="5%"><?php echo JText::_('COM_DDC_ID'); ?></th>
						<th style="text-align:left;"><?php echo JText::_('COM_DDC_PROJECT_TITLE'); ?></th>
						<th style="text-align:left;"><?php echo JText::_('COM_DDC_CLIENT'); ?></th>
						<th style="text-align:left;"><?php echo JText::_('COM_DDC_ACTUAL_START_DATE'); ?></th>
						<th style="text-align:left;"><?php echo JText::_('COM_DDC_ACTUAL_END_DATE'); ?></th>
						<th style="text-align:left;"><?php echo JText::_('COM_DDC_TASKS'); ?></th>
					</tr>
                </thead>
                <tfoot>

                </tfoot>
                <tbody>
                <?php foreach($this->items as $i => $item): ?>
        			<tr class="row<?php echo $i % 2; ?>">
                		<td>
        					<?php echo JHtml::_('jgrid.published', $item->state, 'ddc_projects'); ?>
        				</td>
                		<td>
                	        <?php echo $item->ddc_project_id; ?>
                		</td>
                		<td>
                	        <a href="<?php echo JRoute::_('index.php?option=com_devcloudmanager&view=ddcprojects&layout=edit&project_id='.$item->ddc_project_id); ?>"><?php echo $item->title; ?></a>
                		</td>
                		<td>
                	        <?php echo $item->business_name; ?>
                		</td>
                		<td>
                	        <?php if($item->pl_enddate!='0000-00-00 00:00:00'){echo JHtml::date($item->pl_enddate,"d M Y");} ?>
                		</td>
                		<td>
                	        <?php if($item->act_enddate!='0000-00-00 00:00:00'){echo JHtml::date($item->act_enddate,"d M Y");} ?>
                		</td>
                		<td>
                	        <?php echo $item->tasks; ?>
                		</td>
        			</tr>
				<?php endforeach; ?>
                </tbody>
        </table>
        <div>
                <input type="hidden" name="jform[table]" value="ddcproject" />
                <input type="hidden" name="task" value="" />
                <input type="hidden" name="boxchecked" value="0" />
                <?php echo JHtml::_('form.token'); ?>
        </div>
        </form>
	</div>
