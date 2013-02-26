<?php
  $cachefile = "cache/".str_replace("/","_",$_SERVER['SCRIPT_NAME']).'_'.$_GET['id'].".html";
  $cachetime = 0 * 60;
   if (file_exists($cachefile) && (time() - $cachetime<filemtime($cachefile))){
      echo '<!-- Cached '.date('jS F Y H:i', filemtime($cachefile))."->\n";
      include($cachefile);
      exit;
   }else
  ob_start();
?>

<?php
require_once("creds.php");
$mysqli = new mysqli("localhost", $db_user, $db_pass, $db_name);

if ($mysqli->connect_errno) {
    echo "Failed to connect to MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
}

$trail_id=$_GET['id'];

if(!empty($trail_id)){
	$get_place = $mysqli->stmt_init();
	$get_place->prepare("SELECT trail_name, trail_desc FROM trail where trail_id=?");
	$get_place->bind_param( "i", $trail_id);
	$get_place->execute();
	$get_place->bind_result($trail_name, $trail_desc);
	$get_place->fetch();
	$get_place->close();
}

require_once("functions.php");
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
<link rel="stylesheet" media="screen" type="text/css" href="/themes/intoOrkney/main.20121102.css" />
<link rel="stylesheet" media="screen" type="text/css" href="/themes/intoOrkney/typography.css" />

<script src="/themes/intoOrkney/js/vendor/modernizr-2.6.1.min.js"></script>

<title>intoOrkney - <?=$trail_name?></title>

</head>
<body class="trail">
<div class="container"><div class="content">
	<!--[if lt IE 7]>
        <p class="chromeframe">You are using an outdated browser. <a href="http://browsehappy.com/">Upgrade your browser today</a> or <a href="http://www.google.com/chromeframe/?redirect=true">install Google Chrome Frame</a> to better experience this site.</p>
    <![endif]-->
<div class="header">
	<div class="topMenu">
		<ul class="nav"><li class="nav-selected nav-path-selected"><a href="/" target="_self" class="nav-selected nav-path-selected">Home</a></li><li class=""><a href="/about/" target="_self" class="">About</a></li><li class=""><a href="/contribute/" target="_self" class="">Contribute</a></li><li class=""><a href="/contact/" target="_self" class="">Contact</a></li></ul>	
	</div>
	<div class="logo">
		<a href="/"><img src="/themes/intoOrkney/i/headerLogo.png" width="306" height="47" alt=""/></a>
	</div>
	<div class="clearfix"></div>
</div>

<div class="mainContent mainContentTrail">
	<div class="mainArea">
	<div class="trailTop">
	<div class="heading"><?=$trail_name?></div>
	<div class="searchContent">
		<div id="map" class="map"></div>
	</div></div>

	<div class="details">
		<div class="places">
			<?php
				$query = 'SELECT p.place_id, p.place_name, p.loc_lat, p.loc_long from trail_place tp	join place p on p.place_id=tp.place_id where tp.trail_id=? order by tp.trail_order';

				if ($stmt = $mysqli->prepare($query)) {
					$stmt->bind_param( "i", $trail_id);
				    $stmt->execute();
				    $stmt->bind_result($place_id, $place_name, $loc_lat, $loc_long);
				    while ($stmt->fetch()) {
						$thumbURL=getPlaceImageURL($place_id);
						echo '<div class="place">';
						if(!empty($thumbURL))
						   echo '<a href="/intoOrkney/place.php?id='.$place_id.'"><img src="'.$thumbURL.'" width="120" height="120" alt="'.$place_name.'"/></a><br/>';
						else
						   echo '<a href="/intoOrkney/place.php?id='.$place_id.'"><img src="/themes/intoOrkney/i/105image.jpg" width="120" height="120" alt="'.$place_name.'"/></a><br/>';
						echo '<a href="/intoOrkney/place.php?id='.$place_id.'" class="trailPlace" rel="'.$place_id.','.$loc_lat.','.$loc_long.','.$place_name.'">'.$place_name.'</a>';
						echo '</div>';
				    }
				    $stmt->close();
				}
			?>
		</div>		
		<div class="details">
			<?=$trail_desc?>
		</div>
		<div class="clearfix"></div>
	</div>
	<div class="otherTrails">
		<h2>Other Trails</h2>
		<?php
			$query = 'select trail_id, trail_name from trail order by trail_id desc';

			if ($stmt = $mysqli->prepare($query)) {
			    $stmt->execute();
			    $stmt->bind_result($list_trail_id, $list_trail_name);
			    while ($stmt->fetch()) {
					echo '<div class="trail">';
					$thumbURL=getTrailImageURL($list_trail_id);
					if(!empty($thumbURL))
					   echo '<a href="/intoOrkney/trail.php?id='.$list_trail_id.'"><img src="'.getTrailImageURL($list_trail_id).'" width="120" height="120" alt="'.$list_trail_name.'"/></a><br/>';
					else
					   echo '<a href="/intoOrkney/trail.php?id='.$list_trail_id.'"><img src="/themes/intoOrkney/i/105image.jpg" width="120" height="120" alt="'.$list_trail_name.'"/></a><br/>';						
					echo '<a href="/intoOrkney/trail.php?id='.$list_trail_id.'">'.$list_trail_name.'</a><br/>';
					echo '</div>';
			    }
			    $stmt->close();
			}
		?>
		<div class="clearfix"></div>		
	</div>
</div>


<div class="footer">
	<div class="footMenu">
		<p>website by <a href="http://www.coplasystems.com" target="_blank">copla</a></p>
		<p><a title="Terms of Use" href="/terms-use">Terms of Use</a> <a title="Privacy Policy" href="/privacy-policy">Privacy Policy</a></p>		
	</div>
</div>

<script src="//ajax.googleapis.com/ajax/libs/jquery/1.8.0/jquery.min.js"></script>
<script>window.jQuery || document.write('<script src="/themes/intoOrkney/js/vendor/jquery-1.8.0.min.js"><\/script>')</script>

<script type="text/javascript" src="http://maps.googleapis.com/maps/api/js?sensor=false"></script>
<script type="text/javascript" src="/themes/intoOrkney/js/vendor/markerclusterer.js"></script>
<script src="/themes/intoOrkney/js/plugins.js"></script>
<script src="/themes/intoOrkney/js/main.js"></script>

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

<?php
  $fp = fopen($cachefile, 'w'); 
  fwrite($fp, ob_get_contents());
  fclose($fp); 
  ob_end_flush(); 
?>