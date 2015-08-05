<?php 
$per_page = get_settings('business_settings', 'posts_per_page', 6);
$user = $user->row();
?>
<!-- Page heading two starts -->
    <div class="page-heading-two">
        <div class="container">
            <h2><?php echo get_user_fullname_by_id($user->id); ?> </h2>
            <div class="breads">
                <a href="<?php echo site_url(); ?>"><?php echo lang_key('home'); ?></a> / <a href="<?php echo site_url('users'); ?>"><?php echo lang_key('all_users'); ?></a> / <?php echo get_user_fullname_by_id($user->id); ?>
            </div>
            <div class="clearfix"></div>
        </div>
    </div>   
    
<!-- Container -->
<div class="container">

    <div class="row">

        <div class="col-md-9 col-sm-12 col-xs-12">
            <div class="agent-holder clearfix">
                <!-- Team #2 -->
                <div class="team-two">
                    <div class="row">
                        <div class="col-md-12">
                            <!-- Team #2 member -->
                            <div class="team-member well" style="max-width: 100%">
                                <!-- Image -->
                                <a href="<?php echo site_url('profile/'.$user->id.'/'.get_user_fullname_by_id($user->id));?>">
                                <img class="img-responsive" src="<?php echo get_profile_photo_by_id($user->id,'thumb');?>" alt="" />

                                </a>
                                <div class="team-details">
                                    <!-- Name -->
                                    <h4><?php echo $user->first_name.' '.$user->last_name; ?></h4>
                                    <?php if(get_user_meta($user->id, 'company_name')!=''){?>
                                        <p class="contact-types">
                                            <strong><?php echo lang_key('company_name'); ?>:</strong> <?php echo get_user_meta($user->id, 'company_name'); ?></a>
                                        </p>
                                    <?php }?>
                                    <?php if(get_user_meta($user->id, 'about_me')!=''){?>
                                    <!-- Para -->
                                    <p><?php echo get_user_meta($user->id, 'about_me'); ?></p>
                                    <?php }?>
                                    <p class="contact-types">
                                        <?php if(get_user_meta($user->id, 'hide_phone',0)==0) {?>
                                        <strong><?php echo lang_key('phone'); ?>:</strong> <?php echo get_user_meta($user->id, 'phone'); ?> <br />
                                        <?php }?>
                                        <?php if(get_user_meta($user->id, 'hide_email',0)==0) {?>
                                        <strong>Email:</strong> <a href="mailto:<?php echo $user->user_email; ?>"><?php echo $user->user_email; ?></a>
                                        <?php }?>
                                    </p>
                                    <!-- Social -->
                                    <?php $fb_profile = get_user_meta($user->id, 'fb_profile'); ?>
                                    <?php $gp_profile = get_user_meta($user->id, 'gp_profile'); ?>
                                    <?php $twitter_profile = get_user_meta($user->id, 'twitter_profile'); ?>
                                    <?php $li_profile = get_user_meta($user->id, 'li_profile'); ?>
                                    <div class="brand-bg">
                                        <?php if($fb_profile != ''){?>
                                        <a class="facebook" href="https://<?php echo $fb_profile; ?>"><i class="fa fa-facebook circle-3"></i></a>
                                        <?php }?>
                                        <?php if($gp_profile != ''){?>
                                        <a class="google-plus" href="https://<?php echo $gp_profile; ?>"><i class="fa fa-google-plus circle-3"></i></a>
                                        <?php }?>
                                        <?php if($twitter_profile != ''){?>
                                        <a class="twitter" href="https://<?php echo $twitter_profile; ?>"><i class="fa fa-twitter circle-3"></i></a>
                                        <?php }?>
                                        <?php if($li_profile != ''){?>
                                        <a class="linkedin" href="https://<?php echo $li_profile; ?>"><i class="fa fa-linkedin circle-3"></i></a>
                                        <?php }?>
                                    </div>
                                </div>
                                <div class="clearfix"></div>
                            </div>
                        </div>

                    </div>
                </div>
                <!-- Team #2 end -->
            </div>

            <div class="block-heading-two">
                <h3><span><i class="fa fa-user"></i> <?php echo lang_key('posts_by');?> : <?php echo get_user_fullname_by_id($user->id);?> (<?php echo get_user_properties_count($user->id);?>)</span>
                    <div class="pull-right list-switcher">
                        <a target="recent-posts" href="<?php echo site_url('show/memberposts_ajax/'.$per_page.'/grid/'.$user->id);?>"><i class="fa fa-th "></i></a>
                        <a target="recent-posts" href="<?php echo site_url('show/memberposts_ajax/'.$per_page.'/list/'.$user->id);?>"><i class="fa fa-th-list "></i></a>
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
                <?php render_widgets('right_bar_all_users');?>
            </div>
        </div>

    </div>
</div>
