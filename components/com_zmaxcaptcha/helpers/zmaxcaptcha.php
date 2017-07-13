<?php
/**
 *	description:ZMAX验证码 帮助文件
 *  author：min.zhang
 *  Email:zhang19min88@163.com
 *	Url:http://www.zmax99.com
 *  copyright:南宁市程序人软件科技有限责任公司保留所有权利
 *  date:2015-05-26
 */
require_once JPATH_BASE."/libraries/dysms/api_sdk/aliyun-php-sdk-core/Config.php" ;
require_once JPATH_BASE.'/libraries/dysms/api_sdk/Dysmsapi/Request/V20170525/SendSmsRequest.php';
require_once JPATH_BASE.'/libraries/dysms/api_sdk/Dysmsapi/Request/V20170525/QuerySendDetailsRequest.php';
	
 class zmaxcaptchaHelper 
 {
	public static function getCode()
	{
		$session = JFactory::getSession();
		$token = $session->getToken();
		$db = JFactory::getDbo();		
		$sql = "SELECT code from #__zmaxcaptcha_code WHERE session_id='{$token}'";
		$db->setQuery($sql);
		$code = $db->loadResult();
		return $code;
		
	}
	
	public static function deleteCode()
	{
		$date =JDate::getInstance();		
		$now = $date->toUnix();
		$db = JFactory::getDbo();		
		$sql = "DELETE from #__zmaxcaptcha_code WHERE end_date<{$now}";
		$db->setQuery($sql);
		$db->query();
	}
	
	public  static function sessionExist()
	{
		$session = JFactory::getSession();
		$token = $session->getToken();
		$db = JFactory::getDbo();		
		$sql = "SELECT * from #__zmaxcaptcha_code WHERE session_id='{$token}'";
		$db->setQuery($sql);
		$result = $db->loadObject();
		return $result;
	}
	
	public static function updateCode($code)
	{
		$session = JFactory::getSession();
		$token = $session->getToken();
		$db = JFactory::getDbo();		
		$sql = "UPDATE #__zmaxcaptcha_code SET code='{$code}' WHERE session_id='{$token}'";	
		$db->setQuery($sql);
		return $db->query();
	}
	
	public static function insertCode($code)
	{
		$session = JFactory::getSession();
		$token = $session->getToken();
		
		$date =JDate::getInstance();		
		$start_time = $date->toUnix();
		$end_time = $start_time + 600;
		$db = JFactory::getDbo();		
		$sql = "INSERT INTO #__zmaxcaptcha_code(session_id,type,code,start_date,end_date) VALUES ('$token','normal','$code','$start_time','$end_time' )";	
		$db->setQuery($sql);
		return $db->query();
	}
	
	public  static function saveCode($code)
	{		
		if(self::sessionExist())
		{
			 self::updateCode($code);
			 self::deleteCode();
		}
		else
		{
			 self::insertCode($code);
			 self::deleteCode();
		}
	}
	
	public  static function  sendMsg($phone_no)
	{
		self::_sendMsg($phone_no);
		
	}
	

   protected static function _makeRandomNum($length)
   {
		$pattern = "1234567890abcdefghijklmnopqrstuvwxyz";
		$key="";
		for($i=0;$i<$length;$i++)
		{
			$key .= $pattern{rand(0,35)};
		}
		return $key;
  }
	protected static  function _getrandomNo($smslength)
	{
		 $randomNo ="";
		 $characters = array("0","1","2","3","4","5","6","7","8","9");
			$keys = array();
			while(count($keys) < $smslength) {
				$x = mt_rand(0, count($characters)-1);
				if(!in_array($x, $keys)) {
				   $keys[] = $x;
				}
			}
			foreach($keys as $key){
			   $randomNo .= $characters[$key];
			}
		return $randomNo;
	 }

	public static function sendSmsVerify($tomobileno) {
			
		
		$params	= JComponentHelper::getParams('com_zmaxcaptcha');
		  
		$accessKeyId = $params->get("user_id");//$accessKeyId
		$accessKeySecret = $params->get("password");//$accessKeySecret
		$time = $params->get("time",1);		
		$templateCode = $params->get('msg_template'); //"SMS_75785186"
				
		//短信API产品名
		$product = "Dysmsapi";
		//短信API产品域名
		$domain = "dysmsapi.aliyuncs.com";
		//暂时不支持多Region
		$region = "cn-hangzhou";
		
		//初始化访问的acsCleint
		$profile = DefaultProfile::getProfile($region, $accessKeyId, $accessKeySecret);
		DefaultProfile::addEndpoint("cn-hangzhou", "cn-hangzhou", $product, $domain);
		$acsClient= new DefaultAcsClient($profile);
		
		$request = new Dysmsapi\Request\V20170525\SendSmsRequest;
		//必填-短信接收号码
		$request->setPhoneNumbers($tomobileno);
		//必填-短信签名
		$request->setSignName("人人时代");//人人时代
		//必填-短信模板Code
		$request->setTemplateCode($templateCode);  //SMS_75785186
		//选填-假如模板中存在变量需要替换则为必填(JSON格式)
		//验证码${number}，您正进行人人时代的手机验证，注意保密

		$randomNo = self:: _getrandomNo(4);
		$request->setTemplateParam("{\"number\":\"".$randomNo."\"}");
		//选填-发送短信流水号
		$outid	=time().$tomobileno;
		$request->setOutId($outid);
		
		//发起访问请求
		//  $acsResponse = $acsClient->getAcsResponse($request);
		//return $acsResponse;
		

		if($acsResponse->Code !=='OK')
		{
			echo "ERROR:".$acsResponse->Code.":". $acsResponse->Message;//"ERROR";
		}
		else
		{
			// echo $acsResponse->Code;
			echo $randomNo;
		}

		
		//echo $randomNo;
		return true;
		//var_dump($acsResponse);
	   //print_r("acsResponse[Message] =".$acsResponse->Message);
	   //print_r("\\n");
	   //print_r("acsResponse[Code] =".$acsResponse->Code);
	}
	protected static function _sendMsg($phone_no)
	{
		
		require_once(JPATH_COMPONENT_ADMINISTRATOR."/libs/sms/sms.lib.php");
		$params = JComponentHelper::getParams('com_zmaxcaptcha');	
		
		$uid = $params->get("user_id");
		$pswd = $params->get("password");
		$time = $params->get("time",1);		
		$message = $params->get('msg_template');
		$code = self:: _makeRandomNum(4);
		$message = str_replace("_##CODE##_",$code ,$message);
		
		$message = mb_convert_encoding($message,"gb2312","utf-8"); 	
		$fields = array(
		'CorpID'=>urlencode($uid),
		'Pwd'=>urlencode($pswd),
		'Mobile'=>urlencode($phone_no),
		'Content'=>urlencode($message),
		'Cell'=>'',
		'SendTime'=>''
        );
		
	   
		$url = "http://www.106551.com/ws/Send.aspx";
		$result = execPostRequest($url,$fields);
		
		if(0!= $result)
		{
			echo "ERROR";
		}
		else
		{
			echo $code;
		}
		return true;
	}
 }
 
 
 
 ?>