<?php
defined( '_JEXEC' ) or die( 'Restricted access' );
$app = JFactory::getApplication();
$params = JComponentHelper::getParams('com_devcloudmanager');
$session = JFactory::getSession();
$lines = 10;
$position = array();
$descriptions = array();
$quantities = array();
$costs = array();
$total = array();
$paymentDetails = array();
$paymentDetails['token'] = $this->item->token;
$paymentDetails['id'] = $this->item->ddc_invoice_header_id;
$session->set('invoice_id',$this->item->ddc_invoice_header_id);
$paymentDetails['shipping'] = 0.00;
if($this->item->payment_state != 1):
for($i=0;$i<count($this->invd);$i++)
{
	array_push($position,(int)$this->invd[$i]->pos);
	if($this->invd[$i]->service_id!=0){
		array_push($descriptions,(string)$this->invd[$i]->service_title);
		$paymentDetails['details'][$i]['description'] = (string)$this->invd[$i]->service_title;
	}elseif($this->invd[$i]->item_id!=0){
		array_push($descriptions,(string)$this->invd[$i]->item_title);
		$paymentDetails['details'][$i]['description'] = (string)$this->invd[$i]->item_title;
	}
	elseif($this->invd[$i]->task_id!=0){
		array_push($descriptions,(string)$this->invd[$i]->task_title);
		$paymentDetails['details'][$i]['description'] = (string)$this->invd[$i]->task_title;
	}
	array_push($quantities,(double)$this->invd[$i]->quantity);
	$paymentDetails['details'][$i]['quantity'] = (string)$this->invd[$i]->quantity;
	array_push($costs,(double)$this->invd[$i]->cost);
	$paymentDetails['details'][$i]['cost'] = (string)$this->invd[$i]->cost;
	array_push($total,(double)$this->invd[$i]->total);
}
for($i=0;$i<($lines-count($this->invd));$i++)
{
	array_push($position,null);
	array_push($descriptions,"");
	array_push($quantities,"");
	array_push($costs,0);
	array_push($total,0);
}
$paypal = new DevcloudmanagerModelsDdcinvoices();
$paypal->ddcpaypal($paymentDetails);
else:
	echo "Thank you, according to our records, your payment is complete.";
endif;
?>
