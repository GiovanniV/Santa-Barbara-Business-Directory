<?php
$CI = get_instance();
$CI->load->database();
$CI->db->where('status',1);
$CI->db->select('city, COUNT(city) as total');
$CI->db->group_by('city');
$CI->db->order_by('total', 'desc');
$CI->db->limit(12);
$query = $CI->db->get('posts');
?>
<div class="block-heading-two">
    <h3><span><i class="fa fa-map-marker"></i> <?php echo lang_key('top_locations'); ?></span>

    </h3>
</div>
<span class="location-widget">
    <?php foreach ($query->result() as $post) { ?>
            <div class="col-md-3 col-sm-3">
                <ul class="list-10">
                    <li><a href="<?php echo site_url('location-posts/'.$post->city.'/city/'.dbc_url_title(get_location_name_by_id($post->city)));?>"><?php echo get_location_name_by_id($post->city); ?> <span class="color" dir="rtl">(<?php echo $post->total; ?>)</span></a></li>
                </ul>
            </div>

    <?php } ?>

    <div class="clearfix"></div>
</span>

