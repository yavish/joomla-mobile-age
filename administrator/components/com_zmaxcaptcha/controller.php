<?php

// ADMIN
defined('_JEXEC') or die('Restricted access');

jimport('joomla.application.component.controller');

class zmaxcaptchaController extends JControllerLegacy
{
	function display($cachable = false,$urlparams = false)
	{
		// set default view if not set
		$input = JFactory::getApplication()->input;
		$input ->set('view',$input->getCmd('view','main'));
		//call parent behavior
		parent::display($cachable);
	}
	
    
}