    <!-- JavaScript libs are placed at the end of the document so the pages load faster -->

<!--    <script src="http://netdna.bootstrapcdn.com/bootstrap/3.0.0/js/bootstrap.min.js"></script>-->


    <span class="totop"><a href="#"><i class="fa fa-angle-up bg-color"></i></a></span>

    <!-- Javascript files -->

    <!-- Bootstrap JS -->
    <script src="<?php echo theme_url();?>/assets/js/bootstrap.min.js"></script>
    <!-- Placeholders JS -->
    <script src="<?php echo theme_url();?>/assets/js/placeholders.js"></script>
    <!-- Magnific Popup -->
    <script src="<?php echo theme_url();?>/assets/js/jquery.magnific-popup.min.js"></script>
    <!-- Owl carousel -->
    <script src="<?php echo theme_url();?>/assets/js/owl.carousel.min.js"></script>

    <!-- Main JS -->
    <script src="<?php echo theme_url();?>/assets/js/main.js"></script>


    <script src="<?php echo theme_url();?>/assets/js/respond.min.js"></script>
    <!-- HTML5 Support for IE -->
    <script src="<?php echo theme_url();?>/assets/js/html5shiv.js"></script>

    <!-- Custom JS. Type your JS code in custom.js file -->
    <script src="<?php echo theme_url();?>/assets/js/custom.js"></script>

<!--    <script src="--><?php //echo theme_url();?><!--/assets/js/ion.rangeSlider.min.js"></script>-->

<!--    <script src="--><?php //echo theme_url();?><!--/assets/js/jquery.slider.min.js"></script>-->

    <script src="<?php echo theme_url();?>/assets/js/jquery.mCustomScrollbar.concat.min.js"></script>

    <script src="<?php echo theme_url();?>/assets/js/waypoints.min.js"></script>
    <script src="<?php echo theme_url();?>/assets/js/jquery.countTo.js"></script>


    <div id="signin-modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">

        <div class="modal-dialog">

            <div class="modal-content">

                <div class="modal-header">

                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>

                    <h4 class="modal-title" id="myModalLabel"><?php echo lang_key('login_to_your_account'); ?> </h4>

                </div>

                <div class="modal-body">

                    <!-- Login starts -->
                    <div class="well login-reg-form">

                        <!-- Form -->
                        <form action="<?php echo site_url('account/login');?>" class="form-horizontal" role="form" method="post">
                            <!-- Form Group -->
                            <div class="form-group">
                                <!-- Label -->
                                <label for="user" class="col-sm-3 control-label"><?php echo lang_key('email'); ?></label>
                                <div class="col-sm-9">
                                    <!-- Input -->
                                    <input type="text" class="form-control" name="useremail" placeholder="<?php echo lang_key('email'); ?>">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="password" class="col-sm-3 control-label"><?php echo lang_key('password'); ?></label>
                                <div class="col-sm-9">
                                    <input type="password" class="form-control"  name="password" placeholder="<?php echo lang_key('password'); ?>">
                                </div>
                            </div>
                            <?php if(constant("ENVIRONMENT")=='demo'){?>
                                <div class="form-group">
                                    <div class="col-sm-offset-3 col-sm-9">
                                        <div class="checkbox">
                                            <label>
                                                demo user : user@dbcinfotech.com pass: 12345
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            <?php }?>
                            <div class="form-group">
                                <div class="col-sm-offset-3 col-sm-9">
                                    <div class="checkbox">
                                        <label>
                                            <input type="checkbox"> <?php echo lang_key('remember_me'); ?>
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-sm-offset-3 col-sm-9">
                                    <!-- Button -->
                                    <button type="submit" class="btn btn-red"><?php echo lang_key('login'); ?></button>&nbsp;
                                    <button type="submit" class="btn btn-white"><?php echo lang_key('reset'); ?></button>
                                </div>
                            </div>
                            <div class="col-sm-offset-3 col-sm-9">
                                <a href="<?php echo site_url('account/recoverpassword');?>" class="black"><?php echo lang_key('forgot_password'); ?> ?</a> | <a href="<?php echo site_url('account/signup');?>" class="black"><?php echo lang_key('sign_up'); ?></a>
                            </div>
                        </form>
                        <br />
                        <?php
                        $fb_enabled = get_settings('business_settings','enable_fb_login','No');
                        $gplus_enabled = get_settings('business_settings','enable_gplus_login','No');
                        if($fb_enabled=='Yes' || $gplus_enabled=='Yes'){
                        ?>
                        <!-- Social Media Login -->
                        <div class="s-media text-center">
                            <!-- Button -->
                            <?php if($gplus_enabled=='Yes'){?>
                            <a href="<?php echo site_url('account/newaccount/google_plus');?>" class="btn btn-red"><i class="fa fa-google-plus"></i> &nbsp; <?php echo lang_key('login_with_google')?></a>
                            <?php }?>
                            <?php if($fb_enabled=='Yes'){?>
                            <a href="<?php echo site_url('account/newaccount/fb');?>" class="btn btn-blue"><i class="fa fa-facebook"></i> &nbsp; <?php echo lang_key('login_with_facebook')?></a>
                            <?php }?>
                        </div>
                        <?php } ?>
                    </div>
                    <!-- Login ends -->

                </div>

                <div class="modal-footer">

                </div>

            </div>

            <!-- /.modal-content -->

        </div>

        <!-- /.modal-dialog -->

    </div>


    <div id="ie-msg-modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">

        <div class="modal-dialog">

            <div class="modal-content">

                <div class="modal-header">

                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>

                    <h4 class="modal-title" id="myModalLabel"><?php echo lang_key('upgrade_browser'); ?> </h4>

                </div>

                <div class="modal-body">

                    <div class="alert alert-danger"><?php echo lang_key('please_upgrade_your_browser');?></div>
                </div>

                <div class="modal-footer">

                </div>

            </div>

            <!-- /.modal-content -->

        </div>

        <!-- /.modal-dialog -->

    </div>
<?php
$ga_tracking_code = get_settings('site_settings','ga_tracking_code','');

if($ga_tracking_code != ''){
    echo $ga_tracking_code;
}

?>
<script type="text/javascript">
jQuery(document).ready(function(){

    if(old_ie==1)
    {
        jQuery('#ie-msg-modal').modal('show');
    }

    jQuery('.signin').click(function(e){
        e.preventDefault();
        jQuery('#signin-modal').modal('show');
    });

    // jQuery(window).resize(function(){
    //    console.log(jQuery(window).width()); 
    // });
});
</script>
<script type="text/javascript">


    $(document).ready(function() {

        jQuery('.list-switcher').each(function(){
            jQuery(this).children(":first").trigger('click');           
        });

        jQuery('.featured-list-switcher').each(function(){
            jQuery(this).children(":first").trigger('click');
        });
      
        fix_grid_height();


    });

    function fix_grid_height()
    {
        var maxHeight = -1;
        $('.item-title').each(function() {
            maxHeight = maxHeight > $(this).height() ? maxHeight : $(this).height();
        });

        $('.item-title').each(function() {
            $(this).height(maxHeight);
        });
        jQuery('.find-my-location').tooltip();
        jQuery('.hot-tag').tooltip();
        jQuery('.hot-tag-list').tooltip();
    }

</script>