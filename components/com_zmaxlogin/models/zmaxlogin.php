<?php
/**
 *	description:ZMAX��������½ ��½ģ��
 *  author��min.zhang
 *  Email:zhang19min88@163.com
 *	Url:http://www.zmax99.com
 *  copyright:�����г���������Ƽ��������ι�˾��������Ȩ��
 *  date:2015-01-15
 *  check-date :2016-09-28
 *  checker :min.zhang
 * @license GNU General Public License version 3, or later
 */
 
defined('_JEXEC') or die ('You can not access this file');

jimport('joomla.application.component.modellist');

/**
 *  ���еĵ�������½������������������
 *
 *  ����Ϊ���࣬����ֱ�Ӵ�������
 */
abstract class zmaxloginModelzmaxlogin extends JModelLegacy{

	protected $_zmax_permit="www.zmax99.com";//ZMAXͨ��֤
	protected $_type="";//��½������
	protected $_3part_id="";//�������ܹ�������ݵ�Ψһid
	protected $_3part_params="";//����������
	protected $_3part_image_url="";//���������û�ͼ���ַ
	protected $_joomla_id="";//joomla��id
	protected $_3part_username="";//���������û���
	protected $_joomla_username="";//joomla���û���
	protected $_password ="zmax99";//JoomlaĬ������
	protected $_userEmail="";//�û�Email
	protected $_credentials=array();//��֤��Ϣ
	protected $_options=array();//��֤�ĸ�����Ϣ
	
	protected $_suffix="zmax";//�û����ĺ�׺
	protected $_prefix="";//�û�����ǰ׺
	
	protected $_returnUrl="";//��½��ɺ󷵻صĵ�ַ
	protected $_userInfoUrl="";
	protected $_url="";//����url
	protected $_config=array();//���ò���
	protected $_callback;//�ص���ַ
	
	protected $_develop_model=false;//�Ƿ��ǿ�������ģʽ
	
	
	//�ض��򵽵�½ҳ�� ��������ʵ��
	abstract	public  function redirectLoginPage();
	
	
		
	
	//�����callback
	abstract	public  function _callback();
	
	//����û���Ϣ 
	/**
	 *	���������������Ӧ��������� 
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
	 *  ���ĵĵ�½���̷�װ
	 * 
	 *  ͬ���������н��� �������Ϣ
	 **/
	public function callback()
	{
		$app = JFactory::getApplication();
		
		//STEP 1 ִ�������callback ͬ���������������н���
		$this->_callback();
		
		//STEP 2 ��д��Ҫ���û���Ϣ
		$this->getUserInfo();
		
		if($this->_develop_model)
		{
			$app->enqueueMessage(JText::_('COM_ZMAXLOGIN_MODEL_ZMAXLOGIN_DEVELOP_MODEL'), 'notice');
			return false;
		}
		//STEP 3 �ж��û��Ƿ�ע��
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
		
		//STEP 4 ׼����֤�Ĳ���
		$this->preparOptions();
		$this->preparCredentials();
		
		//STEP 5 ִ����֤
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

		//STEP 6 �жϷ���	
		
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
		
		//STEP 7 �رմ���
		$this->closeWindow();
	}
	
	
	
	/*************************************************************************************************************************/
	/*																														 */				
	/************************************* protected  function ***************************************************************/
	/*																														 */			
	/*************************************************************************************************************************/
	
	/**
	 * ���ܣ��õ��ص���ַ
	 *  
	 * �޸����ڣ�2016-11-03
				ʹ��media�ļ������ͼƬ�ļ�
	 */
	 protected function getCallBack()
	 {
		$siteBase = JURI::root(); //http://www.zmax99.com/ 
		$this->_3part_image_url=$siteBase."media/zmaxlogin/images/zmaxdefault_user.gif";
		$this->_callback=$siteBase."index.php?option=com_zmaxlogin&task=callback&type=".$this->_type; 
	 }
	 
	/**
	 *	���ܣ��жϵ�ǰ�û��Ƿ���һ���Ѿ�ע����û���������Ƿ��� NULL,����Ƿ��� ��ǰ����
	 */
	protected function getRegisterUser()
	{
		$db = JFactory::getDbo();
		$query = $db->getQuery(true);
		$query->select('*')->from('#__zmax_users')->where("uid = '".$this->_3part_id."'" );
		$query->where("type ='".$this->_type."'");//��������uid�ַ����п�����ͬ�������Ҫ���type������
		$db->setQuery($query);
		$user = $db->loadObject();
		return $user;
	}
	
