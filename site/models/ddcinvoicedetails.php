<?php // no direct access

defined( '_JEXEC' ) or die( 'Restricted access' ); 
 
class DevcloudmanagerModelsDdcinvoicedetails extends DevcloudmanagerModelsDefault
{

  /**
  * Protected fields
  **/
  var $_ddcinvh_id		= null;
  var $_ddcinvd_id		= null;
  var $_query			= null;
  var $_cat_id		    = null;
  var $_pagination  	= null;
  var $_project_id  	= null;
  var $_published   	= 0;
  protected $messages;	
  
  function __construct()
  {
  	$app = JFactory::getApplication();
	$this->_ddcinvh_id = $app->input->get('ddcinvh_id', null);
	$this->_ddcinvd_id = $app->input->get('ddcinvd_id', null);
	$this->_query = $app->input->get('query', null);
	$this->_cat_id = $app->input->get('id', null);
  	  	
    parent::__construct();       
  }
    
	
   protected function _buildQuery()
  {
 	
    $db = JFactory::getDBO();
    $query = $db->getQuery(TRUE);

    $query->select('invd.*');
    $query->select('(invd.cost * invd.quantity * (1-invd.discount)) as total');
    $query->select('s.title as service_title');
    $query->select('i.title as item_title');
    $query->select('t.title as task_title');
    $query->from('#__ddc_invoice_details as invd');
    $query->leftJoin('#__ddc_services as s on s.ddc_service_id = invd.service_id');
    $query->leftJoin('#__ddc_items as i on i.ddc_item_id = invd.item_id');
    $query->leftJoin('#__ddc_tasks as t on t.ddc_task_id = invd.task_id');

    $query->group('invd.ddc_invoice_detail_id ASC');
    
    return $query;
    
  }
  
  protected function _buildWhere(&$query, $id = null)
  {
  	if($this->_published!=null)
  	{
  		$query->where('invd.state = "'.$this->_published.'"');
  	}
  	if($this->_ddcinvd_id!=null)
  	{
  		$query->where('invd.ddc_invoice_detail_id = "'.$this->_ddcinvd_id.'"');
  	}
  	if($id!=null)
  	{
  		$query->where('invd.invoiceheader_id = "'.(int)$id.'"');
  	}
  	else 
  	{
  		$query->where('invd.invoiceheader_id = "'.(int)$this->_ddcinvh_id.'"');
  	}

   return $query;
  }
  public function storeDetails($id)
  {
  	$date = date("Y-m-d H:i:s");
  	$app = JFactory::getApplication();
  	$result = $app->input->get('jform', array(),'array');
  	$lines = count($result['selbox']);
  	for($i = 0;$i < $lines;$i++)
  	{
  		if($result['cost'][$i]!=null):
  			$this->db = JFactory::getDbo();
  			$query = $this->db->getQuery(true);
  			$columns = array('invoiceheader_id','pos', 'service_id', 'item_id', 'task_id', 'cost', 'quantity', 'discount', 'created','state');
  			$values = array();
  			array_push($values,$this->db->quote($id));
  			array_push($values,$this->db->quote($result['pos'][$i]));
  			array_push($values,$this->db->quote($result['service_id'][$i]));
  			array_push($values,$this->db->quote($result['item_id'][$i]));
  			array_push($values,$this->db->quote($result['task_id'][$i]));
  			array_push($values,$this->db->quote($result['cost'][$i]));
  			array_push($values,$this->db->quote($result['quantity'][$i]));
  			array_push($values,$this->db->quote($result['discount'][$i]/100));
  			array_push($values,$this->db->quote($date));
  			array_push($values,'1');
  			$query
  				->insert($this->db->quoteName('#__ddc_invoice_details'))
  				->columns($this->db->quoteName($columns))
  				->values(implode(',', $values));
  			$this->db->setQuery($query);
  			$this->db->execute();
  		endif;
  	}
  }
	public function deleteInvd($id)
	{
		$this->db = JFactory::getDbo();
		$query = $this->db->getQuery(true);
		// delete the relevant id.
		$conditions = array($this->db->quoteName('ddc_invoice_detail_id') . ' = '.$id);
		$query->delete($this->db->quoteName('#__ddc_invoice_details'));
		$query->where($conditions);
		$this->db->setQuery($query);
		
		
		$result = $this->db->execute();
		return $result;
	}

}