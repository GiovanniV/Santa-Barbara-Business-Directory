<?php $settings = json_decode($settings);?>
<div class="row">
    <div class="col-md-12">
        <div class="box">
            <div class="box-title">
                <h3><i class="fa fa-bars"></i><?php echo lang_key("web_email_settings") ?> </h3>

                <div class="box-tool">
                    <a href="#" data-action="collapse"><i class="fa fa-chevron-up"></i></a>
                   </div>
            </div>
            <div class="box-content">
                <?php echo $this->session->flashdata('msg'); ?>
                <form class="form-horizontal" action="<?php echo site_url('admin/system/savesettings/webadmin_email');?>" method="post">


                    <div class="form-group">
                        <label class="col-sm-3 col-lg-2 control-label"><?php echo lang_key('contact_email'); ?></label>

                        <div class="col-sm-9 col-lg-10 controls">
                            <input type="text" name="contact_email" value="<?php echo(isset($settings->contact_email))?$settings->contact_email:'';?>" placeholder="<?php echo lang_key('type_something');?>g" class="form-control" >

                            <span class="help-inline">&nbsp;</span>
                            <?php echo form_error('contact_email'); ?>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-3 col-lg-2 control-label"><?php echo lang_key('webadmin_name'); ?></label>

                        <div class="col-sm-9 col-lg-10 controls">
                            <input type="text" name="webadmin_name" value="<?php echo(isset($settings->webadmin_name))?$settings->webadmin_name:'';?>" placeholder="<?php echo lang_key('type_something');?>g" class="form-control" >

                            <span class="help-inline">&nbsp;</span>
                            <?php echo form_error('webadmin_name'); ?>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-3 col-lg-2 control-label"><?php echo lang_key('webadmin_email'); ?></label>

                        <div class="col-sm-9 col-lg-10 controls">
                            <input type="text" name="webadmin_email" value="<?php echo(isset($settings->webadmin_email))?$settings->webadmin_email:'';?>" placeholder="<?php echo lang_key('type_something');?>g" class="form-control" >

                            <span class="help-inline">&nbsp;</span>
                            <?php echo form_error('webadmin_email'); ?>
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
