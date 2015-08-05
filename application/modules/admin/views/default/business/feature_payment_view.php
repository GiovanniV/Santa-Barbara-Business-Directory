<div class="row">
    <div class="col-md-12">
        <div class="box">
            <div class="box-title">
                <h3><i class="fa fa-bars"></i><?php echo lang_key("Pay for feature") ?> </h3>

                <div class="box-tool">
                    <a href="#" data-action="collapse"><i class="fa fa-chevron-up"></i></a>
                </div>
            </div>
            <div class="box-content">
                <?php echo $this->session->flashdata('msg'); ?>
                <label>Post ID: #<?php echo $post->id;?></label>
                <p>You'll have to pay <?php echo get_settings('business_settings','feature_charge','0').' '.get_settings('paypalsettings','currency','USD');?> and your property will be
                    Featured for <?php echo get_settings('business_settings','feature_day_limit','0');?> days</p>

                <?php if(get_settings('business_settings','enable_paypal_transfer','Yes')=='Yes'){?>
                    <?php
                    $action = (get_settings('paypal_settings','enable_sandbox_mode','No')=='Yes')?'https://www.sandbox.paypal.com/cgi-bin/webscr':'https://www.paypal.com/cgi-bin/webscr';
                    ?>
                    <form action="<?php echo $action;?>" method="post" target="_top">
                    <input type="hidden" name="cmd" value="_xclick">
                    <input type="hidden" name="business" value="<?php echo get_settings('paypal_settings','email','none');?>">
                    <input type="hidden" name="lc" value="US">
                    <input type="hidden" name="item_name" value="Make Property Feature">
                    <input type="hidden" name="amount" value="<?php echo get_settings('business_settings','feature_charge','0');?>">
                    <input type="hidden" name="currency_code" value="<?php echo get_settings('paypal_settings','currency','USD');?>">
                    <input type="hidden" name="no_note" value="1">
                    <input type="hidden" name="no_shipping" value="1">
                    <input type="hidden" name="rm" value="1">
                    <input type="hidden" name="return" value="<?php echo site_url('admin/business/finish_url');?>">
                    <input type="hidden" name="cancel_return" value="<?php echo site_url('admin/business/cancel_url');?>">
                    <input type="hidden" name="bn" value="PP-BuyNowBF:btn_buynowCC_LG.gif:NonHosted">
                    <input type="hidden" name="notify_url" value="<?php echo site_url('account/featured_ipn_url');?>">
                    <input type="hidden" name="custom" value="<?php echo $this->session->userdata('unique_id');?>">
                    <button type="submit" class="btn btn-primary">Go to Paypal</button>
                    <img alt="" border="0" src="https://www.paypalobjects.com/en_US/i/scr/pixel.gif" width="1" height="1">
                    </form>
                <?php }?>
                </p>
                <?php if(get_settings('business_settings','enable_bank_transfer','No')=='Yes'){?>
                <div style="border-bottom:1px solid #aaa;font-weight:bold;font-size:14px;padding:0 0 5px 5px;">Bank transfer</div>
                <?php echo get_settings('business_settings','featured_payment_bank_instruction','');?>
                <?php }?>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
jQuery(document).ready(function(){

});
</script>