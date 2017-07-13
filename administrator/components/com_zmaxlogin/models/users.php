<?php
/**
 *	description:ZMAX第三方登陆系统入口点文件
 *  author：min.zhang
 *  Email:zhang19min88@163.com
 *	Url:http://www.zmax99.com
 *  copyright:南宁市程序人软件科技有限责任公司保留所有权利
 *  date:2015-01-15
 * @license GNU General Public License version 3, or later
 */
 
defined('_JEXEC') or die();

jimport('joomla.application.component.modellist');

class zmaxLoginModelUsers extends JModelList
{
	public $_items ;
	public function __construct($config = array())
	{
		if(empty($config['filter_fields']))
		{
			$config['filter_fields'] = array(
			'id', 
			'nick_name',
			'login_name',
			'type',
			'register_date',
			'lastlogin_date',
			'email'			
			);
			if (JLanguageAssociations::isEnabled())
			{
				$config['filter_fields'][] = 'association';
			}
		}
		return parent::__construct($config);
	
	}
	protected function getListQuery()
	 {
		zmaxloginHelper::checkPermit();
		
		$db =  JFactory::getDBO();
		
		$query = $db->getQuery(true);
		
		$query->select("zu.id AS id  ,zu.joomla_uid ,zu.params AS params");
		$query->select("ju.name AS nick_name ,ju.username AS login_name ,ju.email AS email ,ju.registerDate AS register_date ,ju.lastvisitDate AS lastlogin_date");
		$query->select("ze.friendName AS type");
		$query->from( "#__zmax_users AS zu");
		$query->leftJoin("#__users AS ju ON zu.joomla_uid = ju.id ");
		$query->leftJoin("#__zmax_extension AS ze ON zu.type =ze.logintype");
		
		//搜索
		$search = $this->getState('filter.search');
		if (!empty($search))
		{
			$search = $db->quote('%' . $db->escape($search, true) . '%');
			$query->where('(ju.name LIKE ' . $search . 'OR  ju.username LIKE ' . $search . ')');
	
		}
		
		//排序
		$orderCol = $this->state->get("list.ordering" ,'id');
		$orderDirn = $this->state->get("list.direction",'desc');
		$query->order($db->escape($orderCol).' '.$db->escape($orderDirn));
		
		return $query;
	 }
	 
}


?>