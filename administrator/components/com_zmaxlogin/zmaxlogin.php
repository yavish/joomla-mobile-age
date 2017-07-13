<?php
/**
 *	description:ZMAX第三方登陆系统 入口点文件
 *  author：min.zhang
 *  Email:zhang19min88@163.com
 *	Url:http://www.zmax99.com
 *  copyright:南宁市程序人软件科技有限责任公司保留所有权利
 *  date:2015-01-12
 * @license GNU General Public License version 3, or later
 */
 
defined('_JEXEC') or die('you can not access this file!');

if(!JFactory::getUser()->authorise('core.manage' ,'com_zmaxlogin'))
{
	return JError::raiseWarning(404,JText::_('COM_ZMAXLOGIN_ACCESS_DENY'));
}
// import joomla controller library
jimport('joomla.application.component.controller');

//兼容j25 j3x
if(!defined('DS')) define('DS', DIRECTORY_SEPARATOR);

// require helper file
JLoader::register('zmaxloginHelper',dirname(__FILE__).DS.'helpers'.DS.'zmaxlogin.php');

// get an instance of the controller prefixed by qqlogin
$controller = JControllerLegacy::getInstance('zmaxlogin');

$jinput = JFactory::getApplication()->input;
$task = $jinput->get('task',"",'STR');

// perform the request task
$controller->execute($task);

// redirect if set by controller
$controller->redirect();
