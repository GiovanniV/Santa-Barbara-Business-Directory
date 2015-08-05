<?php require_once'includes_top.php';?>
<link href="<?php echo theme_url();?>/assets/css/lightGallery.css" rel="stylesheet">
<!-- Page heading two starts -->
<script src="<?php echo theme_url(); ?>/assets/js/jquery.lightSlider.min.js"></script>
<script src="<?php echo theme_url(); ?>/assets/js/lightGallery.min.js"></script>

<style type="text/css">
    @media print {
        a[href]:after {
            content: none !important;
        }

        .no-print{
            display: none !important;
        }

        .new-page{
            page-break-after: always;
        }

    }
</style>

<style>

    #details-map img { max-width: none; }
    .stButton .stFb, .stButton .stTwbutton, .stButton .stMainServices{
        height: 23px;
    }
    .stButton .stButton_gradient{
        height: 23px;
    }
    .map-wrapper{
        background: none repeat scroll 0 0 #f5f5f5;
        position: relative;
    }
    .map-wrapper #map_canvas_wrapper {
        overflow: hidden;
    }
    #map_street_view {
        height: 487px;
        width: 100%;
    }
</style>
<style>

    .team-two img{
        width: 120px !important;
        margin-right:10px !important;
    }
    .rs-property .sp-agent img{
        width: 120px !important;
    }
    .lightbox img{
        width:20%;
    }
    .page-heading-two{
        margin-bottom: 0px;
        padding-top:0;
        padding-bottom: 0;
    }
</style>

<?php $post = $post->row(); ?>

<!-- Page heading two starts -->
<div class="page-heading-two">
    <div class="container">   
        <div class="col-md-7">  
        <?php
            $business_logo = get_post_meta($post->id,'business_logo','');
            if($business_logo!='' && $business_logo!='no-image.png')
            {
                ?>
                <span class="business-logo-detail">
                    <img src="<?php echo base_url('uploads/logos/'.$business_logo);?>" class="pull-left" />
                </span>
                <?php
            }

            ?>   
        <h2 class="business-title-detail"><?php echo get_post_data_by_lang($post,'title'); ?> <span><?php echo get_category_title_by_id($post->category); ?></span></h2>
        
            
        </div>
        <div class="col-md-5">
            &nbsp;
        </div>
        <div class="clearfix"></div>
    </div>
</div>

