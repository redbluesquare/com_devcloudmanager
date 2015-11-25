<?php
defined( '_JEXEC' ) or die( 'Restricted access' );
$app = JFactory::getApplication();
$params = JComponentHelper::getParams('com_devcloudmanager');
$session = JFactory::getSession();
$invhtoken = $this->item->token;
$siteurl = JUri::root();
$lines = 10;
$position = array();
$descriptions = array();
$quantities = array();
$costs = array();
$total = array();
$paypallogo = $params->get('paypal_logo');
$paymentDetails = array();

if($session->get('invoice_id',null)!=null)
{
	$paymentDetails['token'] = $session->get('invoice_token',null);
	$paymentDetails['id'] = $session->get('invoice_id',null);
	$hosturl = (string)$siteurl.'index.php?option=com_devcloudmanager&view=ddcinvoices&ddcinvh_id='.$session->get('invoice_id',null).'&token='.$session->get('invoice_token',null);
	$invoiceModel = new DevcloudmanagerModelsDdcinvoices();
	$invoiceDetailModel = new DevcloudmanagerModelsDdcinvoicedetails();
	$invoice = $invoiceModel->getItem($session->get('invoice_id',null));
	$invdetails = $invoiceDetailModel->listItems($session->get('invoice_id',null));
	if($invoice->state == 1):
		for($i=0;$i<count($invdetails);$i++)
		{
			array_push($position,(int)$invdetails[$i]->pos);
			if($invdetails[$i]->service_id!=0){
				array_push($descriptions,(string)$invdetails[$i]->service_title);
				$paymentDetails['details'][$i]['description'] = (string)$invdetails[$i]->service_title;
			}elseif($invdetails[$i]->item_id!=0){
				array_push($descriptions,(string)$invdetails[$i]->item_title);
				$paymentDetails['details'][$i]['description'] = (string)$invdetails[$i]->item_title;
			}
			elseif($invdetails[$i]->task_id!=0){
				array_push($descriptions,(string)$invdetails[$i]->task_title);
				$paymentDetails['details'][$i]['description'] = (string)$invdetails[$i]->task_title;
			}
			array_push($quantities,(double)$invdetails[$i]->quantity);
			$paymentDetails['details'][$i]['quantity'] = (string)$invdetails[$i]->quantity;
			array_push($costs,(double)$invdetails[$i]->cost);
			$paymentDetails['details'][$i]['cost'] = (string)$invdetails[$i]->cost;
			array_push($total,(double)$invdetails[$i]->total);
		}
		$paypal = new DevcloudmanagerModelsDdcinvoices();
		$paypal->ddcpaypal($paymentDetails);
		else:
		if($app->input->get('paypalpayment',false))
		{
			echo "It appears your payment has not processed.<br> To complete your payment please return to PayPal.<br>";
			echo '<a href="'.$hosturl.'" rel="nofollow"><img src="'.$paypallogo.'" height="80px" /></a>';
			$session->clear('invoice_id');
			$session->clear('invoice_token');
		}
		else
		{
			echo "Thank you, your payment is complete.";
			$session->clear('invoice_id');
			$session->clear('invoice_token');
		}
	endif;	
}
else
{
	$paymentDetails['token'] = $invhtoken;
	$paymentDetails['id'] = $this->item->ddc_invoice_header_id;
	$session->set('invoice_id',$this->item->ddc_invoice_header_id);
	$session->set('invoice_token',$invhtoken);
	$hosturl = (string)$siteurl.'index.php?option=com_devcloudmanager&view=ddcinvoices&ddcinvh_id='.$session->get('invoice_id',null).'&token='.$session->get('invoice_token',null);
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
	$paypal = new DevcloudmanagerModelsDdcinvoices();
	$paypal->ddcpaypal($paymentDetails);
	else:
	if($app->input->get('paypalpayment',false))
	{
		echo "It appears your payment has not processed.<br> To complete your payment please return to PayPal.<br>";
		echo '<a href="'.$hosturl.'" rel="nofollow"><img src="'.$paypallogo.'" height="80px" /></a>';
		$session->clear('invoice_id');
		$session->clear('invoice_token');
	}
	else
	{
		echo "Thank you, your payment is complete.";
		$session->clear('invoice_id');
		$session->clear('invoice_token');
	}
	
	endif;
}

?>
