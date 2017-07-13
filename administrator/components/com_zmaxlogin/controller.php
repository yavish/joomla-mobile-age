<?php
/**
 *	description:ZMAX第三方登陆系统 主控制器文件
 *  author：min.zhang
 *  Email:zhang19min88@163.com
 *	Url:http://www.zmax99.com
 *  copyright:南宁市程序人软件科技有限责任公司保留所有权利
 *  date:2015-01-12
 * @license GNU General Public License version 3, or later
 */
 
defined('_JEXEC') or die('Restricted access');

jimport('joomla.application.component.controller');

class zmaxLoginController extends JControllerLegacy
{
	
	function display($cachable = false,$urlparams = false)
	{
		// set default view if not set
		$input = JFactory::getApplication()->input;
		$input ->set('view',$input->getCmd('view','main'));
		
		// call parent behavior
		parent::display($cachable);
	}	
}