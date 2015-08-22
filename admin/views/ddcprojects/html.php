<?php defined( '_JEXEC' ) or die( 'Restricted access' ); 
 
class DevcloudmanagerViewsDdcprojectsHtml extends JViewHtml
{
	protected $data;
	protected $form;
	protected $params;
	protected $state;

  function render()
  {
    $layout = $this->getLayout();
    $modelProjects = new DevcloudmanagerModelsDdcprojects();
    $modelProjectForm = new DevcloudmanagerModelsDdcproject();
    DevcloudmanagerHelpersDevcloudmanager::addSubmenu('projects');
 
    switch($layout) {

     	case "default":
     		default:
     		$this->items = $this->model->listItems();
			$this->addToolbar();
			$this->sidebar = JHtmlSidebar::render();
			
    	break;
    	
    	case "edit":
    	default:
    		$this->form = $modelProjectForm->getForm();
    		$this->item = $modelProjects->getItem();
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
  
  	JToolBarHelper::title(JText::_('COM_DDC_PROJECTS'));
  	JToolBarHelper::addNew('ddcproject.add');
  	
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
  	if($app->input->get('project_id') == null)
  	{
  		$isNew = true;
  	}else 
  	{
  		$isNew = false;
  	}
  	JToolBarHelper::title($isNew ? JText::_('COM_DDC_MANAGER_PROJECT_NEW'): JText::_('COM_DDC_MANAGER_PROJECT_EDIT'));
  	JToolBarHelper::apply('ddcproject.apply');
  	JToolBarHelper::save('ddcproject.save');
  	JToolBarHelper::cancel('ddcproject.cancel', $isNew ? 'JTOOLBAR_CANCEL': 'JTOOLBAR_CLOSE');
  }
}