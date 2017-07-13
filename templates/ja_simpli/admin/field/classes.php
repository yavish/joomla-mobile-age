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
class JFormFieldClasses extends JFormField
{
	/**
	 * The field type.
	 *
	 * @var		string
	 */
	protected $type = 'Classes';
	protected function getInput()
	{
		$attr = '';
		// Initialize some field attributes.
		$attr .= !empty($this->class) ? ' class="' . $this->class . '"' : '';
		$attr .= !empty($this->size) ? ' size="' . $this->size . '"' : '';
		$attr .= $this->multiple ? ' multiple' : '';
		$attr .= $this->required ? ' required aria-required="true"' : '';
		$attr .= $this->autofocus ? ' autofocus' : '';

		// Build dropdown list base on the presets
		$options = array();

		$classes_file = dirname(dirname(__DIR__)) . '/etc/supported-classes.ini';
		$classes = parse_ini_file($classes_file, true);
		$groups = $this->element['groups'] ? explode('+', $this->element['groups']) : null;
		// no specified groups, use all groups
		if (!$groups) $groups = array_keys($classes);
		foreach ($groups as $group) {
			$group = trim($group);
			if (!isset($classes[$group])) continue;
			$options[$group] = array();
			foreach ($classes[$group] as $class => $class_title) {
				$options[$group][] = array(
					'text' => $class_title,
					'value' => $class
				);
			}
		}

		$html = JHtml::_(
				'select.groupedlist', $options, $this->name,
				array(
					'list.attr' => $attr, 'id' => $this->id, 'list.select' => $this->value, 'group.items' => null, 'option.key.toHtml' => false,
					'option.text.toHtml' => false
				)
			);
		return $html;
	}

}
