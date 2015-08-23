<?php defined( '_JEXEC' ) or die( 'Restricted access' ); 
 
class TableDdcservice extends JTable
{                      
  /**
  * Constructor
  *
  * @param object Database connector object
  */
	var $ddc_service_id 			= null;
	
	function __construct( &$db )
	{
    	parent::__construct('#__ddc_services', 'ddc_service_id', $db);
  	}
}