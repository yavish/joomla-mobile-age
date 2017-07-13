<?php
/**
 *	description:ZMAX第三方登陆系统 扩展安装视图文件
 *  author：min.zhang
 *  Email:zhang19min88@163.com
 *	Url:http://www.zmax99.com
 *  copyright:南宁市程序人软件科技有限责任公司保留所有权利
 *  date:2015-01-18
 * @license GNU General Public License version 3, or later
 */

defined('_JEXEC') or die;

class zmaxloginHelper
{
	/**
	 * Configure the Linkbar.
	 *
	 * @param   string  $vName  The name of the active view.
	 *
	 * @return  void
	 */
	public static function addSubmenu($vName = 'install')
	{
		JHtmlSidebar::addEntry(
			JText::_('COM_ZMAXLOGIN_SUBMENU_MAIN'),
			'index.php?option=com_zmaxlogin&view=main',
			$vName == 'main'
		);
		JHtmlSidebar::addEntry(
			JText::_('COM_ZMAXLOGIN_SUBMENU_USERS'),
			'index.php?option=com_zmaxlogin&view=users',
			$vName == 'users'
		);
		JHtmlSidebar::addEntry(
			JText::_('COM_ZMAXLOGIN_SUBMENU_INSTALL'),
			'index.php?option=com_zmaxlogin&view=install',
			$vName == 'install'
		);
		JHtmlSidebar::addEntry(
			JText::_('COM_ZMAXLOGIN_SUBMENU_EXTENSIONS'),
			'index.php?option=com_zmaxlogin&view=extensions',
			$vName == 'extensions'
		);
	}

	/**
	 * Get a list of filter options for the extension types.
	 *
	 * @return  array  An array of stdClass objects.
	 *
	 * @since   3.0
	 */
	public static function getExtensionTypes()
	{
		$db    = JFactory::getDbo();
		$query = $db->getQuery(true)
			->select('DISTINCT type')
			->from('#__extensions');
		$db->setQuery($query);
		$types = $db->loadColumn();

		$options = array();
		foreach ($types as $type)
		{
			$options[] = JHtml::_('select.option', $type, 'COM_INSTALLER_TYPE_' . strtoupper($type));
		}

		return $options;
	}

	/**
	 * Get a list of filter options for the extension types.
	 *
	 * @return  array  An array of stdClass objects.
	 *
	 * @since   3.0
	 */
	public static function getExtensionGroupes()
	{
		$db = JFactory::getDbo();
		$query = $db->getQuery(true)
			->select('DISTINCT folder')
			->from('#__extensions')
			->where('folder != ' . $db->quote(''))
			->order('folder');
		$db->setQuery($query);
		$folders = $db->loadColumn();

		$options = array();
		foreach ($folders as $folder)
		{
			$options[] = JHtml::_('select.option', $folder, $folder);
		}

		return $options;
	}

	/**
	 * Gets a list of the actions that can be performed.
	 *
	 * @return  JObject
	 *
	 * @since   1.6
	 * @deprecated  3.2  Use JHelperContent::getActions() instead
	 */
	public static function getActions()
	{
		// Log usage of deprecated function
		JLog::add(__METHOD__ . '() is deprecated, use JHelperContent::getActions() with new arguments order instead.', JLog::WARNING, 'deprecated');

		// Get list of actions
		$result = JHelperContent::getActions('com_installer');

		return $result;
	}
	
	public static function isActive()
	{
		return true;
		$host =  $_SERVER["HTTP_HOST"];
		$checkHost = md5($host);
		$active_code=JComponentHelper::getParams("com_zmaxlogin")->get("active_code");
		$active_domain=JComponentHelper::getParams("com_zmaxlogin")->get("active_domain");
		if(md5($active_code) == $checkHost && md5($active_domain) == $checkHost )
		{
			return true;
		}
		return false;
		
	}
	
	public static function checkPermit()
	{
		if(!zmaxloginHelper::isActive())
		{
			JError::raiseWarning("100",JText::_("COM_ZMAXLOGIN_SYSTEM_PRODUCT_NOT_ACTIVE"));
			$app = JFactory::getApplication();
			$app->redirect("index.php?option=com_zmaxlogin&view=main");
			return false;
		}
		return true;
	}
}
