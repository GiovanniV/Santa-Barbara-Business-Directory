<?php $per_page = get_settings('business_settings', 'posts_per_page', 6); ?>

<div class="block-heading-two">
    <h3><span><i class="fa fa-bookmark"></i> <?php echo lang_key('featured_businesses'); ?></span>
        <div class="pull-right featured-list-switcher">
        	<a target="featured-posts" href="<?php echo site_url('show/featuredposts_ajax/'.$per_page.'/grid');?>"><i class="fa fa-th "></i></a>
        	<a target="featured-posts" href="<?php echo site_url('show/featuredposts_ajax/'.$per_page.'/list');?>"><i class="fa fa-th-list "></i></a>
        </div>
    </h3>
</div>
<span class="featured-posts">
</span>
<div class="ajax-loading featured-loading"><img src="<?php echo theme_url();?>/assets/img/loading.gif" alt="loading..."></div>
<a href="" class="load-more-featured btn btn-blue" style="width:100%"><?php echo lang_key('load_more_featured_posts');?></a>
<div style="clear:both;margin-top:20px"></div>
<script type="text/javascript">
var per_page = '<?php echo $per_page;?>';
var featured_count = '<?php echo $per_page;?>';

jQuery(document).ready(function(){
	jQuery('.featured-list-switcher a').click(function(e){
		jQuery('.featured-list-switcher a').removeClass('selected');
		jQuery(this).addClass('selected');
		e.preventDefault();
		var target = jQuery(this).attr('target');
		var loadUrl = jQuery(this).attr('href');
        jQuery('.featured-loading').show();
        jQuery.post(
            loadUrl,
            {},
            function(responseText){
                jQuery('.'+target).html(responseText);
                jQuery('.featured-loading').hide();
                if(jQuery('.featured-posts > div').children().length<featured_count)
                {
                    jQuery('.load-more-featured').hide();
                }
                fix_grid_height();
            }
        );
	});

    jQuery('.load-more-featured').click(function(e){
        e.preventDefault();
        var next = parseInt(featured_count)+parseInt(per_page);
        jQuery('.featured-list-switcher a').each(function(){
            var url = jQuery(this).attr('href');
            url = url.replace('/'+featured_count+'/','/'+next+'/');
            jQuery(this).attr('href',url);
        });
        featured_count = next;
        jQuery('.featured-list-switcher > .selected').trigger('click');
    });
});
</script>