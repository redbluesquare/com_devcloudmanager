<?php // no direct access

defined( '_JEXEC' ) or die( 'Restricted access' ); 

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
  var $_invtoken		= null;
  
  protected $messages;	
  
  
  function __construct()
  {
  	$this->_app = JFactory::getApplication();
  	$this->_session = JFactory::getSession();
  	$this->_params = JComponentHelper::getParams('com_devcloudmanager');
	$this->_ddcinvh_id = $this->_app->input->get('ddcinvh_id', null);
	$this->_query = $this->_app->input->get('query', null);
	$this->_cat_id = $this->_app->input->get('id', null);
	if($this->_session->get('invoice_token',null)==null)
	{
		$this->_invtoken = $this->_app->get('invtoken');
		$this->_session->set('invoice_token',$this->_app->get('invtoken'));
		$this->_session->set('invoice_id',$this->_app->get('invoice_id'));
		
	}else 
	{
		$this->_invtoken = $this->_session->get('invoice_token',null);
	}
	
	
  	  	
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
    $query->select('invd.cost as total');
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
  		$query->where('invh.ddc_invoice_header_id = '.(int)$this->_ddcinvh_id);
  	}
  	if($id!=null)
  	{
  		$query->where('invh.ddc_invoice_header_id = "'.(int)$id.'"');
  		$query->where('cu.primary = 1');
  	}

   return $query;
  }

  public function getPaymentDetails($id = null)
  {
  	$position = array();
    $descriptions = array();
    $quantities = array();
  	$costs = array();
  	$total = array();
  	$paymentdetails = array();
  	if($id == null)
  	{
  		$id = (int)$this->_ddcinvh_id;
  	}
  	$paymentdetails['id'] = $id;
  	$paymentdetails['token'] = $this->_invtoken;
  	$invoiceModel = new DevcloudmanagerModelsDdcinvoices();
  	$invoiceDetailModel = new DevcloudmanagerModelsDdcinvoicedetails();
  	$invoice = $invoiceModel->getItem();
  	$invdetails = $invoiceDetailModel->listItems();
  	for($i=0;$i<count($invdetails);$i++)
  	{
  		if($invdetails[$i]->service_id!=0){
  			$paymentdetails['details'][$i]['description'] = (string)$invdetails[$i]->service_title;
		}elseif($invdetails[$i]->item_id!=0){
  			$paymentdetails['details'][$i]['description'] = (string)$invdetails[$i]->item_title;
  		}
  		elseif($invdetails[$i]->task_id!=0){
  			$paymentdetails['details'][$i]['description'] = (string)$invdetails[$i]->task_title;
  		}
  		$paymentdetails['details'][$i]['quantity'] = (string)$invdetails[$i]->quantity;
  		$paymentdetails['details'][$i]['cost'] = (string)$invdetails[$i]->cost;
  	}
  	
  	return $paymentdetails;
  }
  
}