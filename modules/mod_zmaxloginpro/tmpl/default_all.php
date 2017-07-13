<?php
/**
 *	description:ZMAX第三方登陆布局文件文件
 *  author：min.zhang
 *  Email:zhang19min88@163.com
 *	Url:http://www.zmax99.com
 *  copyright:南宁市程序人软件科技有限责任公司保留所有权利
 *  date:2016-11-05
  * @license GNU General Public License version 3, or later
 */
 
 /**
  *  ###### 重要说明 ###### 
  *  # 为了便于升级以及便于第三方开发，ZMAX专门为第三方登陆模块提供通用库，关于库的使用说明，请参考http://www.zmax99.com相关文章
  *  # 如果你要重写本模块，建议不要直接修改代码，而是使用输出覆盖
  *  #  						
  *  #                ZMAX程序人  2015-01-15
  */
  
defined('_JEXEC') or die('you can not access this file!');




//获得参数
$width = $params->get('window_width',450);
$height = $params->get('window_height',320);
$window_position_x = $params->get('window_position_x',700);
$window_position_y = $params->get('window_position_y',320);
$window_style = $params->get('window_style','same_window');
$label = $params->get('otherloginlabel'); 
$image_style = $params->get('image_style'); 

$enableSms = $params->get("smslogin","0");
$enableJoomla = $params->get("joomlalogin","0");


//获得一个ZMAX登陆前端对象
$zmaxlogin= new zmaxloginFront($width ,$height,$window_position_x ,$window_position_y ,$window_style);
$loginTypes =$zmaxlogin->getLoginTypes();
$config=null;
foreach($loginTypes as $type)
{
	$config[$type]=$params->get($type."login",true);
}
$zmaxlogin->setConfig($config);
$zmaxlogin->setImageStyle($image_style);

JHtml::_('jquery.framework');
$doc = JFactory::getDocument();
$doc->addStyleSheet("modules/mod_zmaxlogin/css/zmaxlogin.css");
$doc->addStyleSheet("media/zmaxlogin/css/system.css");
$doc->addScript("media/zmaxlogin/js/system.js")
?>
<div id="zmaxlogin-module" class="zmaxui">
	<div >
		<!-- 产生tab的标题 -->
		<ul class="zmax-nav zmax-nav-tabs" role="tablist">	
			<?php if($enableJoomla):?>
			<li role="zmax-presentation" target="joomla-login" data="joomla-login" group="zmax-tab-content" class="zmax-active">
				<a ><?php echo $joomlaLabel;?></a>
			</li>
			<?php endif;?>
			<li role="zmax-presentation" target="social-login" data="social-login" group="zmax-tab-content" >
				<a ><?php echo $socialLabel;?></a>
			</li>
			<?php if($enableSms):?>
			<li role="zmax-presentation" target="msg-login" data="msg-login" group="zmax-tab-content" >
				<a ><?php echo $smsLabel;?></a>
			</li>
			<?php endif;?>
		</ul>
	</div>
	<!-- 产生tab的内容-->
	<div class="zmax-tab-content" role="tab-content">
		<?php if($enableJoomla):?>
		<div class="zmax-tab-panel  zmax-fadezmax-fade zmax-active " id="joomla-login" >	
				<?php if($showLabelDesc):?>
				<h3><?php echo $joomlaLabel;?><small><?php echo $joomlaLabelDesc;?></small></h3>
				<?php endif;?>
				<?php 
				$joomlaLoginHtml = $zmaxlogin->outPutJoomlaLogin();
					echo $joomlaLoginHtml;
				?>
				
		</div>
		<?php endif;?>
		<div class="zmax-tab-panel  zmax-fade" id="social-login" >				
				<?php if(!empty($loginTypes)):?>
				<div id="other_oauth">
					<div>
					<?php if($showLabelDesc):?>
							<h3><?php echo JText::_($socialLabel);?> <small><?php echo $socialLabelDesc;?></small></h3>
					<?php endif;?>
						<div class="icon">
							<?php echo $zmaxlogin->outPutAllZmaxLogin();?>
						</div>
					</div>
				</div>
				<?php endif;?>
		</div>
		<?php if($enableSms):?>
		<div class="zmax-tab-panel zmax-fade " id="msg-login" >				
				<?php if($showLabelDesc):?>
				<h3 ><?php echo $smsLabel;?> <small><?php echo $smsLabelDesc;?></small></h3>
				<?php endif;?>
				<form class="" action="index.php?option=com_zmaxlogin&task=redirect2&type=msg" method="post" name="email-login-form" role="form">					
					<?php echo $captcha->getPhoneCaptchaHtml();?>
					<?php echo JHtml::_( 'form.token' ); ?>
				</form>				
		</div>
		<?php endif;?>
	</div>				
</div>
