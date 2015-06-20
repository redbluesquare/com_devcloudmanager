<?php defined( '_JEXEC' ) or die( 'Restricted access' ); 
 
class TableDdctaskdetail extends JTable
{                      
  /**
  * Constructor
  *
  * @param object Database connector object
  */
	var $id 			= null;
	var $actioned_by 	= null;
	
	function __construct( &$db )
	{
    	parent::__construct('#__ddc_task_details', 'ddc_task_detail_id', $db);
  	}
}