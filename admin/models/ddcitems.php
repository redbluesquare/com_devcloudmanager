<?php // no direct access

defined( '_JEXEC' ) or die( 'Restricted access' ); 
 
class DevcloudmanagerModelsDdcitems extends DevcloudmanagerModelsDefault
{

  /**
  * Protected fields
  **/
  var $_ddctask_id    	= null;
  var $_query			= null;
  var $_cat_id		    = null;
  var $_pagination  	= null;
  var $_project_id  	= null;
  var $_published   	= 0;
  protected $messages;	
  
  function __construct()
  {
  	$app = JFactory::getApplication();
	$this->_ddcitem_id = $app->input->get('ddcitem_id', null);
	$this->_query = $app->input->get('query', null);
	$this->_cat_id = $app->input->get('id', null);
  	  	
    parent::__construct();       
  }
    
	
   protected function _buildQuery()
  {
 	
    $db = JFactory::getDBO();
    $query = $db->getQuery(TRUE);

    $query->select('i.*');
    $query->from('#__ddc_items as i');

    $query->group('i.ddc_item_id, i.title ASC');
    
    return $query;
    
  }
  
  protected function _buildWhere(&$query)
  {
  	if($this->_published!=null)
  	{
  		$query->where('i.state = "'.$this->_published.'"');
  	}
  	if($this->_ddcitem_id!=null)
  	{
  		$query->where('i.ddc_item_id = "'.$this->_ddcitem_id.'"');
  	}

   return $query;
  }

}