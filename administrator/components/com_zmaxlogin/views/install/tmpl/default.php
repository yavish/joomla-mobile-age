<?php
/**
 *	description:ZMAX第三方登陆系统 扩展安装视图文件
 *  author：min.zhang
 *  Email:zhang19min88@163.com
 *	Url:http://www.zmax99.com
 *  copyright:南宁市程序人软件科技有限责任公司保留所有权利
 *  date:2015-01-18
 * @license GNU General Public License version 3, or later
 */
 
// No direct access.
defined('_JEXEC') or die ('can not access this file!');
JHtml::_('behavior.tooltip');
JHtml::_('behavior.formvalidation');
$option = JRequest::getCmd('option');
?>

<script type="text/javascript">
	Joomla.submitbutton = function()
	{
		var form = document.getElementById('adminForm');

		// do field validation
		if (form.install_package.value == ""){
			alert("<?php echo JText::_('COM_ZMAXLOGIN_MSG_INSTALL_PLEASE_SELECT_A_PACKAGE', true); ?>");
		}
		else
		{
			jQuery('#loading').css('display', 'block');

			form.installtype.value = 'upload';
			form.submit();
		}
	};

	Joomla.submitbutton3 = function()
	{
		var form = document.getElementById('adminForm');

		// do field validation
		if (form.install_directory.value == ""){
			alert("<?php echo JText::_('COM_INSTALLER_MSG_INSTALL_PLEASE_SELECT_A_DIRECTORY', true); ?>");
		}
		else
		{
			jQuery('#loading').css('display', 'block');

			form.installtype.value = 'folder';
			form.submit();
		}
	};

	Joomla.submitbutton4 = function()
	{
		var form = document.getElementById('adminForm');

		// do field validation
		if (form.install_url.value == "" || form.install_url.value == "http://"){
			alert("<?php echo JText::_('COM_INSTALLER_MSG_INSTALL_ENTER_A_URL', true); ?>");
		}
		else
		{
			jQuery('#loading').css('display', 'block');

			form.installtype.value = 'url';
			form.submit();
		}
	};

	Joomla.submitbuttonInstallWebInstaller = function()
	{
		var form = document.getElementById('adminForm');

		form.install_url.value = 'http://www.zmax99.com/extension/webinstaller.xml';

		Joomla.submitbutton4();
	};

	// Add spindle-wheel for installations:
	jQuery(document).ready(function($) {
		var outerDiv = $('#installer-install');

		$('<div id="loading"></div>')
			.css("background", "rgba(255, 255, 255, .8) url('../media/jui/img/ajax-loader.gif') 50% 15% no-repeat")
			.css("top", outerDiv.position().top - $(window).scrollTop())
			.css("left", outerDiv.position().left - $(window).scrollLeft())
			.css("width", outerDiv.width())
			.css("height", outerDiv.height())
			.css("position", "fixed")
			.css("opacity", "0.80")
			.css("-ms-filter", "progid:DXImageTransform.Microsoft.Alpha(Opacity = 80)")
			.css("filter", "alpha(opacity = 80)")
			.css("display", "none")
			.appendTo(outerDiv);
	});

</script>

<div id="installer-install" class="clearfix">
<form enctype="multipart/form-data" action="<?php echo JRoute::_('index.php?option=com_zmaxlogin&view=install');?>" method="post" name="adminForm" id="adminForm" class="form-horizontal">	
	<?php if (!empty( $this->sidebar)) : ?>
	<div id="j-sidebar-container" class="span2">
		<?php echo $this->sidebar; ?>
	</div>
	<div id="j-main-container" class="span10">
	<?php else : ?>
	<div id="j-main-container">
	<?php endif;?>
	
	<div class="alert alert-info j-jed-message" style="margin-bottom: 40px; line-height: 2em; color:#333333;">
		<h5>
			<?php echo JText::_("COM_ZMAXLOGIN_VIEW_INSTALL_ZMAXINFO");?>
		</h5>
	</div>

	<?php echo JHtml::_('bootstrap.startTabSet', 'myTab', array('active' => 'upload')); ?>

			<?php echo JHtml::_('bootstrap.addTab', 'myTab', 'upload', JText::_('COM_ZMAXLOGIN_VIEW_INSTALL_UPLOAD_PACKAGE', true)); ?>
			<fieldset class="uploadform">
				<legend><?php echo JText::_('COM_ZMAXLOGIN_VIEW_INSTALL_UPLOAD_PACKAGE_DESC'); ?></legend>
				<div class="control-group">
					<label for="install_package" class="control-label"><?php echo JText::_('COM_ZMAXLOGIN_VIEW_INSTALL_PACKAGE'); ?></label>
					<div class="controls">
						<input class="input_box" id="install_package" name="install_package" type="file" size="57" />
					</div>
				</div>
				<div class="form-actions">
					<input class="btn btn-primary" type="button" value="<?php echo JText::_('COM_ZMAXLOGIN_VIEW_INSTALL_BUTTON'); ?>" onclick="Joomla.submitbutton()" />
				</div>
			</fieldset>
		<?php echo JHtml::_('bootstrap.endTab'); ?>

		<?php echo JHtml::_('bootstrap.addTab', 'myTab', 'directory', JText::_('COM_ZMAXLOGIN_VIEW_INSTALL_UPLOAD_FOLDER', true)); ?>
			<fieldset class="uploadform">
				<legend><?php echo JText::_('COM_ZMAXLOGIN_VIEW_INSTALL_UPLOAD_FOLDER_DESC'); ?></legend>
				<div class="control-group">
					<div class="alert alert-info j-jed-message" style="margin-bottom: 40px; line-height: 2em; color:#333333;">
					<?php echo JText::_('COM_ZMAXLOGIN_VIEW_INSTALL_NO'); ?>
					</div>
				</div>
			</fieldset>
		<?php echo JHtml::_('bootstrap.endTab'); ?>

		<?php echo JHtml::_('bootstrap.addTab', 'myTab', 'url', JText::_('COM_ZMAXLOGIN_VIEW_INSTALL_UPLOAD_URL', true)); ?>
			<fieldset class="uploadform">
				<legend><?php echo JText::_('COM_ZMAXLOGIN_VIEW_INSTALL_UPLOAD_URL_DESC'); ?></legend>
				<div class="control-group">
					<div class="alert alert-info j-jed-message" style="margin-bottom: 40px; line-height: 2em; color:#333333;">
					<?php echo JText::_('COM_ZMAXLOGIN_VIEW_INSTALL_NO'); ?>
					</div>
				</div>
			</fieldset>

		<?php echo JHtml::_('bootstrap.endTab'); ?>
		

	<input type="hidden" name="type" value="" />
	<input type="hidden" name="installtype" value="upload" />
	<input type="hidden" name="task" value="extensions.install" />
	<?php echo JHtml::_('form.token'); ?>

	<?php echo JHtml::_('bootstrap.endTabSet'); ?>
</form>
</div>
