<?php
/**
 *	description:ZMAX第三方登陆模块入口点文件文件
 *  author：min.zhang
 *  Email:zhang19min88@163.com
 *	Url:http://www.zmax99.com
 *  copyright:南宁市程序人软件科技有限责任公司保留所有权利
 *  date:2015-01-15
  * @license GNU General Public License version 3, or later
 */
 
// no direct access
defined('_JEXEC') or die('Restricted access');

if(!defined('DS'))
{
	define('DS' ,DIRECTORY_SEPARATOR);
}
$layout = $params->get('layout' ,'default');

$user = JFactory::getUser();
// Kiggebd users must load the logout sublayout
if(!$user->guest)
{
	$layout .="_logout";
}
require(JModuleHelper::getLayoutPath('mod_zmaxlogin' ,$layout));

