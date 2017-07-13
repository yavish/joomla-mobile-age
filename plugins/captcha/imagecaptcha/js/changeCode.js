var gCode="";

jQuery(function() {
	getCode();
    document.formvalidator.setHandler('captcha',
        function (value) {
			value = value.toLowerCase();
			if(value == gCode)
			{
				return true;
			}
			return false;
        });
});


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