<?php
$curr_lang = get_current_lang();
$page_local_data = load_page_local_data($alias,$curr_lang);
$layout = get_page_layout($alias);
$page = $query->row_array();

if($page_local_data['status']==0)
{
	
	if(isset($page['content_from']) && $page['content_from']=='Manual')
	{
	    $sidebar = $page['sidebar'];
	    $content = $page['content'];
	    $status  = $page['status'];
	} 	
}
else
{
	$page_data = $page_local_data;
	$sidebar = $page_data['sidebar'];
    $content = $page_data['content'];
    $status  = $page_data['status'];
}
?>
 <!-- Page heading two starts -->
 <div class="page-heading-two">
	 <div class="container">
		 <h2><?php echo translate($page['title']); ?> </h2>
		 <div class="breads">
			 <a href="<?php echo site_url(); ?>"><?php echo lang_key('home'); ?></a> / <?php echo translate($page['title']); ?>
		 </div>
		 <div class="clearfix"></div>
	 </div>
 </div>
 <!-- Page heading two ends -->
 <div class="container">
	 <div class="row">
	 	<?php if($layout==0){?>
	 	<div class="col-md-3">
	 		<?php
				if(isset($sidebar) && $sidebar!='')
		        {
		            echo '<div class="page-sidebar">'.$sidebar.'</div>';
		        }
	 		?>
	 	</div>
	 	<?php }?>

	 	<div class="<?php echo ($layout==2)?'col-md-12':'col-md-9'?>"> 
			<?php 	
				if(isset($content)==FALSE)
				{
					?>
					<div class="alert alert-info">
			        <button data-dismiss="alert" class="close" type="button">×</button>
			        <strong><?php echo lang_key('oops'); ?> :(
				    </div>
					<?php
				}
				else
				{
					if($status!=1)
					{
						?>
						<div class="alert alert-info">
				        <button data-dismiss="alert" class="close" type="button">×</button>
				        <strong><?php echo lang_key('oops'); ?> :(
					    </div>
						<?php
					}
					else

						echo '<div class="page-sidebar">'.$content.'</div>';
				}
			?>
		</div>
		
		<?php if($layout==1){?>
		<div class="col-md-3">
	 		<?php

				if(isset($sidebar) && $sidebar!='')
		        {
		        	echo '<div class="page-sidebar">'.$sidebar.'</div>';
		        }
	 		?>
		</div>
		<?php }?>		

	</div>
 </div>

