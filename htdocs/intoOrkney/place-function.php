<?php

require_once("creds.php");
$mysqli = new mysqli("localhost", $db_user, $db_pass, $db_name);

if ($mysqli->connect_errno) {
    echo "Failed to connect to MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
}


Class place_data{
	public $place_name;
	public $loc_lat;
	public $loc_long;
	public $freetext;
	public $flickr_search;
	public $soundcloud_search;
	public $twitter_search;
	public $youtube_search;
}

Class rcahms_image{
	public $copyright;
	public $desc;
	public $url;
}

Class rcahms_data{
	public $rcahms_id;
	public $arch_notes;
	public $archi_notes;
	public $site_type;
	public $images;
}

Class placenames_data{
	public $desc;
	public $type;
	public $source;
	public $grid;
}


$place_id=$_GET['id'];
$place=new place_data;
$rcahms=new rcahms_data;
$placenames=new placenames_data;

$get_place = $mysqli->stmt_init();
$get_place->prepare("select p.place_name, p.loc_lat, p.loc_long, freetext, flickr_search, soundcloud_search, twitter_search, youtube_search from place p where p.place_id=?");
$get_place->bind_param( "i", $place_id);
$get_place->execute();
$get_place->bind_result($place->place_name, $place->loc_lat, $place->loc_long, $place->freetext, $place->flickr_search, $place->soundcloud_search, $place->twitter_search,$place->youtube_search);
$get_place->fetch();
$get_place->close();
$place->flickr_search='orkney '.$place->flickr_search;
$place->soundcloud_search='orkney and '.$place->soundcloud_search;
$place->twitter_search='orkney '.$place->twitter_search;
$place->youtube_search='orkney '.$place->youtube_search;

$get_placenames = $mysqli->stmt_init();
$get_placenames->prepare("SELECT place_description, name_type, name_source, original_grid_ref FROM place_name where place_id=?");
$get_placenames->bind_param( "i", $place_id);
$get_placenames->execute();
$get_placenames->bind_result($placenames->desc, $placenames->type, $placenames->source, $placenames->grid);
$get_placenames->fetch();
$get_placenames->close();

$get_rcahms = $mysqli->stmt_init();
$get_rcahms->prepare("select r.rcahms_id, r.archaeological_notes, r.architectural_notes, r.site_type from rcahms r where r.place_id=?");
$get_rcahms->bind_param( "i", $place_id);
$get_rcahms->execute();
$get_rcahms->bind_result($rcahms->rcahms_id, $rcahms->arch_notes, $rcahms->archi_notes, $rcahms->site_type);
$get_rcahms->fetch();
$get_rcahms->close();

$rcahms->images = array();


$get_rcahms_images = $mysqli->stmt_init();
$get_rcahms_images->prepare("select image_url, copyright, description from rcahms_image where rcahms_id=?");
$get_rcahms_images->bind_param( "s", $rcahms->rcahms_id);
$get_rcahms_images->execute();

$image_url='';
$image_copyright='';
$image_desc='';
$get_rcahms_images->bind_result($image_url, $image_copyright, $image_desc);
while ($get_rcahms_images->fetch()) {
	$nextImage=new rcahms_image;
	$nextImage->url=$image_url;
	$nextImage->copyright=$image_copyright;
	$nextImage->desc=$image_desc;
	$rcahms->images[]=$nextImage;
}
$get_rcahms_images->close();

$mysqli->close();
?>