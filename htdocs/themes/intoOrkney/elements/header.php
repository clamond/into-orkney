<?php  defined('C5_EXECUTE') or die("Access Denied."); ?>
<!DOCTYPE html>
<!--[if lt IE 7]>      <html lang="<?php echo LANGUAGE?>" class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>         <html lang="<?php echo LANGUAGE?>" class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>         <html lang="<?php echo LANGUAGE?>" class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]><!--> <html lang="<?php echo LANGUAGE?>" class="no-js"> <!--<![endif]-->
<head>

<?php  Loader::element('header_required'); ?>
	
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
<meta name="viewport" content="width=device-width">

<link rel="stylesheet" media="screen" type="text/css" href="<?php echo $this->getStyleSheet('normalize.css')?>" />
<link rel="stylesheet" media="screen" type="text/css" href="<?php echo $this->getStyleSheet('main.css')?>" />
<link rel="stylesheet" media="screen" type="text/css" href="<?php echo $this->getStyleSheet('typography.css')?>" />

<script src="<?=$this->getThemePath()?>/js/vendor/modernizr-2.6.1.min.js"></script>

</head>
<body>
<div class="container"><div class="content">
	<!--[if lt IE 7]>
        <p class="chromeframe">You are using an outdated browser. <a href="http://browsehappy.com/">Upgrade your browser today</a> or <a href="http://www.google.com/chromeframe/?redirect=true">install Google Chrome Frame</a> to better experience this site.</p>
    <![endif]-->
<div class="header">
	<div class="topMenu">
		<?php 
		$as = new Area('Top Menu');
		$as->display($c);
		?>		
	</div>
	<div class="logo">
		<a href="/"><img src="<?=$this->getThemePath()?>/i/headerLogo.png" width="306" height="47" alt=""/></a>		
	</div>
	<div class="clearfix"></div>
</div>