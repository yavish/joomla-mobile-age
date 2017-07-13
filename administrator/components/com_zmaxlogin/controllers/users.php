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
 
defined('_JEXEC') or die ('Restricted Access');

jimport('joomla.application.component.controlleradmin');

/***
 *  Zmaxlogin 的controller
 *
 */
 class ZmaxloginControllerUsers extends JControllerAdmin
 {
	public function getModel($name = 'user' ,$prefix = 'ZmaxloginModel' ,$config = array())
	{
		return parent::getModel($name , $prefix ,$config);
	}
	 
	function users()
	{
		$input = JFactory::getApplication()->input;
		$view = $input->getCmd('view' ,"users");
		$this->setView($view);
		parent::display();
	}
	
 }


?>