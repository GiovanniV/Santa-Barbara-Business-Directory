<link href="<?php echo theme_url();?>/assets/css/parallax-slider.css" rel="stylesheet">
<div class="parallax-slider">
    <div id="da-slider" class="da-slider">
        <?php
        $CI = get_instance();
        $CI->load->model('admin/slider_model');
        $slider_query = $CI->slider_model->get_all_posts_by_range('all','','slide_order');
        foreach ($slider_query->result() as $slide) 
        {
        ?>
        <div class="da-slide">
            <h2><span class="color"><?php echo $slide->title;?></span></h2>
            <p><?php echo $slide->description;?></p>
            <!--a href="index-parallax-slider.html#" class="da-link btn btn-color">Read more</a-->
            <div class="da-img"><img src="<?php echo get_slider_photo_by_name($slide->featured_img);?>" alt="image01" /></div>
        </div>
        <?php 
        }
        ?>        
        <nav class="da-arrows">
            <span class="da-arrows-prev"></span>
            <span class="da-arrows-next"></span>
        </nav>
    </div>
</div>
<!-- Parallax slider & Modernizr -->
<script src="<?php echo theme_url()?>/assets/js/modernizr.custom.28468.js"></script>
<script src="<?php echo theme_url()?>/assets/js/jquery.cslider.js"></script>

<script type="text/javascript">
    $('#da-slider').cslider({
        autoplay    : true,
        bgincrement : 150,
        interval	: 3000
    });
</script>