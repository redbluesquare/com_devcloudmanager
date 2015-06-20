<?php
// No direct access
defined('_JEXEC') or die('Restricted access');

?>
<tr>
	<td style="text-align: center;">
    	<?php echo $this->tditem->ddc_task_detail_id; ?>
    </td>
    <td style="text-align: left;">
    	<?php echo $this->tditem->actioned_by; ?>
    </td>
    <td style="text-align: center;">
    	<?php echo JHtml::date($this->tditem->action_date,'d M Y'); ?>
    </td>
    <td style="text-align: center;">
    	<?php echo $this->tditem->timestart; ?>
    </td>
    <td style="text-align: center;">
    	<?php echo $this->tditem->timeend; ?>
    </td>
</tr>