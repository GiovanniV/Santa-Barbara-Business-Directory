<div class="row">

    <div class="col-md-2">
        <a href="http://localhost/businessdirectory/index.php/en/profile/1/Saad Naufel">
            <img alt="user-image" src="<?php echo get_profile_photo_by_id($review->created_by); ?>" class="img-responsive user-img">
        </a>
    </div>
    <div class="col-md-10">
        <h4><?php echo get_user_fullname_by_id($review->created_by); ?></h4>
        <p class="contact-types">
        <?php echo get_review_stars($review->rating);?>

        <div class="clearfix"></div>
        <strong><?php echo lang_key('posted_on');?>:</strong> <?php echo date('D, M d, Y', $review->create_time); ?>
        </p>
        <p><?php echo $review->comment; ?></p>
    </div>

</div>