<link href="<?php echo theme_url();?>/assets/css/lightGallery.css" rel="stylesheet">
<script type="text/javascript">
    var switchTo5x=true;
    var url = "//w.sharethis.com/button/buttons.js";
    $.getScript( url, function() {
        stLight.options({publisher: "14ee463c-2587-4a82-9bf6-73dad7fc1c93", doNotHash: false, doNotCopy: true, hashAddressBar: false});
    });
</script>
<!-- Page heading two starts -->
<script src="<?php echo theme_url(); ?>/assets/js/jquery.lightSlider.min.js"></script>
<script src="<?php echo theme_url(); ?>/assets/js/lightGallery.min.js"></script>

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
        <div class="breads">
            <a href="<?php echo site_url(); ?>"><?php echo lang_key('home'); ?></a> / <?php echo lang_key('business_detail'); ?>
        </div>
        </div>
        <div class="clearfix"></div>
    </div>
</div>
<?php $street_view_settings = get_settings('business_settings', 'show_street_view', 'Yes'); ?>
<?php if($street_view_settings == 'Yes'){ ?>
<div class="map-wrapper">
    <div id="map_canvas_wrapper">
        <div id="map_street_view">

        </div>
    </div>
</div>
<?php } ?>
<!-- Page heading two ends -->
<div class="container real-estate" style="padding-top: 10px">

    <!-- Actual content -->
    <div class="rs-property">
        <!-- Block heading two -->
        <!--div class="block-heading-two">
            <h3><span><?php echo get_post_data_by_lang($post,'title'); ?></span></h3>
        </div>
        <br /-->
        <div class="row">
            <div class="col-md-9 col-sm-12 col-xs-12">
                
                <!-- Nav tab style 1 starts -->
                <div class="nav-tabs-one">
                    <!-- Nav tabs -->
                    <ul class="nav nav-tabs">
                        <li class="active"><a href="#p-nav-1" data-toggle="tab"><?php echo lang_key('details'); ?></a></li>
                        <li><a href="#p-nav-2" data-toggle="tab"><?php echo lang_key('contact'); ?></a></li>
                        <li><a href="#p-nav-3" data-toggle="tab"><?php echo lang_key('review'); ?></a></li>
                    </ul>
                    <!-- Tab content -->
                    <div class="tab-content">
                        <div class="tab-pane fade in active" id="p-nav-1">

                            <div class="single-property">

                                <?php $i=0; $images = ($post->gallery!='')?json_decode($post->gallery):array();?>

                                <div class="detail-slider">
                                    <ul id="imageGallery">

                                        <li data-thumb="<?php echo base_url().'uploads/images/'.$post->featured_img?>" data-src="<?php echo base_url().'uploads/images/'.$post->featured_img?>">
                                            <span class="helper"></span><img  src="<?php echo base_url().'uploads/images/'.$post->featured_img?>" />
                                        </li>

                                        <?php $i=0; $images = ($post->gallery!='')?json_decode($post->gallery):array();?>
                                        <?php 
                                        if(count($images)>0 && $images[0]!='')
                                        { 
                                            foreach ($images as $img) 
                                            { 
                                        ?>
                                        <li data-thumb="<?php echo base_url('uploads/gallery/' . $img); ?>" data-src="<?php echo base_url('uploads/gallery/' . $img); ?>">
                                            <span class="helper"></span><img  src="<?php echo base_url('uploads/gallery/' . $img); ?>" />
                                        </li>
                                        <?php 
                                            }
                                        } 
                                        ?>

                                    </ul>
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
                						    	<a href="mailto:<?php echo $post->email; ?>" target="_top"><?php echo $post->email; ?></a>
                                        </span>
                                    </div>

                                    <?php if($post->website!=''){?>
                                    <div class="ad-detail-info">
                                        <span class="span-left"><i class="fa fa-link bg-lblue"></i> <?php echo lang_key('website'); ?>:</span>

                                        <span class="span-right">
                                                <?php 
                                                $link = $post->website;
                                                if(strpos($post->website, '//')<=0)
                                                $link = '//'.$post->website;
                                                ?>
                						    	<a href="<?php echo $link;?>" target="_blank"><?php echo $post->website;?></a>
                                        </span>
                                    </div>
                                    <?php }?>

                                    <div class="ad-detail-info">
                                        <span class="span-left"><i class="fa fa-phone phone-icon"></i> <?php echo lang_key('phone'); ?>:</span>
                
                                        <span class="span-right">
                						    	<?php echo $post->phone_no; ?>
                                        </span>
                                    </div>

                                    <?php if($post->founded!=''){?>
                                        <div class="ad-detail-info">
                                            <span class="span-left"><i class="fa fa-key bg-lblue"></i> <?php echo lang_key('founded'); ?>:</span>

                                        <span class="span-right">
                						    	<?php echo $post->founded; ?>
                                        </span>
                                        </div>
                                    <?php }?>

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

                                    <div class="ad-detail-info">
                                        <span class="span-right">
                                        <a target="_blank" href="<?php echo site_url('show/printview/'.$post->unique_id);?>"><i class="fa fa-print fa-lg"></i> <?php echo lang_key('print') ?></a></span>
                                    </div>
                                    <div class="share-links">
                                        <span class='st_sharethis_hcount' displayText='ShareThis'></span>
                                        <span class='st_facebook_hcount' displayText='Facebook'></span>
                                        <span class='st_twitter_hcount' displayText='Tweet'></span>
                                        <span class='st_linkedin_hcount' displayText='LinkedIn'></span>
                                        <span class='st_pinterest_hcount' displayText='Pinterest'></span>
                                        <span class='st_email_hcount' displayText='Email'></span>
                                    </div>
                                </div>
                                <div class="clearfix"></div>




                                <!-- heading -->
                                <h4 class="info-subtitle"><i class="fa fa-rocket"></i> <?php echo lang_key('details') ?></h4>

                                <!-- paragraph -->
                                <p><?php echo get_post_data_by_lang($post,'description'); ?></p>
                                <hr />
                                <div class="clearfix"></div>


                                <?php if($post->opening_hour != ''){ ?>
                                    <h4 class="info-subtitle"><i class="fa fa-list-ul"></i> <?php echo lang_key('opening_hour'); ?></h4>
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

                                <?php

                                $comment_settings = get_settings('business_settings', 'enable_comment', 'No');
                                if($comment_settings == 'Disqus Comment')
                                { 
                                    $disqus_shortname = get_settings('business_settings', 'disqus_shortname', 'dbcinfotech');

                                ?>
                                <div id="disqus_thread"></div>
                                <script type="text/javascript">
                                    var disqus_shortname = '<?php echo $disqus_shortname; ?>'; // required: replace example with your forum shortname

                                    (function() {
                                        var dsq = document.createElement('script'); dsq.type = 'text/javascript'; dsq.async = true;
                                        dsq.src = '//' + disqus_shortname + '.disqus.com/embed.js';
                                        (document.getElementsByTagName('head')[0] || document.getElementsByTagName('body')[0]).appendChild(dsq);
                                    })();
                                </script>
                                <noscript>Please enable JavaScript to view the <a href="http://disqus.com/?ref_noscript">comments powered by Disqus.</a></noscript>
                                <div class="clearfix"></div>
                                
                                <?php 
                                } 
                                ?>

                                <?php 

                                if($comment_settings == 'Facebook Comment')
                                { 
                                    $fb_app_id = get_settings('business_settings', 'fb_comment_app_id', ''); ?>
                                    <style>
                                        .fb-comments, .fb-comments iframe[style] {width: 100% !important;}
                                    </style>
                                    <div id="fb-root"></div>
                                    <script>
                                        var fb_app_id = '<?php echo $fb_app_id; ?>';

                                        (function(d, s, id) {
                                            var js, fjs = d.getElementsByTagName(s)[0];
                                            if (d.getElementById(id)) return;
                                            js = d.createElement(s); js.id = id;
                                            js.src = "//connect.facebook.net/en_US/sdk.js#xfbml=1&appId=" + fb_app_id + "&version=v2.0";
                                            fjs.parentNode.insertBefore(js, fjs);
                                        }(document, 'script', 'facebook-jssdk'));
                                    </script>

                                    <div style="clear:both;margin-top:10px;"></div>
                                    <div class="fb-comments" data-href=" <?php echo current_url();?>" data-numposts="10" data-colorscheme="light"></div>

                                <?php 
                                } 
                                ?>
                                
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
                        </div>

                        <div class="tab-pane fade" id="p-nav-2">

                            <div class="single-property sp-agent">
                                <!--img class="img-responsive img-thumbnail" src="<?php echo get_profile_photo_by_id($post->created_by); ?>" alt="" />
                                <h5><?php echo get_user_fullname_by_id($post->created_by); ?></h5-->

                                <!--span><strong><?php echo lang_key('contact_mode'); ?></strong>: <?php echo lang_key('phone'); ?>, <?php echo lang_key('email'); ?></span-->

                                <div class="clearfix"></div>
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

                                <div class="rs-enquiry">
                                    <h3><?php echo lang_key('send_email_to_business');?></h3>
                                    <div class="ajax-loading recent-loading"><img src="<?php echo theme_url();?>/assets/img/loading.gif" alt="loading..."></div>
                                    <div class="clearfix"></div>
                                    <span class="agent-email-form-holder">
                                    </span>
                                </div>

                            </div>

                        </div>

                         <div class="tab-pane fade" id="p-nav-3">
                             <div class="ajax-loading review-loading"><img src="<?php echo theme_url();?>/assets/img/loading.gif" alt="loading..."></div>

                             <?php if(is_loggedin()){?>

                             <span class="review-form-holder"></span>
                            <?php } else { ?>
                                 <div class="alert alert-info" role="alert"><?php echo lang_key('review_alert'); ?></div>
                             <?php } ?>
                             <div style="margin-top:20px"></div>
                             <h4 class="info-subtitle"><i class="fa fa-rocket"></i> <?php echo lang_key('recent_reviews');?></h4>
                             <div id="reviews-holder" class="team-two">
                                 <?php require('all_reviews_view.php');?>
                             </div>
                        </div>

                    </div>
                </div>
            </div>
            <div class="col-md-3 col-sm-12 col-xs-12">
                <div class="sidebar">
                
                    <div class="s-widget">
                        <h5><i class="fa fa-photo color"></i>&nbsp; <?php echo lang_key('image_gallery'); ?></h5>
                        <div class="widget-content gallery">
                            <div class="thumb">
                                <a href="<?php echo base_url('uploads/images/' . $post->featured_img); ?>" class="lightbox">
                                <img src="<?php echo base_url('uploads/images/' . $post->featured_img); ?>" alt="" class="img-responsive " />
                                </a>
                            </div>
                            <?php foreach ($images as $img) { ?>
                            <div class="thumb">
                                <a href="<?php echo base_url('uploads/gallery/' . $img); ?>" class="lightbox">
                                <img src="<?php echo base_url('uploads/gallery/' . $img); ?>" alt="" class="img-responsive " />
                                </a>
                            </div>
                            <?php $i++; } ?>
                        </div>
                        <div class="clearfix"></div>
                    </div>

                    <div class="s-widget">
                        <h5><i class="fa fa-tags color"></i>&nbsp; <?php echo lang_key('tags'); ?></h5>
                        <?php 
                        $tags = $post->tags; 
                        $CI = get_instance();
                        $CI->load->helper('text');
                        ?>
                        <?php if($tags != 'n/a' && $tags != ''){ ?>
                            <div class="widget-content tags">
                                <?php $tags = explode(',',$tags);
                                foreach ($tags as $tag) { ?>
                                    <a class="label label-color" href="<?php echo site_url('show/results/plainkey='.$tag)?>"><?php echo character_limiter($tag,30,'...'); ?></a>
                                <?php } ?>
                            </div>
                        <?php } ?>
                    </div>
                    <div class="clearfix"></div>

                    <div class="s-widget">
                        <h5><i class="fa fa-share color"></i>&nbsp; <?php echo lang_key('social_links');?></h5>
                        <!-- Widgets Content -->
                        <div class="widget-content brand-bg">
                            <!-- Social Media Icons -->
                            <?php 
                            $profile_link = get_post_meta($post->id,'facebook_profile','');
                            if($profile_link!=''){?>
                            <a class="facebook" href="<?php echo $profile_link;?>"><i class="fa fa-facebook square-3 rounded-1"></i></a>
                            <?php }?>

                            <?php 
                            $profile_link = get_post_meta($post->id,'twitter_profile','');
                            if($profile_link!=''){?>
                            <a class="twitter" href="<?php echo $profile_link;?>"><i class="fa fa-twitter square-3 rounded-1"></i></a>
                            <?php }?>

                            <?php 
                            $profile_link = get_post_meta($post->id,'linkedin_profile','');
                            if($profile_link!=''){?>
                            <a class="linkedin" href="<?php echo $profile_link;?>"><i class="fa fa-linkedin square-3 rounded-1"></i></a>
                            <?php }?>

                            <?php 
                            $profile_link = get_post_meta($post->id,'pinterest_profile','');
                            if($profile_link!=''){?>
                            <a class="pinterest" href="<?php echo $profile_link;?>"><i class="fa fa-pinterest square-3 rounded-1"></i></a>
                            <?php }?>

                            <?php 
                            $profile_link = get_post_meta($post->id,'googleplus_profile','');
                            if($profile_link!=''){?>
                            <a class="google-plus" href="<?php echo $profile_link;?>"><i class="fa fa-google-plus square-3 rounded-1"></i></a>
                            <?php }?>
                            
                        </div>
                    </div>

                    <?php render_widgets('right_bar_detail');?>
                </div>
            </div>
        </div>
    </div>
</div>

</div>

<div id="reviewModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">

    <div class="modal-dialog">

        <div class="modal-content">

            <div class="modal-header">

                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>

                <h4 class="modal-title" id="myModalLabel"><?php echo lang_key('review'); ?></h4>

            </div>

            <div class="modal-body">


            </div>

            <div class="modal-footer">

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

        $('#imageGallery').lightSlider({
            gallery:false,
            item:1,
            speed:1000,
            auto:true,
            loop: true,
            thumbItem:9,
            slideMargin:0,
            currentPagerPosition:'left',
            onSliderLoad: function(plugin) {
                plugin.lightGallery();
            }
        });
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


        <?php if($street_view_settings == 'Yes'){ ?>
        var panoramaOptions = {
            position: myLatlng,
            pov: {
                heading: 165,
                pitch: 0
            },
            zoom: 1,
            scrollwheel: false
        };
        var myPano = new google.maps.StreetViewPanorama(
            document.getElementById('map_street_view'),
            panoramaOptions);
        myPano.setVisible(true);
        <?php } ?>

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

            title: '<?php echo get_post_data_by_lang($post,"title"); ?>',
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

    $("#reviews-holder").mCustomScrollbar();
    
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

                    loadUrl = '<?php echo site_url("show/review/load_all_reviews/".$post->id);?>';
                    jQuery.post(
                        loadUrl,
                        {},
                        function(responseText){
                            jQuery('#mCSB_1_container').html(responseText);
                        }
                    );

                    jQuery('.review-loading').hide();
                    init_create_review_js();
                }
            );
        });

    }
</script>
<?php } ?>
