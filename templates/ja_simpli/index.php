<?php
/**
 * @package   Simpli
 * @copyright Copyright (C) 2005 - 2012 Open Source Matters, Inc. All rights reserved.
 * @license   GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;
$helper = require (__DIR__ . '/helper.php');
$helper->init($this);
?>

<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="<?php echo $this->language; ?>" lang="<?php echo $this->language; ?>" dir="<?php echo $this->direction; ?>">

<head>

	<!-- Custom code -->
	<?php $helper->_('advancedCodeBeforeHead'); ?>
	<!-- // Custom code -->

	<!-- META FOR IOS & HANDHELD -->
	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no"/>
	<style type="text/stylesheet">
		@-webkit-viewport   { width: device-width; }
		@-moz-viewport      { width: device-width; }
		@-ms-viewport       { width: device-width; }
		@-o-viewport        { width: device-width; }
		@viewport           { width: device-width; }
	</style>

	<script type="text/javascript">
		//<![CDATA[
		if (navigator.userAgent.match(/IEMobile\/10\.0/)) {
			var msViewportStyle = document.createElement("style");
			msViewportStyle.appendChild(
				document.createTextNode("@-ms-viewport{width:auto!important}")
			);
			document.getElementsByTagName("head")[0].appendChild(msViewportStyle);
		}
		//]]>
	</script>

	<meta name="HandheldFriendly" content="true"/>
	<meta name="apple-mobile-web-app-capable" content="YES"/>
	<!-- //META FOR IOS & HANDHELD -->

	<meta name="viewport" content="width=device-width, initial-scale=1.0" />

	<jdoc:include type="head" />

	<!--[if lt IE 9]>
		<script src="<?php echo JUri::root(true); ?>/media/jui/js/html5.js"></script>
	<![endif]-->

	<?php

	JHtml::_('bootstrap.framework');

	// TEMPLATE JS
	$this->addScript($this->baseurl . '/templates/' . $this->template . '/js/template.js');

	// SYSTEM CSS
	$this->addStyleSheet(JURI::base(true) . '/templates/system/css/system.css');

	// TEMPLATE CSS
	$this->addStyleSheet($this->baseurl . '/templates/' . $this->template . '/css/template.css');

	// CUSTOM CSS
	if (is_file(__DIR__ . '/css/custom.css')) {
		$this->addStyleSheet($this->baseurl . '/templates/' . $this->template . '/css/custom.css');
	}
	?>

	<!-- Custom color style -->
	<?php $helper->addCustomStyle(); ?>
	<!-- Custom code -->
	<?php $helper->_('advancedCodeAfterHead'); ?>
	<!-- // Custom code -->

</head>

<body class="page-<?php $helper->_('view') ?> <?php $helper->_('page-class') ?>">

	<!-- Custom code -->
	<?php $helper->_('advancedCodeBeforeBody'); ?>
	<!-- // Custom code -->

<div class="main">
	
	<?php if ($helper->is('header-enabled')) : ?>
	<!-- HEADER -->
	<header id="header" class="header<?php echo $helper->is('layoutSticky_header') ? ' stick-on-top' : '' ?>" role="banner"<?php $helper->_bg('header') ?>>
		<?php $helper->_container_open('header') ?>
		
		<div class="<?php $helper->_row_class('header') ?>">
	    	<!-- Logo - header left -->
	    	<div class="<?php $helper->_('header-left-class') ?>">
			<a class="navbar-brand logo logo-text" href="<?php echo $this->baseurl; ?>/">
				<strong><?php $helper->_('advancedSiteName') ?></strong>
				<small class="slogan"><?php $helper->_('advancedSiteSlogan') ?></small>
			</a>
			</div>
			<!-- // Logo -->

			<?php if ($helper->has('header-right-class')) : ?>
	    	<!-- ADS-->
	    	<div class="banner <?php $helper->_('header-right-class') ?> <?php $helper->_('extraClass_header_right'); ?> ">
				<jdoc:include type="modules" name="<?php $helper->_('header-right-pos') ?>" style="none" /> 
			</div>
			<!-- // ADS-->
			<?php endif ?>
		</jdoc:include>

		<?php $helper->_container_close('header') ?>
	</header>
	<!-- // HEADER -->
	<?php endif ?>
	<?php if ($helper->is('nav-enabled')) : ?>
	<!-- MAIN NAVIGATION -->
	<nav id="mainnav" class="navbar navbar-static-top<?php echo $helper->is('layoutSticky_nav') ? ' stick-on-top' : '' ?>" role="navigation"<?php $helper->_bg('nav') ?>>
		<div class="navbar-inner">
		<?php $helper->_container_open('nav') ?>

			<div class="<?php $helper->_row_class('nav') ?>">
				<div class="<?php echo $helper->_('nav-left-class') ?>">
			      	<button type="button" class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
						<i class="fa fa-bars"></i>
			        	<span>Menu</span>
			      	</button>

					<!-- The Nav -->
					<div class="nav-collapse collapse">
						<jdoc:include type="modules" name="<?php $helper->_('nav-left-pos') ?>" style="none" />
					</div>
					<!-- // The Nav -->
				</div>

				<?php if ($helper->has('nav-right-class')) : ?>
				<!-- Search-->
				<div class="navbar-form <?php $helper->_('nav-right-class') ?>" role="search">
					<jdoc:include type="modules" name="<?php $helper->_('nav-right-pos') ?>" style="none" />
				</div>
				<!-- // Search- -->
				<?php endif; ?>
			</div>
		<?php $helper->_container_close('nav') ?>
		</div>
	</nav>
	<!-- // MAIN NAVIGATION -->
	<?php endif ?>

	<?php $helper->spotlight('top_1', array('class'=>'top-sl')) ?>
	
	<?php $helper->spotlight('top_2', array('class'=>'top-sl')) ?>
	
	<?php $helper->spotlight('top_3', array('class'=>'top-sl')) ?>

	<?php $helper->spotlight('top_4', array('class'=>'top-sl')) ?>

	<?php if ($helper->is('content-enabled')): ?>
	<!-- MAIN BODY -->
	<div class="mainbody"<?php $helper->_bg('content') ?>>
		<?php $helper->_container_open('content') ?>
			<div class="mainbody-inner <?php $helper->_row_class('content') ?>">

				<!-- Content -->
				<main id="content" class="content <?php echo $helper->_('main-class') ?>" role="main">

					<!-- Breadcrums -->
					<jdoc:include type="modules" name="position-2" style="none" />
					<!-- // Breadcrums -->

					<jdoc:include type="message" />
					<jdoc:include type="component" />
				</main>
				<!-- // Content -->

				<?php if ($helper->has('col1-class')) : ?>
				<!-- Sidebar 1-->
				<div class="sidebar sidebar-1 <?php $helper->_('col1-class') ?>">
					<div class="sidebar-inner">
						<jdoc:include type="modules" name="<?php $helper->_('col1-pos') ?>" style="JAxhtml" />
					</div>

				</div>
				<!-- // Sidebar 1-->
				<?php endif; ?>

				<?php if ($helper->has('col2-class')) : ?>
				<!-- Sidebar 2 -->
				<div class="sidebar sidebar-2 <?php $helper->_('col2-class') ?>">
					<div class="sidebar-inner">
						<jdoc:include type="modules" name="<?php $helper->_('col2-pos') ?>" style="JAxhtml" />
					</div>
				</div>
				<!-- // Sidebar 2 -->
				<?php endif; ?>
			</div>
		<?php $helper->_container_close('content') ?>
	</div>
	<!-- // MAIN BODY -->
	<?php endif ?>

	<?php $helper->spotlight('bot_1', array('class'=>'bot-sl')) ?>
	
	<?php $helper->spotlight('bot_2', array('class'=>'bot-sl')) ?>
	
	<?php $helper->spotlight('bot_3', array('class'=>'bot-sl')) ?>

	<?php $helper->spotlight('bot_4', array('class'=>'bot-sl')) ?>

</div>

<!-- FOOTER -->
<?php $helper->spotlight('footer', array('class'=>'footer-section')) ?>
<!-- // FOOTER -->


<?php if($this->countModules('float-pos')) : ?>
	<div class="float-pos hidden-phone">
		<jdoc:include type="modules" name="float-pos" style="raw" />
	</div>
<?php endif ?>

<jdoc:include type="modules" name="debug" style="none" />

<!-- Custom code -->
<?php $helper->_('advancedCodeAfterBody'); ?>
<!-- // Custom code -->

</body>

</html>
