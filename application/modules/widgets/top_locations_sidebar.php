<?php
$CI = get_instance();
$CI->load->database();
$CI->db->where('status',1);
$CI->db->select('city, COUNT(city) as total');
$CI->db->group_by('city');
$CI->db->order_by('total', 'desc');
$CI->db->limit(10);
$query = $CI->db->get('posts');
?>
<div class="s-widget">
    <!-- Heading -->
    <h5><i class="fa fa-map-marker color"></i>&nbsp; <?php echo lang_key('top_locations') ?></h5>
    <!-- Widgets Content -->

    <div class="widget-content categories">
        <ul class="list-6">
            <?php foreach ($query->result() as $post) { ?>
                <li class="col-xs-12 col-sm-6 col-md-12 col-lg-12">
                    <a href="<?php echo site_url('location-posts/'.$post->city.'/city/'.dbc_url_title(get_location_name_by_id($post->city)));?>">
                    <?php echo get_location_name_by_id($post->city); ?> 
                        <span class="color">(<?php echo $post->total;?>)</span>
                    </a>
                </li>
            <?php } ?>
        </ul>
    </div>
</div>
<div style="clear:both"></div>