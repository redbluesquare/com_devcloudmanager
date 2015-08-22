<?php // no direct access

defined( '_JEXEC' ) or die( 'Restricted access' ); 
 
class DevcloudmanagerModelsDdctaskdetails extends DevcloudmanagerModelsDefault
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
	$this->_ddctaskdetail_id = $app->input->get('ddctaskdetail_id', null);
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
    $query->from('#__ddc_task_details as td');
	$query->select('td.*');
    $query->leftJoin('#__ddc_tasks as t on (t.ddc_task_id = td.ddctask_id)');
    $query->select('u.name as actioned_by');
    $query->leftJoin('#__users as u on t.user_id = u.id');
    $query->group('td.ddc_task_detail_id');
    $query->group('td.action_date, td.timestart	 ASC');
    
    return $query;
    
  }
  
  protected function _buildWhere(&$query)
  {
  	if($this->_ddctask_id!=null)
  	{
  		$query->where('t.ddc_task_id = "'.$this->_ddctask_id.'"');
  	}
  	if($this->_ddctaskdetail_id!=null)
  	{
  		$query->where('td.ddc_task_detail_id = "'.$this->_ddctaskdetail_id.'"');
  	}
   return $query;
  }
  
  /**
   * Method to delete an entry from the task detail table
   * @param TaskDetailId $id
   * @return mixed
   */
  public function deleteTaskd($id)
  {
  	$this->db = JFactory::getDbo();
  	$query = $this->db->getQuery(true);
  	// delete the relevant id.
  	$conditions = array($this->db->quoteName('ddc_task_detail_id') . ' = '.$id);
  	$query->delete($this->db->quoteName('#__ddc_task_details'));
  	$query->where($conditions);
  	$this->db->setQuery($query);
  
  
  	$result = $this->db->execute();
  	return $result;
  }

}