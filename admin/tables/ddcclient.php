<?php defined( '_JEXEC' ) or die( 'Restricted access' ); 
 
class TableDdcclient extends JTable
{                      
  /**
  * Constructor
  *
  * @param object Database connector object
  */
	var $ddc_clients_id 			= null;
	
	function __construct( &$db )
	{
    	parent::__construct('#__ddc_clients', 'ddc_client_id', $db);
  	}
}