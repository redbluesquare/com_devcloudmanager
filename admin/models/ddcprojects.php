<?php // no direct access

defined( '_JEXEC' ) or die( 'Restricted access' ); 
 
class DevcloudmanagerModelsDdcprojects extends DevcloudmanagerModelsDefault
{

  /**
  * Protected fields
  **/
  var $_project_id    	= null;
  var $_query			= null;
  var $_cat_id		    = null;
  var $_pagination  	= null;
  var $_published   	= 1;
  protected $messages;	
  
  function __construct()
  {
  	$app = JFactory::getApplication();
	$this->_project_id = $app->input->get('project_id', null);
	$this->_query = $app->input->get('query', null);
	$this->_cat_id = $app->input->get('id', null);
  	  	
    parent::__construct();       
  }
    
	
   protected function _buildQuery()
  {
 	
    $db = JFactory::getDBO();
    $query = $db->getQuery(TRUE);

    $query->select('p.*');
    $query->from('#__ddc_projects as p');
    $query->select('c.business_name');
    $query->leftJoin('#__ddc_clients as c on p.client_id = c.ddc_client_id');
    $query->group('p.title');
    
    return $query;
    
  }
  
  protected function _buildWhere(&$query)
  {
  	if($this->_project_id!=null)
  	{
  		$query->where('p.ddc_project_id = "'.$this->_project_id.'"');
  	}
  	if($this->_published!=null)
  	{
  		$query->where('p.state = "'.$this->_published.'"');
  	}
   return $query;
  }

}