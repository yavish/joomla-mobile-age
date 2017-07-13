<?php
defined('_JEXEC') or die;
use Joomla\Registry\Registry;

if (!class_exists('SimpliHelper')) {
	class SimpliHelper {
		private $params = null;
		private $template = null;
		private $style_id = 0;
		private $data = array();
		private $isHome = false;
		private $defaultParams = null;

		public function __construct () {
		}

		public function loadStyle ($id) {
			$db = JFactory::getDBO();
			$query = $db->getQuery(true)
						->select ('*')
						->from('#__template_styles')
						->where('id=' . $id);
			$db->setQuery($query);
			$tpl = $db->loadObject();
			if ($tpl) {
				$this->params = new Registry;
				$this->params->loadString ($tpl->params);
				$this->style_id = $tpl->id;
				$this->template = $tpl->template;
				$this->isHome = $tpl->home;

			// parse tplhelper json
			$this->data['tplhelper'] = json_decode($this->getParam('tplhelper'), true);

			// base url
			$this->params->set ('baseUrl', JUri::root(true) . '/');
				
			}
		}

		public function loadDefaultStyleParams() {
			if ($this->isHome) {
				$this->defaultParams = $this->params;
				return;
			}

			$db = JFactory::getDBO();
			$query = $db->getQuery(true)
						->select ('*')
						->from('#__template_styles')
						->where('home=1')
						->where('client_id=0');
			$db->setQuery($query);
			$tpl = $db->loadObject();
			if ($tpl) {
				$this->defaultParams = new Registry;
				$this->defaultParams->loadString ($tpl->params);
			}
		}

		public function init ($template = null) {
			if ($template !== null) {
				$this->params = $template->params;
				$tpl = JFactory::getApplication()->getTemplate(true);
				$this->style_id = $tpl->id;
				$this->template = $tpl->template;
				$this->isHome = $tpl->home;
			}

			$app = JFactory::getApplication();
			$doc = JFactory::getDocument();

			$this->data['option']   = $app->input->getCmd('option', '');
			$this->data['view']     = $app->input->getCmd('view', '');			

			$itemid       = JRequest::getVar('Itemid');
			$menu         = $app->getMenu()->getActive();
			if (!$menu) $menu = $app->getMenu()->getDefault();
			$this->data['page-class']    = $menu->params->get('pageclass_sfx');

			// parse tplhelper json
			$this->data['tplhelper'] = json_decode($this->getParam('tplhelper'), true);

			// base url
			$this->params->set ('baseUrl', JUri::base(true) . '/');

			// header
			$this->data['header-enabled'] = $this->getParam('layoutEnable_header', 1);
			$this->data['header-left-class'] = $this->data['header-right-class'] = $this->data['header-right-pos'] = '';
			if ($this->data['header-enabled']) {
				$this->data['header-left-class'] = 'span' . $this->getParam('layoutWidth_header_left', 3);
				

				if ($this->getParam('layoutEnable_header_right', 1)) {
					$this->data['header-right-pos'] = $this->getParam('layoutPos_header_right', 'banner-top');
					if ($doc->countModules ($this->data['header-right-pos'])) {
						$this->data['header-right-class'] = 'span' . ($this->getParam('layoutWidth_header_right') ? $this->getParam('layoutWidth_header_right') : 12 - $this->getParam('layoutWidth_header_left', 3));
					}
				}
			}

			// main navigation
			$this->data['nav-enabled'] = $this->getParam('layoutEnable_nav', 1);
			$this->data['nav-left-class'] = $this->data['nav-right-class'] = $this->data['nav-left-pos'] = $this->data['nav-right-pos'] = '';
			if ($this->data['nav-enabled']) {
				$this->data['nav-left-pos'] = $this->getParam('layoutPos_nav_left', 'position-1');
				$this->data['nav-left-class'] = 'span' . $this->getParam('layoutWidth_nav_left', 9);
				
				if ($this->getParam('layoutEnable_nav_right', 1)) {
					$this->data['nav-right-pos'] = $this->getParam('layoutPos_nav_right', 'position-0');
					if ($doc->countModules ($this->data['nav-right-pos'])) {
						$this->data['nav-right-class'] = 'span' . ($this->getParam('layoutWidth_nav_right') ? $this->getParam('layoutWidth_nav_right') : 12 - $this->getParam('layoutWidth_nav_left', 9));
					}
				}
			}

			// main content
			$this->data['content-enabled'] = $this->getParam ('layoutEnable_content', 1);
			$this->data['main-class'] = $this->data['col1-class'] = $this->data['col2-class'] = null;
			if ($this->data['content-enabled']) {
				$col1 = $col2 = 0;
				if ($this->getParam ('layoutEnable_col_1', 0)) {
					$this->data['col1-pos'] = $this->getParam ('layoutPos_col_1', 'position-7');
					if ($doc->countModules($this->data['col1-pos'])) {
						$col1 = $this->getParam ('layoutWidth_col_1', 3);
						$this->data['col1-class'] = 'span' . $col1;
					}
				}
				if ($this->getParam ('layoutEnable_col_2', 0)) {
					$this->data['col2-pos'] = $this->getParam ('layoutPos_col_2', 'position-8');
					if ($doc->countModules($this->data['col2-pos'])) {
						$col2 = $this->getParam ('layoutWidth_col_2', 3);
						$this->data['col2-class'] = 'span' . $col2;
					}
				}
				$main = 12 - $col1 - $col2;
				if ($main < 3) $main = 12;
				$this->data['main-class'] = 'span' . $main;
				if ($this->getParam ('layoutPosition_content', 'left') == 'right') {
					$this->data['main-class'] .= ' pull-right';
				}
			}

			// run once after saving template params
			$this->afterSave();
		}

		public function get ($name, $default = null) {		
			return isset ($this->data[$name]) ? $this->data[$name] : $this->getParam($name, $default);
		}

		public function getParam ($name, $default = null) {
			$val = $this->params->get ($name, $default);
			if ($val == 'use-default' && !$this->isHome) {
				if (!$this->defaultParams) $this->loadDefaultStyleParams();
				$val = $this->defaultParams->get ($name, $default);
			}
			if ($val == 'use-default') $val = $default;
			return $val;
		}

		public function setParam ($name, $value) {
			$this->params->set ($name, $value);
		}

		public function _ ($name, $glue = ' ', $separator = '') {
			$val = $this->get($name);
			if (is_array($val)) $val = implode($glue, $val);
			echo $val ? $separator . $val : '';
		}

		public function is ($name) {
			return (bool) $this->get($name);
		}

		public function has ($name) {
			return $this->is($name);
		}

		public function hasContainer ($section) {
			return ($this->getParam('layoutContainer_' . $section) == 1 ||
				($this->getParam('layoutContainer_' . $section, '') === '' && $this->getParam('layoutContainer', 1) == 1));
		}

		public function _container_open ($section) {
			if ($this->hasContainer($section)) {
				echo '<div class="container">';
			} else {
				echo '<div class="no-container">';
			}

		}

		public function _container_close ($section) {
			//if ($this->hasContainer($section)) {
				echo '</div>';
			//}
		}

		public function _bg ($section) {
			$background = $this->getParam('layoutBackground_' . $section) ? ' style="background-image:url(' . $this->getParam('layoutBackground_' . $section) . ');"' : '';
			echo $background;
		}

		public function _row_class ($section) {
			if ($this->hasContainer($section)) {
				echo 'row';
			} else {
				echo 'row-fluid';
			}
		}

		public function getStyleId () {
			return $this->style_id;
		}

		public function groupNeedUpdate ($group) {
			$needUpdate = false;
			// check if change in params, then save
			$tplhelper = $this->get('tplhelper');
			if (is_array($tplhelper) && isset($tplhelper[$group]) && $tplhelper[$group] == 1) $needUpdate = true;

			return $needUpdate;
		}

		/**
		 * Save settings into file to allow rollback
		 */
		public function saveRevision ($prefix, $group) {			
			$path = JPATH_ROOT . $this->getMediaLocation() . '/revisions/' . $group . '/';
			$needUpdate = $this->groupNeedUpdate($group);
			if (!is_dir($path)) {
				// create folder
				jimport('joomla.filesystem.folder');
				if (!JFolder::create ($path)) return false;
				$needUpdate = true;
			}
			// check if change in params, then save
			if (!$needUpdate) return false;

			// export all var with $prefix and store in a file
			$lines = array();
			foreach ($this->params->toArray() as $name => $value) {
				// $value = json_encode($value);
				if (is_array($value)) $value = implode(',', $value);
				if (strpos ($name, $prefix) === 0) {
					$lines[] = $name . ': ' . preg_replace('/[\r\n]+/', '\\n', $value);
				}
			}

			// save to file
			$filename = $this->getStyleId();
			$filename .= '-' . JFactory::getDate()->format('Y.m.d-h.i.s') . '.nvp';
			jimport('joomla.filesystem.file');
			file_put_contents($path . $filename, implode("\n", $lines));

			return true;
		}

		public function getCustomCssPath ($url = false) {
			$path = $this->getMediaLocation() . '/css/custom-styles/' . $this->getStyleId() . '.css';
			$custom_css_file = JPATH_ROOT . $path;
			$custom_css_url = JUri::base(true) . $path;
			return $url ? $custom_css_url : $custom_css_file;
		}

		public function getMediaLocation () {
			return '/media/' . $this->template;
		}

		public function saveCustomStyle () {
			// check custom css file existed or need update
			$custom_css_file = $this->getCustomCssPath();
			if (!is_file($custom_css_file) || $this->groupNeedUpdate('styles')) {
				$custom_css = $this->buildCustomStyle();
				// write to file
				jimport('joomla.filesystem.file');
				return JFile::write ($custom_css_file, $custom_css);
			}
		}

		public function clearTplStatus () {
			// update the tplhelper value to prevent change file later
			$needUpdate = false;
			$tplhelper = $this->get('tplhelper');
			if (!is_array($tplhelper)) return;
			foreach ($tplhelper as $group => $val) {
				if ($val) $needUpdate = true;
			}
			if (!$needUpdate) return ;

			$tplParams = $this->params;
			$tplParams->set('tplhelper', '');

			$db = JFactory::getDBO();
			$query = $db->getQuery(true)
						->update('#__template_styles')
						->set('params = ' . $db->quote(json_encode($tplParams->toArray())))
						->where('id=' . $this->getStyleId());
			$db->setQuery($query);
			$db->execute();
		}

		/**
		 * Compile settings into custom style css 
		 */
		public function buildCustomStyle () {
			static $custom_style_css = null;
			if ($custom_style_css !== null) return $custom_style_css;

			$custom_css_tpl_file = __DIR__ .'/css/custom-styles.tpl.css';
			if (!is_file($custom_css_tpl_file)) return; // no custom style file

			$custom_style_css = file_get_contents ($custom_css_tpl_file);
			// replace condition pattern
			$arr = preg_split('/\/\* \?([^\s]+) \*\//m', $custom_style_css, -1, PREG_SPLIT_DELIM_CAPTURE);
			$i = 0;
			$chucks = array();
			$chucks[] = $arr[0];
			while ($i < count($arr)-2) {
				// first chuck, no precess
			  	$checkVar = $arr[++$i];
			  	$tmp = explode(':', $checkVar, 2);
			  	$checkVar = $tmp[0];
			  	$checkValue = count($tmp) > 1 ? $tmp[1] : null;
			    $checkArr = preg_split('/\/\* \/' . $checkVar . ' \*\//', $arr[++$i]);
			    $checkStr = count($checkArr) > 1 ? $checkArr[0] : null;
			  	if ($checkStr) {
			  		// check if match with value then add, else ignore the block
			  		if (($checkValue !== null && $this->getParam($checkVar) == $checkValue) || ($checkValue === null && $this->getParam($checkVar))) {
			  			$tplParams = $this->params;
			  			$checkStr = preg_replace_callback ('/\{?__([0-9a-zA-Z_]+)\}?/', function ($matches) use ($tplParams) {
				            return $tplParams->get($matches[1], 'inherit');
				        }, $checkStr);
						$chucks[] = $checkStr;
			  		}
			  		// push no process style
			  		if (count($checkArr) > 1) $chucks[] = $checkArr[1];
			  	} else {
			  		// wrong pattern, just ignore the separator
			  		$chucks[] = $arr[$i];
			  	}
			}
			if (count($chucks) > 1)
				$custom_style_css = implode('', $chucks);

			// replace variables
			$tplParams = $this->params;
			$custom_style_css = preg_replace_callback ('/\{?__([0-9a-zA-Z_]+)\}?/', function ($matches) use ($tplParams) {
	            return $tplParams->get($matches[1], 'inherit');
	        }, $custom_style_css);

	        return $custom_style_css;
		}

		/**
		 * Auto detect after template save to compile custom css and store settings revision
		 */
		public function afterSave () {
			// Check and save config revision, build custom css file
			$this->saveRevision ('style', 'styles');
			$this->saveRevision ('layout', 'layouts');
			$this->saveCustomStyle();
			$this->clearTplStatus();
		}

		/**
		 * Add custom style css
		 */
		public function addCustomStyle () {
			$html = '';
			$google_fonts = preg_split('/\n/', $this->getParam('styleGoogleFonts'));
			foreach ($google_fonts as $font) {
				$font = trim($font);
				if(!$font) continue;
				$html .= '<link href="https://fonts.googleapis.com/css?family=' . ($font) . '" rel="stylesheet" type="text/css" >' . "\n";
			}

			if (is_file($this->getCustomCssPath())) {
				$html .= '<link id="custom-style-css" href="' . $this->getCustomCssPath(true) . '" rel="stylesheet" type="text/css" >' . "\n";
			} else {
				$html .= '<style type="text/css" id="custom-style-css">' . "\n";
				$html .= $this->buildCustomStyle() . "\n";
				$html .= '</style>' . "\n";
			}

			echo $html;
		}


		/**
		 * Render a spotlight
		 */
		public function spotlight ($pos, $options = array()) {			
			if ($this->getParam('layoutEnable_' . $pos)) {			
			
				$position = $this->getParam('layoutPos_' . $pos);
				$posWidth = $this->getParam('layoutWidth_' . $pos);

				$modules = JModuleHelper::getModules($position);

				if (!count($modules)) return;

				$widths = array();
				$posWidth = preg_replace ('/\s/', '', $posWidth);
				if (preg_match('/^[0-9,:-]+$/', $posWidth)) {
					$widths = preg_split('/[,:-]/', $posWidth);
				} else {
					if ($posWidth == 'none') {
						$widths[] = '';
					} else {
						// auto width
						$col = count($modules);
						$width = $col < 6 ? floor (12 / $col) : 2;
						$lastWidth = $col < 6 ? 12 - $width * ($col - 1) : 2;
						$widths = $col > 1 ? array_fill(0, $col-1, $width) : array();
						$widths[] = $lastWidth;
					}
				}

				// pust into columns
				$columns = array();
				$mod = round(count ($modules) / count($widths));
				$c = 0;
				for ( $i =0; $i < count($widths); $i++) {
					$col = new stdclass();
					$col->width = $widths[$i] ? 'span' . $widths[$i] : '';
					$col->html = '';
					while($c < count($modules) && $c < ($i+1) * $mod) {
						$col->html .= JModuleHelper::renderModule($modules[$c], array('style'=>'JAxhtml')) . "\n";
						$c++;
					}
					$columns[] = $col;
				}
				$options['key'] = $pos;
				$options['id'] = $this->getParam('layoutName_' . $pos) ? $this->getParam('layoutName_' . $pos) : $pos;
				$class = isset($options['class']) ? $options['class'] . ' section ' : 'section ';
				$class .= is_array($this->getParam('layoutClass_' . $pos)) ? implode(' ', $this->getParam('layoutClass_' . $pos)) : $this->getParam('layoutClass_' . $pos);
				$options['class'] = $class ? ' class="' . trim($class) . '"' : '';
				$options['row'] = $posWidth !== 'none';
				
				// display the column
				echo JLayoutHelper::render ('simpli.position', array('columns' => $columns, 'options' => $options, 'helper' => $this));
			}
		}
	}
}	

return new SimpliHelper();