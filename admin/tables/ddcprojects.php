<?php defined( '_JEXEC' ) or die( 'Restricted access' ); 
 
class TableDdcprojects extends JTable
{                      
  /**
  * Constructor
  *
  * @param object Database connector object
  */
	var $ddc_project_id 			= null;
	
	function __construct( &$db )
	{
    	parent::__construct('#__ddc_projects', 'ddc_project_id', $db);
  	}
}