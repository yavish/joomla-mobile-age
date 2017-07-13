<?php
/**
 *	description:ZMAX第三方登陆 登陆模型
 *  author：min.zhang
 *  Email:zhang19min88@163.com
 *	Url:http://www.zmax99.com
 *  copyright:南宁市程序人软件科技有限责任公司保留所有权利
 *  date:2015-01-15
 *  check-date :2016-09-28
 *  checker :min.zhang
 * @license GNU General Public License version 3, or later
 */
 
defined('_JEXEC') or die ('You can not access this file');

jimport('joomla.application.component.modellist');

/**
 *  所有的第三方登陆插件必须派生自这个类
 *
 *  该类为虚类，不可直接创建对象
 */
abstract class zmaxloginModelzmaxlogin extends JModelLegacy{

	protected $_zmax_permit="www.zmax99.com";//ZMAX通行证
	protected $_type="";//登陆的类型
	protected $_3part_id="";//第三方能够辨明身份的唯一id
	protected $_3part_params="";//第三方参数
	protected $_3part_image_url="";//第三方的用户图像地址
	protected $_joomla_id="";//joomla的id
	protected $_3part_username="";//第三方的用户名
	protected $_joomla_username="";//joomla的用户名
	protected $_password ="zmax99";//Joomla默认密码
	protected $_userEmail="";//用户Email
	protected $_credentials=array();//认证信息
	protected $_options=array();//认证的附加信息
	
	protected $_suffix="zmax";//用户名的后缀
	protected $_prefix="";//用户名的前缀
	
	protected $_returnUrl="";//登陆完成后返回的地址
	protected $_userInfoUrl="";
	protected $_url="";//最终url
	protected $_config=array();//配置参数
	protected $_callback;//回调地址
	
	protected $_develop_model=false;//是否是开发调试模式
	
	
	//重定向到登陆页面 ，由子类实现
	abstract	public  function redirectLoginPage();
	
	
		
	
	//子类的callback
	abstract	public  function _callback();
	
	//获得用户信息 
	/**
	 *	子类在这个函数中应该完成设置 
	   # 	$_3part_id
	   #	$_3part_params
	   #	$_3part_username
	   #    $_3Path_image_url
	 */
	abstract public  function getUserInfo();
	
	
	
	public  function loadConfig()
	{
		$db = JFactory::getDBO();
		$query = $db->getQuery(true);
		$query->select("params");
		$query->from("#__zmax_extension");
		$query->where("logintype='".$this->_type."'");
		$db->setQuery($query);
		$result = $db->loadResult();
		$config = json_decode($result);
		return $config;
	}
	
	
	/**
	 *  核心的登陆流程封装
	 * 
	 *  同服务器进行交互 获得新信息
	 **/
	public function callback()
	{
		$app = JFactory::getApplication();
		
		//STEP 1 执行子类的callback 同第三方服务器进行交互
		$this->_callback();
		
		//STEP 2 填写需要的用户信息
		$this->getUserInfo();
		
		if($this->_develop_model)
		{
			$app->enqueueMessage(JText::_('COM_ZMAXLOGIN_MODEL_ZMAXLOGIN_DEVELOP_MODEL'), 'notice');
			return false;
		}
		//STEP 3 判断用户是否注册
		$user = $this->getRegisterUser();
		if($user)
		{
			$this->_credentials['uid']=$user->joomla_uid;
		}
		else
		{
			$this->storeUser();
			zmaxloginHelper::sendEmail();
			$this->triggerAfterSaveEvent();
			zmaxloginHelper::zmaxlog(JText::_('COM_ZMAXLOGIN_MODEL_ZMAXLOGIN_EVENT_AFTER_SAVE'));
		}
		
		//STEP 4 准备认证的参数
		$this->preparOptions();
		$this->preparCredentials();
		
		//STEP 5 执行认证
		if(true == $app->login($this->_credentials ,$this->_options))
		{
			$this->bindJoomlaUser();
			zmaxloginHelper::zmaxlog(JText::_('COM_ZMAXLOGIN_MODEL_ZMAXLOGIN_LOGIN_SUCCESS'));
		}
		else
		{
			zmaxloginHelper::zmaxlog(JText::_('COM_ZMAXLOGIN_MODEL_ZMAXLOGIN_LOGIN_FAILED'));
			$app->enqueueMessage(JText::_('COM_ZMAXLOGIN_MODEL_ZMAXLOGIN_LOGIN_FAILED'), 'error');
		}

		//STEP 6 判断返回	
		
		$this->_url = $this->getReturnUrl();
		zmaxloginHelper::zmaxlog("success_returnurl:".$this->_returnUrl);
		$this->getUserInfoUrl();
		
		if(zmaxloginHelper::needModifyEmail($this->_userEmail ,$this->_3part_id))
		{
			$this->_url = $this->_userInfoUrl;
		}
		zmaxloginHelper::zmaxlog("final_url:".$this->_url);
		$this->triggerBeforeReturn();
		zmaxloginHelper::zmaxlog(JText::_('COM_ZMAXLOGIN_MODEL_ZMAXLOGIN_EVENT_BEFORE_RETURN'));
		zmaxloginHelper::zmaxlog(JText::_('COM_ZMAXLOGIN_MODEL_ZMAXLOGIN_LOGIN_FILISHED'));
		
		//STEP 7 关闭窗口
		$this->closeWindow();
	}
	
	
	
