<?php
/**
 *	description:ZMAX第三方登陆前端公共函数文件
 *  author：min.zhang
 *  Email:zhang19min88@163.com
 *	Url:http://www.zmax99.com
 *  copyright:南宁市程序人软件科技有限责任公司保留所有权利
 *  date:2015-01-15
  * @license GNU General Public License version 3, or later
 */
 defined('_JEXEC') or die('Restricted access');
  
  class zmaxloginFront{
	
	protected $_window_width;
	protected $_window_height;
	protected $_window_position_x;
	protected $_window_position_y;
	protected $_window_style;
	protected $_image_style;
	protected $_ismobile;
	
	protected $_loginTypes=array();
	protected $_config=array();
	
	
	public function __construct($width="700",$height="400" ,$window_position_x="700",$window_position_y="320",$window_style="new_window" ,$image_style="")
	{
		$this->_window_width=$width;
		$this->_window_height=$height;
		$this->_window_position_x=$window_position_x;
		$this->_window_position_y=$window_position_y;
		$this->_window_style=$window_style;
		$this->_image_style=$image_style;
		$this->_ismobile = $this->isMobile();
		$this->loadTypes();
		$this->initConfig();
		$this->initZmaxLogin();
	}
	
    //从数据库中装载可用的插件
	protected function loadTypes()
	{
		$db = JFactory::getDBO();
		$query = $db->getQuery(true);
		$query->select($db->quoteName("logintype"))->from($db->quoteName("#__zmax_extension"));
		$query->where($db->quoteName("published")."=".$db->quote("1"));
		$db->setQuery($query);
		$types = $db->loadColumn();
		
		if(is_array($types) && count($types))
		{
			for($i= 0; $i< count($types) ;$i++ )
			{
				//移除短信登陆 // 2016-11-01
				if($types[$i]=="msg") //不显示移动版本的微信
				{
					unset($types[$i]);
					continue ;
				}
				
				if($this->_ismobile) //微信扫描就隐藏
				{
					if($types[$i]=="weixin")
					{
						unset($types[$i]);
					}
				}
				else
				{
					if($types[$i]=="weixinyd") //不显示移动版本的微信
					{
						unset($types[$i]);
					}
				}
				
				
			}
		}
		
		$this->_loginTypes = $types;

	}
	
	//判断当前环境是否是移动端
	function isMobile() 
	{
		//如果有HTTP_X_WAP_PROFILE则一定是移动设备
		if (isset ($_SERVER['HTTP_X_WAP_PROFILE'])) 
		{
			return true;
		}
		
		//如果via信息含有wap则一定是移动设备,部分服务商会屏蔽该信息
		if (isset ($_SERVER['HTTP_VIA'])) 
		{
			//找不到为flase,否则为true
			return stristr($_SERVER['HTTP_VIA'], "wap") ? true : false;
		}
		
		//判断手机发送的客户端标志,兼容性有待提高
		if (isset ($_SERVER['HTTP_USER_AGENT'])) 
		{
			$clientkeywords = array (
				'nokia',
				'sony',
				'ericsson',
				'mot',
				'samsung',
				'htc',
				'sgh',
				'lg',
				'sharp',
				'sie-',
				'philips',
				'panasonic',
				'alcatel',
				'lenovo',
				'iphone',
				'ipod',
				'blackberry',
				'meizu',
				'android',
				'netfront',
				'symbian',
				'ucweb',
				'windowsce',
				'palm',
				'operamini',
				'operamobi',
				'openwave',
				'nexusone',
				'cldc',
				'midp',
				'wap',
				'mobile'
			);
		
			//从HTTP_USER_AGENT中查找手机浏览器的关键字
			if (preg_match("/(" . implode('|', $clientkeywords) . ")/i", strtolower($_SERVER['HTTP_USER_AGENT']))) 
			{
				return true;
			}
		}
		return false;
	}
	
	//将所有的插件都设置为启用状态
	protected function initConfig()
	{
		if(!empty($this->_loginTypes))
		{
			foreach($this->_loginTypes as $type)
			{
				$this->_config[$type]=true;
			}
		}
	}
	
	//初始化系统变量 
	protected  function initZmaxLogin()
	{
		$returnURL=JURI::current();
		$u = JURI::getInstance();
		$query = $u->getQuery();
		$app = JFactory::getApplication();
        if($query!="")
        {
			$returnURL = $returnURL."?".$query;
		}
		if(strpos($returnURL ,"index.php?option=com_zmaxlogin&") === false && strpos($returnURL ,"task=redirect2") === false)
		{
			$app->setUserState('zmax.success_returnURL',$returnURL);
		}
		$app->setUserState('zmax.window_style',$this->_window_style);
	}
	
	//外界可以使之是否启用
	public function setConfig($config)
	{
		if(is_array($config))
		{
			foreach($config as $k=>$v)
			{
				$this->_config[$k]=$v;
			}
		}
	}
	
	public function setImageStyle($style)
	{
		$this->_image_style = $style;
	}
	
	//得到所有可用的登陆类型
	public function getLoginTypes()
	{
		return $this->_loginTypes;
	}
	
	//得到当前的配置
	public function getConfig()
	{
		return $this->_config;
	}
	
	//设置窗口的风格
	public function setWindowStyle($width,$height,$window_position_x ,$window_position_y,$window_style)
	{
		$this->_window_width=$width;
		$this->_window_height=$height;
		$this->_window_position_x=$window_position_x;
		$this->_window_position_y=$window_position_y;
		$this->_window_style=$window_style;
	}
	
	//得到链接跳转地址
	public function getLoginLink($type)
	{
		return "index.php?option=com_zmaxlogin&task=redirect2&type=".$type;	
	}
	
	//得到JS跳转地址
	public function getLoginJSFunction($type)
	{	
		$siteBase = JURI::root();
		$link = $this->getLoginLink($type);
		$link = $siteBase.$link;
		
		$type=ucfirst($type);
		$js = '';	
		$js.='		function to'.$type.'Login()' ;
		$js.='		{					';	
		$js.='			var A=window.open("'.$link.'","zmaxLogin","width='.$this->_window_width.',height='.$this->_window_height.',menubar=0,scrollbars=1, resizab ';
		$js.='			le=1,status=1,titlebar=0,toolbar=0,left='.$this->_window_position_x.' ,top='.$this->_window_position_y.', location=1");';
		$js.='				';
		$js.='		} ';
		  
		$doc = JFactory::getDocument();
		$doc->addScriptDeclaration($js);	
		return "to".$type."Login();return false;";
	}
	
	//得到输出HTML
	public function getOutPut($type,$enable=true,$htmlTag="div" )
	{
		 if ($enable)
		 {
			$link = $this->getLoginLink($type);
			$jsFunction = $this->getLoginJSFunction($type);
			$html[]="<$htmlTag>";
			if($this->_window_style=="new_window")
			{
				$html[]="<a href='#' onclick='$jsFunction'>";
			}
			else
			{
				$html[]="<a href='$link'>";
			}
			if($this->_image_style)
			{
				$html[]="<img src='".JURI::root()."administrator/components/com_zmaxlogin/images/".$type."_image/".$type.$this->_image_style."_login.png'>";
			}
			else
			{
				$html[]="<img src='".JURI::root()."administrator/components/com_zmaxlogin/images/".$type."_image/".$type."_login.png'>";
			}
			$html[]="</a>";
			$html[]="</$htmlTag>";
			$html=implode("\n",$html);
			return $html;
		 }
		 return NULL;
	}	
	
	//输出所有的ZMAX登陆
	public function outPutAllZmaxLogin($wrapTag="ul" ,$elementTag="li")
	{
		if(!empty($this->_loginTypes))
		{
			$html[]="<$wrapTag>";
			foreach($this->_loginTypes as $type)
			{			
				$html[]=$this->getOutPut($type ,$this->_config[$type],"$elementTag");		
			}
			$html[]="</$wrapTag>";		
			return implode("\n" ,$html);
		}
		return null;
	}
	
	static	public function getUserImageUrl()
	{
		$user = JFactory::getUser();
		if($user->guest)
		{
			return null;
		}
		$db = JFactory::getDBO();
		$query = $db->getQuery(true);
		$query->select("image_url");
		$query->from("#__zmax_users");
		$query->where("joomla_uid =".$user->id);
		$db->setQuery($query);
		$result = $db->loadResult();
		if(!$result)
		{
			$result = JURI::root()."administrator/components/com_zmaxlogin/images/zmaxdefault_user.gif";
		}
		
		return $result;
	}
	
	//OUT PUT Joomla LOGIN
	public function outPutJoomlaLogin()
	{
		$module = JModuleHelper::getModule("login" );
		$joomla_login=JModuleHelper::renderModule( $module); 
		return $joomla_login;
	}
  }
  
  
  
  

?>