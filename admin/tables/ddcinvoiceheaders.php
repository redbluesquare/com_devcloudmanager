<?php defined( '_JEXEC' ) or die( 'Restricted access' ); 
 
class TableDdcinvoiceheaders extends JTable
{                      
  /**
  * Constructor
  *
  * @param object Database connector object
  */
	var $id 			= null;
	
	function __construct( &$db )
	{
    	parent::__construct('#__ddc_invoice_headers', 'ddc_invoice_header_id', $db);
  	}
}