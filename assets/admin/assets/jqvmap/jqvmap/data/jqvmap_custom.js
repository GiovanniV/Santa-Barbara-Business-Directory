$(document).ready(function(){

//--------------------------- Vector Maps --------------------------------//

$('#vmap-world').vectorMap({

map: 'world_en',

backgroundColor: '#d5e2f1',

hoverOpacity: 0.7,

enableZoom: true,

showTooltip: true,

values: sample_data,

normalizeFunction: 'polynomial'

});

$('#vmap-usa').vectorMap({

map: 'usa_en',

backgroundColor: '#d5e2f1',

enableZoom: true,

showTooltip: true,

selectedRegion: 'MO'

});

$('#vmap-germany').vectorMap({

map: 'germany_en',

backgroundColor: '#d5e2f1',

onRegionClick: function(element, code, region)

{

var message = 'You clicked "'

+ region 

+ '" which has the code: '

+ code.toUpperCase();

 

alert(message);

}

});

$('#vmap-europe').vectorMap({

map: 'europe_en',

backgroundColor: '#d5e2f1',

enableZoom: false,

showTooltip: true

});

});