<?php
/**
 *	description:ZMAX第三方登陆系统 激活控制器
 *  author：min.zhang
 *  Email:zhang19min88@163.com
 *	Url:http://www.zmax99.com
 *  copyright:南宁市程序人软件科技有限责任公司保留所有权利
 *  date:2015-03-10
  * @license GNU General Public License version 3, or later
 */
defined('_JEXEC') or die('');

jimport('joomla.application.component.controllerform');
jimport('joomla.filesystem.file');
	
class zmaxloginControllerActive extends JControllerLegacy
 {
	protected $_certPath;
	
	function __construct()
	{
		$this->_certPath =JPath::clean(JPATH_COMPONENT_ADMINISTRATOR."/zmaxlogin.cert");
		parent::__construct();
	}

	function active()
	{
		$params = JComponentHelper::getParams('com_zmaxlogin');
		$active_type = $params->get("active_type");
		$active_email =  $params->get("active_email");
		$active_code = $params->get("active_code");
		$active_domain = $params->get("active_domain");
		
	
		$fields=array(
			'active_type'=>urlencode($active_type),
			'active_email'=>urlencode($active_email),
			'active_domain'=>urlencode($active_domain),
			'active_code'=>urlencode($active_code)
		);
		
		$url ="http://www.zmax99.com/index.php?option=com_download&task=active.permitActive&token=zmax99";
		
		$result = $this->execPostRequest($url,$fields);
		$result = JString::ltrim($result);
		echo $result;
		$state = JString::substr($result,0,6);
		$message="产品激活未完成，请检查你填入的信息是否正确！";
		if($state=="ZMAXOK")
		{
			$message="产品成功激活";
		}
		JFile::write($this->_certPath ,$result);
		$this->setRedirect("index.php?option=com_zmaxlogin&view=install" ,$message );
	}
	
	
	
	function execPostRequest($url,$fields)
	{
		if(empty($url)){ return false;}
		$fields_string="";
		foreach($fields as $key=>$value) { $fields_string .= $key.'='.$value.'&'; }
		rtrim($fields_string,'&');		
		$ch = curl_init();
		curl_setopt($ch,CURLOPT_URL,$url);
		curl_setopt($ch,CURLOPT_POST,count($fields));
		curl_setopt($ch,CURLOPT_POSTFIELDS,$fields_string);
		curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);
		$result = curl_exec($ch);
		curl_close($ch);
		return $result;
}
 }	
	

?>