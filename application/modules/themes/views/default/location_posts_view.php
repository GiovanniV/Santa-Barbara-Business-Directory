<?php require 'home_custom_search.php';  ?>
<?php $per_page = get_settings('business_settings', 'posts_per_page', 6); ?>
<!-- Page heading two starts -->
<div class="page-heading-two">
    <div class="container">
        <h2><?php echo get_location_name_by_id($location_id);?></h2>
        <div class="breads">
            <a href="<?php echo site_url(); ?>"><?php echo lang_key('home'); ?></a> / <a href="<?php echo site_url('show/location/'); ?>"><?php echo lang_key('location'); ?></a> / <?php echo get_location_name_by_id($location_id);?>
        </div>
        <div class="clearfix"></div>
    </div>
</div>

<!-- Container -->
<div class="container">

    <div class="row">

        <div class="col-md-9 col-sm-12 col-xs-12">
            <div class="block-heading-two">
                <h3><span><i class="fa fa-map-marker"></i> <?php echo lang_key($location_type);?> : <?php echo get_location_name_by_id($location_id);?></span>
                    <div class="pull-right list-switcher">
                        <a target="recent-posts" href="<?php echo site_url('show/location_posts_ajax/'.$per_page.'/grid/'.$location_id.'/'.$location_type);?>"><i class="fa fa-th "></i></a>
                        <a target="recent-posts" href="<?php echo site_url('show/location_posts_ajax/'.$per_page.'/list/'.$location_id.'/'.$location_type);?>"><i class="fa fa-th-list "></i></a>
                    </div>
                </h3>
            </div>
            <span class="recent-posts">
            </span>
            <div class="ajax-loading recent-loading"><img src="<?php echo theme_url();?>/assets/img/loading.gif" alt="loading..."></div>
            <a href="" class="load-more-recent btn btn-blue" style="width:100%"><?php echo lang_key('load_more_posts');?></a>

            <script type="text/javascript">
                var per_page = '<?php echo $per_page;?>';
                var recent_count = '<?php echo $per_page;?>';

                jQuery(document).ready(function(){
                    jQuery('.list-switcher a').click(function(e){
                        jQuery('.list-switcher a').removeClass('selected');
                        jQuery(this).addClass('selected');
                        e.preventDefault();
                        var target = jQuery(this).attr('target');
                        var loadUrl = jQuery(this).attr('href');
                        jQuery('.recent-loading').show();
                        jQuery.post(
                            loadUrl,
                            {},
                            function(responseText){
                                jQuery('.'+target).html(responseText);
                                jQuery('.recent-loading').hide();
                                if(jQuery('.recent-posts > div').children().length<recent_count)
                                {
                                    jQuery('.load-more-recent').hide();
                                }
                                fix_grid_height();
                            }
                        );
                    });

                    jQuery('.load-more-recent').click(function(e){
                        e.preventDefault();
                        var next = parseInt(recent_count)+parseInt(per_page);
                        jQuery('.list-switcher a').each(function(){
                            var url = jQuery(this).attr('href');
                            url = url.replace('/'+recent_count+'/','/'+next+'/');
                            jQuery(this).attr('href',url);
                        });
                        recent_count = next;
                        jQuery('.list-switcher > .selected').trigger('click');
                    });
                });
            </script>
        </div>


        <div class="col-md-3 col-sm-12 col-xs-12">
            <div class="sidebar">
                <?php render_widgets('right_bar_locations');?>
            </div>
        </div>

    </div>
</div>
