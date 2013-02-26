<?php
  $cachefile = "cache/".str_replace("/","_",$_SERVER['SCRIPT_NAME']).'_'.$_GET['id'].".html";
  $cachetime = 5 * 60;
  if (file_exists($cachefile) && (time() - $cachetime<filemtime($cachefile))){
      echo '<!-- Cached '.date('jS F Y H:i', filemtime($cachefile))."->\n";
      include($cachefile);
      exit;
  }else
  ob_start();
?>

<!DOCTYPE html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js"> <!--<![endif]-->
<head>

<?php
require_once("place-function.php");
?>

<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
<meta name="viewport" content="width=device-width">

<link rel="stylesheet" media="screen" type="text/css" href="/themes/intoOrkney/normalize.css" />
<link rel="stylesheet" media="screen" type="text/css" href="/themes/intoOrkney/main.20121102.css" />
<link rel="stylesheet" media="screen" type="text/css" href="/themes/intoOrkney/typography.css" />

<script src="/themes/intoOrkney/js/vendor/modernizr-2.6.1.min.js"></script>

<title><?=$place->place_name?> - intoOrkney</title>

</head>
<body class="place">
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

<div class="mainContent">
	<div class="topArea">
<h1><?=$place->place_name?></h1>
	</div>
	<div class="mainArea">

<div class="smallblocks">
<?php
if(!empty($rcahms->site_type)){
	echo '<div class="rcahms smallBox">';
	echo '<div class="heading"><img src="/themes/intoOrkney/i/icon_rcahms.png" width="47" height="51" alt="RCAHMS"/>RCAHMS</div>';
	echo '<div class="details">';
	echo '<div class="label">Site Type:</div><div class="value">'.$rcahms->site_type.'</div>';
	echo '<div class="label">Canmore ID:</div><div class="value">'.$rcahms->rcahms_id.'</div>';
	echo '<div class="clearfix"></div>';
	if(!empty($rcahms->arch_notes)){
		echo '<div><div class="noteHeading">Archaeological Notes</div>'.nl2br(substr($rcahms->arch_notes,0,600)).' ........</div>';
	}
	if(!empty($rcahms->archi_notes)){
		echo '<div><div class="noteHeading">Architectural Notes</div>'.nl2br(substr($rcahms->archi_notes,0,600)).' ........</div>';	
	}	
	echo '<div class="more"><a href="http://canmore.rcahms.gov.uk/en/site/'.$rcahms->rcahms_id.'/" target="_blank">View more</a></div>';	
	echo '</div>';
	echo '</div><div class="clearfix"></div>';
}
?>	
	
<?php
if(!empty($placenames->type)){
	echo '<div class="placenames smallBox">';
	echo '<div class="heading"><img src="/themes/intoOrkney/i/icon_placenames.png" width="47" height="51" alt="placenames"/>Placenames</div>';
	echo '<div class="details">';
	echo '<div class="label">Type:</div><div class="value">'.$placenames->type.'</div>';	
	echo '<div class="label">Source:</div><div class="value">'.$placenames->source.'</div>';		
	echo '<div class="label">Grid:</div><div class="value">HY '.$placenames->grid.'</div>';	
	echo '<div class="label">Description:</div><div class="value">'.$placenames->desc.'</div>';	
	echo '</div>';
	echo '</div><div class="clearfix"></div>';	
}
?>

<?php
error_log('-'.$place->loc_lat.'-');
if(!empty($place->loc_lat)){
	echo '<div class="map smallBox">';
	echo '<div class="heading"><img src="/themes/intoOrkney/i/icon_map.png" width="47" height="51" alt="map"/>Map</div>';
	echo '<div class="details">';
	echo '<img width="430" height="300" alt="location map" src="http://maps.googleapis.com/maps/api/staticmap?center='.$place->loc_lat.','.$place->loc_long.'8&zoom=15&size=430x300&markers=color:blue%7C'.$place->loc_lat.','.$place->loc_long.'&sensor=false"/>';
	echo '<br/><a href="http://www.google.co.uk/maps?q='.$place->loc_lat.','.$place->loc_long.'" target="_blank">google</a>';
	echo ' <a href="http://www.bing.com/maps/?v=2&where1='.$place->loc_lat.','.$place->loc_long.'&lvl=15&sty=r&encType=1" target="_blank">bing</a>';
	echo ' <a href="http://streetmap.co.uk/loc/'.$place->loc_lat.','.$place->loc_long.'" target="_blank">streetmap</a>';
	echo '</div>';
	echo '</div><div class="clearfix"></div>';
}
?>

<?php
require_once("phpFlickr.php");
$f = new phpFlickr("");
$photos = $f->photos_search(array("text"=>"'.$place->flickr_search.'"));
if(!empty($photos)){
	if($photos['total']>0){
		$count=0;
		echo '<div class="flickr smallBox">';	
		echo '<div class="heading"><img src="/themes/intoOrkney/i/icon_flickr.png" width="99" height="51" style="padding-right:1px;" alt="flickr"/></div>';
		echo '<div class="details">';
		foreach ($photos['photo'] as $photo) {
			if($count<16){
			  echo '<a href="http://www.flickr.com/photos/'.$photo['owner'].'/'.$photo['id'].'" target="_blank"><img class="thumb" src="'.$f->buildPhotoURL($photo, "square").'" alt="'.$photo['title'].'" width="97" height="97"/></a>';
			}
			$count++;
		}
		echo '<div class="clearfix"></div>';
		echo '</div>';
		echo '</div><div class="clearfix"></div>';	
	}
}
?>

