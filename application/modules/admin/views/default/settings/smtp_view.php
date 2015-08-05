<div class="row">
    <div class="col-md-12">
        <div class="box">
            <div class="box-title">
                <h3><i class="fa fa-bars"></i><?php echo lang_key("smtp_email_settings") ?> </h3>

                <div class="box-tool">
                    <a href="#" data-action="collapse"><i class="fa fa-chevron-up"></i></a>
                   </div>
            </div>
            <div class="box-content">
                <?php echo $this->session->flashdata('msg'); ?>
                <form class="form-horizontal" action="<?php echo site_url('admin/system/savesmtpemailsettings');?>" method="post">

                    <div class="form-group">
                        <label class="col-sm-3 col-lg-2 control-label"><?php echo lang_key('smtp_email'); ?></label>

                        <div class="col-sm-9 col-lg-10 controls">
                            <?php $v = (set_value('smtp_email')!='')?set_value('smtp_email'):get_settings('smtp_settings','smtp_email','Disable');?>
                            <?php $options = array('Disable'=>'Disable[ if disabled php mail() function will be used]','Enable'=>'Enable');?>
                            <select class="form-control" name="smtp_email" id="enable_smtp">
                                <?php foreach ($options as $key => $value) {
                                    $sel = ($v==$key)?'selected="selected"':'';
                                ?>
                                    <option value="<?php echo $key;?>" <?php echo $sel;?>><?php echo $value;?></option>
                                <?php
                                }?>
                            </select>
                            <input type="hidden" name="smtp_email_rules" value="required">
                            <span class="help-inline">&nbsp;</span>
                            <?php echo form_error('smtp_email'); ?>
                        </div>
                    </div>

                    <span id="enable-panel">
                    <div class="form-group">
                        <label class="col-sm-3 col-lg-2 control-label"><?php echo lang_key('smtp_host'); ?></label>

                        <div class="col-sm-9 col-lg-10 controls">
                            <?php $v = (set_value('smtp_host')!='')?set_value('smtp_host'):get_settings('smtp_settings','smtp_host','ssl://smtp.googlemail.com');?>
                            <input type="text" name="smtp_host" value="<?php echo $v;?>" placeholder="<?php echo lang_key('type_something');?>g" class="form-control" >
                            <input type="hidden" name="smtp_host_rules" value="required">
                            <span class="help-inline">&nbsp;</span>
                            <?php echo form_error('smtp_host'); ?>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-3 col-lg-2 control-label"><?php echo lang_key('smtp_port'); ?></label>

                        <div class="col-sm-9 col-lg-10 controls">
                            <?php $v = (set_value('smtp_port')!='')?set_value('smtp_port'):get_settings('smtp_settings','smtp_port','465');?>
                            <input type="text" name="smtp_port" value="<?php echo $v;?>" placeholder="<?php echo lang_key('type_something');?>g" class="form-control" >
                            <input type="hidden" name="smtp_port_rules" value="required">
                            <span class="help-inline">&nbsp;</span>
                            <?php echo form_error('smtp_port'); ?>
                        </div>
                    </div>


                    <div class="form-group">
                        <label class="col-sm-3 col-lg-2 control-label"><?php echo lang_key('smtp_timeout'); ?></label>

                        <div class="col-sm-9 col-lg-10 controls">
                            <?php $v = (set_value('smtp_timeout')!='')?set_value('smtp_timeout'):get_settings('smtp_settings','smtp_timeout','30');?>
                            <input type="text" name="smtp_timeout" value="<?php echo $v;?>" placeholder="<?php echo lang_key('type_something');?>g" class="form-control" >
                            <input type="hidden" name="smtp_timeout_rules" value="required">
                            <span class="help-inline">&nbsp;</span>
                            <?php echo form_error('smtp_timeout'); ?>
                        </div>
                    </div>


                    <div class="form-group">
                        <label class="col-sm-3 col-lg-2 control-label"><?php echo lang_key('smtp_user'); ?></label>

                        <div class="col-sm-9 col-lg-10 controls">
                            <?php $v = (set_value('smtp_user')!='')?set_value('smtp_user'):get_settings('smtp_settings','smtp_user','test@example.com');?>
                            <input type="text" name="smtp_user" value="<?php echo $v;?>" placeholder="<?php echo lang_key('type_something');?>g" class="form-control" >
                            <input type="hidden" name="smtp_user_rules" value="required|valid_email">
                            <span class="help-inline">&nbsp;</span>
                            <?php echo form_error('smtp_user'); ?>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-3 col-lg-2 control-label"><?php echo lang_key('smtp_password'); ?></label>

                        <div class="col-sm-9 col-lg-10 controls">
                            <?php $v = (set_value('smtp_pass')!='')?set_value('smtp_pass'):get_settings('smtp_settings','smtp_pass','');?>
                            <input type="text" name="smtp_pass" value="<?php echo $v;?>" placeholder="<?php echo lang_key('type_something');?>g" class="form-control" >
                            <input type="hidden" name="smtp_pass_rules" value="required">
                            <span class="help-inline">&nbsp;</span>
                            <?php echo form_error('smtp_pass'); ?>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-3 col-lg-2 control-label"><?php echo lang_key('Charter Set'); ?></label>

                        <div class="col-sm-9 col-lg-10 controls">
                            <?php $v = (set_value('char_set')!='')?set_value('char_set'):get_settings('smtp_settings','char_set','utf-8');?>
                            <input type="text" name="char_set" value="<?php echo $v;?>" placeholder="<?php echo lang_key('type_something');?>g" class="form-control" >
                            <input type="hidden" name="char_set_rules" value="required">
                            <span class="help-inline">&nbsp;</span>
                            <?php echo form_error('char_set'); ?>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-3 col-lg-2 control-label"><?php echo lang_key('New Line'); ?></label>

                        <div class="col-sm-9 col-lg-10 controls">
                            <?php $v = (set_value('new_line')!='')?set_value('new_line'):get_settings('smtp_settings','new_line','\r\n');?>
                            <input type="text" name="new_line" value="<?php echo $v;?>" placeholder="<?php echo lang_key('type_something');?>g" class="form-control" >
                            <input type="hidden" name="new_line_rules" value="required">
                            <span class="help-inline">&nbsp;</span>
                            <?php echo form_error('new_line'); ?>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-3 col-lg-2 control-label"><?php echo lang_key('Mail Type'); ?></label>

                        <div class="col-sm-9 col-lg-10 controls">
                            <?php $v = (set_value('mail_type')!='')?set_value('mail_type'):get_settings('smtp_settings','mail_type','html');?>
                            <input type="text" name="mail_type" value="<?php echo $v;?>" placeholder="<?php echo lang_key('type_something');?>g" class="form-control" >
                            <input type="hidden" name="mail_type_rules" value="required">
                            <span class="help-inline">&nbsp;</span>
                            <?php echo form_error('mail_type'); ?>
                        </div>
                    </div>
                    </span>

                    <div class="form-group">
                        <label class="col-sm-3 col-lg-2 control-label"></label>

                        <div class="col-sm-9 col-lg-10 controls">
                            <button class="btn btn-primary" type="submit"><i
                                    class="fa fa-check"></i><?php echo lang_key("update"); ?></button>
                        </div>
                    </div>

                </form>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
jQuery(document).ready(function(){
    jQuery('#enable_smtp').change(function(){
        var val = jQuery(this).val();
        if(val=='Enable')
        {
            jQuery('#enable-panel').show();            
        }
        else
        {
            jQuery('#enable-panel').hide();
        }
    }).change();
});
</script>
