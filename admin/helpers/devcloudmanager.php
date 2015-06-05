<?php
/**
 * @package     Joomla.Administrator
 * @subpackage  com_devcloudmanager
 */

defined('_JEXEC') or die;

/**
 * Devcloudmanager component helper.
 *
 * @package     Joomla.Administrator
 * @subpackage  com_devcloudmanager
 * @since       1.6
 */
class DevcloudmanagerHelpersDevcloudmanager
{
	public static $extension = 'com_devcloudmanager';

	/**
	 * @return  JObject
	 */
	public static function getActions()
	{
		$user	= JFactory::getUser();
		$result	= new JObject;

		$assetName = 'com_devcloudmanager';
		$level = 'component';

		$actions = JAccess::getActions('com_devcloudmanager', $level);

		foreach ($actions as $action)
		{
			$result->set($action->name,	$user->authorise($action->name, $assetName));
		}

		return $result;
	}
	
	public static function addSubmenu($submenu)
	{
		JSubMenuHelper::addEntry(JText::_('COM_DDC_DASHBOARD'),
		'index.php?option=com_devcloudmanager&view=dashboard', $submenu == 'dashboard');
		JSubMenuHelper::addEntry(JText::_('COM_DDC_CLIENTS'),
		'index.php?option=com_devcloudmanager&view=ddcclients', $submenu == 'clients');
		JSubMenuHelper::addEntry(JText::_('COM_DDC_CLIENTUSERS'),
		'index.php?option=com_devcloudmanager&view=ddcclientusers', $submenu == 'clientusers');
		JSubMenuHelper::addEntry(JText::_('COM_DDC_PROJECTS'),
		'index.php?option=com_devcloudmanager&view=ddcprojects', $submenu == 'projects');
		JSubMenuHelper::addEntry(JText::_('COM_DDC_CATEGORIES'),
		'index.php?option=com_categories&view=categories&extension=com_devcloudmanager', $submenu == 'categories');
		JSubMenuHelper::addEntry(JText::_('COM_DDC_TASKS'),
		'index.php?option=com_devcloudmanager&view=ddctasks', $submenu == 'tasks');
		JSubMenuHelper::addEntry(JText::_('COM_DDC_INVOICES'),
		'index.php?option=com_devcloudmanager&view=ddcinvoices', $submenu == 'invoices');

		// set some global property
		$document = JFactory::getDocument();

		if ($submenu == 'categories')
		{
			$document->setTitle(JText::_('COM_DEVCLOUDMANAGER_ADMINISTRATION_CATEGORIES'));
		}
	}
}