<?php // No direct access

defined( '_JEXEC' ) or die( 'Restricted access' );

ini_set('display_errors',1);
error_reporting(E_ALL);

//sessions
jimport( 'joomla.session.session' );

//load tables
JTable::addIncludePath(JPATH_COMPONENT_ADMINISTRATOR.'/tables');

//load classes
JLoader::registerPrefix('Devcloudmanager', JPATH_COMPONENT_ADMINISTRATOR);

//Load plugins
//JPluginHelper::importPlugin('devcloudmanager');
 
//application
$app = JFactory::getApplication();
 
// Require specific controller if requested
$controller = $app->input->get('controller','default');

// Create the controller
$classname  = 'DevcloudmanagerControllers'.ucwords($controller);
$controller = new $classname();

JHtml::_('bootstrap.framework');
//Load styles and javascripts
DevcloudmanagerHelpersStyle::load();

// Perform the Request task
$controller->execute();