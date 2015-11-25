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
  	$this->session = JFactory::getSession();
	$this->_project_id = $this->session->get('ddcproject', null);
	$this->_client_id = $app->input->get('client_id', null);
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
    $query->select('COUNT(t.ddc_task_id) as tasks');
    $query->leftJoin('#__ddc_clients as c on p.client_id = c.ddc_client_id');
    $query->leftJoin('#__ddc_tasks as t on p.ddc_project_id = t.project_id');
    $query->group('p.title');
    
    return $query;
    
  }
  
  protected function _buildWhere(&$query)
  {
  	if($this->_project_id!=null)
  	{
  		$query->where('p.ddc_project_id = "'.(int)$this->_project_id.'"');
  	}
  	if($this->_client_id!=null)
  	{
  		$query->where('c.ddc_client_id = "'.$this->_client_id.'"');
  	}
  	if($this->_published!=null)
  	{
  		$query->where('p.state = "'.$this->_published.'"');
  	}
   return $query;
  }
  
  public function getTaskHours($client_id = null)
  {
  	 
  	$db = JFactory::getDBO();
  	$query = $db->getQuery(TRUE);
  	$query->select('sum(TIME_TO_SEC(TIMEDIFF(td.timeend,td.timestart))/(60*60)) as hours');
    $query->from('#__ddc_tasks as t');
    $query->rightJoin('#__ddc_task_details as td on td.ddctask_id = t.ddc_task_id');
    $query->rightJoin('#__ddc_projects as p on p.ddc_project_id = t.project_id');
    $query->where('p.client_id = '.$client_id);
  	$query->where('p.state = '.$this->_published);
  	//$query->where('t.state = '.$this->_published);
  	$db->setQuery($query);
  	$item = $db->loadObject();
  	return $item;
  }

}