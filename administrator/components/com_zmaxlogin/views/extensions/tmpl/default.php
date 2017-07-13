<?php
/**
 *	description:ZMAX第三方登陆系统 扩展列表视图文件
 *  author：min.zhang
 *  Email:zhang19min88@163.com
 *	Url:http://www.zmax99.com
 *  copyright:南宁市程序人软件科技有限责任公司保留所有权利
 *  date:2015-01-12
 * @license GNU General Public License version 3, or later
 */

// No direct access.
defined('_JEXEC') or die ('can not access this file!');

$option = JRequest::getCmd('option');
JHtml::_('behavior.tooltip');
JHtml::_('behavior.formvalidation');
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
		<?php if (empty($this->items)) : ?>
		<div class="alert alert-no-items">
			<?php echo JText::_('JGLOBAL_NO_MATCHING_RESULTS'); ?>
		</div>
		<?php else : ?>
		<table class="table table-striped" id="toursList">
			<thead>
				<tr>
					<th class="center"><?php echo JHtml::_('grid.checkall'); ?></th>
					<th class="center"><?php echo JText::_('图标'); ?></th>
					<th class="center"><?php echo JText::_("COM_ZMAXLOGIN_VIEW_EXTENSIONS_TITLE_TYPE");?></th>
					<th class="center"><?php echo JText::_("COM_ZMAXLOGIN_VIEW_EXTENSIONS_TITLE_VERSION");?></th>
					<th class="center"><?php echo JText::_("COM_ZMAXLOGIN_VIEW_EXTENSIONS_TITLE_AUTHOR");?></th>
					<th class="center"><?php echo JText::_("COM_ZMAXLOGIN_VIEW_EXTENSIONS_TITLE_POST_DATE");?></th>
					<th class="center"><?php echo JText::_("COM_ZMAXLOGIN_VIEW_EXTENSIONS_TITLE_PUBLISHED");?></th>
					<th class="center"><?php echo JText::_("COM_ZMAXLOGIN_VIEW_EXTENSIONS_TITLE_ID");?></th>
				</tr>
			</thead>
			<tbody>
				<?php foreach ($this->items as $i => $item) :?>
				<tr class="row<?php echo $i % 2; ?>" sortable-group-id="<?php echo $item->id; ?>">
					<td class="center ">
						<?php echo JHtml::_('grid.id', $i, $item->id); ?>
					</td>
					<td class="center">
						<a href="index.php?option=com_zmaxlogin&task=extension.edit&id=<?php echo $item->id;?>">
							<img width="25px" src="components/com_zmaxlogin/images/<?php echo $item->logintype;?>_image/<?php echo $item->logintype;?>_logo_16_16.png"/>
						</a>
					</td>
					<td class="center">
						<a href="index.php?option=com_zmaxlogin&task=extension.edit&id=<?php echo $item->id;?>">
						<?php echo $item->logintype;?>
						</a>
					</td>
					<td class="center">
						<?php echo $item->version;?>
					</td>
					<td class="center">
						<?php echo $item->author;?>
					</td>
					<td class="center">
						<?php echo JHtml::_('date', $item->post_date, 'Y-m-d'); ?>
					</td>
					<td class="center">
						<?php echo  JHTML::_('grid.published',$item->published, $item->id ,'tick.png','publish_x.png','extensions.');?>
				
					</td>
					<td class="center">
						<?php echo $item->id;?>
					</td>
				</tr>
				<?php endforeach; ?>
			</tbody>
		</table>
		<?php endif; ?>
		<?php  echo $this->pagination->getListFooter(); ?>
		
		<input type="hidden" name="task" value="" />
		<input type="hidden" name="boxchecked" value="0" />
		<?php echo JHtml::_('form.token'); ?>
	</div>
</form>
