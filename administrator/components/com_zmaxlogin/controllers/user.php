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

jimport('joomla.application.component.controllerform');

/***
 *  Zmaxlogin 的controller
 *
 */
class ZmaxLoginControllerUser extends JControllerForm
 {
	function users()
	{
		$input = JFactory::getApplication()->input;
		$view = $input->getCmd("view" ,"users");
		$input->set('view' ,$view);
		parent::display();
	}
 }


?>