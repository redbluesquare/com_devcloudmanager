<?php defined( '_JEXEC' ) or die( 'Restricted access' ); 
 
class DevcloudmanagerViewsDdcinvoicesHtml extends JViewHtml
{
	protected $data;
	protected $form;
	protected $params;
	protected $state;

  function render()
  {
    $layout = $this->getLayout();
    $modelForm = new DevcloudmanagerModelsDdcinvoice();
    $modelInvDetail = new DevcloudmanagerModelsDdcinvoicedetails();
	DevcloudmanagerHelpersDevcloudmanager::addSubmenu('invoices');
 
    switch($layout) {

     	case "default":
     		default:
     		$this->items = $this->model->listItems();
			$this->addToolbar();
			$this->sidebar = JHtmlSidebar::render();
			//$this->model->ddcpaypal();
    	break;
    	
    	case "edit":
    	default:
    		$this->form = $modelForm->getForm();
    		$this->item = $this->model->getItem();
    		$this->itemdetails = $modelInvDetail->listItems();
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
  	JToolBarHelper::addNew('ddcinvoice.add');
  	
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
  	if($app->input->get('ddcinvh_id') == null)
  	{
  		$isNew = true;
  	}else 
  	{
  		$isNew = false;
  	}
  	JToolBarHelper::title($isNew ? JText::_('COM_DDC_MANAGER_INVOICE_NEW'): JText::_('COM_DDC_MANAGER_INVOICE_EDIT'));
  	//JToolBarHelper::apply('ddcinvoice.apply');
  	JToolBarHelper::save('ddcinvoice.save');
  	JToolBarHelper::cancel('ddcinvoice.cancel', $isNew ? 'JTOOLBAR_CANCEL': 'JTOOLBAR_CLOSE');
  }
}