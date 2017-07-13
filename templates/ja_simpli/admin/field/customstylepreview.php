<?php
/**
 * @package     Joomla.Libraries
 * @subpackage  Form
 *
 * @copyright   Copyright (C) 2005 - 2009 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('JPATH_PLATFORM') or die;

/**
 * Form Field class for the Joomla Framework.
 *
 * @since  2.5
 */
class JFormFieldCustomstylepreview extends JFormField
{
	/**
	 * The field type.
	 *
	 * @var		string
	 */
	protected $type = 'CustomStylePreview';
	protected function getInput()
	{
		return '<div id="custom-style-preview"><iframe src="about:blank"></iframe></div>';
	}

	/**
	 * Method to get the field label markup for a spacer.
	 * Use the label text or name from the XML element as the spacer or
	 * Use a hr="true" to automatically generate plain hr markup
	 *
	 * @return  string  The field label markup.
	 *
	 * @since   11.1
	 */
	protected function getLabel()
	{
		return '';
	}

	public function setup(SimpleXMLElement $element, $value, $group = null)
	{
		$doc = JFactory::getDocument();
		// add custom-style-style
		$custom_style_file = dirname(dirname(__DIR__)) . '/css/custom-styles.tpl.css';
		$custom_style_tpl = is_file($custom_style_file) ? file_get_contents($custom_style_file) : '';
		$script = 'var custom_style_tpl = ' . json_encode($custom_style_tpl);
		$script .= ', site_root_url = "' . JUri::root() . '";';
		$doc->addScriptDeclaration ($script);
		return parent::setup($element, $value, $group);
	}

}
