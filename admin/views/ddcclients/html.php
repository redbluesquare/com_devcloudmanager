<?php defined( '_JEXEC' ) or die( 'Restricted access' ); 
 
class DevcloudmanagerViewsDdcclientsHtml extends JViewHtml
{
	protected $data;
	protected $form;
	protected $params;
	protected $state;

  function render()
  {
    $layout = $this->getLayout();
    $modelClients = new DevcloudmanagerModelsDdcclients();
    $modelClientForm = new DevcloudmanagerModelsDdcclient();
 
    switch($layout) {

     	case "default":
     		default:
     		$this->items = $modelClients->listItems();
			$this->addToolbar();
			DevcloudmanagerHelpersDevcloudmanager::addSubmenu('clients');
    	break;
    	
    	case "edit":
    	default:
    		$this->form = $modelClientForm->getForm();
    		$this->item = $modelClients->getItem();
    		$this->addToolbar();
    	break;
    }
   
 
    //display
    return parent::render();
  }
  protected function addToolbar()
  {
  	$canDo  = DevcloudmanagerHelpersDevcloudmanager::getActions();
  
  	// Get the toolbar object instance
  	$bar = JToolBar::getInstance('toolbar');
  
  	JToolBarHelper::title(JText::_('COM_DDC_DASHBOARD'));
  	JToolBarHelper::help('JHELP_DEVCLOUDMANAGER',true,'http://redbluesquare.co.uk/custom-joomla-components/24-apartment-manager.html');
  
  	if ($canDo->get('core.admin'))
  	{
  		JToolbarHelper::preferences('com_devcloudmanager');
  	}
  }
}