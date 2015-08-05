
<!-- Page heading two starts -->
    <div class="page-heading-two">
      <div class="container">
        <h2><?php echo lang_key('all_users');?></h2>
        <div class="breads">
            <a href="<?php echo site_url(); ?>"><?php echo lang_key('home'); ?></a> / <?php echo lang_key('all_users');?>
        </div>
        <div class="clearfix"></div>
      </div>
    </div>   
    
<!-- Container -->
<div class="container real-estate">

    <div class="row">

        <div class="col-md-9 col-sm-12 col-xs-12">
            <div class="widget-content search" style="max-width: 400px">
                <form method="post" action="">
                    <div class="input-group">
                        <input type="text" placeholder="<?php echo lang_key('name'); ?>" class="form-control" name="agent_key" value="<?php echo $this->input->post('agent_key');?>">
                <span class="input-group-btn">
                    <button class="btn btn-color" type="submit"><?php echo lang_key('search'); ?></button>
                </span>
                    </div>
                </form>
            </div>
            <div class="rs-property">
                <!-- Block heading two -->
                <div class="block-heading-two">
                    <h3><span><i class="fa fa-user"></i> <?php echo lang_key('all_users');?></span></h3>
                </div>
                <div class="team-two">
                    <?php foreach($query->result() as $user){
                    if(get_settings('classified_settings','show_admin_agent','Yes')=='No' && $user->user_type==1)
                        continue;
                    ?>
                        <div class="row">
                            
                                    <div class="col-md-3 col-sm-3 col-xs-12">
                                    <!-- Image -->
                                    <a href="<?php echo site_url('profile/'.$user->id.'/'.get_user_fullname_by_id($user->id));?>">
                                        <img class="img-responsive" src="<?php echo get_profile_photo_by_id($user->id,'thumb');?>" alt="user-photo" />

                                    </a>
                                    </div>

                                    <div class="col-md-9 col-sm-9 col-xs-12">
                                        <!-- Name -->
                                        <h4> <a href="<?php echo site_url('profile/'.$user->id.'/'.get_user_fullname_by_id($user->id));?>"><?php echo $user->first_name.' '.$user->last_name; ?></a></h4>
                                        <?php if(get_user_meta($user->id, 'company_name')!=''){?>
                                            <p class="contact-types">
                                                <strong><?php echo lang_key('company_name'); ?>:</strong> <?php echo get_user_meta($user->id, 'company_name'); ?></a>
                                            </p>
                                        <?php }?>
                                        <a href="<?php echo site_url('profile/'.$user->id.'/'.get_user_fullname_by_id($user->id));?>"><span class="label label-red"><?php echo get_user_properties_count($user->id);?> <?php echo lang_key('posts');?></span></a>
                                        <?php if(get_user_meta($user->id, 'about_me')!=''){?>
                                            <!-- Para -->
                                            <p><?php echo get_user_meta($user->id, 'about_me'); ?></p>
                                        <?php }?>
                                        <p class="contact-types">
                                            <?php if(get_user_meta($user->id, 'hide_phone',0)==0) {?>
                                            <strong><?php echo lang_key('phone'); ?>:</strong> <?php echo get_user_meta($user->id, 'phone'); ?> <br \>
                                            <?php }?>
                                            <?php if(get_user_meta($user->id, 'hide_email',0)==0) {?>
                                            <strong><?php echo lang_key('email');?>:</strong> <a href="mailto:<?php echo $user->user_email; ?>"><?php echo $user->user_email; ?></a>
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
                                    
                                

                        </div>
                        <hr/>
                    <?php } ?>




                </div>
                <!-- Team #7 end -->
            </div>
            <div class="align-center">
                <ul class="pagination">
                    <?php echo (isset($pages))?$pages:'';?>
                </ul>
            </div>


            <div class="clearfix"></div>
        </div>


        <div class="col-md-3 col-sm-12 col-xs-12">
            <div class="sidebar">
                <?php render_widgets('right_bar_all_users');?>
            </div>
        </div>

    </div>


</div>