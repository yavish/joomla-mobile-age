<?php
/**
 *	description:ZMAX第三方登陆模块的帮助文件
 *  author：min.zhang
 *  Email:zhang19min88@163.com
 *	Url:http://www.zmax99.com
 *  copyright:南宁市程序人软件科技有限责任公司保留所有权利
 *  date:2016-11-01
  * @license GNU General Public License version 3, or later
 */
 
// no direct access
defined('_JEXEC') or die('Restricted access');

class ModZmaxLoginproHelper
{
	static public function getLoginConfig($type)
	{
		$db = JFactory::getDBO();
		$query = $db->getQuery(true);
		$query->select("params");
		$query->from("#__zmax_extension");
		$query->where("logintype='".$type."'");
		$db->setQuery($query);
		$result = $db->loadResult();
		$config = json_decode($result);
		return $config;
	}	
}