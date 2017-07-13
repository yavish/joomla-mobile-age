<?php
/**
 * @package     Joomla.Libraries
 * @subpackage  Form
 *
 * @copyright   Copyright (C) 2005 - 2009 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('JPATH_PLATFORM') or die;
JFormHelper::loadFieldClass('list');
/**
 * Form Field class for the Joomla Framework.
 *
 * @since  2.5
 */
class JFormFieldGooglefont extends JFormFieldList
{
	/**
	 * The field type.
	 *
	 * @var		string
	 */
	protected $type = 'GoogleFont';
	protected function getInput()
	{
		$html = parent::getInput();
		// inject data-value attribute
		$data_value = 'data-value="' . htmlentities($this->value) . '"';
		$empty_option = '<option value="">' . JText::_('TPL_SIMPLI_SELECT_FONT') . '</option>';
		$html = preg_replace('/<select ([^>]*)>/', '<select ' . $data_value . ' \1>' . $empty_option, $html);
		return $html;
	}

}
