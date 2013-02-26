<?php
require_once("../creds.php");
$mysqli = new mysqli("localhost", $db_user, $db_pass, $db_name);

if ($mysqli->connect_errno) {
    echo "Failed to connect to MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
}

if(!empty($_POST['trail_name'])){
	$get_place = $mysqli->stmt_init();
	$get_place->prepare("INSERT INTO trail (`trail_name`) VALUES(?)");
	$get_place->bind_param( "s",$_POST["trail_name"]);
	$get_place->execute();
	header("Location: http://$_SERVER[HTTP_HOST]/intoOrkney/cms/trail.php?id=".	$mysqli->insert_id);
	$get_place->close();
	exit;	
}
?>
<!DOCTYPE html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js"> <!--<![endif]-->
<head>

<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
<meta name="viewport" content="width=device-width">

<link rel="stylesheet" media="screen" type="text/css" href="/themes/intoOrkney/normalize.css" />
<link rel="stylesheet" media="screen" type="text/css" href="/themes/intoOrkney/main.css" />
<link rel="stylesheet" media="screen" type="text/css" href="/themes/intoOrkney/typography.css" />

<script src="/themes/intoOrkney/js/vendor/modernizr-2.6.1.min.js"></script>

<title>intoOrkney - edit trails</title>

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
	<div class="mainArea">
	<div><br/>
From this page you can create a new trail, or edit an existing trail.
<br/><br/>
	</div>
	<div class="newTrail">
		<form action="" method="post">
		<b>new trail name:</b> <input name="trail_name" value="">
		<input type="submit" value="create"/>
		</form>
		<br/><br/>
	</div>

	<div class="trails">
		<b>edit existing trail</b><br/>
	<?php
		$query = 'select trail_id, trail_name from trail order by trail_id';

		if ($stmt = $mysqli->prepare($query)) {
		    $stmt->execute();
		    $stmt->bind_result($list_trail_id, $list_trail_name);
		    while ($stmt->fetch()) {
				echo $list_trail_name.' <a href="/intoOrkney/cms/trail.php?id='.$list_trail_id.'">edit</a><br/>';
		    }
		    $stmt->close();
		}

		$mysqli->close();
	?>		
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