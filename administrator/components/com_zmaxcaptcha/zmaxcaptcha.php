<?php
defined('_JEXEC') or die('you can not access this file!');


if(!defined('DS')) define('DS', DIRECTORY_SEPARATOR);

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
