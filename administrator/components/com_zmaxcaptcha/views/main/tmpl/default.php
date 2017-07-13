<?php
/**
 *	description:ZMAX验证码布局文件
 *  author：min.zhang
 *  Email:zhang19min88@163.com
 *	Url:http://www.zmax99.com
 *  copyright:南宁市程序人软件科技有限责任公司保留所有权利
 *  date:2015-05-26
 */
defined('_JEXEC') or die;
$cpInfo = $this->getComponentInfo();
?>
<section>
<div class="span7">
	<h1>
		Hello !<small>中国专业的Joomla扩展开发团队</small>
	</h1>
	<div class="alert-success alert">	
		欢迎访问我们的官方网站<a href="http://renrenshidai.com" target="_blank">http://www.renrenshidai.com</a>获得更多的Joomla国产扩展!
	</div>								
</div>
<div class="span5">
			<div class="well well-small">
				<div class="center">
					<img src="components/com_zmaxcaptcha/images/zmax_logo.png" />
				</div>
				<hr class="hr-condensed">
				<dl class="dl-horizontal">
					<dt><?php echo JText::_('版本:') ?></dt>
					<dd><?php echo $cpInfo->version;?></dd>
					<dt>日期:</dt>
					<dd><?php echo $cpInfo->creationDate;?></dd>
					<dt>作者:</dt>
					<dd><a href="<?php echo $cpInfo->authorUrl;?>" target="_blank"><?php echo $cpInfo->author;?></a></dd>
					<dt>版权:</dt>
					<dd>&copy;<?php echo $cpInfo->copyright;?></dd>
					<dt>许可:</dt>
					<dd>GNU General Public License</dd>
				</dl>
			</div>
		</div>
	</div>
</section>
