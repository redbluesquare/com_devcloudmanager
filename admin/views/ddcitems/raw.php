<?php 

defined( '_JEXEC' ) or die( 'Restricted access' ); 
 
class DevcloudmanagerViewsDdctasksRaw extends JViewHtml
{
  function render()
  {
    $app = JFactory::getApplication();
    $type = $app->input->get('type');
    $id = $app->input->get('id');
    $view = $app->input->get('view');
 
    //retrieve task list from model
    $model = new DevcloudmanagerModelsDdctaskdetails();
 
    $this->tditem = $model->getItem();
    
    //display
    echo $this->tditem;
  } 
}