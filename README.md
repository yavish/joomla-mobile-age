# joomla-mobile-age
What does Joomla look like in the mobile age? sms  mobile number weixin  短信 手机号 微信
在互联网时代诞生的joomla ，已经存在了10多年了。在移动互联网时代显得很不适用，尤其在中国 存在微信的普及使用。joomla 架构与应用也已非常的成熟与完善，在国际上有完整的生态链条。放弃不用显得可惜，为此特做了些 老树发新枝的工作。I hope it's helpful to Chinese Joomla developers.
如下是开发需求：
<br>
一、用户组件相关的需求
<br>
0. simply registration flow, 简化注册的字段， hide three fields: name , email2  password2 , usename fill into  name .
    简化成 注册（用户名（姓名）+密码+ 邮箱  + 手机号 <br>
1.joomla core  need support mobile number just like email 。 jooma 内核需要支持手机号码 像邮件一样，<br>
    （为此需要手工更新四个地方site : 注册页 registration page， profile 个人资料 查看与编辑页，   admin :后台：users management 用户管理， admin profile  管理员帐户编辑)<br>
    
  1.1  support registration by mobile number ,sms verify 支持手机号码 注册与 图形 与短信验证码  ）<br>
  
  1.2  add support login  by email  ,mobile number  支持邮件 手机登录 用户名 三种方式登录<br>
  1.3 add support login by weixin  , 微信开发放帐号 或公众号登录 两种方式。需要自行向腾讯网站申请开通帐号<br>
       其中 手机号与微信相关采用zmax 的商业组件，请前往购买。<br>
       短信发送是采用 阿里的大于短信 接口， 需要开户购买 短信<br>
       
   1.4 加上一个移动端 友好 自适应的免费模板 ja_simpli<br>
以上功能，在这个quickstart package, 只要解压到你的htdocs 根目录， 并创建一个数据库 导入根目录的sql , 修改你的 configuration.php 有关数据库用户与密码 即可。后台登录用户名与密码： admin/admin<br>
在短信验证码插件中要配置 三个参数 ，因为系统要用到： <br>
 //此处需要替换成自己的AK信息 <br>
    $accessKeyId = " "; // 类此用户名<br>
   $accessKeySecret = " "; //类此用户名密码<br>
   $request->setTemplateCode("SMS_75785186");  //SMS_75785186  短信模板<br>

 问题交流 QQ :529121330
 
   
