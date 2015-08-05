<!-- Page heading two starts -->
    <div class="page-heading-two">
      <div class="container">
        <h2><?php echo lang_key('contact_us');?> </h2>
        <div class="breads">
            <a href="<?php echo site_url(); ?>"><?php echo lang_key('home'); ?></a> / <?php echo lang_key('contact_us'); ?>
        </div>
        <div class="clearfix"></div>
      </div>
    </div>   
    
<!-- Container -->
<div class="container">

    <div class="contact-us-three">
        <div class="row">

            <div class="col-md-9 col-sm-12 col-xs-12">

                <!-- Contact Form -->
                <div class="contact-form">
                    <h5><?php echo lang_key('contact_us');?></h5>
                    <?php echo $this->session->flashdata('msg');?>

                    <!-- Form -->
                    <form action="<?php echo site_url('sendcontactemail');?>" method="post">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <input class="form-control" type="text" name="sender_name" value="<?php echo set_value('sender_name');?>" placeholder="<?php echo lang_key('name'); ?>">
                                    <?php echo form_error('sender_name');?>

                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <input class="form-control" type="text" name="sender_email" value="<?php echo set_value('sender_email');?>" placeholder="<?php echo lang_key('email'); ?>">
                                    <?php echo form_error('sender_email');?>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <input type="text" class="form-control" name="phone" value="<?php echo set_value('phone');?>" placeholder="<?php echo lang_key('phone'); ?>">
                                    <?php echo form_error('phone');?>

                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <textarea placeholder="<?php echo lang_key('type_your_message'); ?>" class="form-control" rows="8" name="msg"><?php echo set_value('msg');?></textarea>
                        </div>
                        <div class="row">
                            <div class="col-sm-12 contact-captcha">
                                <span><?php echo (isset($question))?$question:'';?></span>
                                <input type="text" name="ans" value="" class="form-control">
                                <div class="clearfix"></div><?php echo form_error('ans');?>
                            </div>
                        </div>
                        <div class="clear-top-margin"></div>
                        <!-- Button -->
                        <input class="btn btn-red" type="submit" value="<?php echo lang_key('send') ?>">

                        <button type="button" class="btn btn-default"><?php echo lang_key('reset') ?></button>
                    </form>
                </div>

                <br />

            </div>


            <div class="col-md-3 col-sm-12 col-xs-12">
                <div class="sidebar">
                    <?php echo render_widget('contact_text');?>
                </div>
            </div>

        </div>
    </div>

</div>