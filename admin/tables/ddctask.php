<?php defined( '_JEXEC' ) or die( 'Restricted access' ); 
 
class TableDdctask extends JTable
{                      
  /**
  * Constructor
  *
  * @param object Database connector object
  */
	var $id 			= null;
	
	function __construct( &$db )
	{
    	parent::__construct('#__ddc_tasks', 'ddc_task_id', $db);
  	}
}