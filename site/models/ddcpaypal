<?php // no direct access

defined( '_JEXEC' ) or die( 'Restricted access' ); 
use PayPal\Rest\ApiContext;
use PayPal\Api\Payer;
use PayPal\Api\Payment;
use PayPal\Api\Transaction;
use PayPal\Auth\OAuthTokenCredential;
use PayPal\Api\Details;
use PayPal\Api\Amount;
use PayPal\Api\RedirectUrls;
use PayPal\Api\Item;
use PayPal\Api\ItemList;
use PayPal\Api\PaymentExecution;
use PayPal\Exception\PayPalConnectionException;


class DevcloudmanagerModelsDdcpaypal extends DevcloudmanagerModelsDefault
{

  /**
  * Protected fields
  **/
  var $_ddcinvh_id    	= null;
  var $_query			= null;
  var $_cat_id		    = null;
  var $_pagination  	= null;
  var $_project_id  	= null;
  var $_published   	= 0;
  var $_session			= null;
  var $_params			= null;
  var $_app				= null;
  var $_invtoken		= null;
  var $_token			= null;
  
  protected $messages;	
  
  
  function __construct()
  {
  	$this->_app = JFactory::getApplication();
  	$this->_session = JFactory::getSession();
  	$this->_params = JComponentHelper::getParams('com_devcloudmanager');
	$this->_ddcinvh_id = $this->_app->input->get('ddcinvh_id', null);
	$this->_query = $this->_app->input->get('query', null);
	$this->_cat_id = $this->_app->input->get('id', null);
	$this->_invtoken = $this->_session->get('invoice_token',null);
	
	
  	  	
    parent::__construct();       
  }
    
  
  /**
   * Paypal function to make payments
   * 
   * 
   */
  public function createPaypalPayment($paymentDetails = array())
  {
  	$date = date("Y-m-d H:i:s");
  if($this->_params->get('paypal_mode')=="live")
  	{
  		$api = new ApiContext(
  			new OAuthTokenCredential(
  					$this->_params->get('paypal_clientid'),
  					$this->_params->get('paypal_client_secret')
  			)
  		);
  	}
  	else
  	{
  		$api = new ApiContext(
  			new OAuthTokenCredential(
  					$this->_params->get('paypal_clientid_sandbox'),
  					$this->_params->get('paypal_client_secret_sandbox')
  			)
  		);
  	}
  	$api->setConfig([
  			'mode' => $this->_params->get('paypal_mode'),
  			'log.FileName' => JPATH_ROOT.DIRECTORY_SEPARATOR.'logs'.DIRECTORY_SEPARATOR.'PayPal.log',
  			'http.ConnectionTimeOut' => 100,
  			'log.LogEnabled' => false,
  			'log.LogLevel' => 'FINE',
  			'validation.level' => 'log'
  			]);
  	
  	$payer = new Payer();
  	$payer->setPaymentMethod('paypal');
  	
  	$payment = new Payment();
  	$redirecturls = new RedirectUrls();
  	
  	$invoice = new DevcloudmanagerModelsDdcinvoices();
  	$paymentDetails = $invoice->getPaymentDetails();
  	$id = $paymentDetails['id'];
  	$descriptions = array();
  	$quantities = array();
  	$costs = array();
  	for($i=0;$i<count($paymentDetails['details']);$i++)
  	{
  	array_push($descriptions, $paymentDetails['details'][$i]['description']);
  			array_push($quantities, $paymentDetails['details'][$i]['quantity']);
	  		array_push($costs,$paymentDetails['details'][$i]['cost']);
  	}
  	$subtotal = 0.00;
  	
  	$currency = $this->_params->get('ddc_currency');
  	
  	$url = JRoute::_('index.php?option=com_devcloudmanager$view=ddcinvoices');
  	
	  	for($i=0;$i<count($paymentDetails['details']);$i++)
  		  	{
  		  	$items[$i] = new Item();
  		  	$items[$i]->setPrice(number_format(($costs[$i]),2));
  		  	$subtotal = $subtotal+(($costs[$i]*$quantities[$i]));
  		  	$items[$i]->setName(substr($descriptions[$i],0,60));
  		  	$items[$i]->setQuantity((int)$quantities[$i]);
  		  	$items[$i]->setCurrency($currency);
  	}
  	
  	$itemList = new ItemList();
  	$itemList->setItems($items);
  	
  	$details = new Details();
  	$details->setSubtotal(number_format($subtotal,2));
  	
  	
  	$amount = new Amount();
  	$amount->setTotal($subtotal)
  	->setCurrency($currency)
  	->setDetails($details);
  	
  	$transaction = new Transaction();
  	$transaction->setAmount($amount)
  	->setItemList($itemList)
  	->setInvoiceNumber($id);
  	
  	if($this->_params->get('paypal_mode')=="live")
  	{
  		$redirecturls->setReturnUrl($this->_params->get('paypal_success_url'))
  			->setCancelUrl($this->_params->get('paypal_cancel_url'));
  	}
  	else 
  	{
  		$redirecturls->setReturnUrl($this->_params->get('paypal_success_url_sandbox'))
  		->setCancelUrl($this->_params->get('paypal_cancel_url_sandbox'));
  	}
  	
  	
  	$payment->setIntent('sale')
  	->setPayer($payer)
	  		->setTransactions([$transaction])
  			  	->setRedirectUrls($redirecturls);
  	
  	try {
	  	$payment->create($api);
  	
  		//store transaction details
  		$paymentId = $payment->getId();
  		$this->_session->set('paymentId',$paymentId);
  		$this->_session->set('paypal_hash',md5($payment->getId()));
  		$tokendata = json_encode(array('paypal_hash' => $this->_session->get('paypal_hash',null)));
  		
  		//Store paypal payment information into #__ddc_payments table
  		$db = JFactory::getDBO();
  		$query = $db->getQuery(TRUE);
  		$query->select('p.*')
  		->from('#__ddc_payments as p')
  		->where('(p.ref = "ddc_invoices") And (p.ref_id = '.$this->_app->input->get('ddcinvh_id', null).')');
  		$db->setQuery($query);
  		$payitem = $db->loadObject();
  		
  		if(($payitem->ref=='ddc_invoices') || ($payitem->ref_id!=$this->_app->input->get('ddcinvh_id', null)))
  		{
	  		$db = JFactory::getDBO();
	  		$query = $db->getQuery(TRUE);
	  		$columns = array('ref','ref_id', 'token', 'state', 'created', 'modified', 'created_by', 'modified_by');
	  		$values = array($db->quote('ddc_invoices'),$this->_app->input->get('ddcinvh_id', null),$db->quote($tokendata),0,$db->quote($date),$db->quote($date),0,0);
	  		$query
	  		->insert($db->quoteName('#__ddc_payments'))
	  		->columns($db->quoteName($columns))
	  		->values(implode(',', $values));
	  		$db->setQuery($query);
	  		$db->execute();
  		}
  	
  	}
  	catch(PayPalConnectionException $e)
  	{
  		if (count($e))
  		{
  	
  			JError::raiseError(500, implode('<br />', 'Error2 '.$e->getMessage()));
  			return false;
  		}
  	
  	}
  	
  	$approvalUrl = $payment->getApprovalLink();
  	$this->_app->redirect($approvalUrl);
  }
  	
  
  