<!-- Page heading two ends -->
<div class="container real-estate" style="padding-top: 10px">

    <!-- Actual content -->
    <div class="rs-property">
        
        <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">
                
                <!-- Nav tab style 1 starts -->
                <div class="nav-tabs-one">
                    
                    <!-- Tab content -->
                    <div class="tab-content">
                        <div class="tab-pane fade in active" id="p-nav-1">

                            <div class="single-property">

                                <?php $i=0; $images = ($post->gallery!='')?json_decode($post->gallery):array();?>

                                <div class="detail" style="text-align:center">
                                   

                                        <img  src="<?php echo base_url().'uploads/images/'.$post->featured_img?>" />
                                        

                                        <?php $i=0; $images = ($post->gallery!='')?json_decode($post->gallery):array();?>
                                        <?php 
                                        if(count($images)>0 && $images[0]!='')
                                        { 
                                            foreach ($images as $img) 
                                            { 
                                        ?>
                                       
                                           <img  src="<?php echo base_url('uploads/gallery/' . $img); ?>" />
                                        
                                        <?php 
                                            }
                                        } 
                                        ?>

                                    
                                </div>
                                <div class="clearfix"></div>

                                <hr />
                                <div class="info-box">
                                    <?php 
                                        $fa_icon        = get_category_fa_icon($post->category);
                                        $category_title = get_category_title_by_id($post->category);
                                    ?>
                                    <i class="fa <?php echo $fa_icon; ?> bg-red category"></i>
                                    <div class="sub-cat">
                                        <a href="<?php echo site_url('show/categoryposts/'.$post->category.'/'.$category_title);?>"><?php echo $category_title; ?></a>
                                    </div>

                                    <div class="ad-detail-info">
                                        <span class="span-left"><i class="fa fa-clock-o clock-icon"></i> <?php echo lang_key('added'); ?>:</span>

                                        <span class="span-right">
                						    	<?php echo date('M d, Y', $post->create_time); ?>
                                        </span>
                                    </div>

                                    <div class="ad-detail-info">
                                        <span class="span-left"><i class="fa fa-map-marker location-icon"></i> <?php echo lang_key('location'); ?>:</span>
                
                                        <span class="span-right">
                						    	<?php echo get_location_name_by_id($post->city); ?>
                                        </span>
                                    </div>

                                    <div class="ad-detail-info">
                                        <span class="span-left"><i class="fa fa-envelope price-icon"></i> <?php echo lang_key('email'); ?>:</span>
                
                                        <span class="span-right">
                						    	<?php echo $post->email; ?>
                                        </span>
                                    </div>

                                    <?php if($post->website!=''){?>
                                    <div class="ad-detail-info">
                                        <span class="span-left"><i class="fa fa-link bg-lblue"></i> <?php echo lang_key('website'); ?>:</span>

                                        <span class="span-right">
                						    	<?php echo $post->website; ?>
                                        </span>
                                    </div>
                                    <?php }?>

                                    <div class="ad-detail-info">
                                        <span class="span-left"><i class="fa fa-phone phone-icon"></i> <?php echo lang_key('phone'); ?>:</span>
                
                                        <span class="span-right">
                						    	<?php echo $post->phone_no; ?>
                                        </span>
                                    </div>

                                    <div class="ad-detail-info">
                                        <span class="span-left"><i class="fa fa-eye view-icon"></i> <?php echo lang_key('views'); ?>:</span>

                                        <span class="span-right">
                						    	<?php echo $post->total_view; ?>
                                        </span>
                                    </div>

                                    <?php if($post->featured==1){?>
                                    <div class="ad-detail-info">
                                        <span class="span-left"><i class="fa fa-bookmark bookmark-icon"></i> <?php echo lang_key('featured'); ?>:</span>
                
                                        <span class="span-right">
                                                <?php echo lang_key('yes'); ?>
                                        </span>
                                    </div>
                                    <?php }?>

                                    
                                </div>
                                <div class="clearfix"></div>




                                <!-- heading -->
                                <h4 class="info-subtitle"><i class="fa fa-rocket"></i> <?php echo lang_key('details') ?></h4>

                                <!-- paragraph -->
                                <p><?php echo get_post_data_by_lang($post,'description'); ?></p>
                                <hr />
                                <div class="clearfix"></div>


                                <?php if($post->opening_hour != ''){ ?>
                                    <h4 class="info-subtitle"><i class="fa fa-list-ul"></i> <?php echo lang_key('opening_hours'); ?></h4>
                                    <?php $opening_hours = json_decode($post->opening_hour); ?>
                                    <?php //print_r($opening_hours); die; ?>
                                    <ul class="list-6">
                                        <?php foreach($opening_hours as $value){ ?>
                                            <li><span><?php echo lang_key($value->day); ?></span><?php echo $value->closed == 1 ? lang_key('closed') : $value->start_time.'-'.$value->close_time ; ?></li>
                                        <?php } ?>
                                    </ul>
                                    <div class="clearfix"></div>
                                <?php } ?>


                                <?php if($post->additional_features != '' && $post->additional_features != '[]'){ ?>
                                    <h4 class="info-subtitle"><i class="fa fa-list-ul"></i> <?php echo lang_key('additional_features'); ?></h4>
                                    <?php $additional_features= json_decode($post->additional_features); ?>
                                    <ul class="list-2">
                                        <?php foreach($additional_features as $feature){ ?>
                                        <li><?php echo $feature; ?></li>
                                        <?php } ?>
                                    </ul>
                                    <div class="clearfix"></div>
                                <?php } ?>

                                <div class="new-page"></div>
                                <?php $full_address = get_formatted_address($post->address, $post->city, $post->state, $post->country, $post->zip_code); ?>
                                <div id="ad-address"><span><?php echo $full_address; ?></span></div>
                                
                                <h4 class="info-subtitle"><i class="fa fa-map-marker"></i> <?php echo lang_key('location_on_map'); ?></h4>
                                <div class="gmap" id="details-map"></div>
                                <div class="clearfix"></div>


                                <?php if($post->video_url !=''){?>
                                <h4 class="info-subtitle"><i class="fa fa-film"></i> <?php echo lang_key('featured_video'); ?></h4>
                                    <span id="video_preview"></span>

                                    <input type="hidden" name="video_url" id="video_url" value="<?php echo $post->video_url;?>">
                                <?php }?>
                            </div>

                            <div class="table-responsive">
                                <table class="table table-bordered">
                                    <tr>
                                        <th><?php echo lang_key('address'); ?></th>
                                        <td><?php echo $full_address; ?></td>
                                    </tr>
                                    <tr>
                                        <th><?php echo lang_key('email'); ?></th>
                                        <td><?php echo $post->email; ?></td>
                                    </tr>
                                    <tr>
                                        <th><?php echo lang_key('phone'); ?></th>
                                        <td><?php echo $post->phone_no; ?></td>
                                    </tr>
                                    <tr>
                                        <th><?php echo lang_key('website'); ?></th>
                                        <td><?php echo $post->website; ?></td>
                                    </tr>
                                </table>
                            </div>

                            <div class="new-page"></div>
                            <h4 class="info-subtitle"><i class="fa fa-rocket"></i> <?php echo lang_key('recent_reviews');?></h4>
                             <?php $reviews = get_all_post_reviews($post->id); ?>
                             <div id="reviews" class="team-two">
                                 <?php
                                 $i=1;
                                 foreach($reviews->result() as $review)
                                 {
                                    $i++;
                                     ?>
`
                                     <div class="row review-<?php echo $i;?>">

                                         <div class="col-md-2">
                                             <a href="http://localhost/businessdirectory/index.php/en/profile/1/Saad Naufel">
                                                 <img alt="user-image" src="<?php echo get_profile_photo_by_id($review->created_by); ?>" class="img-responsive user-img">
                                             </a>
                                         </div>
                                         <div class="col-md-10">
                                             <h4><?php echo get_user_fullname_by_id($review->created_by); ?></h4>
                                             <p class="contact-types">
                                                 <?php echo get_review_stars($review->rating);?>
                                             <div class="clearfix"></div>
                                             <strong><?php echo lang_key('posted_on');?>:</strong> <?php echo date('D, M d, Y', $review->create_time); ?>
                                             </p>
                                             <p><?php echo truncate(strip_tags($review->comment),200,'&nbsp;<a class="review-detail" href="'.site_url('show/reviewdetail/'.$review->id).'">'.lang_key('review_detail').'</a>',false);?></p>
                                         </div>

                                     </div>
                                     <hr/>
                                 <?php
                                 }
                                 ?>
                             </div>

                        </div>


                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

</div>


<script src="//maps.googleapis.com/maps/api/js?v=3.exp&libraries=places"></script>
<script src="<?php echo theme_url();?>/assets/js/markercluster.min.js"></script>
<script src="<?php echo theme_url();?>/assets/js/map-icons.min.js"></script>
<script src="<?php echo theme_url();?>/assets/js/map_config.js"></script>

<script type="text/javascript">
    function getUrlVars(url) {

        var vars = {};

        var parts = url.replace(/[?&]+([^=&]+)=([^&]*)/gi, function(m,key,value) {

            vars[key] = value;

        });

        return vars;

    }



    function showVideoPreview(url)

    {

        if(url.search("youtube.com")!=-1)

        {

            var video_id = getUrlVars(url)["v"];

            //https://www.youtube.com/watch?v=jIL0ze6_GIY

            var src = '//www.youtube.com/embed/'+video_id;

            //var src  = url.replace("watch?v=","embed/");

            var code = '<iframe class="thumbnail" width="100%" height="420" src="'+src+'" frameborder="0" allowfullscreen></iframe>';

            jQuery('#video_preview').html(code);

        }

        else if(url.search("vimeo.com")!=-1)

        {

            //http://vimeo.com/64547919

            var segments = url.split("/");

            var length = segments.length;

            length--;

            var video_id = segments[length];

            var src  = url.replace("vimeo.com","player.vimeo.com/video");

            var code = '<iframe class="thumbnail" src="//player.vimeo.com/video/'+video_id+'" width="100%" height="420" frameborder="0" webkitallowfullscreen mozallowfullscreen allowfullscreen></iframe>';

            jQuery('#video_preview').html(code);

        }

        else

        {


        }

    }

    $(document).ready(function() {

        jQuery('.review-detail').click(function(e){
            e.preventDefault();
            var loadUrl = jQuery(this).attr('href');
            jQuery.post(
                loadUrl,
                {},
                function(responseText){
                    jQuery('#reviewModal .modal-body').html(responseText);
                    jQuery('#reviewModal').modal('show');
                }
            );

        }); 

        jQuery('#video_url').change(function(){

            var url = jQuery(this).val();

            showVideoPreview(url);

        }).change();

    });

    var myLatitude = parseFloat('<?php echo $post->latitude; ?>');

    var myLongitude = parseFloat('<?php echo $post->longitude; ?>');

    function initialize() {


        var zoomLevel = parseInt('<?php echo get_settings('banner_settings','map_zoom',8); ?>');

        var myLatlng = new google.maps.LatLng(myLatitude,myLongitude);
        var map_data = jQuery.parseJSON('<?php echo get_business_map_data_single($post); ?>');

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
        map = new google.maps.Map(document.getElementById('details-map'), mapOptions);


        var contentString = '<div class="img-box-4 text-center map-grid"><div class="img-box-4-item"><div class="image-style-one"><img class="img-responsive" alt="" src="'+ map_data.posts[0].featured_image_url + '"></div>'
            + '<div class="img-box-4-content"><h4 class="item-title"><a href="'+ map_data.posts[0].detail_link + '">'+ map_data.posts[0].post_title + '</a></h4><div class="bor bg-red"></div><div class="row"><div class="info-dta info-price">'
            + map_data.posts[0].price + '</div></div><div class="row"><div class="info-dta info-price">'+ map_data.posts[0].post_short_address + '</div></div>' + '</div></div></div>';



        var infowindow = new google.maps.InfoWindow({

            content: contentString

        });

        var marker, i;

        var markers = [];

        marker = new Marker({

            position: myLatlng,

            map: map,

            title: '<?php echo get_post_data_by_lang($post,'title'); ?>',
            zIndex: 9,
            icon: {
                path: SQUARE_PIN,
                fillColor: '#ed5441',
                fillOpacity: 1,
                strokeColor: '',
                strokeWeight: 0,
                scale: 1/3
            },
            label: '<i class="fa <?php echo $fa_icon; ?>"></i>'


        });

        google.maps.event.addListener(marker, 'click', (function(marker, i) {

            return function() {

                infowindow.open(map, marker);

            }

        })(marker, i));

        markers.push(marker);

    }

    google.maps.event.addDomListener(window, 'load', initialize);
</script>

<!-- Main content ends -->



<script type="text/javascript">
jQuery(document).ready(function(){

    
    var loadUrl = '<?php echo site_url("show/load_contact_agent_view/".$post->unique_id);?>';
    jQuery.post(
        loadUrl,
        {},
        function(responseText){
            jQuery('.agent-email-form-holder').html(responseText);
            init_send_contact_email_js();
        }
    );
});

function init_send_contact_email_js()
{
        jQuery('#message-form').submit(function(e){
        var data = jQuery(this).serializeArray();
        jQuery('.recent-loading').show();
        e.preventDefault();
        var loadUrl = jQuery(this).attr('action');
        jQuery.post(
            loadUrl,
            data,
            function(responseText){
                jQuery('.agent-email-form-holder').html(responseText);
                jQuery('.alert-success').each(function(){
                    jQuery('#message-form input[type=text]').each(function(){
                        jQuery(this).val('');
                    });
                    jQuery('#message-form textarea').each(function(){
                        jQuery(this).val('');
                    });
                    jQuery('#message-form input[type=checkbox]').each(function(){
                        jQuery(this).attr('checked','');
                    });

                });
                jQuery('.recent-loading').hide();
                init_send_contact_email_js();
            }
        );
    });

}
</script>

<?php if(is_loggedin()){?>
<script type="text/javascript">
    jQuery(document).ready(function(){
        var loadUrl = '<?php echo site_url("show/review/load_review_form/".$post->id);?>';
        jQuery.post(
            loadUrl,
            {},
            function(responseText){
                jQuery('.review-form-holder').html(responseText);
                init_create_review_js();
            }
        );

        window.print();
        window.close();
    });

    function init_create_review_js()
    {
        jQuery('#review-form').submit(function(e){
            var data = jQuery(this).serializeArray();
            jQuery('.review-loading').show();
            e.preventDefault();
            var loadUrl = jQuery(this).attr('action');
            jQuery.post(
                loadUrl,
                data,
                function(responseText){
                    jQuery('.review-form-holder').html(responseText);
                    jQuery('.alert-success').each(function(){
                        jQuery('#review-form input[type=text]').each(function(){
                            jQuery(this).val('');
                        });
                        jQuery('#review-form textarea').each(function(){
                            jQuery(this).val('');
                        });
                    });
                    jQuery('.review-loading').hide();
                    init_create_review_js();
                }
            );
        });

    }
</script>
<?php } ?>
