$(function() {
	$.urlParam = function(name){
		try{
 	    	var results = new RegExp('[\\?&]' + name + '=([^&#]*)').exec(window.location.href);
	    	return results[1] || 0;
		}catch(e){
			return "";
		}
	}
	
	if($("body.place").length>0){
		var $container = $('div.smallblocks');

		$container.imagesLoaded( function(){
 		  if ($(window).width()>900){
			  $container.masonry({
			    itemSelector : '.smallBox'
			  });
		  }
		});
	}else
	if($("div.mainContentHome").length>0){
		var search=$.urlParam("search");
		if(search=="")
			dataURL="/intoOrkney/sites-json.php";
		else {
			dataURL="/intoOrkney/sites-json.php?search="+search;		
			$("#search").val(search);
			$("#search").removeClass("hint");
		}
		$("#map").html("<h1>loading<h1>");

		$.getScript(dataURL,function(e){
	        var mapOptions = {
	          center: new google.maps.LatLng(59.002384396250704, -2.7410888671875),
	          zoom: 9,
	          mapTypeId: google.maps.MapTypeId.ROADMAP
	        };
	        var map = new google.maps.Map(document.getElementById("map"), mapOptions);		
		
			var markerCluster;
			var outerCount=Math.floor(sd.count/300);
			for (var j = 0; j < outerCount; j++){
				var base=j*300;
			    var markers = [];
				for (var i = 0; i < 300 ; i++) {
				  var index=base+i;	
					
				  var latLng = new google.maps.LatLng(sd.sites[index].lat, sd.sites[index].long);
				  var marker = new google.maps.Marker({'position': latLng, 'clickable' : true, 'title': sd.sites[index].t});
				  markers.push(marker);
				  addPinClick(marker,"/intoOrkney/place.php?id="+sd.sites[index].id);
				}
				
				if (typeof markerCluster === "undefined")
			      markerCluster = new MarkerClusterer(map, markers);			
				else
				  markerCluster.addMarkers(markers);
			}
			
		    var markers = [];
			for (var i = outerCount*300; i < sd.count ; i++) {
			    var latLng = new google.maps.LatLng(sd.sites[i].lat, sd.sites[i].long);
			    var marker = new google.maps.Marker({'position': latLng, 'clickable' : true, 'title': sd.sites[i].t});
			    markers.push(marker);
			    addPinClick(marker,"/intoOrkney/place.php?id="+sd.sites[i].id);
			}			
			if (typeof markerCluster === "undefined")
		      markerCluster = new MarkerClusterer(map, markers);			
			else
			  markerCluster.addMarkers(markers);

			$("#map").html("");
			
			if(search==""){
			}else if(sd.count==0)
			$("span.resultCount").html("no results");
			else if(i==1)
			$("span.resultCount").html("1 result");
			else
			$("span.resultCount").html(i+" results");						
		});
		$("#search").focus(function(e){
			if($(this).val()=='search'){
				$(this).val("");
 				$("#search").removeClass("hint");				
			}
		});
	}else
	if($("body.cms-choosePlace").length>0){
        var mapOptions = {
          center: new google.maps.LatLng(59.002384396250704, -2.7410888671875),
          zoom: 9,
          mapTypeId: google.maps.MapTypeId.ROADMAP
        };
        var map = new google.maps.Map(document.getElementById("map"), mapOptions);		
		var markers = [];
		for (var i = 0; i < sd.count ; i++) {
		  var latLng = new google.maps.LatLng(sd.sites[i].lat, sd.sites[i].long);
		  var marker = new google.maps.Marker({'position': latLng, 'clickable' : true, 'title': sd.sites[i].t});
		  markers.push(marker);
		  addPinClick(marker,"/intoOrkney/cms/editPlace.php?id="+sd.sites[i].id);
		}
		var markerCluster = new MarkerClusterer(map, markers);
	}else
	if($("body.cms-editTrail").length>0){
		$("a.addSite").click(function(e){
			e.preventDefault();
			$.modal('<iframe src="/intoOrkney/cms/popUpChoosePlace.php" height="430" width="750" style="border:0">', {
				closeHTML:"",
				containerCss:{
					backgroundColor:"#fff", 
					borderColor:"#fff", 
					height:450, 
					padding:0, 
					width:750
				},
				overlayClose:true
			});
		});
		$("textarea").ckeditor();
	}else
	if($("body.cms-popupChoosePlace").length>0){
        var mapOptions = {
          center: new google.maps.LatLng(59.002384396250704, -2.7410888671875),
          zoom: 9,
          mapTypeId: google.maps.MapTypeId.ROADMAP
        };
        var map = new google.maps.Map(document.getElementById("map"), mapOptions);		
		var markers = [];
		for (var i = 0; i < sd.count ; i++) {
		  var latLng = new google.maps.LatLng(sd.sites[i].lat, sd.sites[i].long);
		  var marker = new google.maps.Marker({'position': latLng, 'clickable' : true, 'title': sd.sites[i].t});
		  markers.push(marker);
		  editTrailSelectSiteClick(marker,sd.sites[i].id);
		}
		var markerCluster = new MarkerClusterer(map, markers);
		
		$("a.close").click(function(e){
			e.preventDefault();
			parent.editTrailSelectSiteClose();
		});
	}else
	if($("body.trail").length>0){
        var mapOptions = {
          mapTypeId: google.maps.MapTypeId.ROADMAP
        };
        var map = new google.maps.Map(document.getElementById("map"), mapOptions);		
		var markers = [];
		var bounds = new google.maps.LatLngBounds ();		
		$("a.trailPlace").each(function(i){
		  var e=$(this).attr("rel").split(",");
		  var latLng = new google.maps.LatLng(e[1], e[2]);
		  bounds.extend (latLng);		
		  var marker = new google.maps.Marker({'position': latLng, 'clickable' : true, 'title': e[3]});
		  markers.push(marker);			
		  addPinClick(marker,"/intoOrkney/place.php?id="+e[0]);		
		});
		var markerCluster = new MarkerClusterer(map, markers);
		map.fitBounds (bounds);
	}
});

var map;
var markerCluster;

function loadPinData(){
	
}

function addPinClick(marker, url) {
	google.maps.event.addListener(marker, 'click', function() {
	   window.location=url;
	});		
}

function editTrailSelectSiteClick(marker, siteID){
	google.maps.event.addListener(marker, 'click', function() {
		parent.editTrailSelectSiteClose(siteID)
	});		
}

function editTrailSelectSiteClose(siteID){
	$.modal.close();
	if (typeof siteID != "undefined"){
		$("form.addSite input.add").val(siteID);
		$("form.addSite").submit();
	}
}


