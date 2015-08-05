<div id="sidebar" class="navbar-collapse collapse">

    <div id="sidebar-collapse" class="">


        <i class="fa fa-angle-double-left"></i>


    </div>

    <ul class="nav nav-list">
        <?php if (is_admin()) { ?>
            <!--<li class="active"> HIGHLIGHTS MENU-->
            <li class="<?php echo is_active_menu('admin/index'); ?>">
                <a href="<?php echo site_url('admin/index'); ?>">
                    <i class="fa fa-dashboard"></i>
                    <span><?php echo lang_key("dashboard"); ?></span>
                </a>
            </li>
        <?php } ?>

        <?php if(get_settings('banner_settings','banner_type','Parallax Slider')=='Parallax Slider'){?>
        <li class="<?php echo is_active_menu('admin/slider'); ?>">


            <a href="#" class="dropdown-toggle">


                <i class="fa fa-file-o"></i>


                <span><?php echo lang_key('parallax_slider'); ?></span>


                <b class="arrow fa fa-angle-right"></b>


            </a>


            <ul class="submenu">


                <!--<li class="active"> HIGHLIGHTS SUBMENU-->


                <li class="<?php echo is_active_menu('admin/slider/all'); ?>"><a
                        href="<?php echo site_url('admin/slider/all'); ?>"><?php echo lang_key('all'); ?></a></li>


                <li class="<?php echo is_active_menu('admin/slider/manage'); ?>"><a
                        href="<?php echo site_url('admin/slider/manage'); ?>"><?php echo lang_key('add_new'); ?></a></li>


            </ul>

        </li>
        <?php
        }
        ?>

        <li class="<?php echo is_active_menu('admin/business/'); ?>">
            <a href="#" class="dropdown-toggle">
                <i class="fa fa-plus-circle"></i>
                <span><?php echo lang_key("product_name"); ?></span>
                <b class="arrow fa fa-angle-right"></b>
            </a>

            <ul class="submenu">

                <li class="<?php echo is_active_menu('admin/business/allposts'); ?>">
                    <a href="<?php echo site_url('admin/business/allposts'); ?>">
                        <?php echo lang_key('all_posts'); ?>
                    </a>
                </li>

                <li class="<?php echo is_active_menu('list-business'); ?>">
                    <a href="<?php echo site_url('list-business'); ?>">
                        <?php echo lang_key('new_business'); ?>
                    </a>
                </li>




                <li class="<?php echo is_active_menu('admin/business/emailtracker'); ?>">
                    <a href="<?php echo site_url('admin/business/emailtracker'); ?>">
                        <?php echo lang_key('email_tracker'); ?>
                    </a>
                </li>

                <li class="<?php echo is_active_menu('admin/business/bulkemailform'); ?>">
                    <a href="<?php echo site_url('admin/business/bulkemailform'); ?>">
                        <?php echo lang_key('bulk_email'); ?>
                    </a>
                </li>


                <?php if (is_admin()) { ?>

                <li class="<?php echo is_active_menu('admin/business/locations'); ?>">
                    <a href="<?php echo site_url('admin/business/locations'); ?>">
                        <?php echo lang_key('locations'); ?>
                    </a>
                </li>

                <li class="<?php echo is_active_menu('admin/business/businesssettings'); ?>">
                    <a href="<?php echo site_url('admin/business/businesssettings'); ?>">
                        <?php echo lang_key('site_settings'); ?>
                    </a>
                </li>

                <li class="<?php echo is_active_menu('admin/business/paypalsettings'); ?>">
                    <a href="<?php echo site_url('admin/business/paypalsettings'); ?>">
                        <?php echo lang_key('paypal_settings'); ?>
                    </a>
                </li>

                <li class="<?php echo is_active_menu('admin/business/payments'); ?>">
                    <a href="<?php echo site_url('admin/business/payments'); ?>">
                        <?php echo lang_key('payment_history'); ?>
                    </a>
                </li>

                <li class="<?php echo is_active_menu('admin/business/bannersettings'); ?>">
                    <a href="<?php echo site_url('admin/business/bannersettings'); ?>">
                        <?php echo lang_key('banner_settings'); ?>
                    </a>
                </li>

                <?php } ?>

            </ul>
        </li>

        <?php if (is_admin()) { ?>

        <li class="<?php echo is_active_menu('admin/category/'); ?>">
            <a href="#" class="dropdown-toggle">
                <i class="fa fa-bars"></i>
                <span><?php echo lang_key('category'); ?></span>
                <b class="arrow fa fa-angle-right"></b>
            </a>

            <ul class="submenu">
                <li class="<?php echo is_active_menu('admin/category/all'); ?>">
                    <a href="<?php echo site_url('admin/category/all'); ?>">
                        <?php echo lang_key('all_categories'); ?>
                    </a>
                </li>
                <li class="<?php echo is_active_menu('admin/category/newcategory'); ?>">
                    <a href="<?php echo site_url('admin/category/newcategory'); ?>">
                        <?php echo lang_key('new_category'); ?>
                    </a>
                </li>
            </ul>
        </li>

        <?php } ?>

        <li class="<?php echo is_active_menu('admin/editprofile'); ?>">


            <a href="<?php echo site_url('admin/editprofile'); ?>">


                <i class="fa fa-user"></i>


                <span><?php echo lang_key('profile'); ?></span>


            </a>


        </li>

        <?php if (is_admin()) { ?>



            <li class="<?php echo is_active_menu('admin/package/'); ?>">
                <a href="#" class="dropdown-toggle">
                    <i class="fa fa-bars"></i>
                    <span><?php echo lang_key('packages'); ?></span>
                    <b class="arrow fa fa-angle-right"></b>
                </a>


                <ul class="submenu">
                    <li class="<?php echo is_active_menu('admin/package/all'); ?>">
                        <a href="<?php echo site_url('admin/package/all'); ?>">
                            <?php echo lang_key('all_packages'); ?>
                        </a>
                    </li>

                    <?php $urls = array('admin/package/addpackage', 'admin/package/newpackage'); ?>
                    <li class="<?php echo is_active_menu($urls); ?>">
                        <a href="<?php echo site_url('admin/package/newpackage'); ?>">
                            <?php echo lang_key('create_new_package'); ?>
                        </a>
                    </li>

                    <li class="<?php echo is_active_menu('admin/package/settings'); ?>">
                        <a href="<?php echo site_url('admin/package/settings'); ?>">
                            <?php echo lang_key('package_settings'); ?>
                        </a>
                    </li>


                </ul>

            </li>
            <li class="<?php echo is_active_menu(array('admin/users','admin/edituser')); ?>">


                <a href="<?php echo site_url('admin/users'); ?>">


                    <i class="fa fa-users"></i>


                    <span><?php echo lang_key('users'); ?></span>


                </a>


            </li>
            <li class="<?php echo is_active_menu('admin/widgets/'); ?>">


                <a href="#" class="dropdown-toggle">


                    <i class="fa fa-bars"></i>


                    <span><?php echo lang_key('widgets'); ?></span>


                    <b class="arrow fa fa-angle-right"></b>


                </a>


                <ul class="submenu">


                    <li class="<?php echo is_active_menu('admin/widgets/all'); ?>"><a
                            href="<?php echo site_url('admin/widgets/all'); ?>">


                            <?php echo lang_key('all_widgets'); ?>


                        </a>


                    </li>


                    <li class="<?php echo is_active_menu('admin/widgets/widgetpositions'); ?>"><a
                            href="<?php echo site_url('admin/widgets/widgetpositions'); ?>">


                            <?php echo lang_key('widget_positions'); ?>


                        </a>


                    </li>


                </ul>


            </li>
            
            




            <li class="<?php echo is_active_menu('admin/blog/'); ?>">


                <a href="#" class="dropdown-toggle">


                    <i class="fa fa-file-o"></i>


                    <span><?php echo lang_key('blog_news_article'); ?></span>


                    <b class="arrow fa fa-angle-right"></b>


                </a>


                <ul class="submenu">

                    <li class="<?php echo is_active_menu('admin/blog/all'); ?>"><a
                            href="<?php echo site_url('admin/blog/all'); ?>"><?php echo lang_key('all_posts'); ?></a></li>


                    <li class="<?php echo is_active_menu('admin/blog/manage'); ?>"><a
                            href="<?php echo site_url('admin/blog/manage'); ?>"><?php echo lang_key('new_post'); ?></a></li>


                </ul>


            </li>
            <li class="<?php echo is_active_menu('admin/page/'); ?>">


                <a href="#" class="dropdown-toggle">


                    <i class="fa fa-file-o"></i>


                    <span><?php echo lang_key('pages_and_menu'); ?></span>


                    <b class="arrow fa fa-angle-right"></b>


                </a>


                <ul class="submenu">


                    <!--<li class="active"> HIGHLIGHTS SUBMENU-->


                    <li class="<?php echo is_active_menu('admin/page/all'); ?>"><a
                            href="<?php echo site_url('admin/page/all'); ?>"><?php echo lang_key('all_pages'); ?></a></li>


                    <li class="<?php echo is_active_menu('admin/page/index'); ?>"><a
                            href="<?php echo site_url('admin/page/index'); ?>"><?php echo lang_key('new_page'); ?></a></li>


                    <li class="<?php echo is_active_menu('admin/page/menu'); ?>"><a
                            href="<?php echo site_url('admin/page/menu'); ?>"><?php echo lang_key('menu'); ?></a></li>


                </ul>


            </li>

            <li class="<?php echo is_active_menu('admin/system'); ?>">


                <a href="#" class="dropdown-toggle">


                    <i class="fa fa-cog"></i>


                    <span><?php echo lang_key('system'); ?></span>


                    <b class="arrow fa fa-angle-right"></b>


                </a>


                <ul class="submenu">


                    <!--<li class="active"> HIGHLIGHTS SUBMENU-->


                    <li class="<?php echo is_active_menu('admin/system/allbackups'); ?>"><a
                            href="<?php echo site_url('admin/system/allbackups'); ?>"><?php echo lang_key('manage_backups'); ?></a></li>

                    <li class="<?php echo is_active_menu('admin/system/smtpemailsettings'); ?>"><a
                            href="<?php echo site_url('admin/system/smtpemailsettings'); ?>"><?php echo lang_key('smtp_email_settings'); ?></a>
                    </li>

                    <li class="<?php echo is_active_menu('admin/system/translate'); ?>"><a
                            href="<?php echo site_url('admin/system/translate'); ?>"><?php echo lang_key('auto_translate'); ?></a></li>


                    <li class="<?php echo is_active_menu('admin/system/emailtmpl'); ?>"><a
                            href="<?php echo site_url('admin/system/emailtmpl'); ?>"><?php echo lang_key('edit_email_text'); ?></a></li>


                    <li class="<?php echo is_active_menu('admin/system/sitesettings'); ?>"><a
                            href="<?php echo site_url('admin/system/sitesettings'); ?>"><?php echo lang_key('default_site_settings'); ?></a></li>


                    <li class="<?php echo is_active_menu('admin/system/settings'); ?>"><a
                            href="<?php echo site_url('admin/system/settings'); ?>"><?php echo lang_key('admin_settings'); ?></a></li>


                    <li class="<?php echo is_active_menu('admin/system/generatesitemap'); ?>"><a
                            href="<?php echo site_url('admin/system/generatesitemap'); ?>"><?php echo lang_key('sitemap'); ?></a></li>


                </ul>


            </li>



        <?php } ?>


    </ul>





</div>