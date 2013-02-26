<?php
require_once("../creds.php");
$mysqli = new mysqli("localhost", $db_user, $db_pass, $db_name);

if ($mysqli->connect_errno) {
    echo "Failed to connect to MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
}

$trail_id=$_GET['id'];

if(!empty($_POST['save_trail_id'])){
	$get_place = $mysqli->stmt_init();
	$get_place->prepare("update trail set trail_name=?, trail_desc=? where trail_id=?");
	$get_place->bind_param( "ssi",$_POST["trail_name"],$_POST["trail_desc"], $_POST['save_trail_id']);
	$get_place->execute();
	$get_place->close();	
}

if(!empty($_POST['add'])){
	$get_place = $mysqli->stmt_init();
	$get_place->prepare("insert into trail_place(trail_id, place_id, trail_order) select t.trail_id, ?, ifnull(max(tp.trail_order)+1,1) from trail t left join trail_place tp on tp.trail_id=t.trail_id where t.trail_id=?");
	$get_place->bind_param( "ii",$_POST["add"],$trail_id);
	$get_place->execute();
	$get_place->close();	
}

if(!empty($_GET['d'])){
	$get_place = $mysqli->stmt_init();
	$get_place->prepare("delete from trail_place where trail_place_id=?");
	$get_place->bind_param( "i",$_GET["d"]);
	$get_place->execute();
	$get_place->close();	
}

if(!empty($_GET['up'])){
	$get_place = $mysqli->stmt_init();
	$get_place->prepare("update trail_place set trail_order=trail_order+1 where trail_id=? and trail_order=?");
	$oneToMove=$_GET["cur"]-1;
	$get_place->bind_param( "ii",$trail_id,$oneToMove);
	$get_place->execute();
	$get_place->close();
	
	$get_place = $mysqli->stmt_init();
	$get_place->prepare("update trail_place set trail_order=trail_order-1 where trail_place_id=?");
	$get_place->bind_param( "i",$_GET["up"]);
	$get_place->execute();
	$get_place->close();
}

if(!empty($_GET['dn'])){
	$get_place = $mysqli->stmt_init();
	$get_place->prepare("update trail_place set trail_order=trail_order-1 where trail_id=? and trail_order=?");
	$oneToMove=$_GET["cur"]+1;
	$get_place->bind_param( "ii",$trail_id,$oneToMove);
	$get_place->execute();
	$get_place->close();
	
	$get_place = $mysqli->stmt_init();
	$get_place->prepare("update trail_place set trail_order=trail_order+1 where trail_place_id=?");
	$get_place->bind_param( "i",$_GET["dn"]);
	$get_place->execute();
	$get_place->close();
}


if(!empty($trail_id)){
	$get_place = $mysqli->stmt_init();
	$get_place->prepare("SELECT trail_name, trail_desc FROM trail where trail_id=?");
	$get_place->bind_param( "i", $trail_id);
	$get_place->execute();
	$get_place->bind_result($trail_name, $trail_desc);
	$get_place->fetch();
	$get_place->close();
}
else{
	header("Location: http://$_SERVER[HTTP_HOST]/intoOrkney/cms/trails.php");
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

<title>intoOrkney - edit trail <?=$trail_name?></title>

</head>
<body class="cms-editTrail">
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
	<a href="/intoOrkney/cms/trails.php">back to trails</a>
	<div class="editTrail">
		<form action="" method="post">
			<input type="hidden" name="save_trail_id" value="<?=$trail_id?>">
			<div class="label">trail name:</div><div class="data"><input type="text" name="trail_name" value="<?=$trail_name?>"/></div><div class="clearfix"></div>
			<div class="label">trail details:</div><div class="data"><textarea name="trail_desc">
<?=$trail_desc?>
</textarea></div><div class="clearfix"></div>
			<input type="submit" value="save"/>
		</form>
	</div>
	<div class="trailPlaces">
		<br/><br/>
		Below is a list of places that make up the trail, they are displayed to visitors in the order they are shown below. You can re-order by using the up and down links.<br/>
		<?php
			$query = 'select tp.trail_place_id, p.place_id, p.place_name, tp.trail_order from trail_place tp join place p on p.place_id=tp.place_id where tp.trail_id='.$trail_id.' order by tp.trail_order';
			
			if ($stmt = $mysqli->prepare($query)) {
			    $stmt->execute();
			    $stmt->bind_result($t_trail_place_id, $t_place_id, $t_place_name, $t_trail_order);
			    $first=true;
			    while ($stmt->fetch()) {				
					echo $t_trail_order.' '.$t_place_name.' (<a href="/intoOrkney/cms/editPlace.php?id='.$t_place_id.'">'.$t_place_id.'</a>) <a href="/intoOrkney/cms/trail.php?id='.$trail_id.'&d='.$t_trail_place_id.'">delete</a>';
					if(!$first)
						echo ' <a href="/intoOrkney/cms/trail.php?id='.$trail_id.'&up='.$t_trail_place_id.'&cur='.$t_trail_order.'">up</a>';
					echo ' <a href="/intoOrkney/cms/trail.php?id='.$trail_id.'&dn='.$t_trail_place_id.'&cur='.$t_trail_order.'">down</a>';
					echo '<br/>';
					$first=false;
			    }
			    $stmt->close();
			}

			$mysqli->close();
		?>		
	</div>
	<div>
		<a href="#" class="addSite">Add New Place</a>
		<form class="addSite" action="" method="post">
			<input type="hidden" name="id" value="<?=$trail_id?>"/>
			<input type="hidden" name="add" class="add" value=""/>
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
<script type="text/javascript" src="/themes/intoOrkney/js/vendor/jquery.simplemodal.1.4.3.min.js"></script>
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