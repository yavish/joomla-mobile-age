<?php
/**
 *	description:ZMAX第三方登陆系统入口点文件
 *  author：min.zhang
 *  Email:zhang19min88@163.com
 *	Url:http://www.zmax99.com
 *  copyright:南宁市程序人软件科技有限责任公司保留所有权利
 *  date:2015-01-12
 *  @license GNU General Public License version 3, or later
 *  check-date :2016-09-27
 *  checker:min.zhang
 */
 
defined('_JEXEC') or die('you can not access this file!');

jimport('joomla.application.component.controller');

//兼容j25 j3x
if(!defined('DS')) define('DS', DIRECTORY_SEPARATOR);
	

JLoader::register('zmaxloginHelper',dirname(__FILE__).DS.'helpers'.DS.'zmaxlogin.php');

$app = JFactory::getApplication();
$params = $app->getParams();

if($params->get("debug"))
{
	define('ZMAX_DEBUG',1);
}

$controller = JControllerLegacy::getInstance('zmaxlogin');


$jinput = JFactory::getApplication()->input;
$task = $jinput->get('task',"",'STR');

$controller->execute($task);

$controller->redirect();
