<?php
/**
 *	description:ZMAX第三方登录 用户信息视图文件
 *  author：min.zhang
 *  Email:zhang19min88@163.com
 *	Url:http://www.zmax99.com
 *  copyright:南宁市程序人软件科技有限责任公司保留所有权利
 *  date:2014-12-01
  * @license GNU General Public License version 3, or later
 */
 
defined('_JEXEC') or die("you can not access this file");

class zmaxloginViewUserInfo extends JViewLegacy
{
	protected $data;
	protected $form;
	protected $params;
	protected $state;
	public $returnUrl;

	public function display($tpl = null)
	{
		$info = $this->get('UserInfo');
		$this->getReturnUrl();
		$this->getComponentInfo();
		$this->userInfo	= $info;
		return parent::display($tpl);
	}
	
	protected function getReturnUrl()
	{
		$app = JFactory::getApplication();
		$returnURL = $app->input->get("returnURL","BASE64");
		$returnURL = base64_decode($returnURL);
		
		if (!JUri::isInternal($returnURL))
		{
			$returnURL = 'index.php?option=com_users&view=profile';
		}
		$this->returnURL = $returnURL;
	}
	
	protected function getComponentInfo()
	{
		$app = JFactory::getApplication();
		$this->view = $app->input->get('view',"userinfo","CMD");	
		$this->option = $app->input->get('option',"com_zmaxlogin","CMD");		
	}
	

	
}
