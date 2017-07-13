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
jimport('joomla.application.component.modellist');

class zmaxLoginModelExtensions extends JModelList
{
	public $_items ;
	public function __construct($config = array())
	{
		if(empty($config['filter_fields']))
		{
			$config['filter_fields'] = array('id');// add more
		}
		return parent::__construct($config);
	
	}
	protected function getListQuery()
	{
		zmaxloginHelper::checkPermit();
		$db =  JFactory::getDBO();
		
		$query = $db->getQuery(true);
		
		$query->select("*");
		
		$query->from( '#__zmax_extension');
		
		return $query;
	}
	 
}


?>