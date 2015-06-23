<?php defined( '_JEXEC' ) or die( 'Restricted access' ); 
 
class TableDdcproject extends JTable
{                      
  /**
  * Constructor
  *
  * @param object Database connector object
  */
	var $id 			= null;
	
	function __construct( &$db )
	{
    	parent::__construct('#__ddc_projects', 'ddc_project_id', $db);
  	}
}