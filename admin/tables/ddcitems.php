<?php defined( '_JEXEC' ) or die( 'Restricted access' ); 
 
class TableDdcitems extends JTable
{                      
  /**
  * Constructor
  *
  * @param object Database connector object
  */
	var $ddc_item_id 			= null;
	
	function __construct( &$db )
	{
    	parent::__construct('#__ddc_items', 'ddc_item_id', $db);
  	}
}