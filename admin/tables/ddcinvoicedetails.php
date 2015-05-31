<?php defined( '_JEXEC' ) or die( 'Restricted access' ); 
 
class TableDdcinvoicedetails extends JTable
{                      
  /**
  * Constructor
  *
  * @param object Database connector object
  */
	var $ddc_invoice_detail_id 			= null;
	
	function __construct( &$db )
	{
    	parent::__construct('#__ddc_invoice_details', 'ddc_invoice_detail_id', $db);
  	}
}