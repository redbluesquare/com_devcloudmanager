<?php defined( '_JEXEC' ) or die( 'Restricted access' ); 
 
class TableDdcinvoice extends JTable
{                      
  /**
  * Constructor
  *
  * @param object Database connector object
  */
	var $ddc_invoice_header_id 			= null;
	
	function __construct( &$db )
	{
    	parent::__construct('#__ddc_invoice_headers', 'ddc_invoice_header_id', $db);
  	}
}