<?php $this->load->helper('date');?>
<?php echo $this->session->flashdata('msg');?>
<div class="row">
    <div class="col-md-12">
        <div class="box">
            <div class="box-title">
                <h3><i class="fa fa-file"></i> <?php echo lang_key('profile_info'); ?></h3>
                <div class="box-tool">
                    <a data-action="collapse" href="extra_profile.html#"><i class="fa fa-chevron-up"></i></a>

                </div>
            </div>
            <div class="box-content">
                <div class="row">
                    <div class="col-md-3">
                        <img class="img-responsive img-thumbnail" src="<?php echo get_profile_photo_by_id($profile->id);?>">
                    </div>
                    <div class="col-md-9 user-profile-info">
                        <p>
                            <span><?php echo lang_key('username'); ?>:</span> <?php echo $profile->user_name ?>
                        </p>
                        <p>
                            <span><?php echo lang_key('first_name'); ?>:</span> <?php echo $profile->first_name ?>
                        </p>
                        <p>
                            <span><?php echo lang_key('last_name'); ?>:</span> <?php echo $profile->last_name ?>
                        </p>

                        <p>
                            <span><?php echo lang_key('gender'); ?>:</span> <?php echo $profile->gender ?>
                        </p>

                        <p>
                            <span><?php echo lang_key('email'); ?>:</span><a href="mailto:<?php echo $profile->user_email ?>"><?php echo $profile->user_email ?></a>
                        </p>
                        <?php if($profile->user_type!=1){?>
                        <p>
                            <a href="<?php echo site_url('admin/banuser/'.$profile->id.'/forever');?>" class="btn btn-warning"><?php echo lang_key('ban_forever'); ?>r</a>
                            <a href="<?php echo site_url('admin/deleteuser/' . $profile->id); ?>" class="btn btn-danger"><?php echo lang_key('delete');?></a>
                        </p>
                        <?php }?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>




