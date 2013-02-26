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

$save_place_id=$_POST["save_place_id"];
if(!empty($save_place_id)){
	$saved=true;
	$get_place = $mysqli->stmt_init();
	$get_place->prepare("update place set last_update=now(), flickr_search=?, freetext=?, soundcloud_search=?, twitter_search=?, youtube_search=? where place_id=?");
	$get_place->bind_param( "sssssi",$_POST["flickr_search"],$_POST["freetext"],$_POST["soundcloud_search"],$_POST["twitter_search"],$_POST["youtube_search"], $save_place_id);
	$get_place->execute();
	$get_place->close();	
}

$place_id=$_GET['id'];

$get_place = $mysqli->stmt_init();
$get_place->prepare("SELECT flickr_search, freetext, place_id, place_name, soundcloud_search, twitter_search, youtube_search from place where place_id=?");
$get_place->bind_param( "i", $place_id);
$get_place->execute();
$get_place->bind_result($flickr_search, $freetext, $place_id, $place_name, $soundcloud_search, $twitter_search, $youtube_search);
$get_place->fetch();
$get_place->close();




?>

<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
<meta name="viewport" content="width=device-width">

<link rel="stylesheet" media="screen" type="text/css" href="/themes/intoOrkney/normalize.css" />
<link rel="stylesheet" media="screen" type="text/css" href="/themes/intoOrkney/main.css" />
<link rel="stylesheet" media="screen" type="text/css" href="/themes/intoOrkney/typography.css" />

<script src="/themes/intoOrkney/js/vendor/modernizr-2.6.1.min.js"></script>

<title>intoOrkney - edit site <?=$place_name?></title>

</head>
<body class="cms-edit">
<div class="container"><div class="content">
	<!--[if lt IE 7]>
        <p class="chromeframe">You are using an outdated browser. <a href="http://browsehappy.com/">Upgrade your browser today</a> or <a href="http://www.google.com/chromeframe/?redirect=true">install Google Chrome Frame</a> to better experience this site.</p>
    <![endif]-->
<div class="header">
	<div class="topMenu">

	</div>
	<div class="logo">
		<img src="/themes/intoOrkney/i/headerLogo.png" width="306" height="47" alt=""/><a href="/intoOrkney/cms/">CMS</a>
	</div>
	<div class="clearfix"></div>
</div>

<div class="mainContent">
	<div><br/>This page allows you to edit information about a place.<br/><br/></div>
	<div class="mainArea">
	<a href="/intoOrkney/cms/choosePlace.php">back to map</a> to choose a different place to edit.<br/><br/>
	<?if(!empty($saved)){?>
	<div class="saved">
		saved
	</div>
	<?}?>
	<div class="siteOverview">
	<div class="label">Site:</div><div class="data"><?=$place_name?> (<?=$place_id?>)</div><div class="clearfix"></div>
	</div>
	<div class="siteEdit">
		<form action="" method="post">
		<input type="hidden" name="save_place_id" value="<?=$place_id?>"/>
		<div class="label">flickr search:</div><div class="data"><input class="text" name="flickr_search" value="<?=$flickr_search?>"></div><div class="clearfix"></div>
		<div class="label">twitter search:</div><div class="data"><input class="text" name="twitter_search" value="<?=$twitter_search?>"></div><div class="clearfix"></div>
		<div class="label">youtube search:</div><div class="data"><input class="text" name="youtube_search" value="<?=$youtube_search?>"></div><div class="clearfix"></div>
		<div class="label">sound cloud search:</div><div class="data"><input class="text" name="soundcloud_search" value="<?=$soundcloud_search?>"></div><div class="clearfix"></div>
		<div class="label">site description:</div><div class="data"><textarea name="freetext">
<?=$freetext?>
</textarea></div><div class="clearfix"></div>
		<input type="submit" value="save"/>
		</form>
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
<script type="text/javascript" src="/intoOrkney/ckeditor/ckeditor.js"></script>
<script type="text/javascript" src="/intoOrkney/ckeditor/adapters/jquery.js"></script>
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