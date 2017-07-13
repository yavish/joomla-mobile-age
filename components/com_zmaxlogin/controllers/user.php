<?php
/**
 *	description:ZMAXLOGIN 用户控制器
 *  author：min.zhang
 *  Email:zhang19min88@163.com
 *	Url:http://www.zmax99.com
 *  copyright:南宁市程序人软件科技有限责任公司保留所有权利
 *  date:2014-12-02
 * @license GNU General Public License version 3, or later
 */
// no direct access
defined('_JEXEC') or die;

jimport('joomla.application.component.controlleradmin');


class zmaxloginControllerUser extends JControllerLegacy
{
	function __construct()
	{
		parent::__construct();
	}
	
	function save()
	{
		$returnURL = JRequest::getVar("returnURL" ,"/index.php");
		$returnURL="/index.php";
		$returnURL="index.php?option=com_users&view=profile&".JSession::getFormToken()."=1"; 
		$uid=JRequest::getVar("joomla_uid");
		$model = $this->getModel("userInfo");
		$result = $model->save();
		if($result == 0)
		{
			JPluginHelper::importPlugin('zmaxlogin');
			$dispatcher = JEventDispatcher::getInstance();
			$dispatcher->trigger('onZmaxLoginSuccess' ,array($uid,&$returnURL));
			$this->setRedirect($returnURL, JText::_("COM_ZMAXLOGIN_CONTROLLER_USER_LOGIN_SUCCESS"));
						
		}
		else if($result == 1) 
		{
			$this->setRedirect("index.php?option=com_zmaxlogin&view=userinfo&uid=".$uid."&".JSession::getFormToken()."=1",JText::_("COM_ZMAXLOGIN_CONTROLLER_USER_USERNAME_EXISTS"));
			
		}else if($result == 2)
		{
			$this->setRedirect("index.php?option=com_zmaxlogin&view=userinfo&uid=".$uid."&".JSession::getFormToken()."=1", JText::_("COM_ZMAXLOGIN_CONTROLLER_USER_EMAIL_EXISTS"));
		}
		else if($result == 3) 
		{
			$this->setRedirect("index.php?option=com_zmaxlogin&view=userinfo&uid=".$uid."&".JSession::getFormToken()."=1", JText::_("COM_ZMAXLOGIN_CONTROLLER_USER_WRONG_PASSWORD_OR_USERNAME"));
		}
		
	}
	
	function checkEmail()
	{
		$app = JFactory::getApplication();
		$email=JRequest::getVar("email");
		$model = $this->getModel("userInfo");
		if($model->emailValid($email))
		{
			echo "ZMAX_EMAIL_OK";
		}
		$app->close();
	}
	
}
