<?php 
/**
 *	description:ZMAX第三方登陆 订单视图
 *  author：min.zhang
 *  Email:zhang19min88@163.com
 *	Url:http://www.zmax99.com
 *  copyright:南宁市程序人软件科技有限责任公司保留所有权利
 *  date:2014-11-22
 * @license GNU General Public License version 3, or later
 */
defined('_JEXEC') or die('Restricted access');

jimport('joomla.application.component.view');

class zmaxloginViewExtension extends JViewLegacy
{

     function display($tpl = null)	 
	 {
		// Disable main menu
		JRequest::setVar('hidemainmenu' , true);
		$this->item = $this->get('Item');
		$this->form = $this->get('Form');

		
		$this->addToolBar();
		
	
		//display the template
		parent::display($tpl);
	 }
	 
	 /**
	  * 设置工具栏
	  * 
	  * @access protected
	  */
	  protected function addToolBar()
	  {
		
		JToolBarHelper::title(JText::_("ZMAX第三方登陆系统 - 扩展配置"));
		JToolBarHelper::cancel('extension.cancel',"关闭");
		JToolBarHelper::apply('extension.apply');
	  }
}