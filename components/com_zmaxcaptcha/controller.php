<?php
/**
 *	description:ZMAX验证码 主控制器
 *  author：min.zhang
 *  Email:zhang19min88@163.com
 *	Url:http://www.zmax99.com
 *  copyright:南宁市程序人软件科技有限责任公司保留所有权利
 *  date:2014-12-05
 */

defined('_JEXEC') or die ('Restricted Access');
jimport('joomla.application.component.controller');

class zmaxcaptchaController extends JControllerLegacy
 {
	function __construct()
	{
		parent::__construct();
	}
	
	function display($cachable = false ,$urlparams = Array())
	{

		parent::display($cachable = false ,$urlparams = Array());
	}
	
	function sendMsg()
	{
		$mainframe =  JFactory::getApplication();
		require_once(JPATH_SITE.'/components/com_zmaxcaptcha/helpers/zmaxcaptcha.php');	
		$phone_no = JRequest::getVar("phone_no");		
		zmaxcaptchaHelper::sendSmsVerify($phone_no);
		$mainframe->close();
	}
	
	function changeCode()
	{
		$mainframe =  JFactory::getApplication();
		$this->getNewCode();
		$mainframe->close();
	}
	
	function getCode()
	{
		
		$mainframe =  JFactory::getApplication();
		require_once(JPATH_SITE.'/components/com_zmaxcaptcha/helpers/zmaxcaptcha.php');
		$code = zmaxcaptchaHelper::getCode();
		echo $code;
		$mainframe->close();
		
	}
	
	protected function getNewCode()
	{
		if(!defined('DS'))
		{
			define('DS',DIRECTORY_SEPARATOR);
		}
		$strPathRoot= JPATH_ADMINISTRATOR.DS.'components'.DS.'com_zmaxcaptcha'.DS.'libs'.DS.'captcha';
		$strImageName="zmax.png";
		
		include($strPathRoot.'/captcha.php');
		$captcha = new CValidateCode($strPathRoot); 
		$captcha->createImage($strImageName);
		$strCode = $captcha->getCode();
		echo $strCode;
		require_once(JPATH_SITE.'/components/com_zmaxcaptcha/helpers/zmaxcaptcha.php');
		zmaxcaptchaHelper::saveCode($strCode);
	}
 }


?>