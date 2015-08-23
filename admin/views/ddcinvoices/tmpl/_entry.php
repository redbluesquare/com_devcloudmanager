<?php
// No direct access
defined('_JEXEC') or die('Restricted access');
$ddcservices = new DevcloudmanagerModelsDdcservices();
$ddcservices = $ddcservices->listItems();
$ddcitems = new DevcloudmanagerModelsDdcitems();
$ddcitems = $ddcitems->listItems();
$ddctasks = new DevcloudmanagerModelsDdctasks();
$ddctasks = $ddctasks->listItems();
?>
<tr>
										<td><select name="jform[linetype][0]" id="selbox" class="span12">
											<option value="service_id"><?php echo JText::_('COM_DDC_SERVICE'); ?></option>
											<option value="item_id"><?php echo JText::_('COM_DDC_ITEM'); ?></option>
											<option value="task_id"><?php echo JText::_('COM_DDC_TASK'); ?></option>
										</select>
										</td>
										<td><select name="jform[service_id][0]" id="service_id" class="span12" onchange="getcost()">
										<option value="0" selected="selected"><?php echo JText::_('COM_DDC_SELECT_SERVICE'); ?></option>
										<?php foreach($ddcservices as $service):?>
											<option value="<?php echo $service->ddc_service_id; ?>"><?php echo $service->title." - ".$service->item_title;?></option>
										<?php endforeach;?>
										</select>
										<select name="jform[item_id][0]" id="item_id" class="span12 hidden">
											<option value="0" selected="selected"><?php echo JText::_('COM_DDC_SELECT_ITEM'); ?></option>
											<?php foreach($ddcitems as $ddcitem):?>
												<option value="<?php echo $ddcitem->ddc_item_id; ?>"><?php echo $ddcitem->title;?></option>
											<?php endforeach;?>
										</select>
										<select name="jform[task_id][0]" id="task_id" class="span12 hidden">
											<option value="0" selected="selected"><?php echo JText::_('COM_DDC_SELECT_TASK'); ?></option>
											<?php foreach($ddctasks as $ddctask):?>
												<option value="<?php echo $ddctask->ddc_task_id; ?>"><?php echo $ddctask->title." - ".$ddctask->project_title;?></option>
											<?php endforeach;?>
										</select>
										</td>
										
										<td><input name="jform[quantity][0]" id="" value="1" class="span12" /></td>
										<td><input name="jform[cost][0]" id="" value="" class="span12" /></td>
										<td><input type="number" min="0" max="100" name="jform[discount][0]" id="" value="0" class="span12" /></td>
										<td></td>
										<td><div class="btn" onclick="editinvd()"><i class="icon-plus"></i></div></td>
										</tr>