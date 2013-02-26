<?php 

ini_set('memory_limit', '-1');

require_once("../intoOrkney/creds.php");
$mysqli = new mysqli("localhost", $db_user, $db_pass, $db_name);

if ($mysqli->connect_errno) {
    echo "Failed to connect to MySQL(a1): (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
}

if (!($ins_place = $mysqli->prepare('INSERT INTO place(place_name,loc_lat,loc_long, flickr_search, soundcloud_search, twitter_search, youtube_search) VALUES (?,?,?,?,?,?,?)'))) {
    echo "Prepare failed(a2): (" . $mysqli->errno . ") " . $mysqli->error;
}

if (!($upd_place = $mysqli->prepare('UPDATE place set place_name=?, loc_lat=?, loc_long=? WHERE place_id=?'))) {
    echo "Prepare failed(a3): (" . $mysqli->errno . ") " . $mysqli->error;
}

if (!($ins_rcahms = $mysqli->prepare('INSERT INTO rcahms(rcahms_id, place_id, archaeological_notes, architectural_notes, site_type) VALUES (?,?,?,?,?)'))) {
    echo "Prepare failed(a4): (" . $mysqli->errno . ") " . $mysqli->error;
}

if (!($upd_rcahms = $mysqli->prepare('UPDATE rcahms set archaeological_notes=?, architectural_notes=?, site_type=? WHERE rcahms_id=?'))) {
    echo "Prepare failed(a5): (" . $mysqli->errno . ") " . $mysqli->error;
}


if (!($ins_rcahms_image = $mysqli->prepare('INSERT INTO rcahms_image (rcahms_id,image_url,copyright,description) VALUES (?,?,?,?)'))) {
    echo "Prepare failed(a6): (" . $mysqli->errno . ") " . $mysqli->error;
}


require_once("phpcoord-2.3.php");

echo "getting data...\n";

