<?php
$CI = get_instance();
$CI->load->database();
$limit = 5;
$CI->db->order_by('total_view','desc');
$query = $CI->db->get_where('posts',array('status'=>1),$limit,0);
?>
<div class="s-widget">
    <!-- Heading -->
    <h5><i class="fa fa-building color"></i>&nbsp; <?php echo lang_key('similar_posts');?></h5>
    <!-- Widgets Content -->
    <div class="widget-content hot-properties">
        <?php if($query->num_rows()<=0){?>
            <div class="alert alert-info"><?php echo lang_key('no_posts');?></div>
        <?php }else{?>
            <ul class="list-unstyled">
                <?php
                foreach ($query->result() as $post) {
                    ?>
                    <li class="col-xs-12 col-sm-6 col-md-12 col-lg-12">
                        <!-- Image -->
                        <img class="img-responsive img-thumbnail" src="<?php echo get_featured_photo_by_id($post->featured_img);?>" alt="<?php echo get_post_data_by_lang($post,'title');?>" />
                        <!-- Heading -->
                        <h4><a href="<?php echo post_detail_url($post);?>"><?php echo get_post_data_by_lang($post,'title');?></a></h4>
                        <!-- Price -->
                        <div class="price"><strong><?php echo lang_key('city');?></strong>: <?php echo get_location_name_by_id($post->city);?>
                            <?php $average_rating = $post->rating; ?>
                            <?php $half_star_position = check_half_star_position($average_rating); ?>
                            <?php echo get_review_with_half_stars($average_rating,$half_star_position,'stars-sidebar');?>
                        </div>
                        <div class="clearfix"></div>
                    </li>
                <?php
                }
                ?>
            </ul>
        <?php }?>
    </div>
</div>
<div style="clear:both"></div>