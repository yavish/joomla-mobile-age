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
defined('_JEXEC') or die('you can not access this file!');
?>
<div id="zmaxlogin-module" class="zmaxui">
	
	<div >
		<!-- 产生tab的标题 -->
		<ul class="zmax-nav zmax-nav-tabs" role="tablist">	
			
			<li role="zmax-presentation" target="joomla-login" data="joomla-login" group="zmax-tab-content" class="zmax-active">
				<a ><?php echo $joomlaLabel;?></a>
			</li>
			
			<li role="zmax-presentation" target="social-login" data="social-login" group="zmax-tab-content" >
				<a ><?php echo $socialLabel;?></a>
			</li>
		</ul>
	</div>
	
	<!-- 产生tab的内容-->
	<div class="zmax-tab-content" role="tab-content">
		
		<div class="zmax-tab-panel  zmax-fade zmax-active " id="joomla-login" >	
				<?php if($showLabelDesc):?>
				<h3><?php echo $joomlaLabel;?> <small><?php echo $joomlaLabelDesc;?></small></h3>
				<?php endif;?>
				<?php 
				$joomlaLoginHtml = $zmaxlogin->outPutJoomlaLogin();
					echo $joomlaLoginHtml;
				?>
		</div>
		<div class="zmax-tab-panel  zmax-fade" id="social-login" >				
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
	</div>				
</div>
