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
 
defined('_JEXEC') or die('Restricted access');
jimport('joomla.application.component.view');

class zmaxloginViewMain extends JViewLegacy
{
     function display($tpl = null)	 
	 {
		
		$this->addToolBar();
		
		if ($this->getLayout() !== 'modal')
		{
			zmaxloginHelper::addSubmenu('main');
		}
		$this->sidebar = JHtmlSidebar::render();
		
		parent::display($tpl);
	 }
	 
	 function getComponentInfo()
	 {
		$zmaxlogin = JComponentHelper::getComponent('com_zmaxlogin');
		$db = JFactory::getDBO();
		$query = $db->getQuery(true);
		$query->select("manifest_cache");
		$query->from("#__extensions");
		$query->where("extension_id =".$zmaxlogin->id);
		$db->setQuery($query);
		$item = $db->loadObject();
		$item = json_decode($item->manifest_cache);
		return $item;

	 }
	 
	 /**
	  * 设置工具栏
	  * 
	  * @access protected
	  */
	  protected function addToolBar()
	  {
		
		JToolBarHelper::title(JText::_("COM_ZMAXLOGIN_TITLE_MAIN"));
		if(!zmaxloginHelper::isActive())
		{
			JToolBarHelper::addNew('active.active',JText::_("COM_ZMAXLOGIN_TOOLBAR_MAIN_ACTIVE"));
		}
		if (JFactory::getUser()->authorise('core.admin', 'com_zmaxlogin'))
		{
			JToolBarHelper::preferences('com_zmaxlogin');
		}
	  }
	  
}