	/*************************************************************************************************************************/
	/*																														 */				
	/************************************* protected  function ***************************************************************/
	/*																														 */			
	/*************************************************************************************************************************/
	
	/**
	 * 功能：得到回调地址
	 *  
	 * 修改日期：2016-11-03
				使用media文件来存放图片文件
	 */
	 protected function getCallBack()
	 {
		$siteBase = JURI::root(); //http://www.zmax99.com/ 
		$this->_3part_image_url=$siteBase."media/zmaxlogin/images/zmaxdefault_user.gif";
		$this->_callback=$siteBase."index.php?option=com_zmaxlogin&task=callback&type=".$this->_type; 
	 }
	 
	/**
	 *	功能：判断当前用户是否是一个已经注册的用户，如果不是返回 NULL,如果是返回 当前对象
	 */
	protected function getRegisterUser()
	{
		$db = JFactory::getDbo();
		$query = $db->getQuery(true);
		$query->select('*')->from('#__zmax_users')->where("uid = '".$this->_3part_id."'" );
		$query->where("type ='".$this->_type."'");//第三方的uid字符串有可能相同，因此需要针对type来过滤
		$db->setQuery($query);
		$user = $db->loadObject();
		return $user;
	}
	
	/**
	 *	功能：存储当前第三方用户信息到数据库
	 *  返回： 插入记录的ID
	 *  修改日期： 2016-11-03
				   使用Joomla 数据库API来重新
	 */
	 protected function storeUser()
	 {
		$db = JFactory::getDbo();
		$timestamp = time();
		$item = new stdclass();
		$item->uid = $this->_3part_id;
		$item->timestamp = $timestamp;
		$item->type = $this->_type;
		$item->nickname = $this->_3part_username;
		$item->image_url = $this->_3part_image_url;
		$item->params = $this->_3part_params;
		//$sql = "INSERT INTO #__zmax_users (uid,timestamp,type,nickname,image_url,params) VALUES ('$this->_3part_id','$timestamp','$this->_type' ,'$this->_3part_username' ,'$this->_3part_image_url' ,'$this->_3part_params')";		
		$db->insertObject("#__zmax_users",$item ,"id");
		return $db->insertId();		
	 }
	 
	 
	 /**
	  *	功能：绑定一个Joomla用户
	  * 
	  * 修改日期：2016-11-03
				优化这里的执行逻辑
					并不需要每次都执行 理论上只需要写数据库一次即可
					
			TO DO  [v3.0.6  继续使用老的逻辑 下一版本执行这个优化]
	  */
	  protected function bindJoomlaUser()
	  {
		$user	= JFactory::getUser();
		$this->_joomla_id = $user->id;
		$this->_userEmail=$user->email;
		zmaxloginHelper::zmaxlog("bindJoomlaUser ".$this->_joomla_id);
		$db = JFactory::getDbo ();
		$db->setQuery("UPDATE #__zmax_users SET joomla_uid='{$this->_joomla_id}' WHERE uid='{$this->_3part_id}'");
		zmaxloginHelper::zmaxlog("bindJoomlaUser sql"."UPDATE #__zmax_users SET joomla_uid='{$this->_joomla_id}' WHERE uid='{$this->_3part_id}'");
		$db->query();
	  }
	  
