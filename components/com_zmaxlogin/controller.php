<?php
/**
 *	description:ZMAX第三方登陆系统主控制器文件
 *  author：min.zhang
 *  Email:zhang19min88@163.com
 *	Url:http://www.zmax99.com
 *  copyright:南宁市程序人软件科技有限责任公司保留所有权利
 *  date:2015-01-12
 *  @license GNU General Public License version 3, or later
 *  check-date:2016-09-27
 *  checker:min.zhang
 */
 
defined('_JEXEC') or die ('You can not access this file!');

jimport('joomla.application.component.controller');


 class zmaxLoginController extends JControllerLegacy
 {
	function redirect2()
	{
		$app = JFactory::getApplication();
		$type = $app->input->get("type","","STRING");
		if($type=="")
		{
			JError::raiseError(JText::_("COM_ZMAXLOGIN_CONTROLLER_TYPE_ERROR"));
			return false;
		}
		$modalName=$type."login";
		$model = $this->getModel($modalName);
		$model->redirectLoginPage();
	}
	
	function callback()
	{
		$app = JFactory::getApplication();
		$type = $app->input->get("type","","STRING");
		
		
		if($type=="")
		{
			JError::raiseError(JText::_("COM_ZMAXLOGIN_CONTROLLER_TYPE_ERROR"));
			return false;
		}
		$modalName=$type."login";
		$model = $this->getModel($modalName);
		$model->callback();
	}
}

?>