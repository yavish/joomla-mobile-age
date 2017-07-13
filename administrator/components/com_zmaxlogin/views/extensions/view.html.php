<?php
/**
 *	description:ZMAX第三方登陆系统 扩展列表文件
 *  author：min.zhang
 *  Email:zhang19min88@163.com
 *	Url:http://www.zmax99.com
 *  copyright:南宁市程序人软件科技有限责任公司保留所有权利
 *  date:2015-01-12
 * @license GNU General Public License version 3, or later
 */
defined('_JEXEC') or die;

class zmaxLoginViewExtensions extends JViewLegacy
{
	public function display($tpl = null)
	{
		$items = $this->get('Items');
		$pagination = $this->get('Pagination');
		$state = $this->get('State');
		if(count($errors = $this->get('Errors')))
		{
			JError::raiseError(500, implode('<br />',$errors));
			return false;
		}
		if ($this->getLayout() !== 'modal')
		{
			zmaxloginHelper::addSubmenu('extensions');
		}
		$this->sidebar = JHtmlSidebar::render();
		$this->items = $items;
		$this->pagination = $pagination;
		$this->addToolBar();
		parent::display($tpl);
	}

	 protected function addToolBar()
	 {
		JToolBarHelper::title(JText::_("COM_ZMAXLOGIN_TITLE_EXTENSIONS"));
		JToolBarHelper::deleteList("",'extensions.uninstall',JText::_('COM_ZMAXLOGIN_TOOLBAR_EXTENSIONS_UNINSTALL'));
		JToolBarHelper::publish('extensions.publish',JText::_('COM_ZMAXLOGIN_TOOLBAR_EXTENSIONS_PUBLISHED'));
		JToolBarHelper::unpublish('extensions.unpublish',JText::_('COM_ZMAXLOGIN_TOOLBAR_EXTENSIONS_UNPUBLISHED'));
		JToolBarHelper::editList('extension.edit',JText::_('配置插件'));
		if (JFactory::getUser()->authorise('core.admin', 'com_zmaxlogin'))
		{
			JToolBarHelper::preferences('com_zmaxlogin');
		}
	  }
	
	

}
