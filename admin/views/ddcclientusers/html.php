<?php defined( '_JEXEC' ) or die( 'Restricted access' ); 
 
class DevcloudmanagerViewsDdcclientusersHtml extends JViewHtml
{
	protected $data;
	protected $form;
	protected $params;
	protected $state;

  function render()
  {
    $layout = $this->getLayout();
    $modelClientusers = new DevcloudmanagerModelsDdcclientusers();
    $modelClientuserForm = new DevcloudmanagerModelsDdcclientuser();
 
    switch($layout) {

     	case "default":
     		default:
     		$this->items = $modelClientusers->listItems();
			$this->addToolbar();
			DevcloudmanagerHelpersDevcloudmanager::addSubmenu('clients');
    	break;
    	
    	case "edit":
    	default:
    		$this->form = $modelClientuserForm->getForm();
    		$this->item = $modelClientusers->getItem();
    		$this->updateToolbar();
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
  
  	JToolBarHelper::title(JText::_('COM_DDC_CLIENTS'));
  	JToolBarHelper::addNew('ddcclientuser.add');
  	
  	JToolBarHelper::help('JHELP_DEVCLOUDMANAGER',true,'http://redbluesquare.co.uk/custom-joomla-components/24-devcloudmanager.html');
  
  	if ($canDo->get('core.admin'))
  	{
  		JToolbarHelper::preferences('com_devcloudmanager');
  	}
  }
  protected function UpdateToolBar()
  {
  	$input = JFactory::getApplication()->input;
  	$input->set('hidemainmenu', true);
  	$app = JFactory::getApplication();
  	if($app->input->get('client_id') == null)
  	{
  		$isNew = true;
  	}else 
  	{
  		$isNew = false;
  	}
  	JToolBarHelper::title($isNew ? JText::_('COM_DDC_MANAGER_CLIENT_NEW'): JText::_('COM_DDC_MANAGER_CLIENT_EDIT'));
  	JToolBarHelper::apply('ddcclientuser.apply');
  	JToolBarHelper::save('ddcclientuser.save');
  	JToolBarHelper::cancel('ddcclientuser.cancel', $isNew ? 'JTOOLBAR_CANCEL': 'JTOOLBAR_CLOSE');
  }
}