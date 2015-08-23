<?php defined( '_JEXEC' ) or die( 'Restricted access' ); 
 
class TableDdcclientuser extends JTable
{                      
  /**
  * Constructor
  *
  * @param object Database connector object
  */
	var $ddc_client_user_id 			= null;
	
	function __construct( &$db )
	{
    	parent::__construct('#__ddc_client_users', 'ddc_client_user_id', $db);
  	}
}