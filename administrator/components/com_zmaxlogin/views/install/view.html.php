<?php
/**
 *	description:ZMAX第三方登陆系统 安装视图文件
 *  author：min.zhang
 *  Email:zhang19min88@163.com
 *	Url:http://www.zmax99.com
 *  copyright:南宁市程序人软件科技有限责任公司保留所有权利
 *  date:2015-01-18
 * @license GNU General Public License version 3, or later
 */

defined('_JEXEC') or die;

class zmaxLoginViewInstall extends JViewLegacy
{

	public function display($tpl = null)
	{
		$this->addToolBar();
		if ($this->getLayout() !== 'modal')
		{
			zmaxloginHelper::addSubmenu('install');
		}
		$this->sidebar = JHtmlSidebar::render();
		
		parent::display($tpl);
	}
	  protected function addToolBar()
	  {
		JToolBarHelper::title(JText::_("COM_ZMAXLOGIN_TITLE_INSTALL"));
		if (JFactory::getUser()->authorise('core.admin', 'com_zmaxlogin'))
		{
			JToolBarHelper::preferences('com_zmaxlogin');
		}
	  }
	
	

}
