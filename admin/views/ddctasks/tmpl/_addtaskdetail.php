<?php 
// No direct access
defined('_JEXEC') or die('Restricted access');

?>
<div id="addTaskdetailModal" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="addTaskdetailModalLabel" aria-hidden="true">
  <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
    <h3 id="myModalLabel"><?php echo $this->item->title; ?></h3>
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
  </div>
  <div class="modal-body">
  <div class="span12">
  <table class="table">
                <thead>
                	<tr>
        				<th><?php echo JText::_('COM_DDC_ID'); ?></th>
						<th><?php echo JText::_('COM_DDC_ACTIONED_BY'); ?></th>
						<th><?php echo JText::_('COM_DDC_ACTIONED_DATE'); ?></th>
						<th><?php echo JText::_('COM_DDC_TIME_START'); ?></th>
						<th><?php echo JText::_('COM_DDC_TIME_END'); ?></th>
					</tr>
                </thead>
                <tfoot>

                </tfoot>
                <tbody class="ddctaskdetailsInfo">
                <?php 
                for($i=0, $n = count($this->task_detail_items);$i<$n;$i++) { 
		        	$this->_taskdetailListView->tditem = $this->task_detail_items[$i];
		        	$this->_taskdetailListView->type = 'tditem';
		        	echo $this->_taskdetailListView->render();
				}
				?>
                </tbody>
        </table>
       </div>
	<div class="row-fluid">
		<form id="addTaskdetailForm">
	      <div id="book-modal-info" class="media"></div>
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
                <input type="hidden" name="task" name="task" value="ddctaskdetail.save" />
                <?php echo JHtml::_('form.token'); ?>
        </div>
	</form>
	</div>
  </div>
  <div class="modal-footer">
    <button class="btn" data-dismiss="modal" aria-hidden="true"><?php echo JText::_('COM_DDC_CLOSE'); ?></button>
    <button class="btn btn-success" onclick="addDdctaskdetail();"><?php echo JText::_('COM_DDC_SAVE'); ?></button>
  </div>
</div>