	/**
	 *	���ܣ��洢��ǰ�������û���Ϣ�����ݿ�
	 *  ���أ� �����¼��ID
	 *  �޸����ڣ� 2016-11-03
				   ʹ��Joomla ���ݿ�API������
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
	  *	���ܣ���һ��Joomla�û�
	  * 
	  * �޸����ڣ�2016-11-03
				�Ż������ִ���߼�
					������Ҫÿ�ζ�ִ�� ������ֻ��Ҫд���ݿ�һ�μ���
					
			TO DO  [v3.0.6  ����ʹ���ϵ��߼� ��һ�汾ִ������Ż�]
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
	   * ���ܣ��õ�Joomla�û���
	   */
	  protected function getJoomlaUserName()
	  {
		  $params = JComponentHelper::getParams("com_zmaxlogin",true);
		  $this->_suffix = $params->get("name_suffix");
		  $this->_prefix = $params->get("name_prefix");
		  $this->_joomla_username = $this->_prefix.time().rand(0,9999).$this->_suffix;
	  }
	  
	  /**
	   *  ����:�õ�����URL
	   *  
	   *  ���� �� ����url��ֵ
	   * 
	   *  �޸����ڣ�2016-11-03
					��������Ҳ����ɹ�����url����ô��ֱ�ӷ�����վ����ҳ
	   
	   * ˵����
			�˴�ʹ��session����ɡ���ô��Ҫע��session �洢���ݵ��û���   
	   */
	   protected function getReturnUrl()
	   {
		  $app = JFactory::getApplication();
		  
		  $this->_returnUrl =  $app->getUserState('zmax.success_returnURL',"");
		  if($this->_returnUrl=="")
		  {
			  //����Ҳ��� ,��ôĬ�Ϸ�����վ����ҳ
			  $defaultReturnUrl = JUri::root();
			  $this->_returnUrl = $defaultReturnUrl;
		  }
		  
		  return $this->_returnUrl;
	   }
	   
	   /**
	    *	���ܣ��õ��޸��û���ϢURL
		*     
		*   �޸����ڣ� 2016-11-03
			������urlִ��base64���ܣ������δ��ʼsef����� �Ҳ�����ͼ��bug
		*  
		*/
		protected function getUserInfoUrl()
		{	
			$this->_userInfoUrl=JUri::root()."index.php?option=com_zmaxlogin&view=userinfo&uid=".$this->_joomla_id."&returnURL=".base64_encode($this->_returnUrl)."&".JSession::getFormToken()."=1"; //�޸��û���Ϣ��URL
		}
	   
	  
	  /**
	   * ���ܣ�׼����֤��Ϣ
	   */
	   protected function preparCredentials()
	   {
			$this->getJoomlaUserName();
			$this->_credentials['openid'] = $this->_3part_id;
			$this->_credentials['username']=$this->_joomla_username;//�����ظ�
			$this->_credentials['fullname']=$this->_3part_username; //���ظ�
			$this->_credentials['password']=$this->_password;
	   }
	   
	   /**
	    * ����:׼������ѡ��
		*/
		protected function preparOptions()
		{
			$this->_options['type'] =$this->_zmax_permit;
		}
	  
	  /**
	   * ���ܣ������¼� onZmaxLoginAfterSave
	   */
	   protected function triggerAfterSaveEvent()
	   {
			JPluginHelper::importPlugin('zmaxlogin');
			$dispatcher = JEventDispatcher::getInstance();
			$dispatcher->trigger('onZmaxLoginAfterSave' ,array($this->_3part_id,$this->_type,$this->_3part_params));			
	   }
		
	  /**
	   *  ���ܣ������¼� onZmaxLoginBeforeReturn   
	   */
	   protected function triggerBeforeReturn()
	   {
			JPluginHelper::importPlugin('zmaxlogin');
			$dispatcher = JEventDispatcher::getInstance();
			$dispatcher->trigger('onZmaxLoginBeforeReturn' ,array($this->_3part_id,$this->_type,&$this->_url));
	   }
	   
	   /**
	    *	���ܣ��رյ�������֤����
		*   
		*   �޸����ڣ�2016-11-03
				����ƶ��豸���޷�������ת������  Ĭ�������ʹ��same_window ���д��ڵĹر�
				�������������������
				
			ע�⣺����ͬ��ʹ��session���洢���ò����������Ҫע��session�����ñ���
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