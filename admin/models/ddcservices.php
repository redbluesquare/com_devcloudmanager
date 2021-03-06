<?php // no direct access

defined( '_JEXEC' ) or die( 'Restricted access' ); 
 
class DevcloudmanagerModelsDdcservices extends DevcloudmanagerModelsDefault
{

  /**
  * Protected fields
  **/
  var $_ddcservice_id    	= null;
  var $_query			= null;
  var $_cat_id		    = null;
  var $_pagination  	= null;
  var $_project_id  	= null;
  var $_published   	= 1;
  protected $messages;	
  
  function __construct()
  {
  	$this->app = JFactory::getApplication();
	$this->_ddcservice_id = $this->app->input->get('ddcservice_id', null);
	$this->_query = $this->app->input->get('query', null);
	$this->_cat_id = $this->app->input->get('id', null);
  	  	
    parent::__construct();       
  }
    
	
   protected function _buildQuery()
  {
 	
    $db = JFactory::getDBO();
    $query = $db->getQuery(TRUE);

    $query->select('s.*');
    $query->select('c.business_name');
    $query->select('i.title as item_title');
    $query->select('id.service_id');
    $query->from('#__ddc_services as s');
    $query->leftJoin('#__ddc_items as i on i.ddc_item_id = s.item_id');
    $query->leftJoin('#__ddc_invoice_details as id on s.ddc_service_id = id.service_id');
    $query->leftJoin('#__ddc_clients as c on c.ddc_client_id = s.client_id');

    $query->group('s.ddc_service_id, s.title ASC');
    
    return $query;
    
  }
  
  protected function _buildWhere(&$query)
  {
//   	if($this->_published!=null)
//   	{
//   		$query->where('s.state = "'.$this->_published.'"');
//   	}
  	if($this->_ddcservice_id!=null)
  	{
  		$query->where('s.ddc_service_id = "'.$this->_ddcservice_id.'"');
  	}
  	if($this->app->input->get('view',null)=='ddcinvoices')
  	{
  		$query->where('(id.service_id Is Null)') ;
  		$query->where('s.state = "'.$this->_published.'"');
  	}
  	
  	

   return $query;
  }

}