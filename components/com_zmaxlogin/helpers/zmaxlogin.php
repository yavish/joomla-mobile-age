<?php
/**
 *	description:ZMAX第三方登陆 帮助文件
 *  author：min.zhang
 *  Email:zhang19min88@163.com
 *	Url:http://www.zmax99.com
 *  copyright:南宁市程序人软件科技有限责任公司保留所有权利
 *  date:2014-12-24
 * @license GNU General Public License version 3, or later
 */

defined('_JEXEC') or die;

jimport('joomla.log.log');
JLog::addLogger(array('text_file'=>'zmaxlogin.log.php') ,JLOG::ALL ,array('zmax'));


abstract class zmaxloginHelper
{
	public static $extension = 'com_zmaxlogin';

	public static function zmaxlog($text)
	{
		if(defined('ZMAX_DEBUG'))
		{
			JLog::add($text ,JLOG::DEBUG,'zmax');	
		}
	}
	public static function needModifyEmail($email ,$openid)
	{
		if(strpos($email,"@www.zmax99.com") === false && strpos($email,$openid) === false )
		{
			return false;
		}
		else
		{
			return true;
		}
	}
	
	public static function sendEmail()
	{
		
		//从后台设置获得Email的信息
		$params = JComponentHelper::getParams("com_zmaxlogin");
		
		$enableEmail = $params->get("enable_email",1);
		if(!$enableEmail)
		{
			return true;
		}
		
		$defaultSubject = "ZMAX第三方账号注册网站";
		$defaultBody ="管理员你好，有一个用户使用第三方账号注册了你的网站!";
		
		$subject = $params->get("email_subject" ,$defaultSubject);
		$body = $params->get("email_body",$defaultBody);
		
		//格式化Email的标题 和 主题
		// to do
		
		
		
		$params = JComponentHelper::getParams("com_users");
		if (($params->get('useractivation') < 2) && ($params->get('mail_to_admin') == 1))
		{
			// Get all admin users
			
			$db = JFactory::getDbo();
			$query = $db->getQuery(true);
			$query->clear()
				->select($db->quoteName(array('name', 'email', 'sendEmail')))
				->from($db->quoteName('#__users'))
				->where($db->quoteName('sendEmail') . ' = ' . 1);

			$db->setQuery($query);
			try
			{
				$rows = $db->loadObjectList();
			}
			catch (RuntimeException $e)
			{
				return false;
			}

			// Send mail to all superadministrators id
			$recipient = array();
			foreach ($rows as $row)
			{				
				$recipient[]=$row->email;
			}
			if(count($recipient))
			{
				$config = JFactory::getConfig();
				$mailer = JFactory::getMailer();
				$sender = array(
					$config->get('config.mailfrom'),
					$config->get('config.fromname')
				);
				$mailer->setSender($sender);
				$mailer->addRecipient($recipient );
				$mailer->setSubject($subject);
				$mailer->setBody($body);
				$return = $mailer->Send();
				
				// Check for an error.
				if ($return !== true)
				{
					zmaxlog('Error sending email:'.$send->__toString(),JLOG::WARNING);
					return false;
				}
			}
		
		}
		return true;
	}

}
