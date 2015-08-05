<!-- Page heading two starts -->

    <div class="page-heading-two">

      <div class="container">

        <h2><?php echo lang_key('confirm_payment');?> </h2>

        <div class="breads">

            <a href="<?php echo site_url(); ?>"><?php echo lang_key('home'); ?></a> / <?php echo lang_key('confirm_payment'); ?>

        </div>

        <div class="clearfix"></div>

      </div>

    </div>   

    

<!-- Container -->

<div class="container">



    <div class="contact-us-three">

        <div class="row">



            <div class="col-md-12 col-sm-12">



                <?php 

                $CI = get_instance();

                $CI->load->model('admin/package_model');

                ?>

                <div class="bold-font">
                    <?php echo lang_key('package_title');?> : <?php echo $package->title;?><br/>
                    <?php echo lang_key('price');?> : <?php echo show_package_price($package->price);?><br/>
                    <?php echo lang_key('expirtion_time');?> : <?php echo $package->expiration_time;?> <?php echo lang_key('days'); ?> 
                </div>
                <div class="clearfix clear-top-margin"></div>



                <p><?php echo lang_key('payment_notification'); ?></p>



                <?php if(get_settings('package_settings','enable_paypal_transfer','Yes')=='Yes'){?>

                    <?php

                    $action = (get_settings('paypal_settings','enable_sandbox_mode','No')=='Yes')?'https://www.sandbox.paypal.com/cgi-bin/webscr':'https://www.paypal.com/cgi-bin/webscr';

                    ?>

                    <form action="<?php echo $action;?>" method="post" target="_top">

                    <input type="hidden" name="cmd" value="_xclick">

                    <input type="hidden" name="business" value="<?php echo get_settings('paypal_settings','email','none');?>">

                    <input type="hidden" name="lc" value="US">

                    <input type="hidden" name="item_name" value="<?php echo get_settings('paypal_settings','item_name','Package');?>">

                    <input type="hidden" name="amount" value="<?php echo $package->price;?>">

                    <input type="hidden" name="currency_code" value="<?php echo get_settings('paypal_settings','currency','USD');?>">

                    <input type="hidden" name="no_note" value="1">

                    <input type="hidden" name="no_shipping" value="1">

                    <input type="hidden" name="rm" value="1">

                    <input type="hidden" name="return" value="<?php echo site_url(get_settings('paypal_settings','finish_url','account/finish_url'));?>">

                    <input type="hidden" name="cancel_return" value="<?php echo site_url(get_settings('paypal_settings','cancel_url','account/cancel_url'));?>">

                    <input type="hidden" name="bn" value="PP-BuyNowBF:btn_buynowCC_LG.gif:NonHosted">

                    <input type="hidden" name="notify_url" value="<?php echo site_url('user/payment/ipn_url');?>">

                    <?php 

                        $custom_value = "id=".$unique_id;

                        if(isset($renew))

                            $custom_value .= "&renew=renew";

                    ?>

                    <input type="hidden" name="custom" value="<?php echo $custom_value;?>">

                    <button type="submit" class="btn btn-primary"><?php echo lang_key('go_to_paypal');?></button>

                    <img alt="" border="0" src="https://www.paypalobjects.com/en_US/i/scr/pixel.gif" width="1" height="1">

                    </form>

                <?php }?>    

                </p>

                <?php if(get_settings('package_settings','enable_bank_transfer','No')=='Yes'){?>

                <div class="label label-success"><?php echo lang_key('transaction_id');?> : <?php echo $unique_id;?></div>

                <div class="bank-transfer-ins"><?php echo lang_key('bank_transfer');?></div>

                <?php echo get_settings('package_settings','bank_transfer_instruction_for_posts','');?>                

                <?php }?>



            </div>



        </div>

    </div>



</div>

<script type="text/javascript">
    window.onbeforeunload = function() {
        return "If you reload your data will be lost";
    }
</script>