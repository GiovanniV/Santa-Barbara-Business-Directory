<?php
$CI = get_instance();
$CI->load->model('user/post_model');
$parent_categories = $CI->post_model->get_all_parent_categories();
?>

<div class="block-heading-two">
    <h3><span><i class="fa fa-folder"></i> <?php echo lang_key('categories') ?></span></h3>
</div>
<?php
$i = 0;
foreach ($parent_categories->result() as $parent) {
$i++;
?>
<div class="category-box col-md-4 col-sm-4" style="height: 256px;margin-bottom:30px;">
    <?php
    $class = '';
    if($i%4 == 1)
        $class = "blue";
    else if($i%4 == 2)
        $class = "blue";
    else if($i%4 == 3)
        $class = "blue";
    else
        $class = "blue";
    ?>
    <header class="category-header bg-<?php echo $class;?> clearfix">
        <a href="<?php echo site_url('show/categoryposts/'.$parent->id.'/'.dbc_url_title(lang_key($parent->title)));?>">
            <div class="category-icon"><i class="fa <?php echo $parent->fa_icon;?>"></i></div>
            <div class="category-title">
                <h5><?php echo lang_key($parent->title);?></h5>
                <strong class="count">(<?php echo $CI->post_model->count_post_by_category_id($parent->id);?>)</strong>
            </div>
        </a>
    </header>
    <div class="img-box-6-item category-thumb-img">
        <!-- Image Box #6 Image -->
        <div class="image-style-one">
            <!-- Image -->
            <a href="<?php echo site_url('show/categoryposts/'.$parent->id.'/'.dbc_url_title(lang_key($parent->title)));?>">    <img src="<?php echo get_featured_photo_by_id($parent->featured_img); ?>" alt="" class="img-responsive">
            </a>
        </div>
    </div>
</div>
<?php }?>
<div class="clearfix"></div>
