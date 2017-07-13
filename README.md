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
  1.3 add support login by weixin  , 微信开发放帐号 或公众号登录 两种方式。<br>
       其中 手机号与微信相关采用zmax 的商业组件，请前往购买。<br>
