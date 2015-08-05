$(document).ready(function(){

//--------------------------- Google Maps --------------------------------//

//For more example visit: http://hpneo.github.io/gmaps/examples.html

//Basic Map------------------------------

var map_basic = new GMaps({

el: '#gmap-basic',

lat: -12.043333,

lng: -77.028333,

zoomControl : true,

zoomControlOpt: {

style : 'SMALL',

position: 'TOP_LEFT'

},

panControl : false,

streetViewControl : false,

mapTypeControl: false,

overviewMapControl: false

});

//Map with markers-------------------------

var map_markers = new GMaps({

  div: '#gmap-markers',

  lat: -12.043333,

  lng: -77.028333

});

map_markers.addMarker({

  lat: -12.043333,

  lng: -77.03,

  title: 'Lima',

  details: {

database_id: 42,

author: 'HPNeo'

  },

  click: function(e){

if(console.log)

  console.log(e);

alert('You clicked in this marker');

  }

});

map_markers.addMarker({

  lat: -12.042,

  lng: -77.028333,

  title: 'Marker with InfoWindow',

  infoWindow: {

content: '<p>HTML Content</p>'

  }

});

//Geolocation-----------------------------

var map_geolocation = new GMaps({

  div: '#gmap-geolocation',

  lat: -12.043333,

  lng: -77.028333

});

GMaps.geolocate({

  success: function(position){

map.setCenter(position.coords.latitude, position.coords.longitude);

  },

  error: function(error){

//alert('Geolocation failed: '+error.message);

  },

  not_supported: function(){

//alert("Your browser does not support geolocation");

  },

  always: function(){

//alert("Done!");

  }

});

//Polylines---------------------------------

var map_polyline = new GMaps({

div: '#gmap-polyline',

lat: -12.043333,

lng: -77.028333,

click: function(e){

  console.log(e);

}

});

var path_polylines = [[-12.044012922866312, -77.02470665341184], [-12.05449279282314, -77.03024273281858], [-12.055122327623378, -77.03039293652341], [-12.075917129727586, -77.02764635449216], [-12.07635776902266, -77.02792530422971], [-12.076819390363665, -77.02893381481931], [-12.088527520066453, -77.0241058385925], [-12.090814532191756, -77.02271108990476]];

map_polyline.drawPolyline({

path: path_polylines,

strokeColor: '#131540',

strokeOpacity: 0.6,

strokeWeight: 6

});

//Polygons-----------------------------------

var map_polygon = new GMaps({

div: '#gmap-polygon',

lat: -12.043333,

lng: -77.028333

});

var path_polygons = [[-12.040397656836609,-77.03373871559225],

 [-12.040248585302038,-77.03993927003302],

 [-12.050047116528843,-77.02448169303511],

 [-12.044804866577001,-77.02154422636042]];

var polygon = map_polygon.drawPolygon({

paths: path_polygons,

strokeColor: '#BBD8E9',

strokeOpacity: 1,

strokeWeight: 3,

fillColor: '#BBD8E9',

fillOpacity: 0.6

});

//Static Map----------------------------------

var gmap_static_url = GMaps.staticMapURL({

size: [$('#gmap-static').width(), 350],

lat: -12.043333,

lng: -77.028333

});

$('<img/>').attr('src', gmap_static_url).appendTo('#gmap-static');

});