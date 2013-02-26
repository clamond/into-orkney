<!DOCTYPE html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js"> <!--<![endif]-->
<head>

<?php
require_once("../creds.php");
$mysqli = new mysqli("localhost", $db_user, $db_pass, $db_name);

if ($mysqli->connect_errno) {
    echo "Failed to connect to MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
}
?>

<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
<meta name="viewport" content="width=device-width">

<link rel="stylesheet" media="screen" type="text/css" href="/themes/intoOrkney/normalize.css" />
<link rel="stylesheet" media="screen" type="text/css" href="/themes/intoOrkney/main.css" />
<link rel="stylesheet" media="screen" type="text/css" href="/themes/intoOrkney/typography.css" />

<script src="/themes/intoOrkney/js/vendor/modernizr-2.6.1.min.js"></script>

<title>intoOrkney - sites CMS</title>

</head>
<body class="cms-home">
<div class="container"><div class="content">
	<!--[if lt IE 7]>
        <p class="chromeframe">You are using an outdated browser. <a href="http://browsehappy.com/">Upgrade your browser today</a> or <a href="http://www.google.com/chromeframe/?redirect=true">install Google Chrome Frame</a> to better experience this site.</p>
    <![endif]-->
<div class="header">
	<div class="topMenu">

	</div>
	<div class="logo">
		<img src="/themes/intoOrkney/i/headerLogo.png" width="306" height="47" alt=""/> CMS
	</div>
	<div class="clearfix"></div>
</div>

<div class="mainContent">
	<div class="mainArea">
		<div><br/><br/><br/>
			Welcome to the intoOrkney CMS, from here you can manage 'places' and trails.</div>
			<br/><br/><br/>
		<div>
		<a href="choosePlace.php">edit place</a><br/>
		<a href="trails.php">manage trails</a><br/>
		<br/><a href="/login">site CMS</a>
		<br/><br/><br/><br/><br/>
		</div>
	</div>
</div>


<div class="footer">
	<div class="footMenu">
		FOOT MENU
	</div>
</div>

<script src="//ajax.googleapis.com/ajax/libs/jquery/1.8.0/jquery.min.js"></script>
<script>window.jQuery || document.write('<script src="/themes/intoOrkney/js/vendor/jquery-1.8.0.min.js"><\/script>')</script>
<script type="text/javascript" src="http://maps.googleapis.com/maps/api/js?sensor=false"></script>
<script type="text/javascript" src="/themes/intoOrkney/js/plugins.js"></script>
<script type="text/javascript" src="/themes/intoOrkney/js/vendor/markerclusterer.js"></script>
<script type="text/javascript" src="/intoOrkney/sites-json.php"></script>
<script type="text/javascript" src="/themes/intoOrkney/js/main.js"></script>

<!-- Google Analytics: change UA-XXXXX-X to be your site's ID. -->
<script>
    var _gaq=[['_setAccount','UA-XXXXX-X'],['_trackPageview']];
    (function(d,t){var g=d.createElement(t),s=d.getElementsByTagName(t)[0];
    g.src=('https:'==location.protocol?'//ssl':'//www')+'.google-analytics.com/ga.js';
    s.parentNode.insertBefore(g,s)}(document,'script'));
</script>


</div></div>
</body>
</html>