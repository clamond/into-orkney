<?php

require_once("creds.php");
$mysqli = new mysqli("localhost", $db_user, $db_pass, $db_name);
if ($mysqli->connect_errno) {
    echo "Failed to connect to MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
}

echo 'var sd = { "sites": [';

if(empty($_GET['search']))	
	$query = "select loc_lat, loc_long, place_id, place_name from place where length(loc_lat)>2 and lower(place_name) not like '%general%'";	
else{
	$q='%'.$_GET['search'].'%';
	$query = 'select loc_lat, loc_long, place_id, place_name from place where length(loc_lat)>2 and lower(place_name) not like \'%general%\' and lower(place_name) like lower(?)';	
}	

if ($stmt = $mysqli->prepare($query)) {
	if(!empty($q))
		$stmt->bind_param( "s", $q);
    $stmt->execute();
    $stmt->bind_result($lat, $long, $id, $name);
	$count=0;
    while ($stmt->fetch()) {
		if(!empty($lat)){
			if($count>0) echo ',';
			echo '{"lat":'.$lat.',"long":'.$long.',"id":'.$id.',"t":"'.addslashes($name).'"}';
			$count++;
		}
    }
    $stmt->close();
	echo '],"count":'.$count;
}

$mysqli->close();

echo '}';
?>