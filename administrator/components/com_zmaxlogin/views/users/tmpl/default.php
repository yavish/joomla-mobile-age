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

// No direct access.
defined('_JEXEC') or die ('can not access this file!');

$option = JRequest::getCmd('option');
$listOrder = $this->state->get('list.ordering');
$listDirn = $this->state->get('list.direction');
JHtml::_('behavior.tooltip');
JHtml::_('behavior.formvalidation');
?>

<form action="<?php echo JRoute::_('index.php?option=com_zmaxlogin&view=users');?>" method="post" name="adminForm" id="adminForm">
	<?php if (!empty( $this->sidebar)) : ?>
	<div id="j-sidebar-container" class="span2">
		<?php echo $this->sidebar; ?>
	</div>
	<div id="j-main-container" class="span10">
	<?php else : ?>
	<div id="j-main-container">
	<?php endif;?>
		<?php
		// Search tools bar
			echo JLayoutHelper::render('joomla.searchtools.default', array('view' => $this));
		?>
		<?php if (empty($this->items)) : ?>
		<div class="alert alert-no-items">
			<?php echo JText::_('JGLOBAL_NO_MATCHING_RESULTS'); ?>
		</div>
		<?php else : ?>
		
		<?php 
			$checkAll = JHtml::_('grid.checkall');			
			$loginType = JHTML::_('searchtools.sort',JText::_("COM_ZMAXLOGIN_USER_TITLE_TYPE"),'logintype',$listDirn,$listOrder);
			$nickName = JHTML::_('searchtools.sort',JText::_("COM_ZMAXLOGIN_USER_TITLE_NIKE"),'nick_name',$listDirn,$listOrder);
			$loginName = JHTML::_('searchtools.sort',JText::_("COM_ZMAXLOGIN_USER_TITLE_LOGINNAME"),'login_name',$listDirn,$listOrder);
			$email = JHTML::_('searchtools.sort',JText::_("COM_ZMAXLOGIN_USER_TITLE_EMAIL"),'email',$listDirn,$listOrder);
			$registerDate = JHTML::_('searchtools.sort',JText::_("COM_ZMAXLOGIN_USER_TITLE_REGISTER_DATE"),'register_date',$listDirn,$listOrder);
			$lastLoginDate = JHTML::_('searchtools.sort',JText::_("COM_ZMAXLOGIN_USER_TITLE_LASTLOGIN_DATE"),'lastlogin_date',$listDirn,$listOrder);
		?>
		<table class="table table-striped" id="toursList">
			<thead>
				<tr>
					<th class="center"><?php echo $checkAll;?></th>
					<th class="center"><?php echo $loginType;?></th>
					<th class="center"><?php echo $nickName;?></th>
					<th class="center"><?php echo $loginName;?></th>
					<th class="center"><?php echo $email;?></th>
					<th class="center"><?php echo $registerDate;?></th>
					<th class="center"><?php echo $lastLoginDate;?></th>
				</tr>
			</thead>
			<tbody>
				<?php foreach ($this->items as $i => $item) :?>
				<tr class="row<?php echo $i % 2; ?>" sortable-group-id="<?php echo $item->id; ?>">
					<td class="center ">
						<?php echo JHtml::_('grid.id', $i, $item->id); ?>
					</td>
					<td class="center">
						<?php echo $item->type;?>
					</td>
					<td class="center">
						<?php echo $item->nick_name;?>
					</td>
					<td class="center">
						<?php echo $item->login_name;?>
					</td>
					<td class="center">
						<?php echo $item->email;?>
					</td>
					<td class="center">
						<?php echo JHtml::_('date', $item->register_date, 'Y-m-d H:i:s'); ?>
						
					</td>
					<td class="center">
						<?php echo JHtml::_('date', $item->lastlogin_date, 'Y-m-d H:i:s'); ?>
					</td>
				</tr>
				<?php endforeach; ?>
			</tbody>
		</table>
		<?php endif; ?>
		<?php echo $this->pagination->getListFooter(); ?>
		
		<input type="hidden" name="task" value="" />
		<input type="hidden" name="boxchecked" value="0" />
		<?php echo JHtml::_('form.token'); ?>
	</div>
</form>
