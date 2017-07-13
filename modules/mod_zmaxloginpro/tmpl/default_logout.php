<?php
/**
 *	description:ZMAX第三方登陆布局文件文件
 *  author：min.zhang
 *  Email:zhang19min88@163.com
 *	Url:http://www.zmax99.com
 *  copyright:南宁市程序人软件科技有限责任公司保留所有权利
 *  date:2015-01-15
  * @license GNU General Public License version 3, or later
 */

defined('_JEXEC') or die;

$doc = JFactory::getDocument();
$doc->addStyleSheet("modules/mod_zmaxlogin/css/zmaxlogin.css");

$userImage = $params->get('userimage',1);

include_once("administrator/components/com_zmaxlogin/libs/zmaxlib/common_function.php");
$zmaxlogin= new zmaxloginFront();

JHtml::_('behavior.keepalive');
?>
<?php if($userImage):?>
<div id="zmaxlogin_userimage">
	<img src="<?php echo zmaxloginFront::getUserImageUrl();?>" />
</div>
<?php endif;?>
<div id="zmaxlogin_joomlainfo">
<?php echo $zmaxlogin->outPutJoomlaLogin();?>
</div>