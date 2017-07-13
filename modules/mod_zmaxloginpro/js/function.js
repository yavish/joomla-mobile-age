/***
 *
 *  ZMAX第三方登陆 v3.0.6版本
 *
 **/
//使用jquery来触发登陆
jQuery(document).ready(function(){
	//完善信息页面
	jQuery('.system-zmax-login-social-btn').click(function() {
		var type = jQuery(this).attr("type");
		if(!type)
		{
			alert("无效的登陆类型!");
			return false;
		}
		var loginUrl = "index.php?option=com_zmaxlogin&task=redirect2&type="+type;	
		self.location=loginUrl;
	});		
});	