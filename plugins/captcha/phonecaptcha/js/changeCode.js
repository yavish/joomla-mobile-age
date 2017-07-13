var gCode="";
var gMsg="";
var gTime=60;
var gTimer;
var gStr="";
var g_bImagePass = false;
var g_bPhonePass = false;


jQuery(function() {
	getCode();
    document.formvalidator.setHandler('captcha',
        function (value) {
			value = value.toLowerCase();
				if(value == gCode)
			{
				g_bImagePass = true;
				return true;
			}
			g_bImagePass = false;
			return false;
        });
		
	 document.formvalidator.setHandler('phoneno',
        function (value) {
			if(validatemobile(value))		
			{
				g_bPhonePass=true;
				return true;
			}
			g_bPhonePass = false;
			return false;
        });
	
	 document.formvalidator.setHandler('phonecode',
        function (value) {		
			value = value.toLowerCase();
			
			if(value == gMsg)
			{
				
				return true;
			}
			return false;
        });
});


function count()
{	
	btn = document.getElementById("zmaxsendbtn");
	btn.className = "disable_btn"
	if(gStr=="")
	{
		gStr = btn.onclick;
	}
	btn.onclick="";
	btn.innerHTML=gTime+"(秒)后可重发";
	gTime--;
	if(gTime==0)
	{
		clearInterval(gTimer);
		btn.innerHTML="免费获取验证码";
		btn.className="btn";
		btn.onclick=gStr;
		gTime=60;
	}
}

function sendMsg()
{	
	if(g_bImagePass)
	{
		phone = document.getElementById("jform_phoneno");
		phone = phone.value;
		if(g_bPhonePass)
		{
			_sendMsg(phone);
			gTimer = setInterval("count()",1000);
		}
		else
		{
			alert("手机号码输入不正确，请检查!");
		}
	}
	else{
		alert("请输入正确的图像验证码!");
	}
}

function _sendMsg(phone_no)
{
	var data="&phone_no="+phone_no;
	try {
		xhr = getXhr();
		xhr.onreadystatechange = function()
		{
			if(xhr.readyState==4 &&  xhr.status == 200)
			{
				
				gMsg = xhr.responseText;

				var iserror = gMsg.substring(0,5) ;
				if( iserror == "ERROR:")
				{
					alert("发送短信失败，请稍后重试!".gMsg);
				}
				else 
				{
				
					alert("短信息已经成功发送到手机"+phone_no+"请注意查收!"+gMsg );
					
				}
			}else
			{
			}
		}
	}catch(e)
	{
		alert(e.message);
	}
	
	var url="index.php?option=com_zmaxcaptcha&task=sendMsg";
	xhr.open("GET",url+data,true);
	xhr.send(null);
	
}

function validatemobile(mobile) 
{ 
	   if(mobile.length==0) 
	   { 		 
		  return false; 
	   }     
	   if(mobile.length!=11) 
	   { 
		   return false; 
	   } 
		
	   var myreg = /^(((13[0-9]{1})|(15[0-9]{1})|(18[0-9]{1}))+\d{8})$/; 
	   if(!myreg.test(mobile)) 
	   { 
		   return false; 
	   }
		return true;
 } 

function getCode()
{
	var data="";
	try {
		xhr = getXhr();
		xhr.onreadystatechange = function()
		{
			if(xhr.readyState==4 &&  xhr.status == 200)
			{
				gCode = xhr.responseText;
			}else
			{
			}
		}
	}catch(e)
	{
		alert(e.message);
	}
	
	var url="index.php?option=com_zmaxcaptcha&task=getCode";
	xhr.open("GET",url+data,true);
	xhr.send(null);
}

function changeCode(obj)
{
	//Please Note the Var url is used by JS
	var data="";
	try {
		xhr = getXhr();
		xhr.onreadystatechange = function()
		{
			if(xhr.readyState==4 &&  xhr.status == 200)
			{	
				var newCode = xhr.responseText;
				gCode=newCode;
				var strSrc = obj.src;
	
				var reg = new RegExp(/\?t\=.*/);
				var strRandom = Math.random();
				strRandom= '?t='+strRandom;
				
				strSrc=strSrc.replace(reg,strRandom); 				
				obj.src = strSrc;
				g_bImagePass = false;
				
			}else
			{
			}
		}
	}catch(e)
	{
		alert(e.message);
	}
	
	var url="index.php?option=com_zmaxcaptcha&task=changeCode";
	xhr.open("GET",url+data,true);
	xhr.send(null);
}
/***********************************************************AJAX END******************************************/



/**
 * get xhr object
 *  
 **/
function getXhr()
 {
	var xhr = null;	
	if(window.XMLHttpRequest)
	{
		xhr = new XMLHttpRequest();
	}else if(window.ActiveXObject)
		{
			xhr = new ActiveXObject("Microsoft.XMLHTTP");
		}else{
			alert("Votre navigateru not supports ajax!");	
			xhr = false;
			}
	
	return xhr;
}