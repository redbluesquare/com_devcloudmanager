<?php defined( '_JEXEC' ) or die( 'Restricted access' ); 
 
class DevcloudmanagerViewsDashboardHtml extends JViewHtml
{
	protected $data;
	protected $form;
	protected $params;
	protected $state;

  function render()
  {
    $layout = $this->getLayout();
    DevcloudmanagerHelpersDevcloudmanager::addSubmenu('dashboard');
    $modelClients = new DevcloudmanagerModelsDdcclients();
    $modelProjects = new DevcloudmanagerModelsDdcprojects();
    
 
    switch($layout) {

     	case "default":
     		default:
			$this->addToolbar();
			$this->sidebar = JHtmlSidebar::render();
			$this->clients = $modelClients->listItems();
			$this->projects = $modelProjects->listItems();
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