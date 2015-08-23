<?php
// No direct access
defined('_JEXEC') or die('Restricted access');
JHtml::_('behavior.tooltip');
$app = JFactory::getApplication();
$ddcservices = new DevcloudmanagerModelsDdcservices();
$ddcservices = $ddcservices->listItems();
$ddcitems = new DevcloudmanagerModelsDdcitems();
$ddcitems = $ddcitems->listItems();
$ddctasks = new DevcloudmanagerModelsDdctasks();
$ddctasks = $ddctasks->listItems();
$pos = null;
?>
<div class="span12">
	<form action="<?php echo JRoute::_('index.php?option=com_devcloudmanager&controller=edit'); ?>"
      method="post" name="adminForm" id="adminForm">
        <fieldset class="adminform">
             <legend><?php echo JText::_( 'COM_DDC_INVOICE_DETAILS' ); ?></legend>
                <div class="adminformlist">
					<div class="span9">
						<?php foreach($this->form->getFieldset('left_top') as $field): ?>
							<?php if ($field->hidden):// If the field is hidden, just display the input.?>
								<?php echo $field->input;?>
							<?php else:?>
								<div class="span4">
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
							<table class="table" id="invdTable">
								<thead>
									<tr>
									<th width="5%"><?php echo JText::_('COM_DDC_POS');?></th>
									<th width="15%"><?php echo JText::_('COM_DDC_ID');?></th>
									<th width="35%"><?php echo JText::_('COM_DDC_ITEM')?></th>
									<th width="10%"><?php echo JText::_('COM_DDC_QUANTITY')?></th>
									<th width="10%"><?php echo JText::_('COM_DDC_COST_LABEL')?></th>
									<th width="15%"><?php echo JText::_('COM_DDC_DISCOUNT_LABEL')?></th>
									<th width="10%"><?php echo JText::_('COM_DDC_TOTAL_LABEL')?></th>
									<th width="5%"></th>
									</tr>
								</thead>
								<tbody>
									<?php foreach ($this->itemdetails as $itemd):?>
									<?php if($itemd->service_id!=0){
										$listitem = $itemd->service_title;
										$pos = $itemd->pos;
									}elseif($itemd->item_id!=0){
										$listitem = $itemd->item_title;
										$pos = $itemd->pos;
									}
									elseif($itemd->task_id!=0){
										$listitem = $itemd->task_title;
										$pos = $itemd->pos;
									}else 
									{
										$listitem = null;
									}
									if(!$itemd->pos):
									$pos = $itemd->pos;
									endif;
									?>
										<tr>
										<td><?php echo $itemd->pos; ?></td>
										<td><?php echo $itemd->ddc_invoice_detail_id; ?></td>
										<td><?php echo $listitem; ?></td>
										<td><?php echo $itemd->quantity; ?></td>
										<td><?php echo $itemd->cost; ?></td>
										<td><?php echo ($itemd->discount*100)." %"; ?></td>
										<td><?php echo $itemd->total; ?></td>
										<td><div class="btn btn-danger btn-small" onclick="delinvd(<?php echo $itemd->ddc_invoice_detail_id; ?>)"><i class="icon-remove"></i></div></td>
										</tr>
									<?php endforeach; ?>
									<?php for($i=0;$i<5;$i++):?>	
										<tr id="row">
										<td><input name="jform[pos][<?php echo $i?>]" id="pos<?php echo $i?>" value="<?php echo $pos+1;?>" readonly class="span12" /></td>
										<td><select name="jform[selbox][<?php echo $i?>]" id="selbox<?php echo $i?>" class="selbox span12">
											<option value="service_id"><?php echo JText::_('COM_DDC_SERVICE'); ?></option>
											<option value="item_id"><?php echo JText::_('COM_DDC_ITEM'); ?></option>
											<option value="task_id"><?php echo JText::_('COM_DDC_TASK'); ?></option>
										</select>
										</td>
										<td><select name="jform[service_id][<?php echo $i?>]" id="service_id<?php echo $i?>" class="service_id span12" onchange="getcost()">
										<option value="0" selected="selected"><?php echo JText::_('COM_DDC_SELECT_SERVICE'); ?></option>
										<?php foreach($ddcservices as $service):?>
											<option value="<?php echo $service->ddc_service_id; ?>"><?php echo $service->title." - ".$service->item_title;?></option>
										<?php endforeach;?>
										</select>
										<select name="jform[item_id][<?php echo $i?>]" id="item_id<?php echo $i?>" class="item_id hidden">
											<option value="0" selected="selected"><?php echo JText::_('COM_DDC_SELECT_ITEM'); ?></option>
											<?php foreach($ddcitems as $ddcitem):?>
												<option value="<?php echo $ddcitem->ddc_item_id; ?>"><?php echo $ddcitem->title;?></option>
											<?php endforeach;?>
										</select>
										<select name="jform[task_id][<?php echo $i?>]" id="task_id<?php echo $i?>" class="task_id hidden">
											<option value="0" selected="selected"><?php echo JText::_('COM_DDC_SELECT_TASK'); ?></option>
											<?php foreach($ddctasks as $ddctask):?>
												<option value="<?php echo $ddctask->ddc_task_id; ?>"><?php echo $ddctask->title." - ".$ddctask->project_title;?></option>
											<?php endforeach;?>
										</select>
										</td>
										
										<td><input name="jform[quantity][<?php echo $i?>]" id="quantity<?php echo $i?>" value="1" class="span12" /></td>
										<td><input name="jform[cost][<?php echo $i?>]" id="cost<?php echo $i?>" value="" class="span12" /></td>
										<td><input type="number" min="0" max="100" name="jform[discount][<?php echo $i?>]" id="discount<?php echo $i?>" value="0" class="span12" /></td>
										<td></td>
										<td></td>
										</tr>
										<?php $pos = $pos+1;?>
										<?php endfor; ?>
								</tbody>
								
								
							</table>
						</div>
						<div class="span3">
							<?php foreach($this->form->getFieldset('right_top') as $field): ?>
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
						</div>
					</div>
        	</fieldset>
        <div>
                <input type="hidden" name="task" value="ddcinvoice.edit" />
                <?php echo JHtml::_('form.token'); ?>
        </div>
	</form>
	<form>
		
	</form>
</div>
