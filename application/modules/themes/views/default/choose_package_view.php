<!-- Page heading two starts -->
    <div class="page-heading-two">
      <div class="container">
        <h2><?php echo lang_key('choose_a_package');?> </h2>
        <div class="breads">
            <a href="<?php echo site_url(); ?>"><?php echo lang_key('home'); ?></a> / <?php echo lang_key('choose_a_package'); ?>
        </div>
        <div class="clearfix"></div>
      </div>
    </div>   
    
<!-- Container -->
<div class="container">
    <?php
    if($packages->num_rows()<=0){
        ?>
        <div class="alert alert-danger"><?php echo lang_key('no_package_found'); ?></div>
    <?php
    }
    else
    {
    ?>
    <?php echo $this->session->flashdata('msg');?>

    <!-- Pricing table #1 starts -->
    <div class="pricing-one">
        <div class="container">
            <div class="row">

                <?php foreach($packages->result() as $package):?>
                    <?php $action = (isset($renew) && $renew=='renew')?site_url('user/payment/renewpackage'):site_url('user/payment/takepackage');?>
                <form action="<?php echo $action;?>" method="post">
                    <input type="hidden" name="package_id" value="<?php echo $package->id;?>">
                    <?php 
                     if(isset($renew_post_id)) {
                    ?>
                    <input type="hidden" name="renew_post_id" value="<?php echo $renew_post_id;?>">
                    <?php }?>
                    <div class="col-md-4 col-sm-4">
                        <!-- Pricing Content Item -->
                        <div class="pricing-item">
                            <!-- Heading -->
                            <h3><?php echo $package->title;?> </h3>
                            <p><small><?php echo $package->description;?></small>&nbsp;</p>
                            <!-- Content plan price -->
                            <div class="plan-price">
                                <span class="p-price bg-color"><?php echo number_format($package->price); ?></span>
                                <button class="btn btn-lblue" type="submit" href="<?php echo site_url('show/registerinfo');?>">
                                    <?php echo lang_key('subscribe'); ?>
                                </button>

                            </div>
                            <!-- Plan details -->
                            <div class="plan-details">
                                <ul class="list-unstyled">
                                    <!-- List items -->
                                    <li><?php echo lang_key('price'); ?> <span class="pull-right"><?php echo show_package_price($package->price);?></span></li>
                                    <li><?php echo lang_key('limit'); ?> <span class="pull-right"><?php echo $package->expiration_time;?> <?php echo lang_key('days'); ?></span></li>
                                </ul>
                            </div>
                            <div class="clearfix"></div>
                            <!-- Tag -->
                            <span class="tag bg-color"><i class="fa fa-fire"></i></span>
                        </div>
                    </div>
                </form>

                <?php endforeach;?>
                <div class="clearfix"></div>

            </div>
        </div>
    </div>
    <!-- Pricing #1 ends -->
    <?php
    }
    ?>
</div>