	  /**
	   * 功能：得到Joomla用户名
	   */
	  protected function getJoomlaUserName()
	  {
		  $params = JComponentHelper::getParams("com_zmaxlogin",true);
		  $this->_suffix = $params->get("name_suffix");
		  $this->_prefix = $params->get("name_prefix");
		  $this->_joomla_username = $this->_prefix.time().rand(0,9999).$this->_suffix;
	  }
	  
	  /**
	   *  功能:得到返回URL
	   *  
	   *  返回 ： 返回url的值
	   * 
	   *  修改日期：2016-11-03
					设置如果找不到成功返回url，那么就直接返回网站的首页
	   
	   * 说明：
			此处使用session来完成。那么需要注意session 存储数据的用户名   
	   */
	   protected function getReturnUrl()
	   {
		  $app = JFactory::getApplication();
		  
		  $this->_returnUrl =  $app->getUserState('zmax.success_returnURL',"");
		  if($this->_returnUrl=="")
		  {
			  //如果找不到 ,那么默认返回网站的首页
			  $defaultReturnUrl = JUri::root();
			  $this->_returnUrl = $defaultReturnUrl;
		  }
		  
		  return $this->_returnUrl;
	   }
	   
	   /**
	    *	功能：得到修改用户信息URL
		*     
		*   修改日期： 2016-11-03
			将返回url执行base64加密，解决在未开始sef情况下 找不到试图的bug
		*  
		*/
		protected function getUserInfoUrl()
		{	
			$this->_userInfoUrl=JUri::root()."index.php?option=com_zmaxlogin&view=userinfo&uid=".$this->_joomla_id."&returnURL=".base64_encode($this->_returnUrl)."&".JSession::getFormToken()."=1"; //修改用户信息的URL
		}
	   
	  
	  /**
	   * 功能：准备认证信息
	   */
	   protected function preparCredentials()
	   {
			$this->getJoomlaUserName();
			$this->_credentials['openid'] = $this->_3part_id;
			$this->_credentials['username']=$this->_joomla_username;//不可重复
			$this->_credentials['fullname']=$this->_3part_username; //可重复
			$this->_credentials['password']=$this->_password;
	   }
	   
	   /**
	    * 功能:准备其他选项
		*/
		protected function preparOptions()
		{
			$this->_options['type'] =$this->_zmax_permit;
		}
	  
	  /**
	   * 功能：触发事件 onZmaxLoginAfterSave
	   */
	   protected function triggerAfterSaveEvent()
	   {
			JPluginHelper::importPlugin('zmaxlogin');
			$dispatcher = JEventDispatcher::getInstance();
			$dispatcher->trigger('onZmaxLoginAfterSave' ,array($this->_3part_id,$this->_type,$this->_3part_params));			
	   }
		
	  /**
	   *  功能：触发事件 onZmaxLoginBeforeReturn   
	   */
	   protected function triggerBeforeReturn()
	   {
			JPluginHelper::importPlugin('zmaxlogin');
			$dispatcher = JEventDispatcher::getInstance();
			$dispatcher->trigger('onZmaxLoginBeforeReturn' ,array($this->_3part_id,$this->_type,&$this->_url));
	   }
	   
	   /**
	    *	功能：关闭第三方认证窗口
		*   
		*   修改日期：2016-11-03
				解决移动设备下无法正常跳转的问题  默认情况下使用same_window 进行窗口的关闭
				这个函数经常出现问题
				
			注意：这里同样使用session来存储设置参数，因此需要注意session的设置变量
		*/
		protected function closeWindow()
		{
			$app = JFactory::getApplication();
			$window_style= $app->getUserState('zmax.window_style',"same_window");	
			if($window_style=="same_window") 
			{
				$app->redirect(JRoute::_($this->_url), false);
			}
			else
			{
				exit('<script>opener.location.href="'.$this->_url.'";window.close();</script>');	
			}
		}
}