<?php
if(!empty($rcahms->images)){
	echo '<div class="photos smallBox">';
	echo '<div class="heading"><img src="/themes/intoOrkney/i/icon_photos.png" width="66" height="51" style="padding-right:34px;" alt="photos"/>Photos</div>';
	echo '<div class="details">';
	$count=0;
	foreach ($rcahms->images as $image){
		if($count<9){
			echo '<img class="thumb" src="'.$image->url.'" width="122" height="122" alt="'.$image->desc.'"/>';
			$count++;
		}
	}
	echo '</div>';
	echo '</div><div class="clearfix"></div>';	
}
?>

<?php
require_once("TwitterSearch.php");
$tsearch = new TwitterSearch($place->twitter_search);
$tresults = $tsearch->results();
//var_dump($tresults);
if(!empty($tresults)){
	echo '<div class="tweets smallBox">';
	echo '<div class="heading"><img src="/themes/intoOrkney/i/icon_twitter.png" width="52" height="51" style="padding-right:48px;" alt="tweets"/>Tweets</div>';
	echo '<div class="details">';
	$count=0;
	foreach ($tresults as $tw){
		if($count<5 && !empty($tw->profile_image_url)){
			echo '<div class="tweet">';
			echo '<a href="http://twitter.com/'.$tw->from_user.'" target="_blank"><img class="twitIcon" src="'.$tw->profile_image_url.'"/></a>';
			echo '<div class="twit">';
			echo '<b>'.$tw->from_user_name.'</b> <a href="http://twitter.com/'.$tw->from_user.'" target="_blank"> @'.$tw->from_user.'</a> '.$tw->text;
			echo '</div><div class="clearfix"></div>';
			echo '</div>';
			$count++;
		}
	}
	echo '</div>';
	echo '</div><div class="clearfix"></div>';	
}
?>

<?php
require_once 'Services/Soundcloud.php';
try{
$client = new Services_Soundcloud('');
$tracks = json_decode($client->get('tracks', array('q' => $place->soundcloud_search)));
}catch(Exception $e){
}

if(!empty($tracks)){
	echo '<div class="audio smallBox">';
	echo '<div class="heading"><img src="/themes/intoOrkney/i/icon_audio.png" width="47" height="51" alt="audio"/>Audio</div>';
	echo '<div class="details">';
	$count=0;
	foreach ($tracks as $track){
		if($count<4){
			if(!empty($track->artwork_url)&&!empty($track->description)){
				echo '<div class="sound">';
				echo '<a href="'.$track->permalink_url.'" target="_blank"><img src="'.$track->artwork_url.'" width="100" height="100" alt="'.$track->user->username.'"/></a>';
				echo '<div class="trackInfo">';
				echo '<a href="'.$track->permalink_url.'" target="_blank"><h2>'.$track->user->username.'</h2></a>';
				echo '<div class="desc">'.nl2br(substr($track->description,0,600)).'</div>';				
				echo '</div><div class="clearfix"></div></div>';
				$count++;
			}
		}
	}
	echo '</div>';
	echo '</div><div class="clearfix"></div>';
}
?>

<?php

try{
require_once 'Zend/Loader.php';
Zend_Loader::loadClass('Zend_Gdata_YouTube');
$yt = new Zend_Gdata_YouTube();
$query = $yt->newVideoQuery();
$query->videoQuery = 'orkney '.$place->youtube_search;
$query->startIndex = 1;
$query->maxResults = 1;
$query->orderBy = 'relevance';
$videoFeed = $yt->getVideoFeed($query);

if(!empty($videoFeed)){
	if(sizeof($videoFeed)>0){
		echo '<div class="youtube smallBox">';
		echo '<div class="heading"><img src="/themes/intoOrkney/i/icon_youtube.png" width="72" height="51" style="padding-right:28px;" alt="youtube"/>Youtube</div>';
		echo '<div class="details">';
		foreach ($videoFeed as $videoEntry) {
			echo '<iframe id="player" allowfullscreen="true" type="text/html" width="430" height="270" src="'.$videoEntry->getFlashPlayerUrl().'" frameborder="0"></iframe>';
		    echo "<h1>" . $videoEntry->getVideoTitle() . "</h1>";
		    // echo "<div>".$videoEntry->getVideoDescription()."</div>";
		}
		echo '</div>';
		echo '</div><div class="clearfix"></div>';
	}
}
}catch(Exception $e){
	error_log($e);
}
?>

<?php
if(false){
	echo '<div class="links smallBox">';
	echo '<div class="heading"><img src="/themes/intoOrkney/i/icon_links.png" width="66" height="51" style="padding-right:34px;" alt="links"/>Links</div>';
	echo '<div class="details">';
	echo 'links';
	echo '</div>';
	echo '</div><div class="clearfix"></div>';
}
?>

<?php
if($place->freetext){
	echo '<div class="info smallBox">';
	echo '<div class="heading"><img src="/themes/intoOrkney/i/icon_info.png" width="47" height="51" alt="information"/>Information</div>';
	echo '<div class="details">';
	echo $place->freetext;
	echo '</div>';
	echo '</div><div class="clearfix"></div>';
}
?>

</div>
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