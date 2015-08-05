<!-- Top bar starts -->
<div class="top-bar">
    <div class="container">
		<div class="col-md-9 col-sm-9 primary-header">
			<!-- Logo section -->
			<div class="logo">
				<h3><a href="<?php echo site_url();?>"><img src="<?php echo get_site_logo();?>" alt="Logo"></a></h3>
			</div>
		</div>
		<div class="col-md-3 col-sm-3 primary-header">
        <?php render_widget('top_bar_social'); ?>
		</div>

        <div class="clearfix"></div>
    </div>
</div>

<!-- Top bar ends -->
<!-- Header two Starts -->
<div class="header-2">

    <!-- Container -->
    <div class="container">
        <div class="row">
            <div class="col-md-12 col-sm-12">

                <!-- Navigation starts.  -->
                <div class="navy">
                    <ul class="pull-left">
                        <?php
                            $CI = get_instance();
                            $CI->load->model('admin/page_model');
                            $CI->page_model->init();
                        ?>
                        <?php 
                            $alias = (isset($alias))?$alias:'';
                            foreach ($CI->page_model->get_menu() as $li) 
                            {
                                if($li->parent==0)
                                $CI->page_model->render_top_menu($li->id,0,$alias);
                            }
                        ?>

                        <?php if(!is_loggedin()){?>
                        <li class="">
                            <a class="signup" href="<?php echo site_url('account/signupform');?>"><?php echo lang_key('signup')?></a>
                        </li>
                        <li class="">
                            <a class="signin" href="#"><?php echo lang_key('signin');?></a>
                        </li>
                        <?php }else{ ?>
						<li class="">
                            <a class="signup" href="<?php echo site_url('admin');?>"><?php echo lang_key('my_account');?></a>
                        </li>
                        <li class="">
                            <a class="signup" href="<?php echo site_url('account/logout');?>"><?php echo lang_key('logout');?></a>
                        </li>
                        <?php }?>

                    </ul>
                </div>
                <!-- Navigation ends -->

            </div>

        </div>
    </div>
</div>



