<?php
/**
 *	description:ZMAX第三方登陆模块入口点文件文件
 *  author：min.zhang
 *  Email:zhang19min88@163.com
 *	Url:http://www.zmax99.com
 *  copyright:南宁市程序人软件科技有限责任公司保留所有权利
 *  date:2016-11-04
  * @license GNU General Public License version 3, or later
 */
 
// no direct access
defined('_JEXEC') or die('Restricted access');
require_once __DIR__ . '/helper.php';

if(!defined('DS'))
{
	define('DS' ,DIRECTORY_SEPARATOR);
}
$layout = $params->get('layout' ,'default');
$layoutFile = $params->get('layoutfile' ,'system');

if($layoutFile=="custom")
{
	$layout="default_custom";
}

$user = JFactory::getUser();
// Kiggebd users must load the logout sublayout
if(!$user->guest)
{
	$layout="default_logout";
}

require(JModuleHelper::getLayoutPath('mod_zmaxloginpro' ,$layout));

