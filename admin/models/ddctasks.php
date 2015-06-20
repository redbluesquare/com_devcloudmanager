<?php // no direct access

defined( '_JEXEC' ) or die( 'Restricted access' ); 
 
class DevcloudmanagerModelsDdctasks extends DevcloudmanagerModelsDefault
{

  /**
  * Protected fields
  **/
  var $_ddctask_id    	= null;
  var $_query			= null;
  var $_cat_id		    = null;
  var $_pagination  	= null;
  var $_published   	= 1;
  protected $messages;	
  
  function __construct()
  {
  	$app = JFactory::getApplication();
	$this->_ddctask_id = $app->input->get('ddctask_id', null);
	$this->_query = $app->input->get('query', null);
	$this->_cat_id = $app->input->get('id', null);
  	  	
    parent::__construct();       
  }
    
	
   protected function _buildQuery()
  {
 	
    $db = JFactory::getDBO();
    $query = $db->getQuery(TRUE);

    $query->select('t.*');
    $query->from('#__ddc_tasks as t');
    $query->select('p.title as project_title');
    $query->leftJoin('#__ddc_projects as p on t.project_id = p.ddc_project_id');
    $query->select('sum(TIME_TO_SEC(TIMEDIFF(td.timeend,td.timestart))/(60*60)) as worked');
    $query->leftJoin('#__ddc_task_details as td on t.ddc_task_id = td.ddctask_id');
    $query->select('u.name as responsible,u.email as responsible_email');
    $query->leftJoin('#__users as u on t.user_id = u.id');
    $query->group('t.title ASC');
    
    return $query;
    
  }
  
  protected function _buildWhere(&$query)
  {
  	if($this->_ddctask_id!=null)
  	{
  		$query->where('t.ddc_task_id = "'.$this->_ddctask_id.'"');
  	}

   return $query;
  }

}