<?php 
// No direct access
defined('_JEXEC') or die('Restricted access');

?>

    <h3><?php echo $this->item->title; ?></h3>
    <div class="row-fluid">
    	<div class="span3">
    		<h4><?php echo JText::_('COM_DDC_DUE_DATE'); ?></h4>
    		<p><?php echo JHtml::date($this->item->due_date,'d M Y'); ?></p>
    	</div>
    	<div class="span3">
    		<h4><?php echo JText::_('COM_DDC_TIME_ESTIMATE'); ?></h4>
    		<p><?php echo number_format($this->item->time_estimate/60,2)." ".JText::_('COM_DDC_HRS'); ?></p>
    	</div>
    	<div class="span3">
    		<h4><?php echo JText::_('COM_DDC_WORKED_TIME'); ?></h4>
    		<p><?php echo number_format($this->item->worked,2)." ".JText::_('COM_DDC_HRS'); ?></p>
    	</div>
    	<div class="span3">
    		<h4><?php echo JText::_('COM_DDC_USER_RESPONSIBLE'); ?></h4>
    		<p><?php echo $this->item->responsible; ?></p>
    	</div>
    </div>
  <table class="table">
                <thead>
                	<tr>
        				<th><?php echo JText::_('COM_DDC_ID'); ?></th>
						<th><?php echo JText::_('COM_DDC_ACTIONED_BY'); ?></th>
						<th><?php echo JText::_('COM_DDC_ACTIONED_DATE'); ?></th>
						<th><?php echo JText::_('COM_DDC_TIME_START'); ?></th>
						<th><?php echo JText::_('COM_DDC_TIME_END'); ?></th>
						<th><?php echo JText::_('COM_DDC_DELETE'); ?></th>
					</tr>
                </thead>
                <tfoot>

                </tfoot>
                <tbody>
                <?php foreach($this->items as $i => $item): ?>
                <tr>
					<td style="text-align: center;">
				    	<?php echo $item->ddc_task_detail_id; ?>
				    </td>
				    <td style="text-align: left;">
				    	<?php echo $item->actioned_by; ?>
				    </td>
				    <td style="text-align: center;">
				    	<?php echo JHtml::date($item->action_date,'d M Y'); ?>
				    </td>
				    <td style="text-align: center;">
				    	<?php echo $item->timestart; ?>
				    </td>
				    <td style="text-align: center;">
				    	<?php echo $item->timeend; ?>
				    </td>
				    <td><div class="btn btn-danger btn-small" onclick="deltaskdetail(<?php echo $item->ddc_task_detail_id; ?>)"><i class="icon-remove"></i></div></td>
				</tr>
				<?php endforeach; ?>
                </tbody>
        </table>
	<div class="row-fluid clearfix">
		<form action="<?php echo JRoute::_('index.php?option=com_devcloudmanager&controller=edit'); ?>"
      method="post" name="adminForm" id="adminForm">
        <fieldset class="adminform">
             <legend><?php echo JText::_( 'COM_DDC_ADD_TASK_DETAIL' ); ?></legend>
                <div class="adminformlist">
					<div class="span12">
						<?php foreach($this->form->getFieldset('top') as $field): ?>
							<div class="span3">
							<?php if ($field->hidden):// If the field is hidden, just display the input.?>
								<?php echo $field->input;?>
							<?php else:?>
								<div class="control-group">
									<div class="control-label">
										<?php echo $field->label; ?>
										<?php if (!$field->required && $field->type != 'Spacer') : ?>
											<span class="optional"><?php //echo JText::_('COM_USERS_OPTIONAL');?></span>
										<?php endif; ?>
									</div>
									<div class="controls">
										<?php echo $field->input;?>
									</div>
								</div>
								<?php endif;?>
							</div>
							<?php endforeach; ?>
							<?php foreach($this->form->getFieldset('middle') as $field): ?>
							<?php if ($field->hidden):// If the field is hidden, just display the input.?>
								<?php echo $field->input;?>
							<?php else:?>
								<div class="control-group">
									<div class="control-label">
										<?php echo $field->label; ?>
										<?php if (!$field->required && $field->type != 'Spacer') : ?>
											<span class="optional"><?php //echo JText::_('COM_USERS_OPTIONAL');?></span>
										<?php endif; ?>
									</div>
									<div class="controls">
										<?php echo $field->input;?>
									</div>
								</div>
								<?php endif;?>
							<?php endforeach; ?>
							<?php foreach($this->form->getFieldset('bottom') as $field): ?>
							<?php if ($field->hidden):// If the field is hidden, just display the input.?>
								<?php echo $field->input;?>
							<?php else:?>
								<div class="span5">
								<div class="control-group">
									<div class="control-label">
										<?php echo $field->label; ?>
										<?php if (!$field->required && $field->type != 'Spacer') : ?>
											<span class="optional"><?php //echo JText::_('COM_USERS_OPTIONAL');?></span>
										<?php endif; ?>
									</div>
									<div class="controls">
										<?php echo $field->input;?>
									</div>
								</div>
								</div>
								<?php endif;?>
							<?php endforeach; ?>
						</div>
					</div>
        	</fieldset>
        <div>
                <input type="hidden" name="jform[ddctask_id]" id="jform_ddctask_id" value="<?php echo $this->item->ddc_task_id?>" />
                <input type="hidden" name="task" value="ddctaskdetail.save" />
                <?php echo JHtml::_('form.token'); ?>
        </div>
	</form>
	</div>


