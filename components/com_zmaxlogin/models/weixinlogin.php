<?php
/**
 *	description:ZMAX第三方登陆 微信登陆模型
 *  author：min.zhang
 *  Email:zhang19min88@163.com
 *	Url:http://www.zmax99.com
 *  copyright:南宁市程序人软件科技有限责任公司保留所有权利
 *  date:2015-01-12
 */
 
defined('_JEXEC') or die ('You can not access this file');
jimport('joomla.application.component.modellist');
include_once("components/com_zmaxlogin/models/zmaxlogin.php");


class zmaxloginModelWeixinlogin extends zmaxloginModelzmaxlogin
{
	protected $_type="weixin";
	
	public function redirectLoginPage()
	{
		if (! function_exists ( 'curl_init' )) {
				zmaxloginHelper::zmaxlog( '您的服务器不支持 PHP 的 Curl 模块，请安装或与服务器管理员联系。');
			exit ();
		}

		$config=$this->loadConfig();
		
		
		// 生成state并存入SESSION，以供CALLBACK时验证使用
		$state = uniqid ( 'weixin_', true );
		$_SESSION ['zmaxlogin_weixin'] = $state;
		
		$login_url="https://open.weixin.qq.com/connect/qrconnect?appid=".$config["app_key"]."&redirect_uri=".$config["callback"]."&response_type=code&scope=snsapi_login&state=".$state."#wechat_redirect";
		
		header("Location:$login_url");

	}
	
	public function loadConfig()
	{
		if(empty($this->_config))
		{
			$config = parent::loadConfig();
			
			$strApikey = $config->weixin_appid;
			$strSecretkey = $config->weixin_appsecret;
			$this->getCallBack();
			
			$this->_config["app_key"]=$strApikey;
			$this->_config["app_secret"]=$strSecretkey;
			$this->_config["callback"]=UrlEncode($this->_callback);			
		}
		return $this->_config;
	}
	
	public function getUserInfo()
	{
		$r = $this->getAccessToken();
		$token=$r->access_token;
		$openid = $r->openid;
		$user_url="https://api.weixin.qq.com/sns/userinfo?access_token=".$token."&openid=".$openid;
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
		$token_url="https://api.weixin.qq.com/sns/oauth2/access_token?appid=".$config["app_key"]."&secret=".$config["app_secret"]."&code=".$code."&grant_type=authorization_code";
		$response = file_get_contents($token_url);
		$r = json_decode($response);
		if( $r->access_token)
		{
			return $r;		
		}

	}

}