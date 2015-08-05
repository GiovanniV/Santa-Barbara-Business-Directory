<!DOCTYPE html>

<html lang="en">

<head>

    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">

    <meta charset="utf-8">

    <?php

    $page = get_current_page();


    if (!isset($sub_title))
        $sub_title = (isset($page['title'])) ? $page['title'] : lang_key('list_business');

    $seo = (isset($page['seo_settings']) && $page['seo_settings'] != '') ? (array)json_decode($page['seo_settings']) : array();

    if (!isset($meta_desc))
        $meta_desc = (isset($seo['meta_description'])) ? $seo['meta_description'] : get_settings('site_settings', 'meta_description', 'autocon car dealership');

    if (!isset($key_words))
        $key_words = (isset($seo['key_words'])) ? $seo['key_words'] : get_settings('site_settings', 'key_words', 'car dealership,car listing, house, car');

    if (!isset($crawl_after))
        $crawl_after = (isset($seo['crawl_after'])) ? $seo['crawl_after'] : get_settings('site_settings', 'crawl_after', 3);

    ?>

    <?php
    if(isset($post))
    {
        echo (isset($post))?social_sharing_meta_tags_for_post($post):'';
    }
    elseif(isset($blog_meta))
    {
        echo (isset($blog_meta))?social_sharing_meta_tags_for_blog($blog_meta):'';

    }

    ?>

    <title><?php echo translate(get_settings('site_settings', 'site_title', 'Whizz Business Directory')); ?>
        | <?php echo translate($sub_title); ?></title>

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <meta name="description" content="<?php echo $meta_desc; ?>">

    <meta name="keywords" content="<?php echo $key_words; ?>"/>

    <meta name="revisit-after" content="<?php echo $crawl_after; ?> days">

    <!--<link rel="icon" type="image/png" href="<?php echo theme_url();?>/assets/img/favicon.png">-->
    <?php require_once 'includes_top.php'; ?>

    <?php

    $top_bar_bg_color = get_settings('banner_settings', 'top_bar_bg_color', '#fdfdfd');

    $bg_color = get_settings('banner_settings', 'menu_bg_color', '#ffffff');

    $text_color = get_settings('banner_settings', 'menu_text_color', '#666');

    $active_text_color = get_settings('banner_settings', 'active_menu_text_color', '#32c8de');

    ?>

<style>
    .top-bar{
        background: <?php echo $top_bar_bg_color;?>; 
    }
    
    .header-2{
        background: <?php echo $bg_color;?>; 
    }
    .header-2 .navy > ul > li > ul{
        background: <?php echo $bg_color;?>; 
        
    }
    .header-2 .navy > ul > li > a{
        color: <?php echo $text_color;?>
    }
    .header-2 .navy ul ul li a{
        color: <?php echo $text_color;?>        
    }
   .header-2 .navy > ul > li > a:hover{
        color: <?php echo $active_text_color;?>
    }
    .header-2 .navy ul ul li a:hover{
        color: <?php echo $active_text_color;?>        
    }
    .header-2 .navy > ul > .active > a{
        color: <?php echo $active_text_color;?>
    }
    .header-2 .navy ul ul .active a{
        color: <?php echo $active_text_color;?>        
    }

    .real-estate .re-big-form{
        padding: 15px 0 0 0;
        <?php 
        if(get_settings('banner_settings','show_bg_image','0')==1)
        {
        ?>
        background: <?php echo get_settings('banner_settings','search_panel_bg_color','#222222')?> url(<?php echo base_url('uploads/banner/'.get_settings('banner_settings','search_bg','heading-back.jpg'));?>) center center no-repeat fixed;
        <?php 
        }else{
        ?>
        background: <?php echo get_settings('banner_settings','search_panel_bg_color','#222222')?>;        
        <?php    
        }
        ?>
    }
</style>

<script type="text/javascript">var old_ie = 0;</script>
<!--[if lte IE 8]> <script type="text/javascript"> old_ie = 1; </script> < ![endif]-->

</head>



<?php
$CI = get_instance();
$curr_lang = get_current_lang();
if($curr_lang=='ar' || $curr_lang=='fa' || $curr_lang=='he' || $curr_lang=='ur')
{
?>
<link rel="stylesheet" href="<?php echo theme_url();?>/assets/css/rtl-fix.css">
<body class="home" dir="rtl">
<?php 
}else{
?>
<body class="home" dir="<?php echo get_settings('site_settings','site_direction','ltr');?>">
<?php 
}
?>

<!-- Outer Starts -->
<div class="outer">
<?php require_once 'header.php'; ?>

<?php 
    if($alias=='home')
    {
        if(constant("ENVIRONMENT")=='demo')
        $banner_type = (isset($banner_type))?$banner_type:get_settings('banner_settings','banner_type','Layer Slider');             
        else
        $banner_type = get_settings('banner_settings','banner_type','Layer Slider');             

        if($banner_type == 'Parallax Slider'){
            require_once 'slider_view.php';
        }
        else if($banner_type == 'Layer Slider'){
            require_once 'layer_slider.php';
        }
        else{
            require_once 'map_view.php';
        }
    }
    ?>
<!-- Main content starts -->
<div class="main-block">
    <?php echo (isset($content))?$content:'';?>
</div>

<!-- Main content ends -->
<?php require_once 'footer.php'; ?>


</div>
<?php require_once 'includes_bottom.php'; ?>

</body>

</html>