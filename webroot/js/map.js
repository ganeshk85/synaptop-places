// *
// * Add multiple markers
// * 2013 - en.marnoto.com
// *

// necessary variables
var map;
var infoWindow;

// markersData variable stores the information necessary to each marker
var markersData = [
   {
      lat: 43.642424,
      lng: -79.385865,
      name: "Ripley's Aquarium"
   },
   {
      lat: 43.642566,
      lng: -79.387057,
      name: "CN Tower"
   },
   {
      lat: 43.817699,
      lng: -79.185890,
      name: "Toronto Zoo"
   },
   {
      lat: 43.667710,
      lng: -79.394777,
      name: "Royal Ontario Museum"
   },
   {
      lat: 43.653607,
      lng: -79.392512,
      name: "Art Gallery of Ontario"
   },
   {
      lat: 43.725887,
      lng: -79.453206,
      name: "Yorkdale Mall"
   },
   {
      lat: 43.653597,
      lng: -79.381455,
      name: "Eaton Center"
   },
   {
      lat: 43.653440,
      lng: -79.384090,
      name: "City Hall"
   },
   {
      lat: 43.646988,
      lng: -79.377264,
      name: "Hockey Hall of Fame"
   } // don't insert comma in the last item
];


function initialize() {
   var mapOptions = {
      center: new google.maps.LatLng(43.652644,-79.381769),
      zoom: 9,
      mapTypeId: 'roadmap',
   };

   map = new google.maps.Map(document.getElementById('map-canvas'), mapOptions);

   // a new Info Window is created
   infoWindow = new google.maps.InfoWindow();

   // Event that closes the Info Window with a click on the map
   google.maps.event.addListener(map, 'click', function() {
      infoWindow.close();
   });

   // Finally displayMarkers() function is called to begin the markers creation
   displayMarkers();
}
google.maps.event.addDomListener(window, 'load', initialize);


// This function will iterate over markersData array
// creating markers with createMarker function
function displayMarkers(){

   // this variable sets the map bounds according to markers position
   var bounds = new google.maps.LatLngBounds();
   
   // for loop traverses markersData array calling createMarker function for each marker 
   for (var i = 0; i < markersData.length; i++){

      var latlng = new google.maps.LatLng(markersData[i].lat, markersData[i].lng);
      var name = markersData[i].name;
      //var address1 = markersData[i].address1;
      //var address2 = markersData[i].address2;
      //var postalCode = markersData[i].postalCode;

      createMarker(latlng, name);

      // marker position is added to bounds variable
      bounds.extend(latlng);  
   }

   // Finally the bounds variable is used to set the map bounds
   // with fitBounds() function
   map.fitBounds(bounds);
}

// This function creates each marker and it sets their Info Window content
function createMarker(latlng, name){
   var marker = new google.maps.Marker({
      map: map,
      position: latlng,
      title: name
   });

   // This event expects a click on a marker
   // When this event is fired the Info Window content is created
   // and the Info Window is opened.
   google.maps.event.addListener(marker, 'click', function() {
      
      // Creating the content to be inserted in the infowindow
      var iwContent = '<div id="iw_container">' +
            '<div class="iw_title">' + name + '</div>';
      
      // including content to the Info Window.
      infoWindow.setContent(iwContent);

      // opening the Info Window in the current map and at the current marker location.
      infoWindow.open(map, marker);
   });
}

//function to toggle between map and list
function toggle(name){
   if(name == "list"){
      document.getElementById('places_list').style.display = "block";
      document.getElementById('places_map').style.display = "none";
   }
   else{
      document.getElementById('places_list').style.display = "none";
      document.getElementById('places_map').style.display = "block";
      initialize();
   }
}