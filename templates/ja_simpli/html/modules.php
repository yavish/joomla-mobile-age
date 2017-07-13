<?php
/** 
 *------------------------------------------------------------------------------
 * @package       SIMPLI - Free Template for Joomla!
 *------------------------------------------------------------------------------
 * @copyright     Copyright (C) 2004-2016 JoomlArt.com. All Rights Reserved.
 * @license       GNU General Public License version 2 or later; see LICENSE.txt
 * @authors       JoomlArt
 *------------------------------------------------------------------------------
**/

defined('_JEXEC') or die('Restricted access');

/**
 * This is a file to add template specific chrome to module rendering.  To use it you would
 * set the style attribute for the given module(s) include in your template to use the style
 * for each given modChrome function.
 *
 * eg.  To render a module mod_test in the sliders style, you would use the following include:
 * <jdoc:include type="module" name="test" style="slider" />
 *
 * This gives template designers ultimate control over how modules are rendered.
 *
 * NOTICE: All chrome wrapping methods should be named: modChrome_{STYLE} and take the same
 * three arguments.
 */


/*
 * Default Module Chrome that has sematic markup and has best SEO support
 */
function modChrome_JAxhtml($module, &$params, &$attribs)
{ 
	$badge          = preg_match ('/badge/', $params->get('moduleclass_sfx'))? '<span class="badge">&nbsp;</span>' : '';
	$moduleTag      = htmlspecialchars($params->get('module_tag', 'div'));
	$headerTag      = htmlspecialchars($params->get('header_tag', 'h3'));
	$headerClass    = $params->get('header_class');
	$bootstrapSize  = $params->get('bootstrap_size');
	$moduleClass    = !empty($bootstrapSize) ? ' span' . (int) $bootstrapSize . '' : '';
	$moduleClassSfx = htmlspecialchars($params->get('moduleclass_sfx'));

	if (!empty ($module->content)) {
		$html = "<{$moduleTag} class=\"ja-module module{$moduleClassSfx} {$moduleClass}\" id=\"Mod{$module->id}\">" .
					"<div class=\"module-inner\">" . $badge;

		if ($module->showtitle != 0) {
			$html .= "<{$headerTag} class=\"module-title {$headerClass}\"><span>{$module->title}</span></{$headerTag}>";
		}

		$html .= "<div class=\"module-ct\">{$module->content}</div></div></{$moduleTag}>";

		echo $html;
	}
}


function modChrome_tabs($module, $params, $attribs)
{
	$area = isset($attribs['id']) ? (int) $attribs['id'] :'1';
	$area = 'area-'.$area;

	static $modulecount;
	static $modules;

	if ($modulecount < 1) {
		$modulecount = count(JModuleHelper::getModules($attribs['name']));
		$modules = array();
	}

	if ($modulecount == 1) {
		$temp = new stdClass;
		$temp->content = $module->content;
		$temp->title = $module->title;
		$temp->params = $module->params;
		$temp->id = $module->id;
		$modules[] = $temp;

		// list of moduletitles
		echo '<ul class="nav nav-tabs" id="tab'.$temp->id .'">';

		foreach($modules as $rendermodule) {
			echo '<li><a data-toggle="tab" href="#module-'.$rendermodule->id.'" >'.$rendermodule->title.'</a></li>';
		}
		echo '</ul>';
		echo '<div class="tab-content">';
		$counter = 0;
		// modulecontent
		foreach($modules as $rendermodule) {
			$counter ++;

			echo '<div class="tab-pane  fade in" id="module-'.$rendermodule->id.'">';
			echo $rendermodule->content;
			
			echo '</div>';
		}
		echo '</div>';
		echo '<script type="text/javascript">';
		echo 'jQuery(document).ready(function(){';
			echo 'jQuery("#tab'.$temp->id.' a:first").tab("show")';
			echo '});';
		echo '</script>';
		$modulecount--;

	} else {
		$temp = new stdClass;
		$temp->content = $module->content;
		$temp->params = $module->params;
		$temp->title = $module->title;
		$temp->id = $module->id;
		$modules[] = $temp;
		$modulecount--;
	}
}