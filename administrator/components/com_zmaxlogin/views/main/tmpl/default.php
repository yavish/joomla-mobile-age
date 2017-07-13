<?php
/**
 *	description:ZMAX第三方登陆系统 入口点文件
 *  author：min.zhang
 *  Email:zhang19min88@163.com
 *	Url:http://www.zmax99.com
 *  copyright:南宁市程序人软件科技有限责任公司保留所有权利
 *  date:2015-01-12
  * @license GNU General Public License version 3, or later
 */
 
defined ( '_JEXEC' ) or die ();
$option = JRequest::getCmd('option');
JHtml::_('behavior.tooltip');
JHtml::_('behavior.formvalidation');

$doc = JFactory::getDocument();
$doc->addStyleSheet("components/com_zmaxlogin/css/zmaxlogin.css");
$cpInfo = $this->getComponentInfo();
?>
<form action="<?php echo JRoute::_('index.php?option=com_zmaxlogin');?>" method="post" name="adminForm" id="adminForm">
	<?php if (!empty( $this->sidebar)) : ?>
	<div id="j-sidebar-container" class="span2">
		<?php echo $this->sidebar; ?>
	</div>
	<div id="j-main-container" class="span10">
	<?php else : ?>
	<div id="j-main-container">
	<?php endif;?>
		<section>
			<div class="row-fluid">
				<div class="span12">
					
					<div class="well well-small">	
						<div class="module-title nav-header"><?php echo JText::_('系统信息') ?></div>
						<hr class="hr-condensed">
						<div class="row-fluid">
							<div class="span6">
								<dl class="dl-horizontal">
									<dt>第三方登陆模块:</dt>
									<dd>
										<?php if(1):?>
											已安装
										<?php else:?>
											<font style="color:red">未安装</font>
										<?php endif;?>
										<p class="text-info">该模块允许你将第三方登陆的按钮展示在前台。该模块为兼容旧版本（v3.0.6以前的版本）。</p>
									</dd>
									<dt>第三方登陆模块[专业版]:</dt>
									<dd>
										<?php if(1):?>
											已安装
										<?php else:?>
											<font style="color:red">未安装</font>
										<?php endif;?>
										<p class="text-info">该模块为升级版，自v3.0.6版本后发布，该模块比以前的版本功能更强，支持自定义。该模块允许你将第三方登陆的按钮展示在前台</p>
									</dd>
									<dt>登陆重定向插件:</dt>
									<dd>
										已安装<p class="text-info">该插件允许你在用户第一次使用第三方账号注册的时候将其跳转到指定的页面</p>
									</dd>
									<dt>Login Everywehre插件:</dt>
									<dd>
										已安装<p class="text-info">该插件允许你在网站的任何地方放置第三方登陆</p>
									</dd>
								</dl>
							</div>
						</div>
					</div>
				</div>
				
			</div>
		</section>
		<section class="content-block" id="zmaxlogin" role="main">
				<div class="row-fluid">
					<div class="span7">
						<div class="well well-small">
							<div class="module-title nav-header"><?php echo JText::_('COM_ZMAXLOGIN_VIEW_MAIN_WELCOME') ?></div>
							<hr class="hr-condensed">
							<div id="dashboard-icons" class="btn-group">
								<a class="btn" href="index.php?option=com_zmaxlogin&view=users">
									<img src="../media/zmaxlogin/images/users.png" title="在这里可以查看所有使用第三方社交账号注册的用户，并且可以进行解除绑定操作" alt="<?php echo JText::_('COM_ZMAXLOGIN_VIEW_MAIN_USERS') ?>" /><br />
									<span><?php echo JText::_('COM_ZMAXLOGIN_VIEW_MAIN_USERS') ?></span>
								</a>
								<a class="btn" href="index.php?option=com_zmaxlogin&view=install">
									<img src="../media/zmaxlogin/images/install.png" title="在这里可以安装系统支持的第三方插件，扩充系统的功能" alt="<?php echo JText::_('COM_ZMAXLOGIN_VIEW_MAIN_INSTALL') ?>" /><br />
									<span><?php echo JText::_('COM_ZMAXLOGIN_VIEW_MAIN_INSTALL') ?></span>
								</a>
								<a class="btn" href="index.php?option=com_zmaxlogin&view=extensions">
									<img src="../media/zmaxlogin/images/pluginsmanager.png" title="在这里可以配置已经安装过的第三方插件" alt="<?php echo JText::_('COM_ZMAXLOGIN_VIEW_MAIN_EXTENSION_MANAGE') ?>" /><br/>
									<span><?php echo JText::_('COM_ZMAXLOGIN_VIEW_MAIN_EXTENSION_MANAGE') ?></span>
								</a>
								<a class="btn" href="index.php?option=com_config&view=component&component=com_zmaxlogin" title="在这里可以对第三方登陆系统做出一个配置">
									<img src="../media/zmaxlogin/images/config.png" alt="<?php echo JText::_('COM_ZMAXLOGIN_VIEW_MAIN_CONFIG') ?>" /><br />
									<span><?php echo JText::_('COM_ZMAXLOGIN_VIEW_MAIN_CONFIG') ?></span>
								</a>
							</div>
							<div class="clearfix"></div>
						</div>
						<div class="well well-small">
							<div class="module-title nav-header"><?php echo JText::_('帮助资源') ?></div>
							<hr class="hr-condensed">
							<div id="dashboard-icons" class="btn-group">
								
								<a class="btn" href="http://www.joomlachina.cn/shipin-jiaocheng/241-install-zmaxlogin" target="_blank">
									<img src="../media/zmaxlogin/images/video.png" alt="<?php echo JText::_('视频教程') ?>" /><br/>
									<span><?php echo JText::_('视频教程') ?></span>
								</a>
								<a class="btn" href="http://www.zmax99.com/forum/zmaxlogin" target="_blank">
									<img src="../media/zmaxlogin/images/bug.png" alt="<?php echo JText::_('BUG反馈') ?>" /><br />
									<span><?php echo JText::_('BUG反馈') ?></span>
								</a>
								<a class="btn" href="http://www.zmax99.com/forum/zmaxlogin" target="_blank">
									<img src="../media/zmaxlogin/images/advice.png" alt="<?php echo JText::_('改进建议') ?>" /><br />
									<span><?php echo JText::_('改进建议') ?></span>
								</a>
								<a class="btn" href="http://www.zmax99.com" target="_blank">
									<img src="../media/zmaxlogin/images/develop.png" alt="<?php echo JText::_('开发者网站') ?>" /><br />
									<span><?php echo JText::_('开发者网站') ?></span>
								</a>
								<a class="btn" href="http://www.zmax99.com/extensions" target="_blank">
									<img src="../media/zmaxlogin/images/extension.png" alt="<?php echo JText::_('商城扩展') ?>" /><br/>
									<span><?php echo JText::_('扩展功能') ?></span>
								</a>
				
							</div>
							<div class="clearfix"></div>
						</div>
					</div>

					<div class="span5">
						<div class="well well-small">
							<div class="center">
								<img src="../media/zmaxlogin/images/zmax_logo.png" />
							</div>
							<hr class="hr-condensed">
							<dl class="dl-horizontal">
								<dt><?php echo JText::_('COM_ZMAXLOGIN_VIEW_MAIN_VERSION'); ?></dt>
								<dd><?php echo $cpInfo->version;?></dd>
								<dt><?php echo JText::_('COM_ZMAXLOGIN_VIEW_MAIN_DATE'); ?></dt>
								<dd><?php echo $cpInfo->creationDate;?></dd>
								<dt><?php echo JText::_('COM_ZMAXLOGIN_VIEW_MAIN_AUTHOR'); ?></dt>
								<dd><a href="<?php echo $cpInfo->authorUrl;?>" target="_blank"><?php echo $cpInfo->author;?></a></dd>
								<dt><?php echo JText::_('COM_ZMAXLOGIN_VIEW_MAIN_COPYRIGHT'); ?></dt>
								<dd>&copy;<?php echo $cpInfo->copyright;?></dd>
								<dt><?php echo JText::_('COM_ZMAXLOGIN_VIEW_MAIN_LICENSE'); ?></dt>
								<dd>GNU General Public License</dd>
							</dl>
						</div>
					</div>
				</div>
			</section>
		
		</div>
	<div>
		<input type="hidden" name="option" value="<?php echo $option;?>"/>
		<input type="hidden" name="task" value=""/>
		<?php echo JHtml::_('form.token');?>
	</div>
</form>
