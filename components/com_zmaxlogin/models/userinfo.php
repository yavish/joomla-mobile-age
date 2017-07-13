<?php
/**
 *	description:ZMAX第三方登陆系统  用户模型
 *  author：min.zhang
 *  Email:zhang19min88@163.com
 *	Url:http://www.zmax99.com
 *  copyright:南宁市程序人软件科技有限责任公司保留所有权利
 *  date:2014-12-03
 * @license GNU General Public License version 3, or later
 */
 
defined('_JEXEC') or die ('You can not access this file');
jimport('joomla.application.component.modellist');

class zmaxloginModelUserinfo extends JModelLegacy{

	public function getUserInfo()
	{
		JSession::checkToken('get' ) or die( 'Invalid Token' );
		$uid = JRequest::getInt("uid");
		$db = JFactory::getDbo();
		$query = $db->getQuery(true);
		$query->select('*')->from($db->quoteName('#__zmax_users'))->where($db->quoteName("joomla_uid")."=".$db->quote($uid));
		$db->setQuery($query);
		$result = $db->loadObject();
		
		//$uid = JRequest::getInt("uid");
		//$user = JUser::getInstance();
		//$user->load($uid);
		$db = JFactory::getDBO();
		$query = $db->getQuery(true);
		$query->select("*")->from("#__users")->where("id=".$uid);
		$db->setQuery($query);
		$user = $db->loadObject();
		
		$result->username=$user->name;
		
		return $result;
	}

	public  function save()
    {
	   // Check for request forgeries.
	   JSession::checkToken() or jexit(JText::_('JINVALID_TOKEN'));
	   $user_type= JRequest::getVar("user_type","new" );
	   if($user_type == "new")
	   {
			return $this->update();
			$this->updateUserGroup($joomla_uid);
	   }
	   else
	   {
			return $this->bind();
	   }
	  
       return 0;         		   
	}
	
	protected function bind()
	{
		JSession::checkToken() or jexit(JText::_('JINVALID_TOKEN'));
		$userName = JRequest::getVar("bind_username");
		$passWord = JRequest::getVar("password");
		$joomla_uid = JRequest::getVar("joomla_uid");
		
		$db = JFactory::getDBO();
		$result = $this->_testUser($userName ,$passWord);
		if($result)
		{
			$query = $db->getQuery(true);
			$query->select("*")->from($db->quoteName("#__users"))->where($db->quoteName("username")."=".$db->quote($userName));
			$db->setQuery($query);
			$id = $db->loadResult();
			
			$db->setQuery("UPDATE #__zmax_users SET joomla_uid='{$id}' WHERE  joomla_uid='{$joomla_uid}' ");
			$db->query();
			
			$db->setQuery("DELETE FROM #__users WHERE id= '{$joomla_uid}'");
			$db->query();
			
			return 0;
			
		}
		{
			return 3;
		}
	}
	
	protected function _testUser($userName ,$passWord)
	{
		$options="";
		$credentials['username']=$userName;
		$credentials['password']=$passWord;
		$app = JFactory::getApplication();
		if(true == $app->login($credentials ,$options))
		{
			return true;
		}
		else
		{
			return false;
		}
	}
	
	protected function update()
	{
	   $joomla_uid = JRequest::getInt("joomla_uid");
	   
	   $email = JRequest::getVar("email");
	  
	  
		if( ! $this->emailValid($email))
		{
		   return 2;//Email不可用
		}
		$user = JUser::getInstance();
		$user->load($joomla_uid);
		$user->set('email',$email);
		$user->save();
      
		return 0;
	}
	
	//这里可能会多次执行
	protected function updateUserGroup($uid)
	{
		
		$app = JFactory::getApplication();
		
		$params = $app->getParams();
		$newer_usergroup = $params->get("newer_usergroup","");
		
		$params = JComponentHelper::getParams('com_users');
		$default_usergroup = $params->get("new_usertype");
		
		if($newer_usergroup=="")
		{
			$newer_usergroup=$default_usergroup;
		}
		
		$db = JFactory::getDbo ();
        $db->setQuery("UPDATE #__user_usergroup_map SET group_id='{$newer_usergroup}' WHERE  user_id='{$uid}' ");
        $db->query();	
	
	}
	
    public function emailValid($email)
	
    {
		$db = JFactory::getDbo ();
		$query = $db->getQuery(true);
		$query->select($db->quoteName("id"))->from($db->quoteName("#__users"))->where($db->quoteName("email") ."=".$db->quote($email));
		$db->setQuery($query);
		$result = $db->loadObject();
        if($result) 
		{
			return false; 
		}
        return true;
	}
          
        
           	

}