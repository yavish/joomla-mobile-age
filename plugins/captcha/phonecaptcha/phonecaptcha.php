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
 
class plgCaptchaPhonecaptcha extends JPlugin
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
		$doc->addScript(JURI::root().'plugins/captcha/phonecaptcha/js/changeCode.js');
		$doc->addStyleSheet(JURI::root().'plugins/captcha/phonecaptcha/css/captcha.css');
		
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
		$image ='<div class="syscaptchabox"><input type="text" autocomplete="off"  '.$class.' name="'.$name.'" id="'.$id.'"  /><img src="'.JURI::root().'administrator/components/com_zmaxcaptcha/libs/captcha/'.$this->_imageName.'?t=0" width="100" height="50" title="看不清？点击换一张" onClick="changeCode(this)" /></div>';		
		$phone='<div class="zmaxinputbox"><label for="jform_phoneno">你的手机号:</label><input  id="jform_phoneno"  name="jform[phoneno]"  type="text" required="required"  class="validate-phoneno" size="12" /><a  id="zmaxsendbtn" class="zmaxbtn" onclick="sendMsg();return false;" >免费获取验证码</a></div>';
		$code='<div class="zmaxcodebox"><label for="jform_phonecode">手机验证码:</label><input id="jform_phonecode" required="true" class="validate-phonecode" name="phonecode" type="text" size="12" /></div>';
		return $image.$phone.$code;	
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
	

/*
	function onContentPrepareForm($form, $data)
	{
		if (!($form instanceof JForm))
		{
			$this->_subject->setError('JERROR_NOT_A_FORM');
			return false;
		}

		// Check we are manipulating the registration form
		if ($form->getName() != 'com_users.registration')
		{
			return true;
		}

		// Check whether this is frontend or admin
		if (JFactory::getApplication()->isAdmin()) {
			return true;
		}

		// Remove/Hide fields on frontend
		// Note: since the onContentPrepareForm event gets fired also on
		// submission of the registration form, we need to hide rather than
		// remove the mandatory fields. Otherwise, subsequent filtering of the data
		// from within JModelForm.validate() will result in the required fields
		// being stripped from the user data prior to attempting to save the user model,
		// which will trip an error from inside the user object itself on save!
		$form->removeField('password2');
		$form->removeField('email2');

		$form->setFieldAttribute('name', 'type', 'hidden');
		$form->setValue('name', null, 'placeholder');
		$form->setFieldAttribute('email1', 'type', 'hidden');
		$form->setValue('email1', null, JUserHelper::genRandomPassword(10) . '@invalid.nowhere');

		// Re-label the username field to 'Email Address' (the Email field
		// ordinarily appears below the password field on the default Joomla
		// registration form)
		$form->setFieldAttribute('username', 'label', 'COM_USERS_REGISTER_EMAIL1_LABEL');

		return true;
	}

	*/
}
