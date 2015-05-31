<?php defined( '_JEXEC' ) or die( 'Restricted access' ); 
 
class TableDdctaskdetails extends JTable
{                      
  /**
  * Constructor
  *
  * @param object Database connector object
  */
	var $ddc_task_detail_id 			= null;
	
	function __construct( &$db )
	{
    	parent::__construct('#__ddc_task_details', 'ddc_task_detail_id', $db);
  	}
}