<?php
/**
 *	description:ZMAX第三方登陆系统 扩展模型文件
 *  author：min.zhang
 *  Email:zhang19min88@163.com
 *	Url:http://www.zmax99.com
 *  copyright:南宁市程序人软件科技有限责任公司保留所有权利
 *  date:2015-01-20
 * @license GNU General Public License version 3, or later
 */
 
defined('_JEXEC') or die();
use Joomla\Registry\Registry;
jimport('joomla.application.component.modeladmin');

class zmaxloginModelExtension extends JModelAdmin
{
	public function getForm( $data = array() , $loadData = true)
	{
		$this->addExtensionForm();
		$formName = $this->getItem()->logintype."_config";
		$form = $this->loadForm('com_zmaxlogin.extension' ,$formName ,array('control' =>' jform' ,'load_data' => $loadData ));
		if(!$form)
		{
			return false;
		}
		return $form;
	}
	
	public function loadFormData()
	{
		//Load form data
		$data = $this->getItem();
		return $data->params;
	}
	
	public function addExtensionForm()
	{
		$pathToXMLFile = JPATH_COMPONENT_ADMINISTRATOR."/plugins/config";
		$pathToXMLFile = JPath::clean($pathToXMLFile);
		JForm::addFormPath($pathToXMLFile);
		
	}
	
	public function save($data)
	{
		$registry = new Registry;
        $registry->loadArray($data["jform"]);
        $data['params'] = (string)$registry;
		
		$table = $this->getTable();
		
		if(!$table->bind($data))
		{
			$this->setError($this->_db->getErrorMsg());
			return false;
		}
		
		if(!$table->check())
		{
			$this->setError($this->_db->getErrorMsg());
			return false;
		}
		if(!$table->store())
		{
			$this->setError($this->_db->getErrorMsg());
			return false;
		}
		return true;
	
	}
	
	
}


?>