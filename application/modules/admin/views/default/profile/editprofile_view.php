<div class="row">

    <div class="col-md-12">

        <div class="box">

            <div class="box-title">

                <h3><i class="fa fa-bars"></i><?php echo lang_key("edit_profile") ?> </h3>



                <div class="box-tool">

                    <a href="#" data-action="collapse"><i class="fa fa-chevron-up"></i></a>

                    <a href="#" data-action="close"><i class="fa fa-times"></i></a></div>

            </div>

            <div class="box-content">

                <?php echo $this->session->flashdata('msg'); ?>

                <?php //echo validation_errors(); ?>

                <form class="form-horizontal" action="<?php echo site_url('admin/updateprofile'); ?>" method="post">

                    <?php if(isset($action) && $action=='edituser'){?>
                    <input type="hidden" name="action" value="edituser" />
                    <input type="hidden" name="id" value="<?php echo $profile->id; ?>"/>
                    <?php }else{?>
                    <input type="hidden" name="action" value="editprofile" />
                    <?php if(is_admin()){?>
                    <input type="hidden" name="id" value="<?php echo $this->session->userdata('user_id'); ?>"/>
                    <?php }else{?>
                    <input type="hidden" name="id" value="<?php echo $profile->id; ?>"/>
                    <?php }?>

                    <?php }?>

                    <div class="form-group">

                        <label class="col-sm-3 col-lg-2 control-label">&nbsp;</label>



                        <div class="col-sm-9 col-lg-10 controls">

                            <img class="thumbnail" id="user_photo" src="<?php echo get_profile_photo_by_id($profile->id,'thumb');?>"  style="width:100px;" />

                            <span id="profile_photo_error"><?php echo form_error('profile_photo'); ?></span>

                        </div>

                    </div>



                    <div class="form-group">

                        <label class="col-sm-3 col-lg-2 control-label"><?php echo lang_key('profile_picture'); ?></label>



                        <div class="col-sm-9 col-lg-10 controls">

                            <input type="hidden" name="profile_photo" id="profile_photo" value="<?php echo get_profile_photo_name_by_username($profile->user_name);?>">

                            <iframe src="<?php echo site_url('admin/users/profile_photo_uploader');?>" style="border:0;margin:0;padding:0;height:130px;"></iframe>

                            <span class="help-inline">&nbsp;</span>                            

                        </div>

                    </div>



                    <div class="form-group">

                        <label class="col-sm-3 col-lg-2 control-label"><?php echo lang_key('username'); ?></label>



                        <div class="col-sm-9 col-lg-10 controls">

                            <input type="text" name="user_name" value="<?php echo $profile->user_name; ?>"

                                   placeholder="User Name" class="form-control">

                            <span class="help-inline">&nbsp;</span>

                            <?php echo form_error('user_name'); ?>

                        </div>

                    </div>

                    <div class="form-group">

                        <label class="col-sm-3 col-lg-2 control-label"><?php echo lang_key('email'); ?></label>



                        <div class="col-sm-9 col-lg-10 controls">

                            <input type="text" name="user_email" value="<?php echo $profile->user_email; ?>"

                                   placeholder="User Email" class="form-control">

                            <span class="help-inline">&nbsp;</span>

                            <?php echo form_error('user_email'); ?>

                        </div>

                        <label class="col-sm-3 col-lg-2 control-label"><?php echo lang_key('hide_email');?>:</label>
                        <div class="col-sm-4 col-lg-5 controls">
                        <?php $v = get_user_meta($profile->id, 'hide_email',0);?>
                          <label class="checkbox">
                            <input type="checkbox" name="hide_email" id="hide_email" value="1" <?php echo $v==1?'checked="checked"':'';?>>
                          </label>
                        </div>

                    </div>


                    <?php if(is_admin() && $this->session->userdata('user_id')!=$profile->id){ // if i am admin the user is someone else?>
                        <div class="form-group">

                            <label class="col-sm-3 col-lg-2 control-label"><?php echo lang_key('password'); ?></label>

                            <div class="col-sm-9 col-lg-6 controls">

                                <input type="password" name="password" value="<?php echo ''; ?>"

                                       placeholder="<?php echo lang_key('admin_change_pass_help'); ?>" class="form-control">
                                <?php echo form_error('password'); ?>
                                <span class="help-inline">&nbsp;</span>

                            </div>

                        </div>

                        <div class="form-group">

                            <label class="col-sm-3 col-lg-2 control-label"><?php echo lang_key('re_password'); ?></label>

                            <div class="col-sm-9 col-lg-6 controls">

                                <input type="password" name="confirm_password" value="<?php echo ''; ?>"

                                       placeholder="<?php echo lang_key('confirm_password'); ?>" class="form-control">
                                <?php echo form_error('confirm_password'); ?>
                                <span class="help-inline"><?php echo lang_key('admin_change_pass_help');?></span>

                            </div>

                        </div>
                    <?php }?>



                    <div class="form-group">

                        <label class="col-sm-3 col-lg-2 control-label"><?php echo lang_key('first_name'); ?></label>



                        <div class="col-sm-9 col-lg-10 controls">

                            <input type="text" name="first_name" value="<?php echo $profile->first_name; ?>"

                                   placeholder="User Name" class="form-control">

                            <span class="help-inline">&nbsp;</span>

                            <?php echo form_error('first_name'); ?>

                        </div>

                    </div>



                    <div class="form-group">

                        <label class="col-sm-3 col-lg-2 control-label"><?php echo lang_key('last_name'); ?></label>



                        <div class="col-sm-9 col-lg-10 controls">

                            <input type="text" name="last_name" value="<?php echo $profile->last_name; ?>"

                                   placeholder="User Name" class="form-control">

                            <span class="help-inline">&nbsp;</span>

                            <?php echo form_error('last_name'); ?>

                        </div>

                    </div>



                    <div class="form-group">

                        <label class="col-sm-3 col-lg-2 control-label"><?php echo lang_key('gender');?></label>



                        <div class="col-sm-9 col-lg-10 controls">

                            <?php $curr_value=(set_value('gender')!='')?set_value('gender'):$profile->gender;?>

                            <select class="form-control" name="gender">

                                <?php $sel=($curr_value=='male')?'selected="selected"':'';?>

                                <option value="male" <?php echo $sel;?>>Male</option>

                                <?php $sel=($curr_value=='female')?'selected="selected"':'';?>

                                <option value="female" <?php echo $sel;?>>Female</option>

                            </select>

                            <span class="help-inline">&nbsp;</span>

                            <?php echo form_error('gender'); ?>

                        </div>

                    </div>



                    <div class="form-group">

                        <label class="col-sm-3 col-lg-2 control-label"><?php echo lang_key('phone'); ?></label>

                        <?php $v = (set_value('phone')) ? set_value('phone') : get_user_meta($profile->id, 'phone'); ?>

                        <div class="col-sm-9 col-lg-10 controls">

                            <input type="text" name="phone" value="<?php echo $v; ?>"

                                   placeholder="Phone" class="form-control">

                            <span class="help-inline">&nbsp;</span>

                            <?php echo form_error('phone'); ?>

                        </div>

                        <label class="col-sm-3 col-lg-2 control-label"><?php echo lang_key('hide_phone');?>:</label>
                        <div class="col-sm-4 col-lg-5 controls">
                        <?php $v = get_user_meta($profile->id, 'hide_phone',0);?>
                          <label class="checkbox">
                            <input type="checkbox" name="hide_phone" id="hide_phone" value="1" <?php echo $v==1?'checked="checked"':'';?>>
                          </label>
                        </div>

                    </div>


                    <div class="form-group company-holder">

                        <label class="col-sm-3 col-lg-2 control-label"><?php echo lang_key('company_name'); ?></label>

                        <?php $v = (set_value('company_name')) ? set_value('company_name') : get_user_meta($profile->id, 'company_name'); ?>

                        <div class="col-sm-9 col-lg-10 controls">

                            <input type="text" name="company_name" value="<?php echo $v; ?>"

                                   placeholder="Company Name" class="form-control">

                            <span class="help-inline">&nbsp;</span>

                            <?php echo form_error('company_name'); ?>

                        </div>

                    </div>



                    <div class="form-group">

                        <label class="col-sm-3 col-lg-2 control-label"><?php echo lang_key('about_me'); ?></label>

                        <?php $v = (set_value('about_me')) ? set_value('about_me') : get_user_meta($profile->id, 'about_me'); ?>

                        <div class="col-sm-9 col-lg-10 controls">

                            <textarea name="about_me"

                                   placeholder="About" class="form-control"><?php echo $v; ?></textarea>

                            <span class="help-inline">&nbsp;</span>

                            <?php echo form_error('about_me'); ?>

                        </div>

                    </div>



                    <div class="form-group">

                        <label class="col-sm-3 col-lg-2 control-label"><?php echo lang_key('facebook_account'); ?></label>

                        <?php $v = (set_value('fb_profile')) ? set_value('fb_profile') : get_user_meta($profile->id, 'fb_profile'); ?>

                        <div class="col-sm-9 col-lg-10 controls">

                            <input type="text" name="fb_profile" value="<?php echo $v; ?>"

                                   placeholder="Facebook Profile Link" class="form-control">

                            <span class="help-inline"><?php echo lang_key('account_msg'); ?></span>

                            <?php echo form_error('fb_profile'); ?>

                        </div>

                    </div>



                    <div class="form-group">

                        <label class="col-sm-3 col-lg-2 control-label"><?php echo lang_key('twitter_account'); ?></label>

                        <?php $v = (set_value('twitter_profile')) ? set_value('twitter_profile') : get_user_meta($profile->id, 'twitter_profile'); ?>

                        <div class="col-sm-9 col-lg-10 controls">

                            <input type="text" name="twitter_profile" value="<?php echo $v; ?>"

                                   placeholder="Twitter Profile Link" class="form-control">

                            <span class="help-inline"><?php echo lang_key('account_msg'); ?></span>

                            <?php echo form_error('twitter_profile'); ?>

                        </div>

                    </div>



                    <div class="form-group">

                        <label class="col-sm-3 col-lg-2 control-label"><?php echo lang_key('linkedin_account'); ?></label>

                        <?php $v = (set_value('li_profile')) ? set_value('li_profile') : get_user_meta($profile->id, 'li_profile'); ?>

                        <div class="col-sm-9 col-lg-10 controls">

                            <input type="text" name="li_profile" value="<?php echo $v; ?>"

                                   placeholder="LinkedIn Account Link" class="form-control">

                            <span class="help-inline"><?php echo lang_key('account_msg'); ?></span>

                            <?php echo form_error('li_profile'); ?>

                        </div>

                    </div>



                    <div class="form-group">

                        <label class="col-sm-3 col-lg-2 control-label"><?php echo lang_key('gp_account'); ?></label>

                        <?php $v = (set_value('gp_profile')) ? set_value('gp_profile') : get_user_meta($profile->id, 'gp_profile'); ?>

                        <div class="col-sm-9 col-lg-10 controls">

                            <input type="text" name="gp_profile" value="<?php echo $v; ?>"

                                   placeholder="Google+ Profile Link" class="form-control">

                            <span class="help-inline"><?php echo lang_key('account_msg'); ?></span>

                            <?php echo form_error('gp_profile'); ?>

                        </div>

                    </div>



                    <div class="form-group">

                        <label class="col-sm-3 col-lg-2 control-label"></label>



                        <div class="col-sm-9 col-lg-10 controls">

                            <button class="btn btn-primary" type="submit"><i

                                    class="fa fa-check"></i><?php echo lang_key("update") ?></button>

                        </div>

                    </div>



                </form>

            </div>

        </div>

    </div>

</div>

<script type="text/javascript">

jQuery(document).ready(function(){

    var base_url = "<?php echo base_url();?>";

    jQuery('#profile_photo').change(function(){

        var val = jQuery(this).val();

        var src = base_url+'uploads/profile_photos/thumb/'+val;        

        jQuery('#user_photo').attr('src',src);

    }).change();



});

</script>