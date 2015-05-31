<?php defined( '_JEXEC' ) or die( 'Restricted access' ); 
 
class TableDdcclientusers extends JTable
{                      
  /**
  * Constructor
  *
  * @param object Database connector object
  */
	var $ddc_clientuser_id 			= null;
	
	function __construct( &$db )
	{
    	parent::__construct('#__ddc_clientusers', 'ddc_clientuser_id', $db);
  	}
}