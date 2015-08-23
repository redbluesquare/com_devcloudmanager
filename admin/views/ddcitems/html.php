<?php defined( '_JEXEC' ) or die( 'Restricted access' ); 
 
class DevcloudmanagerViewsDdcitemsHtml extends JViewHtml
{
	protected $data;
	protected $form;
	protected $params;
	protected $state;

  function render()
  {
    $layout = $this->getLayout();
    $modelItemForm = new DevcloudmanagerModelsDdcitem();
    $modelTaskdetails = new DevcloudmanagerModelsDdctaskdetails();
    $modelTaskdetailForm = new DevcloudmanagerModelsDdctaskdetail();
	DevcloudmanagerHelpersDevcloudmanager::addSubmenu('ddcitems');
 
    switch($layout) {

     	case "default":
     		default:
     		$this->items = $this->model->listItems();
			$this->addToolbar();
			$this->sidebar = JHtmlSidebar::render();
			
    	break;
    	
    	case "edit":
    		$this->form = $modelItemForm->getForm();
    		$this->item = $this->model->getItem();
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
  
  	JToolBarHelper::title(JText::_('COM_DDC_ITEMS'));
  	JToolBarHelper::addNew('ddcitem.add');
  	
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
  	JToolBarHelper::title($isNew ? JText::_('COM_DDC_MANAGER_ITEM_NEW'): JText::_('COM_DDC_MANAGER_ITEM_EDIT'));
  	//JToolBarHelper::apply('ddctask.apply');
  	JToolBarHelper::save('ddcitem.save');
  	JToolBarHelper::cancel('ddcitem.cancel', $isNew ? 'JTOOLBAR_CANCEL': 'JTOOLBAR_CLOSE');
  }
}