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
 
 /**
  *  ###### 重要说明 ###### 
  *  # 为了便于升级以及便于第三方开发，ZMAX专门为第三方登陆模块提供通用库，关于库的使用说明，请参考http://www.zmax99.com相关文章
  *  # 如果你要重写本模块，建议不要直接修改代码，而是使用输出覆盖
  *  #  						
  *  #                ZMAX程序人  2015-01-15
  */
  
defined('_JEXEC') or die;
//导入公共库
include_once("administrator/components/com_zmaxlogin/libs/zmaxlib/common_function.php");

//获得参数
$width = $params->get('window_width',450);
$height = $params->get('window_height',320);
$window_position_x = $params->get('window_position_x',700);
$window_position_y = $params->get('window_position_y',320);
$window_style = $params->get('window_style','new_window');
$label = $params->get('otherloginlabel'); 
$image_style = $params->get('image_style'); 


//获得一个ZMAX登陆前端对象
$zmaxlogin= new zmaxloginFront($width ,$height,$window_position_x ,$window_position_y ,$window_style);
$loginTypes =$zmaxlogin->getLoginTypes();
$config=null;
foreach($loginTypes as $type)
{
	$config[$type]=$params->get($type."login",true);
}
$zmaxlogin->setConfig($config);
$zmaxlogin->setImageStyle($image_style);

$doc = JFactory::getDocument();
$doc->addStyleSheet("modules/mod_zmaxlogin/css/zmaxlogin.css");
?>


<div id="zmax_login" class="<?php echo $image_style;?>" >
	<?php if ($params->get('joomlalogin')):?>
	<div id="joomla_login">
		<?php echo $zmaxlogin->outPutJoomlaLogin();?>
	</div>
	<?php endif;?>
	<?php if(!empty($loginTypes)):?>
	<div id="other_oauth">
		<div>
			<?php if($label !=""):?>	
				<label ><?php echo JText::_($label);?></label>
			<?php endif;?>
			<div class="icon">
				<?php echo $zmaxlogin->outPutAllZmaxLogin();?>
			</div>
		</div>
	</div>
	<?php endif;?>
</div>
