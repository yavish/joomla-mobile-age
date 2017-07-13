<?php
/**
 *	description:ZMAX商城 添加商品布局文件
 *  author：min.zhang
 *  Email:zhang19min88@163.com
 *	Url:http://www.zmax99.com
 *  copyright:南宁市程序人软件科技有限责任公司保留所有权利
 *  date:2014-11-22
 * @license GNU General Public License version 3, or later
 */

defined('_JEXEC') or die ('can not access this file!');

$option = JRequest::getCmd('option');
JHtml::_('behavior.tooltip');
JHtml::_('behavior.formvalidation');

//需要加载语言文件
$language = JFactory::getLanguage();
$newPath = JPATH_ADMINISTRATOR . '/components/com_zmaxlogin/plugins/'.$this->item->logintype;
$language->load("com_zmaxlogin",$newPath);
?>
<script type="text/javascript">
	Joomla.submitbutton = function(task)
	{
		if (task == 'extension.cancel' || document.formvalidator.isValid(document.id('item-form')))
		{
			Joomla.submitform(task, document.getElementById('item-form'));
		}
	}
</script>

<form action="<?php echo JRoute::_('index.php');?>" method="post" name="adminForm" class="form-validate" id="item-form"  enctype="multipart/form-data">
	<div id="j-main-container">
	</div>
	<div class="span3">
		<h3>扩展详情</h3>
		<table class="table">
			<tr><td>名称</td><td><?php echo $this->item->friendName;?></td></tr>
			<tr><td>图片</td><td>
				<img src="components/com_zmaxlogin/images/<?php echo $this->item->logintype;?>_image/<?php echo $this->item->logintype;?>_login.png"/>
			</td></tr>
			<tr><td>类型</td><td><?php echo $this->item->logintype;?></td></tr>
			<tr><td>描述</td><td><?php echo $this->item->description;?></td></tr>
			<tr><td>版本<td><?php echo $this->item->version;?></td></tr>
			<tr><td>作者</td><td><?php echo $this->item->author;?></td></td></tr>
			<tr><td>作者Email</td><td><?php echo $this->item->authorEmail;?></td></td></tr>
			<tr><td>作者Url</td><td><a href="<?php echo $this->item->authorUrl;?>" target="_blank"><?php echo $this->item->authorUrl;?></a></td></tr>
			
		</table>
	</div>
	<div class="span1"></div>
	<div class="span3">
		<h3>配置参数</h3>
		<div class="form-horizontal">
		<?php 
			if($this->form)
			{
				echo $this->form->renderFieldset("config");
			}
			else
			{
				echo "该扩展不提供参数设置！";
			}
		 ?>
		 </div>
		
	</div>
	<div>
		<input type="hidden" name="option" value="<?php echo $option;?>"/>
		<input type="hidden" name="task" value=""/>
		<input type="hidden" name="id" value="<?php echo $this->item->id;?>"/>
		<input type="hidden" name="type" value="<?php echo $this->item->logintype;?>"/>
		<?php echo JHtml::_('form.token');?>
	</div>
</form>
