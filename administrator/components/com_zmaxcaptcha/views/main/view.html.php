<?php
/**
 * @copyright	Copyright (C) 2005 - 2013 zmax程序人, Inc. All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

/**
 * View class
 *
 * @subpackage	com_captcha
 * @since		1.5
 */
class zmaxcaptchaViewMain extends JViewLegacy
{
	/**
	 * Display the view
	 */
	public function display($tpl = null)
	{
		// Just show layout
		parent::display($tpl);
		$this->addScript();
		$this->addToolbar();
	}
	
	
	public function addScript()
	{
		// Do Nothing

	}
	
	 /**
	  * 设置工具栏
	  * 
	  * @access protected
	  */
	  protected function addToolBar()
	  {		
		JToolBarHelper::title(JText::_("COM_ZMAXCAPTCHAR_VIEW_MAIN_TITLE"));
		JToolBarHelper::preferences('com_zmaxcaptcha');
		
	  }
	  
	  function getComponentInfo()
	 {
		$zmax = JComponentHelper::getComponent('com_zmaxcaptcha');
		$db = JFactory::getDBO();
		$query = $db->getQuery(true);
		$query->select("manifest_cache");
		$query->from("#__extensions");
		$query->where("extension_id =".$zmax->id);
		$db->setQuery($query);
		$item = $db->loadObject();
		$item = json_decode($item->manifest_cache);
		return $item;

	 }
	
}
