<?php $CI = get_instance();?>
<div class="img-box-4 text-center">
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
    <div class="col-md-4 col-sm-6">
        <div class="img-box-4-item">
            <!-- Image style one starts -->

            <div class="image-style-one">
                <!-- Image -->
                <a href="<?php echo $detail_link;?>">
                    <img class="img-responsive" alt="" src="<?php echo get_featured_photo_by_id($post->featured_img);?>">                        <!-- image hover style for image #1 -->
                </a>

            </div>

            <div class="img-box-4-content">
                <?php if($post->featured == 1){ ?>
                    <span class="hot-tag" data-toggle="tooltip" data-placement="left" data-original-title="<?php echo lang_key('featured');?>"><i class="fa fa-bookmark"></i></span>


                <?php } ?>
                <?php
                $class = "fa ";
                
                    $class .= $CI->post_model->get_category_icon($post->category);
                
                if($i%4 == 1)
                    $class .= " bg-lblue";
                else if($i%4 == 2)
                    $class .= " bg-green";
                else if($i%4 == 3)
                    $class .= " bg-orange";
                else
                    $class .= " bg-red";
                ?>
                <a class="b-tooltip" title="<?php echo get_category_title_by_id($post->category); ?>" href="<?php echo site_url('show/categoryposts/'.$post->category.'/'.dbc_url_title(lang_key(get_category_title_by_id($post->category))));?>"><i class="category-fa-icon <?php echo $class;?>"></i></a>
                <small><?php echo get_category_title_by_id($post->category); ?></small>
                <h4 class="item-title"><a href="<?php echo $detail_link;?>"><?php echo get_post_data_by_lang($post,'title');?></a></h4>
                <div class="bor bg-red"></div>
                <div class="row">

                    <div class="col-xs-12 col-sm-12 col-md-12 info-dta info-price">
                        <?php $average_rating = $post->rating; ?>
                        <?php $half_star_position = check_half_star_position($average_rating); ?>
                        <?php echo get_review_with_half_stars($average_rating,$half_star_position);?>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-12 info-dta"><a href="<?php echo site_url('location-posts/'.$post->city.'/city/'.dbc_url_title(get_location_name_by_id($post->city)));?>"><?php echo get_location_name_by_id($post->city);?></a></div>
                </div>
                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-12 info-dta"><i class="fa fa-phone"></i> &nbsp;<?php echo $post->phone_no; ?></div>
                </div>
                <div class="clearfix"></div>
            </div>
        </div>
    </div>                

    <?php 
        }
    }
    ?>
</div>
<div class="clearfix"></div>
<?php echo (isset($pages))?'<ul class="pagination">'.$pages.'</ul>':'';?>