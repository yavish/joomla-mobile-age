<?php
/**
 *	description:ZMAX第三方登陆系统 用户信息默认布局文件
 *  author：min.zhang
 *  Email:zhang19min88@163.com
 *	Url:http://www.zmax99.com
 *  copyright:南宁市程序人软件科技有限责任公司保留所有权利
 *  date:2014-12-1
 *  @license GNU General Public License version 3, or later
 */
defined('_JEXEC') or die('You Can Not Access This File!');

JHtml::_('jquery.framework');
JHtml::_('behavior.tooltip');

$doc = JFactory::getDocument();
$doc->addStyleSheet("media/zmaxlogin/css/system.css");
$doc->addScript("media/zmaxlogin/js/system.js");
?>

<div id="zmax-userinfo-container">
	<div class="zmaxui">
		<form action="<?php echo JRoute::_('index.php?option=com_zmaxlogin&view=userinfo');?>" method="post" class="zmax-form"  name="adminForm" id="adminForm">
			
			<!-- 说明信息-->
			<h3>
				<?php echo JText::_('COM_ZMAXLOGIN_VIEW_USERINFO_MORE_INFO');?><small> <?php echo JText::_('COM_ZMAXLOGIN_VIEW_USERINFO_MORE_INFO_DESC');?></small>
			</h3>
			<hr />
		
			<!-- 用户选择 -->
			<div class="zmax-type-container">	
				<div class="zmax-radio-inline">
					<label>
						<input  type="radio" name="info-type" class="system-zmax-radio-item-btn"  value="new" checked="checked" />
						<?php echo JText::_("COM_ZMAXLOGIN_VIEW_USERINFO_NO_COUNT");?>
					</label>
				</div>
				 <div class="zmax-radio-inline ">
					<label>
						<input  type="radio" name="info-type" class="system-zmax-radio-item-btn"  value="bind" />
						<?php echo JText::_("COM_ZMAXLOGIN_VIEW_USERINFO_HAS_COUNT");?>
					</label>
				</div>
			</div>
			<hr />
			<form action="<?php echo JRoute::_('index.php?option=com_zmaxlogin&view=userinfo');?>" method="post" class="zmax-form"  name="adminForm" id="adminForm">
				<div class="system-zmax-bind"  style="display: none;">
					<h4><?php echo JText::_("COM_ZMAXLOGIN_VIEW_USERINFO_BIND_COUNT");?></h4>
					<div class="zmax-form-horizontal">
						<div class="zmax-form-group">
							<label class="zmax-col-md-2 zmax-control-label">
								<?php echo JText::_("COM_ZMAXLOGIN_VIEW_USERINFO_USERNAME");?>
								<span class="required">*</span>
							</label>
							<div class="zmax-col-md-10 ">
								<input type="text" required="required" class="system-zmax-bind-username zmax-form-control"  name="bind_username" placeholder="输入用户名" />
							</div>
						</div>
						<div class="zmax-form-group">
							<label class="zmax-col-md-2 zmax-control-label">
								<?php echo JText::_("COM_ZMAXLOGIN_VIEW_USERINFO_PASSWORD");?>
								<span class="required">*</span>
							</label>
							<div class="zmax-col-md-10 ">
								<input type="password" class="zmax-form-control system-zmax-bind-password" required="required"  name="password"/>
							</div>
						</div>
						<div class="zmax-form-group">
							<div class="zmax-col-md-offset-2 zmax-col-md-10">
								<button disabled="disabled" class="zmax-btn zmax-btn-success system-zmax-bind-submit-btn" name="submit" ><?php echo JText::_("COM_ZMAXLOGIN_VIEW_USERINFO_BIND");?></button>
							</div>
						</div>
					</div>	
				</div>
				<div>
					<input type="hidden" name="task" value="user.save"/>
					<input type="hidden" name="id" value="<?php echo $this->userInfo->id;?>"/>
					<input type="hidden" name="uid" value="<?php echo $this->userInfo->uid;?>"/>
					<input type="hidden" name="joomla_uid" value="<?php echo $this->userInfo->joomla_uid;?>"/>
					<input type="hidden" name="option" value="<?php echo $this->option;?>"/>
					<input type="hidden" name="view" value="<?php echo $this->view;?>"/>
					<input type="hidden" name="returnURL" value="<?php echo $this->returnURL;?>"/>
					<?php echo JHtml::_('form.token');?>
				</div>	
			</form>
			
			<form action="<?php echo JRoute::_('index.php?option=com_zmaxlogin&view=userinfo');?>" method="post" class="zmax-form"  name="adminForm" id="adminForm">
				<div class="system-zmax-new">
					<h4> <?php echo JText::_("COM_ZMAXLOGIN_VIEW_USERINFO_PROFILE");?></h4>
					<div class="zmax-form-horizontal">
						<div class="zmax-form-group">
							<label class="zmax-col-md-2 zmax-control-label">
								<?php echo JText::_("COM_ZMAXLOGIN_VIEW_USERINFO_USERNAME");?>
								<span class="required">*</span>
							</label>
							<div class="zmax-col-md-10">
								<input type="text" required="required" value="<?php echo $this->userInfo->username;?>"   class="zmax_username zmax-form-control" id="new_username" name="username"/>
							</div>
						</div>
						
						<div class="zmax-form-group">
							<label class="zmax-col-md-2 zmax-control-label">
								<?php echo JText::_("COM_ZMAXLOGIN_VIEW_USERINFO_EMAIL");?>
								<span class="required">*</span>
							</label>
							<div class="zmax-col-md-10">
								<input type="email"  class="zmax-form-control system-zmax-user-email"  name="email" placeholder="请输入你的Email账号"/>
							</div>
						</div>
						
						<div class="zmax-form-group">
							<div class="zmax-col-md-offset-2 zmax-col-md-10">
								<button name="submit" class="zmax-btn zmax-btn-success system-zmax-new-submit-btn" disabled="disabled" ><?php echo JText::_("COM_ZMAXLOGIN_VIEW_USERINFO_SAVE");?></button>
							</div>
						</div>		
					</div>
				</div>
				<div>
					<input type="hidden" name="task" value="user.save"/>
					<input type="hidden" name="id" value="<?php echo $this->userInfo->id;?>"/>
					<input type="hidden" name="uid" value="<?php echo $this->userInfo->uid;?>"/>
					<input type="hidden" name="joomla_uid" value="<?php echo $this->userInfo->joomla_uid;?>"/>
					<input type="hidden" name="option" value="<?php echo $this->option;?>"/>
					<input type="hidden" name="view" value="<?php echo $this->view;?>"/>
					<input type="hidden" name="returnURL" value="<?php echo $this->returnURL;?>"/>
					<?php echo JHtml::_('form.token');?>
				</div>	
			</form>
			
			
		</form>
	</div>
</div>
	
	