 <?php defined( '_JEXEC' ) or die( 'Restricted access' ); 
 
 
class DevcloudmanagerControllersDefault extends JControllerBase
{
  public function execute()
  {

    // Get the application
    $app = JFactory::getApplication();
 	
    // Get the document object.
    $document     = JFactory::getDocument();
 
    $viewName     = $app->input->getWord('view', 'dashboard');
    $viewFormat   = $document->getType();
    $layoutName   = $app->input->getWord('layout', 'default');
 
    $app->input->set('view', $viewName);
 
    // Register the layout paths for the view
    $paths = new SplPriorityQueue;
    $paths->insert(JPATH_COMPONENT . '/views/' . $viewName . '/tmpl', 'normal');

    $viewClass  = 'DevcloudmanagerViews' . ucfirst($viewName) . ucfirst($viewFormat);
    $modelClass = 'DevcloudmanagerModels' . ucfirst($viewName);
 
    if (false === class_exists($modelClass))
    {
      $modelClass = 'DevcloudmanagerModelsDefault';
    }
 
    $view = new $viewClass(new $modelClass, $paths);

    $view->setLayout($layoutName);

    // Render our view.
    echo $view->render();
 
    return true;
  }

}