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

defined('_JEXEC') or die;

class zmaxLoginViewUsers extends JViewLegacy
{

     function display($tpl = null)	 
	 {
		$this->items = $this->get('Items');
		$this->pagination =$this->get('Pagination');
		$this->state =$this->get('State');
		$this->filterForm    = $this->get('FilterForm');
		$this->activeFilters = $this->get('ActiveFilters');
		
		$this->listOrder = $this->state->get('list.ordering'); //需要排序的
		$this->listDir = $this->state->get('list.direction');//需要排序的方向
		
		if(count($errors = $this->get('Errors')))
		{
			JError::raiseError(500, implode('<br />',$errors));
			return false;
		}
		
		if ($this->getLayout() !== 'modal')
		{
			zmaxloginHelper::addSubmenu('users');
		}
		
		$this->addToolBar();
		$this->sidebar = JHtmlSidebar::render();
		
		parent::display($tpl);
		
	 }

	protected function addToolBar()
	{
		JToolBarHelper::title(JText::_("COM_ZMAXLOGIN_TITLE_USERS"));
		JToolBarHelper::deleteList("",'users.delete');
		if (JFactory::getUser()->authorise('core.admin', 'com_zmaxlogin'))
		{
			JToolBarHelper::preferences('com_zmaxlogin');
		}
	}
	
	

}
