<?php
/**
 *	description:ZMAX验证码 主控制文件
 *  author：min.zhang
 *  Email:zhang19min88@163.com
 *	Url:http://www.zmax99.com
 *  copyright:南宁市程序人软件科技有限责任公司保留所有权利
 *  date:2015-05-28
 */
 
defined('_JEXEC') or die('you can not access this file!');

// import joomla controller library
jimport('joomla.application.component.controller');

// get an instance of the controller prefixed by captcha
$controller = JControllerLegacy::getInstance('zmaxcaptcha');

$jinput = JFactory::getApplication()->input;
$task = $jinput->get('task',"",'STR');

// perform the request task
$controller->execute($task);

// redirect if set by controller
$controller->redirect();
