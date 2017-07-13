<?php 
/**
 * @package Module mod_zmaxqqonline for Joomla! 3.0
 * @author min.zhang
 * @copyright (C) 2010- 2015 南宁市程序人软件科技有限责任公司 。All rights reserved。
 * @license GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
 *
 */
 
// no direct access
defined('_JEXEC') or die('Restricted access');

class JFormFieldPreview extends JFormField
{
	protected $type="Preview";
	
	protected function getInput()
	{
		$defaultStyle = $this->element['default'];
		if($defaultStyle == "")
		{
			$defaultStyle="round";
		}
		$doc = JFactory::getDocument();
		$doc->addScript("../modules/mod_zmaxlogin/fields/changpic.js");
		
		$html = array();
		$html[] = '<div >';
		$html[] = '		<img id="stylePreview" src="../modules/mod_zmaxlogin/images/'.$defaultStyle.'_preview.jpg" />';
		$html[] = '</div>';
		
		return implode("\n" ,$html);		
	}
}

