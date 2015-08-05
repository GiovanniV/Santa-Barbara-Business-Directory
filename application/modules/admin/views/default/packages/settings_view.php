<div class="row">
    <div class="col-md-12">
        <div class="box">
            <div class="box-title">
                <h3><i class="fa fa-bars"></i><?php echo lang_key("package_settings") ?> </h3>

                <div class="box-tool">
                    <a href="#" data-action="collapse"><i class="fa fa-chevron-up"></i></a>
                </div>
            </div>
            <div class="box-content">
                <?php echo $this->session->flashdata('msg'); ?>
                <?php $settings = json_decode($settings);?>
                <form class="form-horizontal" action="<?php echo site_url('admin/package/savesettings/');?>" method="post">
                    

                <h3><?php echo lang_key('post_price_settings');?></h3>
                    <div class="form-group">
                        <label class="col-sm-3 col-lg-2 control-label"><?php echo lang_key('enable_post_pricing'); ?></label>

                        <div class="col-sm-9 col-md-3 controls">
                            <select name="enable_pricing" class="form-control">
                                <?php $options = array('Yes','No');?>
                                <?php $v = (set_value('enable_pricing')!='')?set_value('enable_pricing'):$settings->enable_pricing;?>
                                <?php foreach($options as $row){?>
                                    <?php $sel=($v==$row)?'selected="selected"':'';?>
                                    <option value="<?php echo $row;?>" <?php echo $sel;?>><?php echo $row;?></option>
                                <?php }?>
                            </select>
                            <input type="hidden" name="enable_pricing_rules" value="required">
                            <span class="help-inline">&nbsp;</span>
                            <?php echo form_error('enable_pricing'); ?>
                        </div>
                    </div>

            
                    <div class="form-group">
                        <label class="col-sm-3 col-lg-2 control-label"><?php echo lang_key('enable_paypal_transfer'); ?></label>

                        <div class="col-sm-9 col-lg-3 controls">
                            <select name="enable_paypal_transfer" class="form-control" id="enable_paypal_transfer">
                                <?php $options = array('Yes'=>'Yes','No'=>'No');?>
                                <?php $v = (set_value('enable_paypal_transfer')!='')?set_value('enable_paypal_transfer'):$settings->enable_paypal_transfer;?>
                                <?php foreach($options as $key=>$row){?>
                                    <?php $sel=($v==$key)?'selected="selected"':'';?>
                                    <option value="<?php echo $key;?>" <?php echo $sel;?>><?php echo $row;?></option>
                                <?php }?>
                            </select>
                            <input type="hidden" name="enable_paypal_transfer_rules" value="required">
                            <span class="help-inline">&nbsp;</span>
                            <?php echo form_error('enable_paypal_transfer'); ?>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-3 col-lg-2 control-label"><?php echo lang_key('enable_bank_transfer'); ?></label>

                        <div class="col-sm-9 col-lg-3 controls">
                            <select name="enable_bank_transfer" class="form-control" id="enable_bank_transfer">
                                <?php $options = array('Yes'=>'Yes','No'=>'No');?>
                                <?php $v = (set_value('enable_bank_transfer'))?set_value('enable_bank_transfer'):$settings->enable_bank_transfer;?>
                                <?php foreach($options as $key=>$row){?>
                                    <?php $sel=($v==$key)?'selected="selected"':'';?>
                                    <option value="<?php echo $key;?>" <?php echo $sel;?>><?php echo $row;?></option>
                                <?php }?>
                            </select>
                            <input type="hidden" name="enable_bank_transfer_rules" value="required">
                            <span class="help-inline">&nbsp;</span>
                            <?php echo form_error('enable_bank_transfer'); ?>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-3 col-lg-2 control-label"><?php echo lang_key('bank_transfer_instruction_for_posts'); ?></label>

                        <div class="col-sm-9 col-lg-6 controls">
                            <textarea name="bank_transfer_instruction_for_posts" class="form-control"><?php echo(set_value('bank_transfer_instruction_for_posts')!='')?set_value('bank_transfer_instruction_for_posts'):$settings->bank_transfer_instruction_for_posts;?></textarea>
                            <input type="hidden" name="bank_transfer_instruction_for_posts_rules" value="required">
                            <span class="help-inline">&nbsp;</span>
                            <?php echo form_error('bank_transfer_instruction_for_posts'); ?>
                        </div>
                    </div>


                    <h3><?php echo lang_key('featured_price_settings');?></h3>
                    <div class="form-group">
                        <label class="col-sm-3 col-lg-2 control-label"><?php echo lang_key('enable_featured_pricing'); ?></label>

                        <div class="col-sm-9 col-md-3 controls">
                            <select name="enable_featured_pricing" class="form-control">
                                <?php $options = array('Yes','No');?>
                                <?php $v = (set_value('enable_featured_pricing')!='')?set_value('enable_featured_pricing'):$settings->enable_featured_pricing;?>
                                <?php foreach($options as $row){?>
                                    <?php $sel=($v==$row)?'selected="selected"':'';?>
                                    <option value="<?php echo $row;?>" <?php echo $sel;?>><?php echo $row;?></option>
                                <?php }?>
                            </select>
                            <input type="hidden" name="enable_featured_pricing_rules" value="required">
                            <span class="help-inline">&nbsp;</span>
                            <?php echo form_error('enable_featured_pricing'); ?>
                        </div>
                    </div>

            
                    <div class="form-group">
                        <label class="col-sm-3 col-lg-2 control-label"><?php echo lang_key('enable_featured_paypal'); ?></label>

                        <div class="col-sm-9 col-lg-3 controls">
                            <select name="enable_featured_paypal_transfer" class="form-control" id="enable_featured_paypal_transfer">
                                <?php $options = array('Yes'=>'Yes','No'=>'No');?>
                                <?php $v = (set_value('enable_featured_paypal_transfer')!='')?set_value('enable_featured_paypal_transfer'):$settings->enable_featured_paypal_transfer;?>
                                <?php foreach($options as $key=>$row){?>
                                    <?php $sel=($v==$key)?'selected="selected"':'';?>
                                    <option value="<?php echo $key;?>" <?php echo $sel;?>><?php echo $row;?></option>
                                <?php }?>
                            </select>
                            <input type="hidden" name="enable_featured_paypal_transfer_rules" value="required">
                            <span class="help-inline">&nbsp;</span>
                            <?php echo form_error('enable_featured_paypal_transfer'); ?>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-3 col-lg-2 control-label"><?php echo lang_key('enable_featured_bank_transfer'); ?></label>

                        <div class="col-sm-9 col-lg-3 controls">
                            <select name="enable_featured_bank_transfer" class="form-control" id="enable_featured_bank_transfer">
                                <?php $options = array('Yes'=>'Yes','No'=>'No');?>
                                <?php $v = (set_value('enable_featured_bank_transfer')!='')?set_value('enable_featured_bank_transfer'):$settings->enable_featured_bank_transfer;?>
                                <?php foreach($options as $key=>$row){?>
                                    <?php $sel=($v==$key)?'selected="selected"':'';?>
                                    <option value="<?php echo $key;?>" <?php echo $sel;?>><?php echo $row;?></option>
                                <?php }?>
                            </select>
                            <input type="hidden" name="enable_featured_bank_transfer_rules" value="required">
                            <span class="help-inline">&nbsp;</span>
                            <?php echo form_error('enable_featured_bank_transfer'); ?>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-3 col-lg-2 control-label"><?php echo lang_key('bank_transfer_instruction_for_featured_posts'); ?></label>

                        <div class="col-sm-9 col-lg-6 controls">
                            <textarea name="bank_transfer_instruction_for_featured_posts" class="form-control"><?php echo(set_value('bank_transfer_instruction_for_featured_posts'))?set_value('bank_transfer_instruction_for_featured_posts'):$settings->bank_transfer_instruction_for_featured_posts;?></textarea>
                            <input type="hidden" name="bank_transfer_instruction_for_featured_posts_rules" value="required">
                            <span class="help-inline">&nbsp;</span>
                            <?php echo form_error('bank_transfer_instruction_for_featured_posts'); ?>
                        </div>
                    </div>


                    <h3><?php echo lang_key('bank_currency_settings');?></h3>
                    <div class="form-group">
                        <label class="col-sm-3 col-lg-2 control-label"><?php echo lang_key('bank_currency'); ?></label>

                        <div class="col-sm-9 col-md-3 controls">
                               
                            <select name="bank_currency" class="form-control">
                                <?php $options = get_all_currencies();?>
                                <?php $bank_currency = (isset($settings->bank_currency))?$settings->bank_currency:'';?>
                                <?php $v = (set_value('bank_currency')!='')?set_value('bank_currency'):$bank_currency;?>
                                <?php $sel=($v=='use_paypal')?'selected="selected"':'';?>
                                <option value="use_paypal" <?php echo $sel;?>><?php echo lang_key('use_same_as_paypal_currency');?></option>
                                <?php foreach($options as $currency=>$val){?>
                                    <?php $sel=($v==$currency)?'selected="selected"':'';?>
                                   <option value="<?php echo $currency;?>" <?php echo $sel;?>><?php echo $val[0].' ('.get_currency_icon($currency).' '. $currency.')';?></option>
                                <?php }?>
                            </select>

                            <input type="hidden" name="bank_currency_rules" value="required">
                            <span class="help-inline">&nbsp;</span>
                            <?php echo form_error('bank_currency'); ?>
                        </div>
                    </div>



                    <div class="form-group">
                        <label class="col-sm-3 col-lg-2 control-label">&nbsp;</label>

                        <div class="col-sm-9 col-lg-6 controls">
                            <button type="submit" class="btn btn-success"><?php echo lang_key('save');?></button>
                        </div>
                    </div>



                </form>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
jQuery(document).ready(function(){
    jQuery('#enable_bank_transfer').change(function(){
        var val = jQuery(this).val();
        if(val=='Yes')
            jQuery('input[name=bank_transfer_instruction_for_posts_rules]').val('required');
        else
            jQuery('input[name=bank_transfer_instruction_for_posts_rules]').val('');
    }).change();

    jQuery('#enable_featured_bank_transfer').change(function(){
        var val = jQuery(this).val();
        if(val=='Yes')
            jQuery('input[name=bank_transfer_instruction_for_featured_posts_rules]').val('required');
        else
            jQuery('input[name=bank_transfer_instruction_for_featured_posts_rules]').val('');
    }).change();
});
</script>