try {  
    $client = @new SoapClient("http://orapweb.rcahms.gov.uk/wscanmoreapi/wscanmoreapiPort?WSDL", array('trace' => 1));

	$params = array(array("PParamName" => 'API_KEY', "PParamValue" => ''),
					array("PParamName" => 'SEARCH_MODE', "PParamValue" => 'COMPLEX_SEARCH'),
					array("PParamName" => 'RECORD_LIMIT', "PParamValue" => 10000));

	$result = $client->wsRc010SiteList($params);

	echo "#found ".sizeof($result->WsRc010ElementUser)."\n";
	$loaded=0;

	foreach ($result->WsRc010ElementUser as $site) {
	try{
		echo $site->nmrsName." (".$site->numlink.")\n";
		echo " siteType: ".$site->siteType."\n";
		echo " datum: ".$site->datum."\n";
		echo " latitude: ".$site->latitude."\n";
		echo " longitude: ".$site->longitude."\n";
		echo " mapSheet: ".$site->mapSheet."\n";
		echo " XCoord: ".$site->XCoord."\n";
		echo " YCoord: ".$site->YCoord."\n";

		$lat=trim($site->latitude);
		$long=trim($site->longitude);

		if (preg_match('/[A-Za-z]/', $lat))
			$lat='';
		if (preg_match('/[A-Za-z]/', $long))
			$long='';

		if(empty($lat)){
	        $os1w = new OSRef($site->XCoord, $site->YCoord);
	        echo "  OS Grid Reference: " . $os1w->toString() . " - " . $os1w->toSixFigureString() . "\n";
	        $ll1w = $os1w->toLatLng();
	        $ll1w->OSGB36ToWGS84();
	        echo "  Converted to Lat/Long: " . $ll1w->toString()."\n";
		
			$lat=$ll1w->lat;
			$long=$ll1w->lng;
		}
		
		//check if this record already exists in DB
			
		$mysqli->real_query("select rcahms_id, place_id from rcahms where rcahms_id='$site->numlink'");
		if($res = $mysqli->use_result()){
			$row = $res->fetch_assoc();
			$rcahms_id=$row['rcahms_id'];
			$place_id=$row['place_id'];
			$res->close();
		}
		
		$rcahms_archaeological='';
		$rcahms_architectural='';

		$siteEventParams = array(array("PParamName" => 'API_KEY', "PParamValue" => ''),
						array("PParamName" => 'SEARCH_MODE', "PParamValue" => 'SITE_SEARCH'),
						array("PParamName" => 'LINK_ID', "PParamValue" => $site->numlink));
		$siteEvents = $client->wsRc050EventList($siteEventParams);

		//if there is only one event it does not return an array with one item, but the object
		if(getType($siteEvents->WsRc050ElementUser)=='array'){
			foreach ($siteEvents->WsRc050ElementUser as $event) {
				echo " event: ".$event->eventType.' - '.$event->eventSubtype."\n";		
				if($event->eventSubtype=='ARCHITECTURE NOTES'){
					$rcahms_architectural=$event->eventNotes;
					echo "archi notes length=".strlen($rcahms_architectural)."\n";
				}else
				if($event->eventSubtype=='ARCHAEOLOGY NOTES'){
					$rcahms_archaeological=$event->eventNotes;
					echo "archa notes length=".strlen($rcahms_archaeological)."\n";
				}
			}
		}else{
			$event=$siteEvents->WsRc050ElementUser;
			if($event->eventSubtype=='ARCHITECTURE NOTES'){
				$rcahms_architectural=$event->eventNotes;
				echo "archi notes length=".strlen($rcahms_architectural)."\n";
			}else
			if($event->eventSubtype=='ARCHAEOLOGY NOTES'){
				$rcahms_archaeological=$event->eventNotes;	
				echo "archa notes length=".strlen($rcahms_archaeological)."\n";
			}		
		}
		
		//make sure we don't have empty strings
		if (strlen(trim($rcahms_architectural)) == 0) $rcahms_architectural='';
		if (strlen(trim($rcahms_archaeological)) == 0) $rcahms_archaeological='';

		if(empty($rcahms_id)){
			echo "new RCAHMS site\n";
		
			if (!$ins_place->bind_param( "sssssss", $site->nmrsName, $lat, $long, $site->nmrsName, $site->nmrsName, $site->nmrsName, $site->nmrsName)) {
			    echo "Binding parameters failed(a7): (" . $ins_place->errno . ") " . $ins_place->error ."\n";
			}

			if (!$ins_place->execute()) {
			    echo "Execute failed(a7a): (" . $ins_place->errno . ") " . $ins_place->error ."\n";
			}		
		
			$place_id=$ins_place->insert_id;
			$rcahms_id=$site->numlink;
			echo "new place_id=".$place_id."\n";
			
			if (!$ins_rcahms->bind_param( "sisss", $rcahms_id, $place_id, $rcahms_archaeological, $rcahms_architectural,  $site->siteType)) {
			    echo "Binding parameters failed(a8): (" . $ins_rcahms->errno . ") " . $ins_rcahms->error ."\n";
			}

			if (!$ins_rcahms->execute()) {
			    echo "Execute failed(a9): (" . $ins_rcahms->errno . ") " . $ins_rcahms->error ."\n";
			}
		}else{
			echo 'existing RCAHMS id='.$rcahms_id.", place id=".$place_id." updating....\n";
			if (!$upd_place->bind_param( "sssi", $site->nmrsName, $lat, $long, $place_id)) {
			    echo "Binding parameters failed(a10): (" . $upd_place->errno . ") " . $upd_place->error ."\n";
			}

			if (!$upd_place->execute()) {
			    echo "Execute failed(a11): (" . $upd_place->errno . ") " . $upd_place->error ."\n";
			}

			if (!$upd_rcahms->bind_param( "ssss", $rcahms_archaeological, $rcahms_architectural, $site->siteType, $rcahms_id)) {
			    echo "Binding parameters failed(a12): (" . $upd_rcahms->errno . ") " . $upd_rcahms->error ."\n";
			}

			if (!$upd_rcahms->execute()) {
			    echo "Execute failed(a13): (" . $upd_rcahms->errno . ") " . $upd_rcahms->error ."\n";
			}
			
			
			$mysqli->real_query("delete from rcahms_image where rcahms_id='$rcahms_id'");
		}
		
		
		$siteInfoParams = array(array("PParamName" => 'API_KEY', "PParamValue" => ''),
						array("PParamName" => 'SEARCH_MODE', "PParamValue" => 'SITE_SEARCH'),
						array("PParamName" => 'LINK_ID', "PParamValue" => $site->numlink));
		$siteInfo = $client->wsRc020CollList($siteInfoParams);
		foreach ($siteInfo->WsRc020ElementUser as $item) {
			echo " image: ".$item->thumbnailUrl."\n";
			if (!$ins_rcahms_image->bind_param( "ssss", $rcahms_id, $item->thumbnailUrl, $item->copyright, $item->description)) {
			    echo "Binding parameters failed: (" . $ins_rcahms_image->errno . ") " . $ins_rcahms_image->error ."\n";
			}

			if (!$ins_rcahms_image->execute()) {
			    echo "Execute failed: (" . $ins_rcahms_image->errno . ") " . $ins_rcahms_image->error ."\n";
			}
		}
		$loaded++;
	} catch (Exception $e) {  
		echo "ERROR(1)\n";
	    echo $e->getMessage(); 

		echo "\nREQUEST:\n" . $client->__getLastRequest() . "\n";
	} 	
	}
	echo "#found ".sizeof($result->WsRc010ElementUser).", loaded ".$loaded."\n";

} catch (Exception $e) {  
	echo "ERROR(2)\n";
    echo $e->getMessage(); 
	
	echo "\nREQUEST:\n" . $client->__getLastRequest() . "\n";
} 


$mysqli->close();
?>