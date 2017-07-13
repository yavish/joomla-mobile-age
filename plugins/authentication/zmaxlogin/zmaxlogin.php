<?php
/**
 *	description:ZMAX第三方登陆 认证插件
 *  author：min.zhang
 *  Email:zhang19min88@163.com
 *	Url:http://www.zmax99.com
 *  copyright:南宁市程序人软件科技有限责任公司保留所有权利
 *  date:2015-01-15
 * @license GNU General Public License version 3, or later
 */

defined ( '_JEXEC' ) or die ();

class plgAuthenticationZmaxLogin extends JPlugin {


	/**
	 * This method should handle any authentication and report back to the subject
	 *
	 * @access	public
	 * @param   array	$credentials Array holding the user credentials
	 * @param	array   $options	Array of extra options
	 * @param	object	$response	Authentication response object
	 * @return	boolean
	 * @since 1.5
	 */

	function onUserAuthenticate($credentials, $options, & $response)
	{
		jimport('joomla.log.log');
		JLog::addLogger(array('text_file'=>'zmaxlogin.log.php') ,JLOG::ALL ,array('zmax'));
		
		if( strtoupper  ($options['type']) == 'WWW.ZMAX99.COM') 
		{	
			
			$response->type = strtoupper  ($options['type']);
			$response->status = JAuthentication::STATUS_SUCCESS;
			$response->error_message = '';
			Jlog::add("permit ok!",JLOG::DEBUG,'zmax');
			if ($credentials ['uid']) 
			{
				Jlog::add(" uid=".$credentials ['uid'],JLOG::DEBUG,'zmax');
				$user = JUser::getInstance ($credentials ['uid']);
				$response->email = $user->email;
				$response->username = $user->username;
				$response->fullname = $user->name;
				
				if (JFactory::getApplication ()->isAdmin ()) 
				{
					$response->language = $user->getParam ( 'admin_language' );
				}
				else 
				{
					$response->language = $user->getParam ( 'language' );
				}
			} 
			else  
			{
				Jlog::add("UID not exist",JLOG::DEBUG,'zmax');
				$db = JFactory::getDbo ();
				$query = $db->getQuery ( true );
				$query->select ( '*' );
				$query->from ( '#__users' );
				$query->where ( "email='". $credentials ['openid'] . "@www.zmax99.com'"); 
				$db->setQuery ( $query );
				$result = $db->loadObject ();		
				
				if($result) 
				{
					Jlog::add("uid not exist but email ok!",JLOG::DEBUG,'zmax');
					$user = JUser::getInstance ($result->id); 
					$response->email = $user->email;
					$response->username = $user->username;
					$response->fullname = $user->name;
					if (JFactory::getApplication ()->isAdmin ())
					{
						$response->language = $user->getParam ( 'admin_language' );
					} 
					else 
					{
						$response->language = $user->getParam ( 'language' );
					}
				} 
				else  
				{
					Jlog::add("email not exist",JLOG::DEBUG,'zmax');
					
					$response->email = $credentials ['openid'] . '@www.zmax99.com';
					$response->username = $credentials ['username'];
					$response->fullname = $credentials ['fullname'];
					$response->language = 'zh-CN';
					Jlog::add($response->email,JLOG::DEBUG,'zmax');
					Jlog::add($response->username,JLOG::DEBUG,'zmax');
					Jlog::add($response->fullname,JLOG::DEBUG,'zmax');
				}
			}
		}
	}
}


