<?php
/**
 *	description:ZMAX第三方登陆布局文件文件
 *  author：min.zhang
 *  Email:zhang19min88@163.com
 *	Url:http://www.zmax99.com
 *  copyright:南宁市程序人软件科技有限责任公司保留所有权利
 *  date:2016-11-05
  * @license GNU General Public License version 3, or later
 */
 
 /**
  *  ###### 重要说明 ###### 
  *  # 为了便于升级以及便于第三方开发，ZMAX专门为第三方登陆模块提供通用库，关于库的使用说明，请参考http://www.zmax99.com相关文章
  *  # 如果你要重写本模块，建议不要直接修改代码，而是使用输出覆盖
  *  #  						
  *  #                ZMAX程序人  2015-01-15
  */
  
defined('_JEXEC') or die('you can not access this file!');
?>
<div >				
	<?php if(!empty($loginTypes)):?>
	<div id="other_oauth">
		<div>
			<?php if($showLabelDesc):?>

				<h3><?php echo JText::_($socialLabel);?> <small><?php echo $socialLabelDesc;?></small></h3>
			<?php endif;?>
			<div class="icon">
				<?php echo $zmaxlogin->outPutAllZmaxLogin();?>
			</div>
		</div>
	</div>
	<?php endif;?>
</div>
	
