<?php
/**
 *	description:ZMAX第三方登陆插件 login_everywhere
 *  author：min.zhang
 *  Email:zhang19min88@163.com
 *	Url:http://www.zmax99.com
 *  copyright:南宁市程序人软件科技有限责任公司保留所有权利
 *  date:2016-11-04
  * @license GNU General Public License version 3, or later
 */
 
// no direct access
defined('_JEXEC') or die('Restricted access');

if(!defined('DS')){define('DS',DIRECTORY_SEPARATOR);}
	


class plgSystemZmaxlogin_everywhere extends JPlugin
{

     public function onBeforeRender()
     {
		$app = JFactory::getApplication();
		if($app->isAdmin())
		{
			return true;
		}
      	$doc = JFactory::getDocument();
		$js ='var SITEBASE ="'.JUri::root().'"';
		$doc->addScriptDeclaration($js);
		$doc->addScript("administrator/components/com_zmaxlogin/libs/zmaxlib/zmaxlogin.js");
		return true;
     }
}
?>
