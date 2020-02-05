	
	function openNav() {
	    document.getElementById("mySidenav").style.width = "270px";
	}

	function closeNav() {
	    document.getElementById("mySidenav").style.width = "0";
	}

	function initialize() {
	  var mapProp = {
	    center:new google.maps.LatLng(33.7294,73.0931),
	    zoom:5,
	    mapTypeId:google.maps.MapTypeId.ROADMAP
	  };
	  var map=new google.maps.Map(document.getElementById("googleMap"),mapProp);
	}
	google.maps.event.addDomListener(window, 'load', initialize);

