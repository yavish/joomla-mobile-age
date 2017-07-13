<?php
/**
 *	description:ZMAX第三方登陆系统 扩展控制器
 *  author：min.zhang
 *  Email:zhang19min88@163.com
 *	Url:http://www.zmax99.com
 *  copyright:南宁市程序人软件科技有限责任公司保留所有权利
 *  date:2015-01-20
 * @license GNU General Public License version 3, or later
 */
defined('_JEXEC') or die('');

jimport('joomla.application.component.controllerform');
	
class zmaxloginControllerExtension extends JControllerForm
{

	function save($key = null ,$urlVar = null)
	{
		$data = JRequest::get("post");
		$model = $this->getModel("extension");
		$message ="保存配置失败！";
		$type="Warning";
		if($model->save($data))
		{
			$message = "保存配置成功";
			$type="Message";
		}
		
		$this->setRedirect("index.php?option=com_zmaxlogin&view=extension&id=".$data["id"] ,$message ,$type);
	}
	
}	
	

?>