<?php // no direct access

defined( '_JEXEC' ) or die( 'Restricted access' ); 
 
class DevcloudmanagerModelsDdcclients extends DevcloudmanagerModelsDefault
{

  /**
  * Protected fields
  **/
  var $_client_id    	= null;
  var $_query			= null;
  var $_cat_id		    = null;
  var $_pagination  	= null;
  var $_published   	= 1;
  protected $messages;	
  
  function __construct()
  {
  	$app = JFactory::getApplication();
	$this->_client_id = $app->input->get('client_id', null);
	$this->_query = $app->input->get('query', null);
	$this->_cat_id = $app->input->get('id', null);
  	  	
    parent::__construct();       
  }
    
	
   protected function _buildQuery()
  {
 	
    $db = JFactory::getDBO();
    $query = $db->getQuery(TRUE);

    $query->select('cl.*');
    $query->from('#__ddc_clients as cl');
    $query->group('cl.business_name');
    
    return $query;
    
  }
  
  protected function _buildWhere(&$query)
  {
  	if($this->_client_id!=null)
  	{
  		$query->where('cl.ddc_client_id = "'.$this->_client_id.'"');
  	}
   return $query;
  }

}