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


class DevcloudmanagerModelsDdcinvoices extends DevcloudmanagerModelsDefault
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
	$this->_token = $this->_session->get('invoice_token',null);
	
  	  	
    parent::__construct();       
  }
    
	
   protected function _buildQuery()
  {
 	
    $db = JFactory::getDBO();
    $query = $db->getQuery(TRUE);

    $query->select('cd.*');
    $query->select('c.*');
    $query->select('invh.*');
    $query->select('p.state as payment_state');
    $query->select('cd.name as contact_name');
    $query->select('SUM(invd.cost * invd.quantity * (1-invd.discount)) as total');
    $query->from('#__ddc_invoice_headers as invh');
    $query->leftJoin('#__ddc_payments as p on ((p.ref_id = invh.ddc_invoice_header_id) And (p.ref = "ddc_invoices"))');
    $query->leftJoin('#__ddc_clients as c on c.ddc_client_id = invh.client_id');
    $query->leftJoin('#__ddc_client_users as cu on c.ddc_client_id = cu.client_id');
    $query->leftJoin('#__contact_details as cd on cd.id = cu.user_id');
    $query->leftJoin('#__ddc_invoice_details as invd on invd.invoiceheader_id = invh.ddc_invoice_header_id');
    $query->group('invh.ddc_invoice_header_id, invh.posteddate ASC');
    
    return $query;
    
  }
  
  protected function _buildWhere(&$query,$id=null)
  {
  	if($this->_ddcinvh_id!=null)
  	{
  		$query->where('invh.ddc_invoice_header_id = "'.$this->_ddcinvh_id.'"');
  	}
  	if($id!=null)
  	{
  		$query->where('invh.ddc_invoice_header_id = "'.(int)$id.'"');
  		$query->where('cu.primary = 1');
  	}

   return $query;
  }
  
  
  
  public function emailinvoice($id)
  {
  	$app = JFactory::getApplication();
  	$invoiceModel = new DevcloudmanagerModelsDdcinvoices();
  	$invoiceDetailModel = new DevcloudmanagerModelsDdcinvoicedetails();
	$params = JComponentHelper::getParams('com_devcloudmanager');
  	
  	$invoice = $invoiceModel->getItem($id);
  	$invdetails = $invoiceDetailModel->listItems($id);
  	$invoicetitle = "INVOICE";
  	$invoice_number_title = "Invoice Number";
  	$sitetitle = $app->getCfg('sitename');
  	$owner = $app->getCfg('fromname');
  	$pos_title="Pos";
  	$description_title="Description";
  	$hrs_qty_title="Hrs/Qty";
  	$price_rate_title="Price/Rate";
  	$subtotal_title="Sub Total";
  	$total_title="Total";
  	$bank_details_title = "Bank Details";
  	$contact_details_title = "Contact Details";
  	$name_title = "Name";
  	$email_title = "E-mail";
  	$telephone_title = "Telephone";
  	$bank_name_title = "Bank Name";
  	$account_number_title = "Account Number";
  	$twitter_title = "Twitter";
  	$invoicenumber = (int)$invoice->ddc_invoice_header_id;
  	$posteddate = (string)JHtml::date($invoice->posteddate,'d M Y');
  	$ponumber = (string)$invoice->purchase_order;
  	$owneraddress1 = $params->get('address1');
  	$owneraddress2 = $params->get('address2');
  	$owneraddress3 = $params->get('address3');
  	$owneraddress4 = $params->get('address4');
  	$ownerpostcode = $params->get('post_code');
  	$owneremail = $app->getCfg('mailfrom');
  	$ownertelephone = $params->get('telephone');
  	$ownertwitter = $params->get('twiiter_name');
  	$ownertwitterurl = $params->get('twitterurl');
  	$contact_name = (string)$invoice->contact_name;
  	$business_name = (string)$invoice->business_name;
  	$clientaddress1 = (string)$invoice->address1;
  	$clientaddress2 = (string)$invoice->address2;
  	$clientaddress3 = (string)$invoice->town;
  	$clientaddress4 = (string)$invoice->county;
  	$clientpostcode = (string)$invoice->postcode;
  	$lines=10;
  	$position = array();
  	$description = array();
  	$qty = array();
  	$price = array();
  	$total = array();
  	for($i=0;$i<count($invdetails);$i++)
  	{
  		array_push($position,(int)$invdetails[$i]->pos);
  		if($invdetails[$i]->service_id!=0){
  			array_push($description,(string)$invdetails[$i]->service_title);
  		}elseif($invdetails[$i]->item_id!=0){
  			array_push($description,(string)$invdetails[$i]->item_title);
  		}
  		elseif($invdetails[$i]->task_id!=0){
  			array_push($description,(string)$invdetails[$i]->task_title);
  		}
  		array_push($qty,(double)$invdetails[$i]->quantity);
  		array_push($price,(double)$invdetails[$i]->cost);
  		array_push($total,(double)$invdetails[$i]->total);
  	}
  	for($i=0;$i<($lines-count($invdetails));$i++)
  	{
  		array_push($position,null);
  		array_push($description,"");
  		array_push($qty,"");
  		array_push($price,0);
  		array_push($total,0);
  	}
  	$accountname = $params->get('account_name');
  	$bankname = $params->get('bank_name');
  	$accountnumber = $params->get('account_number');
  	$sortcode = $params->get('sort_code');
  	$paymentterms = $params->get('payment_terms');
  	
  	$string = '<div style="width:720px;font-family: arial, \'Bree Serif\', serif;padding:20px;border:1px solid #ccc;margin:auto">';
  	$string .= '<div style="width:65%;float:left;display:inline;">';
  	$string .= '<a href="'.$ownertwitterurl.'" target="_BLANK">';
  	$string .= '<img src="http://www.redbluesquare.co.uk/images/headers/logo.png" width="40px" style="float:left;display:inline"/>';
  	$string .= '</a>';
  	$string .= '<h1 style="display:inline;text-size:40px;line-height:40px;vertical-align:middle;">';
  	$string .= '<a href="'.$ownertwitterurl.'" target="_BLANK" style="text-decoration:none;">'.$sitetitle.'</a></h1>';
  	$string .= '</div>';
  	$string .= '<div style="width:30%;float:right;display:inline;text-align:right"><h1 style="text-size:40px;line-height:40px;margin-top:5px;">'.$invoicetitle.'</h1>';
  	$string .= '<table style="width:100%;"><tbody><tr><td>'.$invoice_number_title.':</td><td style="text-align:right;"><strong>'.$invoicenumber.'</strong></td></tr><tr><td>Invoice Date:</td><td style="text-align:right;"><strong>'.$posteddate.'</strong></td></tr><tr><td>Purchase Order:</td><td style="text-align:right;"><strong>'.$ponumber.'</strong></td></tr></tbody></table></div>';
  	$string .= '<div style="clear:both;"></div>';
  	$string .= '<div style="padding-top:15px;">';
  	$string .= '<div style="width:35%;float:left;display:inline;"><h4>From: '.$owner.'</h4><p>'.$owneraddress1.'<br> '.$owneraddress2.'<br> '.$owneraddress3.'<br> '.$owneraddress4.'<br>'.$ownerpostcode.'<br></p></div>';
  	$string .= '<div style="width:45%;float:right;display:inline;text-align:right"><h4>To: '.$contact_name.'</h4><p>'.$business_name.'<br>'.$clientaddress1.'<br>'.$clientaddress2.'<br>'.$clientaddress3.'<br>'.$clientaddress4.'<br>'.$clientpostcode.'<br></p></div><div style="clear:both;"></div>';
  	$string .= '</div><!-- / end client details section -->';
  	$string .= '<table style="width:100%;padding-top:10px;border-collapse: collapse;padding:5px;height:400px;">';
  	$string .= '<thead><tr style="text-align:left;height:20px;"><th><h4>'.$pos_title.'</h4></th><th><h4>'.$description_title.'</h4></th><th><h4>'.$hrs_qty_title.'</h4></th><th><h4>'.$price_rate_title.'</h4></th><th style="text-align:right;"><h4>'.$subtotal_title.'</h4></th></tr></thead>';
  	$string .= '<tbody style="border-top:1px solid #ccc;border-bottom:1px solid #ccc;">';
  	for($i=0;$i<$lines;$i++):
  	$string .= '<tr><td style="padding:5px;">'.$position[$i].'</td><td style="padding:5px;">'.$description[$i].'</td><td style="padding:5px;">'.$qty[$i].'</td><td style="padding:5px;">';
  	if($price[$i]!=null):
  	$string .= '&pound; '.number_format($price[$i],2);
  	endif;
  	$string .= '</td>';
  	$string .= '<td style="padding:5px;text-align:right;text-weight:bold;">';
  	if($price[$i]!=null):
  	$string .= '&pound; '.number_format($total[$i],2);
  	endif;
  	$string .= '</td></tr>';
  	endfor;
  	$string .= '</tbody><tfoot><tr><td colspan="3"></td><td style="font-weight:bold;padding:10px 0px 10px 0px;border-bottom:double #ccc;">'.$total_title.': </td><td style="font-weight:bold; text-align:right;padding:10px 0px 10px 0px;border-bottom:double #ccc;">&pound; '.number_format(array_sum($total),2).'</td></tr></tfoot></table><br /><br /><table style="width:100%;border-collapse: collapse;border:1px solid #eee;"><thead style="line-height:20px;"><tr style=";border:1px solid #eee;"><th colspan="2" style=";border:1px solid #eee;"><h4 style="line-height:20px;margin:3px;">'.$bank_details_title.'</h4></th><th colspan="2" style=";border:1px solid #eee;"><h4 style="line-height:20px;margin:3px;">'.$contact_details_title.'</h4></th></tr></thead><tbody><tr><td style="width:22%;font-weight:bold;">'.$name_title.':</td><td style="width:28%;">'.$accountname.'</td><td style="width:20%;font-weight:bold;">'.$email_title.':</td><td style="width:30%;">'.$owneremail.'</td></tr><tr><td style="font-weight:bold;">'.$bank_name_title.':</td><td>'.$bankname.'</td><td style="font-weight:bold;">'.$telephone_title.':</td><td>'.$ownertelephone.'</td></tr><tr><td style="width:20%;font-weight:bold;">'.$account_number_title.':</td><td>'.$accountnumber.'</td><td style="width:20%;font-weight:bold;">'.$twitter_title.':</td><td>'.$ownertwitter.'</td></tr><tr><td style="font-weight:bold;"><?php echo "Sort Code:"; ?></td><td>'.$sortcode.'</td><td></td><td></td></tr></tbody></table><div>'.$paymentterms.'</div></div>';
  	
  	return array($string,$invoice->contact_name,$invoice->email_to, $invoicetitle.": ".$invoicenumber);
  }
  
  /**
   * 
   * 
   * 
   */
  public function ddcpaypal($paymentDetails = array())
  {
  	$date = date("Y-m-d H:i:s");
  	$api = new ApiContext(
  			new OAuthTokenCredential(
  					$this->_params->get('paypal_clientid'),
  					$this->_params->get('paypal_client_secret')
  			)
  	);
  	$api->setConfig([
  			'mode' => $this->_params->get('paypal_mode'),
  			'log.FileName' => '/PayPal.log',
  			'http.ConnectionTimeOut' => 100,
  			'log.LogEnabled' => false,
  			'log.LogLevel' => 'FINE',
  			'validation.level' => 'log'
  			]);
  	
  	$payer = new Payer();
  	$payer->setPaymentMethod('paypal');
  	
  	$payment = new Payment();
  	$redirecturls = new RedirectUrls();
  	
  	if($this->_token != $this->_app->input->get('token'))
  	{
  		if(($this->_app->input->get('paypalpayment',null)==null) || ($this->_app->input->get('paymentId',null)==null) || ($this->_app->input->get('PayerID',null)==null))
  		{
  			//$this->_app->redirect(JUri::root());
  			$exit1 = "paypalpayment, paymentId and PayerID did not validate";
  			return $exit1;
  		}
  		if($this->_app->input->get('paypalpayment',null)===false)
  		{
  			$exit2 = "paypalpayment was false, therefore customer cancelled";
  			return $exit2;
  		}
  		$paymentId = $this->_app->input->get('paymentId',null);
  		$PayerID = $this->_app->input->get('PayerID',null);
  		$this->_session->set('paymentId',$paymentId);
  		$this->_session->set('paypal_hash',md5($payment->getId()));
  		$tokendata = '{"paymentId":"'.$paymentId.'","paypal_hash":"'.$this->_session->get('paypal_hash',null).'"}';
  		
  		//Store paypal payment information into #__ddc_payments table
  		$db = JFactory::getDBO();
  		$query = $db->getQuery(TRUE);
  		$query->select('p.ref, p.ref_id')
  		->from('#__ddc_payments as p')
  		->where('(p.ref = "ddc_invoices") And (p.ref_id = '.$this->_session->get('invoice_id',null).')');
  		$db->setQuery($query);
  		$payitem = $db->loadObject();
  		
  		if(($payitem->ref=='ddc_invoices') || ($payitem->ref_id!=$this->_session->get('invoice_id',null)))
  		{
  			$db = JFactory::getDBO();
  			$query = $db->getQuery(TRUE);
  			$columns = array('ref','ref_id', 'token', 'state', 'created', 'modified', 'created_by', 'modified_by');
  			$values = array($db->quote('ddc_invoices'),$this->_session->get('invoice_id',null),$db->quote($tokendata),0,$db->quote($date),$db->quote($date),0,0);
  			$query
  			->insert($db->quoteName('#__ddc_payments'))
  			->columns($db->quoteName($columns))
  			->values(implode(',', $values));
  			$db->setQuery($query);
  			$db->execute();
  			
  			
  		}
  		
  		
  		$payment = Payment::get($paymentId,$api);
  		
  		$execute = new PaymentExecution();
  		$execute->setPayerId($PayerID);
  		
  		try {
  			$result = $payment->execute($execute,$api);
  				
  		}catch(Exception $e)
  		{
	   		if (count($e)) 
			{
				JError::raiseError(500, implode('<br />', 'Error1 '.$e->getMessage()));
				return false;
			}
  		}
  		
  		$db = JFactory::getDBO();
  		$query = $db->getQuery(TRUE);
  		// Fields to update.
  		$fields = array($db->quoteName('state') . ' = 1');
  		
  		// Conditions for which records should be updated.
  		$conditions = array(
  				$db->quoteName('ref') . ' = '.$db->quote('ddc_invoices'),
  				$db->quoteName('token') . ' = ' . $db->quote('{"paymentId":"'.$paymentId.'","paypal_hash":"'.$this->_session->get('paypal_hash',null).'"}')
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
  		$this->_session->clear('invoice_id');
  		$this->_session->clear('invoice_token');
  	}
  	else 
  	{
  	
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
	  	
	  	
	  	$redirecturls->setReturnUrl($this->_params->get('paypal_success_url'))
	  	->setCancelUrl($this->_params->get('paypal_cancel_url'));
	  	
	  	$payment->setIntent('sale')
	  		->setPayer($payer)
	  		->setTransactions([$transaction])
		  	->setRedirectUrls($redirecturls);
	
	  	
		try {
			$payment->create($api);
		}
		catch(Exception $e)
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
  }

}