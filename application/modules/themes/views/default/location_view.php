<!-- Page heading two starts -->
<div class="page-heading-two">
    <div class="container">
        <h2><?php echo lang_key('locations'); ?></h2>
        <div class="breads">
            <a href="<?php echo site_url(); ?>"><?php echo lang_key('home'); ?></a> / <?php echo lang_key('locations'); ?>
        </div>
        <div class="clearfix"></div>
    </div>
</div>

<!-- Container -->
<div class="container">

    <div class="row">

        <div class="col-md-9 col-sm-12 col-xs-12">
            <?php
            if($countries->num_rows()<=0){
                ?>
                <div class="alert alert-warning"><?php echo lang_key('no_location_found'); ?></div>
            <?php
            }
            else
            foreach($countries->result() as $country){ ?>
                <h4><a href="<?php echo site_url('location-posts/'.$country->id.'/country/'.dbc_url_title('$country->name'));?>"><i class="fa fa-map-marker color"></i> <?php echo lang_key($country->name); ?> <span dir="rtl">(<?php echo get_post_count_by_location($country->id, 'country'); ?>)</span></a></h4>
                <div class="divider-5"></div>
                <div class="clearfix"></div>

                <?php
                $state_active = get_settings('business_settings', 'show_state_province', 'yes');
                $child = $state_active=='yes'? 'state' : 'city';
                $total_count = 0;
                $locations = $child == 'state' ?  get_all_child_of_location('state', $country->id) : get_all_location_of_parent_country('city', $country->id);
                $i = 0;
                foreach($locations->result() as $location){ ?>
            <div class="col-md-4 col-sm-4">
                <ul class="list-2">
                    <li><a href="<?php echo site_url('location-posts/'.$location->id.'/'.$child.'/'.dbc_url_title($location->name));?>"><?php echo lang_key($location->name); ?> <span dir="rtl">(<?php echo get_post_count_by_location($location->id, $child); ?>)</span></a></li>
                </ul>
            </div>

                <?php }  ?>
                <div class="clearfix"></div>
            <?php } ?>


            <div class="clearfix"></div>
        </div>


        <div class="col-md-3 col-sm-12 col-xs-12">
            <div class="sidebar">
                <?php render_widgets('right_bar_locations');?>
            </div>
        </div>

    </div>
</div>
