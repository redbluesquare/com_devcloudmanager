<?php defined( '_JEXEC' ) or die( 'Restricted access' ); 
 
class DevcloudmanagerViewsDdctasksHtml extends JViewHtml
{
	protected $data;
	protected $form;
	protected $params;
	protected $state;

  function render()
  {
    $layout = $this->getLayout();
    $modelTasks = new DevcloudmanagerModelsDdctasks();
    $modelTaskForm = new DevcloudmanagerModelsDdctask();
    $modelTaskdetails = new DevcloudmanagerModelsDdctaskdetails();
    $modelTaskdetailForm = new DevcloudmanagerModelsDdctaskdetail();
    DevcloudmanagerHelpersDevcloudmanager::addSubmenu('ddctasks');
 
    switch($layout) {

     	case "default":
     		default:
     		$this->items = $modelTasks->listItems();
			$this->addToolbar();
			$this->sidebar = JHtmlSidebar::render();
			
    	break;
    	
    	case "edit":
    		$this->form = $modelTaskForm->getForm();
    		$this->item = $modelTasks->getItem();
    		$this->updateToolbar();
    	break;
    	
    	case "edittaskdetail":
    	default:
    		$this->item = $modelTasks->getItem();
    		$this->items = $modelTaskdetails->listItems();
    		$this->form = $modelTaskdetailForm->getForm();
    		$this->updateTDToolbar();
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
  
  	JToolBarHelper::title(JText::_('COM_DDC_TASKS'));
  	JToolBarHelper::addNew('ddctask.add');
  	
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
  	if($app->input->get('ddctask_id') == null)
  	{
  		$isNew = true;
  	}else 
  	{
  		$isNew = false;
  	}
  	JToolBarHelper::title($isNew ? JText::_('COM_DDC_MANAGER_TASK_NEW'): JText::_('COM_DDC_MANAGER_TASK_EDIT'));
  	//JToolBarHelper::apply('ddctask.apply');
  	JToolBarHelper::save('ddctask.save');
  	JToolBarHelper::cancel('ddctask.cancel', $isNew ? 'JTOOLBAR_CANCEL': 'JTOOLBAR_CLOSE');
  }
  protected function UpdateTDToolBar()
  {
  	$input = JFactory::getApplication()->input;
  	$input->set('hidemainmenu', true);
  	$app = JFactory::getApplication();
  	if($app->input->get('ddctaskdetail_id') == null)
  	{
  		$isNew = true;
  	}else
  	{
  		$isNew = false;
  	}
  	JToolBarHelper::title($isNew ? JText::_('COM_DDC_MANAGER_TASK_DETAIL_NEW'): JText::_('COM_DDC_MANAGER_TASK_DETAIL_EDIT'));
  	//JToolBarHelper::apply('ddctask.apply');
  	JToolBarHelper::save('ddctaskdetail.save');
  	JToolBarHelper::cancel('ddctaskdetail.cancel', $isNew ? 'JTOOLBAR_CANCEL': 'JTOOLBAR_CLOSE');
  }
}