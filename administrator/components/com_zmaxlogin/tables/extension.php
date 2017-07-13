<?php
/**
 *	description:ZMAX第三方登陆系统 入口点文件
 *  author：min.zhang
 *  Email:zhang19min88@163.com
 *	Url:http://www.zmax99.com
 *  copyright:南宁市程序人软件科技有限责任公司保留所有权利
 *  date:2015-01-12
 * @license GNU General Public License version 3, or later
 */
defined('_JEXEC') or die('Restricted access');
class TableExtension extends JTable
{
	function __construct(& $db)
	{
		parent::__construct('#__zmax_extension' ,'id' ,$db);
	}
	
	function check()
	{
		return true;
	}
}
?>