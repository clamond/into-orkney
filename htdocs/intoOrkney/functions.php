<?php
require_once("creds.php");

function getTrailImageURL($trail_id){
	global $db_user, $db_pass, $db_name;
	
	$mysqli = new mysqli("localhost", $db_user, $db_pass, $db_name);
	if ($mysqli->connect_errno) {
	    echo "Failed to connect to MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
	}
	
	$get_place = $mysqli->stmt_init();
	$get_place->prepare("select i.image_url from trail_place tp join rcahms r on r.place_id=tp.place_id join rcahms_image i on i.rcahms_id=r.rcahms_id where tp.trail_id=? limit 1");
	$get_place->bind_param( "i", $trail_id);
	$get_place->execute();
	$get_place->bind_result($url);
	$get_place->fetch();
	$get_place->close();
	return $url;
	
	$mysqli->close();
}

function getPlaceImageURL($place_id){
	global $db_user, $db_pass, $db_name;
		
	$mysqli = new mysqli("localhost", $db_user, $db_pass, $db_name);
	if ($mysqli->connect_errno) {
	    echo "Failed to connect to MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
	}
	
	$get_place = $mysqli->stmt_init();	
	$get_place->prepare("select i.image_url from rcahms r join rcahms_image i on i.rcahms_id=r.rcahms_id where r.place_id=? limit 1");
	$get_place->bind_param( "i", $place_id);
	$get_place->execute();
	$get_place->bind_result($url);
	$get_place->fetch();
	$get_place->close();
	return $url;
	
	$mysqli->close();
}

?>