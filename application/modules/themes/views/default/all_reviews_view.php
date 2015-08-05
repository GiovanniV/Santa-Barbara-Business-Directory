<?php 
$post_id = (isset($post_id))?$post_id:$post->id;
$reviews = get_all_post_reviews($post_id); 
$i=1;
foreach($reviews->result() as $review)
{
$i++;
 ?>

 <div class="row review-<?php echo $i;?>">

     <div class="col-md-2 col-xs-12">
         <a href="<?php echo site_url('profile/'.$review->created_by.'/'.get_user_fullname_by_id($review->created_by));?>">
             <img alt="user-image" src="<?php echo get_profile_photo_by_id($review->created_by); ?>" class="img-responsive user-img">
         </a>
     </div>
     <div class="col-md-10 col-xs-12">
         <h4><?php echo get_user_fullname_by_id($review->created_by); ?></h4>
         <p class="contact-types">
             <?php echo get_review_stars($review->rating);?>
         <div class="clearfix"></div>
         <strong><?php echo lang_key('posted_on');?>:</strong> <?php echo date('D, M d, Y', $review->create_time); ?>
         </p>
         <p><?php echo truncate(strip_tags($review->comment),200,'&nbsp;<a class="review-detail" href="'.site_url('show/reviewdetail/'.$review->id).'">'.lang_key('review_detail').'</a>',false);?></p>
     </div>

 </div>
 <hr/>
<?php
}
?>