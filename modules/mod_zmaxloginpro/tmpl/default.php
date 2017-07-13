<?php
/**
 *	description:ZMAX第三方登陆布局文件文件
 *  author：min.zhang
 *  Email:zhang19min88@163.com
 *	Url:http://www.zmax99.com
 *  copyright:南宁市程序人软件科技有限责任公司保留所有权利
 *  date:2016-11-05
  * @license GNU General Public License version 3, or later
 */
 
 /**
  *  ###### 重要说明 ###### 
  *  # 为了便于升级以及便于第三方开发，ZMAX专门为第三方登陆模块提供通用库，关于库的使用说明，请参考http://www.zmax99.com相关文章
  *  # 如果你要重写本模块，建议不要直接修改代码，而是使用输出覆盖
  *  #  						
  *  #                ZMAX程序人  2015-01-15
  */
  
defined('_JEXEC') or die('you can not access this file!');

$enableSms = $params->get("smslogin","0");
$enableJoomla = $params->get("joomlalogin","0");

//导入公共库
include_once("administrator/components/com_zmaxlogin/libs/zmaxlib/common_function.php");


//获得参数
$width = $params->get('window_width',450);
$height = $params->get('window_height',320);
$window_position_x = $params->get('window_position_x',700);
$window_position_y = $params->get('window_position_y',320);
$window_style = $params->get('window_style','same_window');
$label = $params->get('otherloginlabel'); 
$image_style = $params->get('image_style'); 

$enableSms = $params->get("smslogin","0");
$enableJoomla = $params->get("joomlalogin","0");


$smsLabel = $params->get("smslabel","短信登陆");
$joomlaLabel = $params->get("joomlalabel","账号登陆");
$socialLabel = $params->get("sociallabel","社交账号登陆");

$smsLabelDesc = $params->get("smslabeldesc","使用短信登陆");
$joomlaLabelDesc = $params->get("joomlalabeldesc","使用本站账号登陆");
$socialLabelDesc = $params->get("sociallabeldesc","使用第三方社交账号登陆");

$showLabelDesc = $params->get("showlabeldesc","0");


//获得一个ZMAX登陆前端对象
$zmaxlogin= new zmaxloginFront($width ,$height,$window_position_x ,$window_position_y ,$window_style);
$loginTypes =$zmaxlogin->getLoginTypes();
$config=null;
foreach($loginTypes as $type)
{
	$config[$type]=$params->get($type."login",true);
}
$zmaxlogin->setConfig($config);
$zmaxlogin->setImageStyle($image_style);

JHtml::_('jquery.framework');
$doc = JFactory::getDocument();
$doc->addStyleSheet("media/zmaxlogin/css/system.css");
$doc->addStyleSheet("modules/mod_zmaxloginpro/css/zmaxloginpro.css");
$doc->addScript("media/zmaxlogin/js/system.js");

if($enableSms)
{
	//检查zmax验证码组件是否已经安装了
	$zmaxCaptcha = JComponentHelper::getComponent('com_zmaxcaptcha',true);
	if(!$zmaxCaptcha->enabled)
	{
		$msg = "系统没有安装ZMAX短信验证码系统,无法执行发送短信的功能。请先安装!";
		JFactory::getApplication()->enqueueMessage($msg, 'warning');
		$enableSms = "0";
	}
	else
	{
		include_once("administrator/components/com_zmaxcaptcha/libs/captcha/captchahtml.php");
		//得到插件的配置参数
		$config = ModZmaxLoginproHelper::getLoginConfig("msg");
		if(!$config)
		{
			$msg = "请先安装和配置短信登陆插件";
			JFactory::getApplication()->enqueueMessage($msg, 'warning');
			$enableSms = "0";
		}
		else
		{
			$phoneCaptchaConfig = new phoneCaptchaConfig();
			$phoneCaptchaConfig->template_id = $config->msg_template;
			$phoneCaptchaConfig->time = $config->time;	
			$captcha = new zmaxcaptchaHtml($config);	
		}
	}
}



if($enableSms && $enableJoomla)
{
	require(JModuleHelper::getLayoutPath('mod_zmaxloginpro' ,"default_all"));
}
else
{
	if(!$enableSms && !$enableJoomla)
	{
		require(JModuleHelper::getLayoutPath('mod_zmaxloginpro' ,"default_social"));	
	}
	else if($enableJoomla)
	{
		require(JModuleHelper::getLayoutPath('mod_zmaxloginpro' ,"default_social_joomla"));	
	}
	else if($enableSms)
	{
		require(JModuleHelper::getLayoutPath('mod_zmaxloginpro' ,"default_social_sms"));	
	}	
}
?>
