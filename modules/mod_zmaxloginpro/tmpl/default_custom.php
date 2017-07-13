<?php
/**
 *	description:ZMAX验证码插件 主文件
 *  author：min.zhang
 *  Email:zhang19min88@163.com
 *	Url:http://www.zmax99.com
 *  copyright:南宁市程序人软件科技有限责任公司保留所有权利
 *  date:2015-05-27
 */
 
defined('_JEXEC') or die('you can not access this file!');

JHtml::_('jquery.framework');

$html = $params->get('html');
$plg = $params->get('plg',"1");

//让这里的html执行其他的内容插件
if($plg)
{
	JPluginHelper::importPlugin('content');
	$html = JHtml::_('content.prepare', $html, '', 'mod_zmaxlogin.content');	
}



$js = $params->get('js',"");
$css = $params->get('css',"");

$doc = JFactory::getDocument();
$doc->addScript("modules/mod_zmaxloginpro/js/function.js");
if($css)
{
	$doc->addStyleDeclaration($css);
}
if($js)
{
	$doc->addScriptDeclaration($js);
}
?>
<div class="zmaxlogin-custom-container">
<?php echo $html;?>
</div>