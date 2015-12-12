<?php defined( '_JEXEC' ) or die( 'Restricted access' ); 
 
class DevcloudmanagerViewsDdcinvoicesHtml extends JViewHtml
{
	protected $data;
	protected $form;
	protected $params;
	protected $state;
	/**
	 * Method to display the view.
	 *
	 * @param   string	The template file to include
	 * @since   1.6
	 */
  function render()
  {
    $layout = $this->getLayout();
    $modelInvDetails = new DevcloudmanagerModelsDdcinvoicedetails();
 
    switch($layout) {

     	case "default":
     		default:
     			$this->item = $this->model->getItem();
     			$this->invd = $modelInvDetails->listItems();
     		
    	break;
    	case "complete":
    		$this->item = $this->model->getItem();
    		$this->invd = $modelInvDetails->listItems();
    		 
    	break;
    	
    }
   
 
    //display
    return parent::render();
  }
}