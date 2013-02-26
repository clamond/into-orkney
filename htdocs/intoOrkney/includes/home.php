<?php
require_once("../creds.php");
$mysqli = new mysqli("localhost", $db_user, $db_pass, $db_name);
if ($mysqli->connect_errno) {
    echo "Failed to connect to MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
}

require_once("../functions.php");
?>

<div class="container"><div class="content">

<div class="mainContent mainContentHome">
	<div class="mainArea">
		<div class="topArea">
			<h1>Explore Orkney’s Archaeology and Heritage</h1>
		</div>		
	<div class="search">
	<div class="heading">
		<div style="float:left"><img src="/themes/intoOrkney/i/icon_search.png" width="41" height="51" alt="search"/>Search for sites</div>
		<div style="float:right">
			<form method="get" action="">
				<input type="text" name="search" id="search" class="hint" value="search">
			</form>
		</div>
		<div style="float:right;margin:15px 10px 0px 0px;font-size:18px;">
			<span class="resultCount"></span>
			&nbsp;&nbsp;<span class="loadProgress"></span>
		</div>	
		<div class="clearfix"></div>
	</div>
	<div class="searchContent">
		<div class="searchForm">
		</div>
		<div class="searchResults">
			<div id="map" class="map"></div>
		</div>
		<div class="clearfix"></div>
	</div></div>
	<div class="bottom">
		<div class="trails">
			<div class="heading">Explore Orkney’s Archaeology Trails</div>
			<div class="trailThumbs">
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
		<div class="recent smallBox">
		<div class="heading">Recently Updated sites</div>
		<div class="recentUpdates">
			<?php
				$query = 'select place_id, place_name, freetext from place order by last_update desc limit 5';
				if ($stmt = $mysqli->prepare($query)) {
				    $stmt->execute();
				    $stmt->bind_result($place_id, $place_name, $free_text);
				    while ($stmt->fetch()) {
						echo '<div class="place">';
						echo '<div class="placeImage"><img src=""/></div>';
						echo '<div class="placeText"><a href="/intoOrkney/place.php?id='.$place_id.'">'.$place_name.'</a><br/></div>';
						echo '</div>';
						echo '<div class="clearfix"></div>';
				    }
				    $stmt->close();
				}

				$mysqli->close();
			?>		
		</div><div class="clearfix"></div>
		</div>
	</div>

<div class="clearfix"></div>
	</div>

</div>
</div></div>

<script type="text/javascript" src="http://maps.googleapis.com/maps/api/js?sensor=false"></script>
<script type="text/javascript" src="/themes/intoOrkney/js/vendor/markerclusterer.js"></script>