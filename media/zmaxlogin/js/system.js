/***
 *
 *  ZMAX第三方登陆 v3.0.6版本
 *
 **/
//解决数据的有效性检查
jQuery(document).ready(function(){
	
	//完善信息页面
	jQuery('.system-zmax-user-email').on('input propertychange' ,function() {		
		emailInput = jQuery(this);
		submitBtn = jQuery(".system-zmax-new-submit-btn");
		
		//用户输入
		var userVal = emailInput.val();
		
		//校验验证码
		if(testEmail(userVal))
		{
			//开始校验email是否存在
			try {
				jQuery.ajax({
					type:'post',
					url:'index.php?option=com_zmaxlogin&task=user.checkEmail',
					data:{
						email:userVal
					},
					cache:false,
					success:function(data)
					{			
						serverVal=data;	
						serverVal = jQuery.trim(serverVal);
						if(serverVal=="ZMAX_EMAIL_OK") //Email没有问题
						{
							submitBtn.removeAttr("disabled");	
							emailInput.removeClass("zmax-invalid-data");
						}
						else  //Email已经重复了
						{
							emailInput.addClass("zmax-invalid-data");
							submitBtn.attr("disabled","disabled");
							alert("Email:"+userVal+"已经存在，请更换其他!");
						}
						
					},
					error:function()
					{
							
					}		
				});		
			}catch(e)
			{
				alert(e.message);
			}
		}
		else
		{
			emailInput.addClass("zmax-invalid-data");
			submitBtn.attr("disabled","disabled");
		}
	});
	
	//绑定信息的界面	
	jQuery('.system-zmax-bind-username').on('input propertychange' ,function() {		
		usernameInput = jQuery(this);
		passwordInput = jQuery(".system-zmax-bind-password");
		submitBtn = jQuery(".system-zmax-bind-submit-btn");
		
		
		
		var usernameVal = usernameInput.val();
		var passwordVal = passwordInput.val();
		
		
		if(usernameVal!="" && passwordVal!="")
		{
			submitBtn.removeAttr("disabled");	
		}
		else
		{
			submitBtn.attr("disabled","disabled");
		}
	});
	
	//绑定信息的界面	
	jQuery('.system-zmax-bind-password').on('input propertychange' ,function() {		
		passwordInput = jQuery(this);
		usernameInput = jQuery(".system-zmax-bind-username");
		submitBtn = jQuery(".system-zmax-bind-submit-btn");
		
		
		var usernameVal = usernameInput.val();
		var passwordVal = passwordInput.val();
		
		if(usernameVal!="" && passwordVal!="")
		{
			submitBtn.removeAttr("disabled");	
		}
		else
		{
			submitBtn.attr("disabled","disabled");
		}
	});
});


function testEmail(str){
  var reg = /^([a-zA-Z0-9]+[_|\_|\.]?)*[a-zA-Z0-9]+@([a-zA-Z0-9]+[_|\_|\.]?)*[a-zA-Z0-9]+\.[a-zA-Z]{2,3}$/;
	if(reg.test(str)){
		return true;
	}
	else
	{
		return false;
	}
}

//解决radio的切换问题
jQuery(document).ready(function(){
	jQuery('input[name="info-type"]').click(function(){
			var infoType = getRadioValue();
			var bindContainer = jQuery(".system-zmax-bind");
			var newContainer= jQuery(".system-zmax-new"); 
			switch(infoType)
			{
				case 'new':
					bindContainer.hide();
					newContainer.show();
					break;
				case 'bind':
					bindContainer.show();
					newContainer.hide();
					break;
				default:
					break;
			}
	});
});

function getRadioValue()
{
	var obj = document.getElementsByTagName("input");
	value="";
    for(var i=0; i<obj.length; i ++){
        if(obj[i].checked){
           value = obj[i].value ;
		   break;
        }
    }
	return value;
}
/**
 *  ZMAXUI JS代码
 *  bootstrap_tab.js
 */
jQuery(document).ready(function(){
		
	jQuery('ul.zmax-nav li[role="zmax-presentation"]').on('click' ,function(){
		//如果当前的类具有 zmax-active 这个类 ，那么就直接返回，什么都不做
		if(jQuery(this).hasClass("zmax-active"))
		{
			return ;
		}	
		
		//点击的不是当前的类
		var tabs = jQuery('ul.zmax-nav li[role="zmax-presentation"]'); //得到所有的导航栏目
		for(i = 0; i< tabs.length ;i++)
		{
			jQuery(tabs[i]).removeClass("zmax-active");			
		}
		jQuery(this).addClass("zmax-active");
		
		
		var group= jQuery(this).attr("group");
		var contentClass="."+group+" div.zmax-tab-panel";		
		var contents = jQuery(contentClass);
		for(i = 0; i< contents.length ;i++)
		{
			jQuery(contents[i]).removeClass("zmax-active");
		}
		var curTab = jQuery(this).attr("target");
		jQuery("#"+curTab).addClass("zmax-active");
	});
	
});