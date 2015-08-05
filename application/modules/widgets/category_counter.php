<?php
$CI = get_instance();
$CI->load->model('user/post_model');
$parent_categories = $CI->post_model->get_all_parent_categories();
?>
<div class="counter-four">
						<div class="counter-content">
								<?php $i = 0;
								foreach ($parent_categories->result() as $parent) {
								$i++;
								?>
									<?php
									$class = '';
									if($i%4 == 1)
										$class = "lblue";
									else if($i%4 == 2)
										$class = "green";
									else if($i%4 == 3)
										$class = "orange";
									else
										$class = "red";
									?>
								<div class="col-md-4 col-sm-4 col-xs-12">
									<!-- counter item -->
									<div class="counter-item">
										<a href="<?php echo site_url('show/categoryposts/'.$parent->id.'/'.dbc_url_title(lang_key($parent->title)));?>">
										<i class="fa <?php echo $parent->fa_icon.' '.$class;?>"></i>
										</a>
										<!-- Heading -->
										<h4><span class="number-count" data-from="0" data-to="<?php echo $CI->post_model->count_post_by_category_id($parent->id);?>" data-speed="800" data-refresh-interval="50"></span></h4>
										<!-- Paragraph -->
										<h6><?php echo lang_key($parent->title); ?></h6>
										<div class="clearfix"></div>
									</div>
								</div>
								<?php } ?>

						<div class="clearfix"></div>
					</div>

</div>
<script type="text/javascript">
	<!-- Counting code -->
	$(document).ready(function(){
		// Way Points With Count To()
		$('.number-count').waypoint(function(down){
			if(!$(this).hasClass('stop-counter'))
			{
				$(this).countTo();
				$(this).addClass('stop-counter');
			}
		}, {
			offset: '90%'
		});
	});
</script>