<?php
/**
 *	description:ZMAX第三方登陆系统 用户模型文件
 *  author：min.zhang
 *  Email:zhang19min88@163.com
 *	Url:http://www.zmax99.com
 *  copyright:南宁市程序人软件科技有限责任公司保留所有权利
 *  date:2014-11-22
 * @license GNU General Public License version 3, or later
 */
 
defined('_JEXEC') or die();

jimport('joomla.application.component.modeladmin');

class zmaxloginModelUser extends JModelAdmin
{
	public function getForm( $data = array() , $loadData = true)
	{
		//Get the form
		$form = $this->loadForm('com_zmaxlogin.user' ,'user' ,array('control' =>' jform' ,'load_data' => $loadData ));
		if(!$form)
		{
			return false;
		}
		
		return $form;
	}
	
	public function loadFormData()
	{
		//Load form data
		$data = $this->getItem();
		return $data;
	}
	
}


?>