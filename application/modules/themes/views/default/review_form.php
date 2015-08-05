
<div class="review-panel">
    <form id="review-form" method="post" action="<?php echo site_url('show/review/create_review');?>" role="form">
        <input type="hidden" value="<?php echo $post_id; ?>" name="post_id">

        <div class="form-group">
            <label for="enquiryInput3"><?php echo lang_key('rating');?> : </label>
            <div class="clearfix"></div>
            <input type="hidden" class="form-control" id="rating" name="rating" value="0">
            <ul class="rating-input stars">
                <li class="star-1 fa fa-star" star="1"></li>
                <li class="star-2 fa fa-star" star="2"></li>
                <li class="star-3 fa fa-star" star="3"></li>
                <li class="star-4 fa fa-star" star="4"></li>
                <li class="star-5 fa fa-star" star="5"></li>
            </ul>
            <div class="clearfix"></div>
        </div>
        <div class="form-group">
            <label for="enquiryInput4"><?php echo lang_key('comment');?></label>
            <textarea class="form-control" id="comment" name="comment" placeholder="<?php echo lang_key('comment');?>" rows="7"></textarea>
            <?php echo form_error('comment');?>
        </div>



        <div class="clear-top-margin"></div>
        <button type="submit" class="btn btn-color"><?php echo lang_key('submit_review'); ?></button> &nbsp; <button type="submit" class="btn btn-white"><?php echo lang_key('reset'); ?></button>
    </form>
</div>

<script type="text/javascript">
    jQuery(document).ready(function(){
        jQuery('.rating-input > li').hover(function(e){
            e.preventDefault();
            var curr_li = parseInt(jQuery(this).attr('star'));
            jQuery('#rating').val(curr_li);

            jQuery('.rating-input > li').each(function(){
                if(parseInt(jQuery(this).attr('star'))<=curr_li)
                {
                    jQuery(this).addClass('active');
                }
                else
                {
                    jQuery(this).removeClass('active');
                }
            });
        });
    });
</script>