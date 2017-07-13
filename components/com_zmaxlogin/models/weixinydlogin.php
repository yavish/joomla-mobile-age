<?php
/**
 *	description:ZMAX第三方登陆 微信登陆[移动端]模型
 *  author：min.zhang
 *  Email:zhang19min88@163.com
 *	Url:http://www.zmax99.com
 *  copyright:南宁市程序人软件科技有限责任公司保留所有权利
 *  date:2016-06-22
 */
 
defined('_JEXEC') or die ('You can not access this file');
jimport('joomla.application.component.modellist');
include_once("components/com_zmaxlogin/models/zmaxlogin.php");


class zmaxloginModelWeixinydlogin extends zmaxloginModelzmaxlogin
{
	protected $_type="weixinyd";
	
	public function redirectLoginPage()
	{
		if (! function_exists ( 'curl_init' )) {
				zmaxloginHelper::zmaxlog( '您的服务器不支持 PHP 的 Curl 模块，请安装或与服务器管理员联系。');
			exit ();
		}

		$config=$this->loadConfig();
		
		
		// 生成state并存入SESSION，以供CALLBACK时验证使用
		$state = uniqid ( 'weixinyd_', true );
		$_SESSION ['zmaxlogin_weixin'] = $state;
		
		$login_url="https://open.weixin.qq.com/connect/oauth2/authorize?appid=".$config["appid"]."&redirect_uri=".$config["callback"]."&response_type=code&scope=".$config["scope"]."&state=".$state."#wechat_redirect";
		
		//$login_url="https://open.weixin.qq.com/connect/qrconnect?appid=".$config["app_key"]."&redirect_uri=".$config["callback"]."&response_type=code&scope=snsapi_login&state=".$state."#wechat_redirect";
		
		header("Location:$login_url");

	}
	
	public function loadConfig()
	{
		if(empty($this->_config))
		{
			$config = parent::loadConfig();
			
			$strAppid = $config->weixinyd_appid;
			$strAppsecret = $config->weixinyd_secret;
			$strAppscope = $config->weixinyd_scope;
			
			$this->getCallBack();
			
			$this->_config["appid"]=$strAppid;
			$this->_config["secret"]=$strAppsecret;
			$this->_config["scope"]=$strAppscope;
			$this->_config["callback"]=UrlEncode($this->_callback);			
		}
		return $this->_config;
	}
	
	public function getUserInfo()
	{
		$r = $this->getAccessToken();
		$token=$r->access_token;
		$openid = $r->openid;
		$user_url="https://api.weixin.qq.com/sns/userinfo?access_token=".$token."&openid=".$openid."&lang=zh_CN";
		$response = file_get_contents($user_url);
		$user = json_decode($response);

		$this->_3part_id = $user->openid;
		$this->_3part_image_url = $user->headimgurl;
		$this->_3part_params=serialize($user);
		$this->_3part_username=$user->nickname;

	}
	
	
	//获得访问令牌
	public function _callback()
	{
		
	}
	
	protected function getAccessToken()
	{
		$config = $this->loadConfig();
		$code = JRequest::getVar("code");
		$token_url="https://api.weixin.qq.com/sns/oauth2/access_token?appid=".$config["appid"]."&secret=".$config["secret"]."&code=".$code."&grant_type=authorization_code";
		echo $token_url;
		$response = file_get_contents($token_url);
		$r = json_decode($response);
		if( $r->access_token)
		{
			return $r;		
		}

	}

}