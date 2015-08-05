<?php
$CI = get_instance();
$start =0;
$type='news';
$PER_PAGE = get_settings('business_settings', 'posts_per_page', 6);
$posts = $CI->show_model->get_all_active_blog_posts_by_range($start,$PER_PAGE,'id','desc',$type);
?>
<div class="blog-one">
    <div class="row">

        <div class="col-md-9 col-sm-12 col-xs-12">

            <?php
            if($posts->num_rows()<=0){
                ?>
                <div class="alert alert-warning"><?php echo lang_key('post_not_found'); ?></div>
            <?php
            }
            else
                foreach($posts->result() as $post){
                    $title = get_blog_data_by_lang($post,'title');
                    $desc = get_blog_data_by_lang($post,'desc');
                    ?>

                    <!-- Blog item starts -->
                    <div class="blog-one-item row">
                        <!-- blog One Img -->
                        <div class="blog-one-img col-md-3 col-sm-3 col-xs-12">
                            <!-- Image -->
                            <a href="<?php echo site_url('post-detail/'.$post->id.'/'.dbc_url_title($title));?>"><img src="<?php echo get_featured_photo_by_id($post->featured_img);?>" alt="" class="img-responsive img-thumbnail" /></a>
                        </div>
                        <!-- blog One Content -->
                        <div class="blog-one-content  col-md-9 col-sm-9 col-xs-12">
                            <!-- Heading -->
                            <h3><a href="<?php echo site_url('post-detail/'.$post->id.'/'.dbc_url_title($title));?>"><?php echo $title;?></a></h3>
                            <!-- Blog meta -->
                            <div class="blog-meta">
                                <!-- Date -->
                                <i class="fa fa-calendar"></i> &nbsp; <?php echo date('D, M d, Y', $post->create_time); ?> &nbsp;
                                <!-- Author -->
                                <i class="fa fa-user"></i> &nbsp; <?php echo get_user_fullname_by_id($post->created_by); ?></a>

                            </div>
                            <!-- Paragraph -->
                            <p><?php echo truncate(strip_tags($desc),400,'&nbsp;<a href="'.site_url('post-detail/'.$post->id.'/'.dbc_url_title($title)).'">'.lang_key('view_more').'</a>',false);?></p>
                        </div>
                    </div>
                    <!-- Blog item ends -->
                <?php } ?>
            <ul class="pagination">
                <?php echo (isset($pages))?$pages:'';?>
            </ul>


        </div>




    </div>
</div>