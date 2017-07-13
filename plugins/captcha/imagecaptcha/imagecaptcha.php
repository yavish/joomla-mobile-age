<?php
/**
 *	description:ZMAX验证码插件 主文件
 *  author：min.zhang
 *  Email:zhang19min88@163.com
 *	Url:http://www.zmax99.com
 *  copyright:南宁市程序人软件科技有限责任公司保留所有权利
 *  date:2015-05-27
 */
defined('_JEXEC') or die;
jimport('joomla.environment.browser');
jimport('joomla.log.log');
JLog::addLogger(array('text_file'=>'zmaxcaptcha.log.php') ,JLOG::ALL ,array('zmax'));
if(!defined('DS')) define('DS', DIRECTORY_SEPARATOR);
 
class plgCaptchaImagecaptcha extends JPlugin
{
	protected $_path_root ="";
	protected $_code="";
	protected $_imageName="";
	protected $_inputName="";
	
	public function __construct($subject, $config)
	{	
		$this->_path_root= JPATH_ADMINISTRATOR.DS.'components'.DS.'com_zmaxcaptcha'.DS.'libs'.DS.'captcha';
		$this->_imageName="zmax.png";
		include($this->_path_root.'/captcha.php');
		parent::__construct($subject, $config);
		$this->loadLanguage();
	}

	/**
	 * @description Initialise the captcha
	 * @param	string	$id	The id of the field.
	 * @return	Boolean	True on success, false otherwise
	 */
	public function onInit($id)
	{
		//add js
		$doc = JFactory::getDocument();
		$doc->addScript(JURI::root().'plugins/captcha/imagecaptcha/js/changeCode.js');
		
		$css = "#zmax_captcha_image img {
				cursor: pointer;
				}";
		$doc->addStyleDeclaration($css);
		
		//new captcha
		$captcha = new CValidateCode($this->_path_root); 
		$captcha->createImage($this->_imageName);
		$this->_code = $captcha->getCode();
		require_once(JPATH_SITE.'/components/com_zmaxcaptcha/helpers/zmaxcaptcha.php');
		zmaxcaptchaHelper::saveCode($this->_code);
		
		return true;
	}

	/**
	 * @description Gets the challenge HTML
	 * @return  string  The HTML to be embedded in the form.
	 */
	public function onDisplay($name, $id, $class)
	{
		$this->_inputName = $this->_type;
		$valida = "validate-".$this->_inputName." ";
		$class='class="required '.$valida.'"';
		
		$image = '<div style="margin-top:10px" id="zmax_captcha_image"><img src="'.JURI::root().'administrator/components/com_zmaxcaptcha/libs/captcha/'.$this->_imageName.'?t=0" width="100" height="50" title="看不清？点击换一张" onClick="changeCode(this)" /></div>';		
		return '<input type="text" autocomplete="off"  '.$class.' name="'.$name.'" id="'.$id.'"  />'.$image;
	}

	 /**
	  * @description check inputcode whether equal captcha
	  * @return  True if the answer is correct, false otherwise
	  *
	  */
	public function onCheckAnswer($code)
	{	
		require_once(JPATH_SITE.'/components/com_zmaxcaptcha/helpers/zmaxcaptcha.php');
		$myCode = zmaxcaptchaHelper::getCode();
		
		if($myCode != $code)
		{
			$this->_subject->setError(JText::_('验证码输入错误，请重新输入!'));
			return false;
		}
		return true;
	}
	
	
	
}
