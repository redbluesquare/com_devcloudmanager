<?php defined( '_JEXEC' ) or die( 'Restricted access' ); 
 
class TableDdctasks extends JTable
{                      
  /**
  * Constructor
  *
  * @param object Database connector object
  */
	var $ddc_task_id 			= null;
	
	function __construct( &$db )
	{
    	parent::__construct('#__ddc_tasks', 'ddc_task_id', $db);
  	}
}