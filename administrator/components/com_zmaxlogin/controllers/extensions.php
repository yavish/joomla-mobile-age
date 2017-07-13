<?php
/**
 *	description:ZMAX第三方登陆系统 扩展列表控制器
 *  author：min.zhang
 *  Email:zhang19min88@163.com
 *	Url:http://www.zmax99.com
 *  copyright:南宁市程序人软件科技有限责任公司保留所有权利
 *  date:2015-01-20
 * @license GNU General Public License version 3, or later
 */
 
 defined('_JEXEC') or die('Restricted access');
 
jimport('joomla.application.component.controlleradmin');

class zmaxloginControllerExtensions extends JControllerAdmin
 {
	 public function getModel($name = 'extension' ,$prefix = 'zmaxloginModel' ,$config = array())
	 {
		return parent::getModel($name , $prefix ,$config);
	 }
	 
	 public function uninstall()
	 {
		$model = $this->getModel("install");
		
		$message =JText::_("COM_ZMAXLOGIN_EXTENSION_UNINSTALL_FAILED");
		$returnUrl = "index.php?option=com_zmaxlogin&view=extensions";
		if($model->uninstall())
		{
			$message =JText::_("COM_ZMAXLOGIN_EXTENSION_UNINSTALL_SUCCESS");	
		}
		$this->setRedirect($returnUrl ,$message);
	 }
	 
	 public function install()
	 {
		JSession::checkToken() or jexit(JText::_('JINVALID_TOKEN'));
		$model = $this->getModel('install');
		$message =JText::_("COM_ZMAXLOGIN_EXTENSION_INSTALL_FAILED");
		if ($model->install())
		{
			$message =JText::_("COM_ZMAXLOGIN_EXTENSION_INSTALL_SUCCESS");
			$desc = $model->getDescription();			
			if(!empty($desc))
			{
				$message = $message."<br/>".$desc;
			}
		}

		$redirect_url = JRoute::_('index.php?option=com_zmaxlogin&view=extensions', false);
		$this->setRedirect($redirect_url,$message);
	 }
	 public function extensions()
	 {
		$redirect_url = JRoute::_('index.php?option=com_zmaxlogin&view=extensions', false);
		$this->setRedirect($redirect_url);
	 }
 }	
	

?>