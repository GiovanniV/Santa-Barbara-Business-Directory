<script type="text/javascript">
    var switchTo5x=true;
    var url = "http://w.sharethis.com/button/buttons.js";
    $.getScript( url, function() {
        stLight.options({publisher: "14ee463c-2587-4a82-9bf6-73dad7fc1c93", doNotHash: false, doNotCopy: true, hashAddressBar: false});
    });
</script>
<?php
if(count($blogpost)<=0){

}else{
?>
<div class="page-heading-two">
    <div class="container">
        <h2><?php echo get_blog_data_by_lang($blogpost,'title'); ?> </h2>
        <div class="breads">
            <a href="<?php echo site_url(); ?>"><?php echo lang_key('home'); ?></a> / <?php echo get_blog_data_by_lang($blogpost,'title'); ?>
        </div>
        <div class="clearfix"></div>
    </div>
</div>
<?php
}
?>

<!-- Container -->
<div class="container">

    <div class="blog-two">
        <div class="row">

            <div class="col-md-9 col-sm-12 col-xs-12">
                <?php

                if(count($blogpost)<=0){

                    ?>

                    <div class="alert alert-danger"><?php echo lang_key('post_not_found'); ?></div>

                <?php
                }else{ ?>
                    <!-- Blog item starts -->
                    <div class="blog-two-item">
                        <!-- blog two Content -->
                        <div class="blog-two-content">
                            <!-- Blog meta -->
                            <div class="blog-meta">
                                <!-- Date -->
                                <i class="fa fa-calendar"></i> &nbsp; <?php echo date('D, M d, Y', $blogpost->create_time); ?> &nbsp;
                                <!-- Author -->
                                <i class="fa fa-user"></i> &nbsp; <?php echo get_user_fullname_by_id($blogpost->created_by); ?> &nbsp;

                            </div>

                            <!-- Carousel -->

                            <!-- Bootstrap carousel usage
                                Bootstrap carousel should have id. Below i am using "bs-carousel-X". Where "X" denotes number". If a page has more than 1 carousel, then add the new carousel with the id "bs-carousel-1", "bs-carousel-2". You also need to update the id in, "carousel indicators" section and "carousel control" section.

                                Carousel comes with 3 main data attributes which you can customize. They are...
                                data-interval - Time delay between item cycle. Default value "5000".
                                data-pause - Pause on hover. Default value "pause".
                                data-wrap - Continues cycle or stop at the end. Default value "true".
                            -->

                            <!-- Outer layer -->
                            <div id="bs-carousel-1" class="carousel slide" data-ride="carousel" data-interval="5000" data-pause="hover" data-wrap="true">

                                <!-- Slides. You can also add captions -->
                                <div class="carousel-inner">
                                    <!-- Item, First item should have extra class "active" -->
                                    <div class="item active">
                                        <!-- Image -->
                                        <img src="<?php echo base_url('uploads/images/' . $blogpost->featured_img); ?>" alt="">
                                    </div>

                                </div>

                            </div>


                            <!-- Paragraph -->
                            <p><?php echo get_blog_data_by_lang($blogpost,'description');?></p>
                        </div>
                    </div>
                    <!-- Blog item ends -->
                    <!-- Social media sharing section -->
                    <div class="well">
                        <span class='st_sharethis_large' displayText='ShareThis'></span>
                        <span class='st_facebook_large' displayText='Facebook'></span>
                        <span class='st_twitter_large' displayText='Tweet'></span>
                        <span class='st_linkedin_large' displayText='LinkedIn'></span>
                        <span class='st_pinterest_large' displayText='Pinterest'></span>
                        <span class='st_email_large' displayText='Email'></span>

                    </div>

                    <!-- Author section -->
                    <div class="blog-author well">
                        <!-- Author image -->
                        <div class="blog-author-img">
                            <img src="<?php echo get_profile_photo_by_id($blogpost->created_by); ?>" alt="" class="img-responsive img-thumbnail" />
                        </div>
                        <!-- Author details -->
                        <div class="blog-author-content">
                            <h5><?php echo get_user_fullname_by_id($blogpost->created_by); ?></h5>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                <!-- Comments section -->
                    <div class="blog-comments">
                        <?php $comment_settings = get_settings('business_settings', 'enable_comment', 'No'); ?>
                        <?php if($comment_settings == 'Disqus Comment'){ ?>
                            <?php $disqus_shortname = get_settings('business_settings', 'disqus_shortname', 'dbcinfotech'); ?>
                            <div id="disqus_thread"></div>
                            <script type="text/javascript">
                                /* * * CONFIGURATION VARIABLES: EDIT BEFORE PASTING INTO YOUR WEBPAGE * * */
                                var disqus_shortname = '<?php echo $disqus_shortname; ?>'; // required: replace example with your forum shortname

                                /* * * DON'T EDIT BELOW THIS LINE * * */
                                (function() {
                                    var dsq = document.createElement('script'); dsq.type = 'text/javascript'; dsq.async = true;
                                    dsq.src = '//' + disqus_shortname + '.disqus.com/embed.js';
                                    (document.getElementsByTagName('head')[0] || document.getElementsByTagName('body')[0]).appendChild(dsq);
                                })();
                            </script>
                            <noscript>Please enable JavaScript to view the <a href="http://disqus.com/?ref_noscript">comments powered by Disqus.</a></noscript>
                            <div class="clearfix"></div>
                        <?php } ?>

                        <?php if($comment_settings == 'Facebook Comment'){ ?>
                            <?php $fb_app_id = get_settings('business_settings', 'fb_comment_app_id', '1510845559191569'); ?>
                            <!--facebook comment review start-->
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
                                }(document, 'script', 'facebook-jssdk'));</script>

                            <div class="clear-top-margin"></div>



                            <div class="fb-comments" data-href=" <?php echo current_url();?>" data-numposts="10" data-colorscheme="light"></div>

                            <!--facebook comment review end-->
                        <?php } ?>
                    </div>

                <?php } ?>

            </div>


            <div class="col-md-3 col-sm-12 col-xs-12">
                <div class="sidebar">
                    <?php render_widgets('right_bar_blog_posts');?>
                </div>
            </div>

        </div>
    </div>

</div>
