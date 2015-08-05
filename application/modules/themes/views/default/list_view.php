<?php $CI = get_instance();?>
<div class="blog-one">
	<?php
	if($posts->num_rows()<=0)
	{
		echo '<div class="alert alert-info">'.lang_key('no_posts').'</div>';
	}
	else
	{
    $i = 0;
    foreach($posts->result() as $post){
        $i++;
        $detail_link = post_detail_url($post);
    ?>

    <div class="blog-one-item row">
		<!-- blog One Img -->
		<div class="blog-one-img col-md-3 col-sm-3 col-xs-12">
			<!-- Image -->
			<a href="<?php echo $detail_link;?>">
				<div class="image-style-one">
				<?php if($post->featured == 1){ ?>
                    <span class="hot-tag-list" data-toggle="tooltip" data-placement="left" data-original-title="<?php echo lang_key('featured');?>"><i class="fa fa-bookmark"></i></span>
                <?php } ?>
				<img class="img-responsive img-thumbnail" alt="<?php echo get_post_data_by_lang($post,'title');?>" src="<?php echo get_featured_photo_by_id($post->featured_img);?>">
                </div>
			</a>
		</div>
		<!-- blog One Content -->
		<div class="blog-one-content col-md-9 col-sm-9 col-xs-12">
			<!-- Heading -->
			<h3><a href="<?php echo $detail_link;?>"><?php echo get_post_data_by_lang($post,'title');?></a>
				<?php $average_rating = $post->rating; ?>
				<?php $half_star_position = check_half_star_position($average_rating); ?>
				<?php echo get_review_with_half_stars($average_rating,$half_star_position);?>
			</h3>
			<!-- Blog meta -->
			<div class="blog-meta">
				<!-- Date -->
				<a href="//<?php echo $post->website; ?>" target="_blank"><i class="fa fa-link"></i> &nbsp; <?php echo $post->website; ?></a> &nbsp;
				<!-- Author -->
				<a href="<?php echo site_url('show/categoryposts/'.$post->category.'/'.dbc_url_title(lang_key(get_category_title_by_id($post->category))));?>"><i class="fa <?php echo get_category_fa_icon($post->category); ?>"></i> &nbsp; <?php echo get_category_title_by_id($post->category); ?></a> &nbsp;
				<!-- Comments -->
				<a href="<?php echo site_url('location-posts/'.$post->city.'/city/'.dbc_url_title(get_location_name_by_id($post->city)));?>"><i class="fa fa-map-marker"></i> &nbsp; <?php echo get_location_name_by_id($post->city);?></a> &nbsp;

				<i class="fa fa-phone"></i> &nbsp; <?php echo $post->phone_no; ?>
			</div>
			<!-- Paragraph -->
			<p><?php echo truncate(strip_tags(get_post_data_by_lang($post,'description')),200,'',false);?></p>
		</div>
		<div class="clearfix"></div>
	</div>
	<?php
		}
	}
	?>

</div>
<div class="clearfix"></div>
<?php echo (isset($pages))?'<ul class="pagination">'.$pages.'</ul>':'';?>