  public function makePaypalPayment()
  {
  	$date = date("Y-m-d H:i:s");
  	if($this->_params->get('paypal_mode')=="live")
  	{
  		$api = new ApiContext(
  			new OAuthTokenCredential(
  					$this->_params->get('paypal_clientid'),
  					$this->_params->get('paypal_client_secret')
  			)
  		);
  	}
  	else
  	{
  		$api = new ApiContext(
  			new OAuthTokenCredential(
  					$this->_params->get('paypal_clientid_sandbox'),
  					$this->_params->get('paypal_client_secret_sandbox')
  			)
  		);
  	}
  	
  	$api->setConfig([
  			'mode' => $this->_params->get('paypal_mode'),
  			'log.FileName' => JPATH_ROOT.DIRECTORY_SEPARATOR.'logs'.DIRECTORY_SEPARATOR.'PayPal.log',
  			'http.ConnectionTimeOut' => 100,
  			'log.LogEnabled' => false,
  			'log.LogLevel' => 'FINE',
  			'validation.level' => 'log'
  			]);
  	$paymentId = $this->_app->input->get('paymentId',null);
  	$PayerID = $this->_app->input->get('PayerID',null);
  	$token = $this->_app->input->get('token',null);
  	
  	if($token!=null)
  	{
  		$tokendata = json_encode(array('paypal_hash' => md5($this->_app->input->get('paymentId',null))));

  		//Get paypal payment information from #__ddc_payments table
  		$db = JFactory::getDBO();
  		$query = $db->getQuery(TRUE);
  		$query->select('p.*')
  			->from('#__ddc_payments as p')
  			->where("(p.ref = 'ddc_invoices') And (p.token = '".$tokendata."')");
  		$db->setQuery($query);
  		$payitem = $db->loadObject();
  		$this->_session->set('invoice_id',$payitem->ref_id);
  		
  		//Check if payment state is 0 then update payment details
  		if($payitem->state == 0)
  		{
  			$tokendata = json_decode($payitem->token, true);
  			$tokendata = array_merge($tokendata, array('token'=>$token,'PayerID'=>$PayerID));
  			$db = JFactory::getDBO();
  			$query = $db->getQuery(TRUE);
  			// Fields to update.
  			$fields = array(
  					$db->quoteName('state') . ' = 1',
  					$db->quoteName('token') . ' = '.$db->quote(json_encode($tokendata)),
  					$db->quoteName('modified') . ' = ' . $db->quote($date)
  				);
  			$conditions = array(
  							$db->quoteName('ref') . ' = '.$db->quote('ddc_invoices'),
  							$db->quoteName('ref_id') . ' = ' . $payitem->ref_id);
  			$query->update($db->quoteName('#__ddc_payments'))->set($fields)->where($conditions);
  			$db->setQuery($query);
  			$result = $db->execute();
  		}
  		
   		$payment = Payment::get($paymentId,$api);
  		
   		$execute = new PaymentExecution();
   		$execute->setPayerId($PayerID);
  		
   		$payment->execute($execute,$api);
   		

   		$db = JFactory::getDBO();
   		$query = $db->getQuery(TRUE);
   		// Fields to update.
   		$fields = array($db->quoteName('state') . ' = 2',
   				$db->quoteName('modified') . ' = ' . $db->quote($date)
   		);
   		
   		// Conditions for which records should be updated.
   		$conditions = array(
   				$db->quoteName('ref') . ' = '.$db->quote('ddc_invoices'),
   				$db->quoteName('token') . ' = ' . $db->quote(json_encode($tokendata))
   		);
   		$query->update($db->quoteName('#__ddc_payments'))->set($fields)->where($conditions);
   		$db->setQuery($query);
   		$result = $db->execute();
   		
   		$db = JFactory::getDBO();
   		$query = $db->getQuery(TRUE);
   		// Fields to update.
   		$fields = array($db->quoteName('state') . ' = 2',$db->quoteName('closeddate'). ' = '.$db->quote($date));
   		
   		// Conditions for which records should be updated.
   		$conditions = array(
   				$db->quoteName('ddc_invoice_header_id') . ' = '.$this->_session->get('invoice_id',null)
   		);
   		$query->update($db->quoteName('#__ddc_invoice_headers'))->set($fields)->where($conditions);
   		$db->setQuery($query);
   		$result = $db->execute();
   		echo "Thank you, your payment is complete.";
   		echo '<a href="'.JUri::root().'">Click here</a> to return to the homepage.';
   		
   		$url = 'index.php?option=com_devcloudmanager&view=ddcinvoices&layout=complete&ddcinvh_id='.$this->_session->get('invoice_id',null);
   		$this->_app->redirect($url, JText::_('COM_DDC_PAYMENT_COMPLETE'));
  	}
  }

}
