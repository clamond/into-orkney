<?php 

require_once("../intoOrkney/creds.php");
require_once("phpcoord-2.3.php");

echo "updating location of place names\n";

$mysqli = new mysqli("localhost", $db_user, $db_pass, $db_name);
if ($mysqli->connect_errno) {
    echo "Failed to connect to MySQL(a1): (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
}

if (!($upd_place = $mysqli->prepare('UPDATE place set loc_lat=?, loc_long=? WHERE place_id=?'))) {
    echo "Prepare failed: (" . $mysqli->errno . ") " . $mysqli->error;
}



try {  

	$query = 'SELECT p.place_id, p.loc_lat FROM place_name n join place p on p.place_id=n.place_id';

	if ($stmt = $mysqli->prepare($query)) {
	    $stmt->execute();
		$stmt->store_result();	
	    $stmt->bind_result($place_id, $loc);
	    while ($stmt->fetch()) {

			echo '--> updating '.$place_id.' - loc='.$loc."\n";
			
			if(!empty($loc)){
				$parts=explode(" ",$loc);
				$os1='3'.$parts[0].'00';
				$os2='10'.$parts[0].'00';
				$os1w = new OSRef($os1,$os2);
		        echo "  OS Grid Reference: " . $os1w->toString() . " - " . $os1w->toSixFigureString() . "\n";
		        $ll1w = $os1w->toLatLng();
	
		        echo "  Converted to Lat/Long: " . $ll1w->toString()."\n";
			
				if (!$upd_place->bind_param( "ssi", $ll1w->lat, $ll1w->lng, $place_id)) {
				    echo "Binding parameters failed: (" . $upd_place->errno . ") " . $upd_place->error ."\n";
				}

				if (!$upd_place->execute()) {
				    echo "Execute failed(a11): (" . $upd_place->errno . ") " . $upd_place->error ."\n";
				}
			}else echo "#### NOT DOING THIS ONE\n";
	    }
	    $stmt->close();
	}
		

} catch (Exception $e) {  
    echo $e->getMessage(); 
} 


?>