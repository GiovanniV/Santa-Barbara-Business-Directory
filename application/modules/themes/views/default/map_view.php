<style>
    #classify-main-map{

        height: 450px;
    }
    #classify-main-map img { max-width: none; }


</style>

<?php $posts = get_all_business_map_data() ?>
<section id="big-map">
    <div id="classify-main-map"></div>
</section>

<script src="//maps.googleapis.com/maps/api/js?v=3.exp&libraries=places"></script>
<script src="<?php echo theme_url();?>/assets/js/markercluster.min.js"></script>
<script src="<?php echo theme_url();?>/assets/js/map-icons.min.js"></script>
<script src="<?php echo theme_url();?>/assets/js/map_config.js"></script>
<script type="text/javascript">

    var myLatitude = parseFloat('<?php echo get_settings("banner_settings","map_latitude", 37.2718745); ?>');
    var myLongitude = parseFloat('<?php echo get_settings("banner_settings","map_longitude", -119.2704153); ?>');

    var map;
    var markers = [];
    function initialize() {



        var zoomLevel = parseInt('<?php echo get_settings("banner_settings","map_zoom",8); ?>');
        var map_data = jQuery.parseJSON('<?php echo json_encode($posts); ?>');

        var myLatlng = new google.maps.LatLng(myLatitude,myLongitude);
        var mapOptions = {
            scrollwheel: false,
            zoom: zoomLevel,
            center: myLatlng,
            mapTypeControl: true,
            mapTypeControlOptions: {
                style: google.maps.MapTypeControlStyle.HORIZONTAL_BAR,
                position: google.maps.ControlPosition.RIGHT_BOTTOM
            },
            zoomControl: true,
            zoomControlOptions: {
                style: google.maps.ZoomControlStyle.SMALL,
                position: google.maps.ControlPosition.RIGHT_CENTER
            },
            panControl: true,
            panControlOptions: {
                position: google.maps.ControlPosition.RIGHT_TOP
            },
            mapTypeId: google.maps.MapTypeId.ROADMAP,
            styles: MAP_STYLE
        }

        map = new google.maps.Map(document.getElementById('classify-main-map'), mapOptions);

        var marker, i;
        var infoContentString = [];
        var infowindow = new google.maps.InfoWindow({
            content: "Hello World"
        });


        if(map_data.posts.length > 0){
            for (i = 0; i < map_data.posts.length; i++) {

                var marker_label = '<i class="fa '+ map_data.posts[i].fa_icon + '"></i>';
                marker = new Marker({
                    position: new google.maps.LatLng(map_data.posts[i].latitude, map_data.posts[i].longitude),
                    map: map,
                    label: marker_label,
                    title: map_data.posts[i].post_title,
                    zIndex: 9,
                    icon: {
                        path: SQUARE_PIN,
                        fillColor: map_data.posts[i].fa_color,
                        fillOpacity: 1,
                        strokeColor: '',
                        strokeWeight: 0,
                        scale: 1/3
                    }

                });

                infoContentString[i] = '<div class="img-box-4 text-center map-grid"><div class="img-box-4-item"><div class="image-style-one"><img class="img-responsive" alt="" src="'+ map_data.posts[i].featured_image_url + '"></div>'
                + '<div class="img-box-4-content"><h4 class="item-title"><a href="'+ map_data.posts[i].detail_link + '">'+ map_data.posts[i].post_title + '</a></h4><div class="bor bg-red"></div><div class="row"><div class="info-dta info-price">'
                + map_data.posts[i].price + '</div></div><div class="row"><div class="info-dta info-price">'+ map_data.posts[i].post_short_address + '</div></div>' + '</div></div></div>';

                google.maps.event.addListener(marker, 'click', (function (marker, i) {
                    return function () {
                        infowindow.setContent(infoContentString[i]);
                        infowindow.open(map, marker);
                        map.setCenter(this.getPosition());

                    }
                })(marker, i));
//                createMarkerButton(marker, map_data.posts[i]);
                markers.push(marker);
//                infoContentString.push(contentString);
            }
            var markerCluster = new MarkerClusterer(map, markers);
        }
    }

    google.maps.event.addDomListener(window, 'load', initialize);

</script>