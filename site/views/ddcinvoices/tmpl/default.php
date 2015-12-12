<?php
defined( '_JEXEC' ) or die( 'Restricted access' );


$this->_app = JFactory::getApplication();
$session = JFactory::getSession();
$paypal = new DevcloudmanagerModelsDdcpaypal();
$params = JComponentHelper::getParams('com_devcloudmanager');
$paypallogo = $params->get('paypal_logo');
if($this->item->payment_state!=2)
{
	if($this->_app->input->get('paypalsuccess',null)==="false")
	{
		echo JText::_('COM_DDC_PAYMENT_CANCELLED')."<br>";
		echo '<a href="'.JUri::root().'index.php?option=com_devcloudmanager&view=ddcinvoices&ddcinvh_id='.$this->item->ddc_invoice_header_id.'&invtoken='.$this->item->token.'">
					<img src="'.$paypallogo.'" style="height:80px;" /></a>';
	}
	elseif($this->_app->input->get('paypalsuccess',null)==="true")
	{
		if($item->payment_state!=2)
		{
			$paypal->makePaypalPayment();
		}
	
	
	}
	elseif($this->_app->input->get('paypalsuccess',null)===null)
	{
		if(($this->item->payment_state==null) || ($this->item->payment_state==0)){
			$invoice = new DevcloudmanagerModelsDdcinvoices();
			$paypal->createPaypalPayment($invoice->getPaymentDetails());
		}
	}
}
else 
{
	echo JText::_('COM_DDC_PAYMENT_COMPLETE');
}


?>
