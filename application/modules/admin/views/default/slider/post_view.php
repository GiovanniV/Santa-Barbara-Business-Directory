<div class="row">

  <div class="col-md-12">

	<form action="<?php echo site_url('admin/slider/add');?>" method="post">

    <div class="box">

      <div class="box-title">

        <h3><i class="fa fa-bars"></i> <?php echo $title;?></h3>

        <div class="box-tool">

          <a href="#" data-action="collapse"><i class="fa fa-chevron-up"></i></a>



        </div>

      </div>

      <div class="box-content">





		<input type="hidden" id="action" name="action" value="1">

		<input type="hidden" name="action_type" value="<?php echo (isset($action_type))?$action_type:'insert';?>">

		<?php if(isset($page) && isset($page->id)){?>

		<input type="hidden" name="id" value="<?php echo $page->id;?>">

		<?php }?>

		<?php echo $this->session->flashdata('msg');?>

		<div class="form-group">
			<div class="col-sm-12 col-md-12 col-lg-12">
				<input type="submit" value="Draft" class="btn btn-primary submit" action="2">

				<input type="submit" value="Publish" class="btn btn-success submit" action="1">

				<input type="submit" value="Delete" class="btn btn-danger submit" action="0">
			</div>
		</div>	

		<div style="margin-bottom:20px;"></div>



		<?php 

			$title = '';

			if(set_value('title')!='')

				$title = set_value('title');

			else if(isset($page) && isset($page->title))

				$title = $page->title;

		?>

		<div class="form-group">

			<label class="col-sm12 col-lg-12 control-label"><?php echo lang_key('title');?></label>

			<div class="col-sm-12 col-lg-12 controls">

				<input type="text" class="form-control" name="title" id="title" value="<?php echo $title;?>" placeholder="<?php echo lang_key('type_something');?>" />

				<span class="help-inline">&nbsp;</span>

				<?php echo form_error('title'); ?>

			</div>

		</div>

		<div style="clear:both"></div>

		<div class="form-group">

			<label class="col-sm-12 col-lg-12 control-label"><?php echo lang_key('content');?></label>

			<div class="col-sm-12 col-lg-12 controls">

				<?php 

					$description = '';

					if(set_value('description')!='')

						$description = set_value('description');

					else if(isset($page) && isset($page->description))

						$description = $page->description;

				?>		

				<textarea name="description" class="form-control" style="height:170px"><?php echo $description;?></textarea>

				<span class="help-inline">&nbsp;</span>

				<?php echo form_error('description'); ?>

			</div>

		</div>



		<div style="clear:both"></div>	
            
        <div class="form-group">
            <label class="col-sm-3 col-lg-2 control-label">&nbsp;</label>
            <div class="col-sm-4 col-lg-5 controls">
                <img class="thumbnail" id="featured_photo" src="<?php echo get_featured_photo_by_id('');?>" style="width:256px;">
            </div>
            <div class="clearfix"></div>                   
            <span id="featured-photo-error"></span> 
        </div>

        <div class="form-group">
            <label class="col-sm-3 col-lg-2 control-label"><?php echo lang_key('featured_image');?>:</label>
            <div class="col-sm-4 col-lg-5 controls">  
            	<?php $featured_img = (isset($page->featured_img))?$page->featured_img:'';?>                  
            	<?php $v = (set_value('featured_img')!='')?set_value('featured_img'):$featured_img;?>
                <input type="hidden" name="featured_img" id="featured_photo_input" value="<?php echo $v;?>">                    
                <iframe src="<?php echo site_url('admin/slider/featuredimguploader');?>" style="border:0;margin:0;padding:0;height:130px;"></iframe>
                <?php echo form_error('featured_img');?>
            </div>          
        </div>
        <div class="clearfix"></div>

        <?php 

			$slide_order = '';

			if(set_value('slide_order')!='')

				$slide_order = set_value('slide_order');

			else if(isset($page) && isset($page->slide_order))

				$slide_order = $page->slide_order;

		?>

		<div class="form-group">

			<label class="col-sm12 col-lg-12 control-label"><?php echo lang_key('slide_order');?></label>

			<div class="col-sm-12 col-lg-12 controls">

				<input type="text" class="form-control" name="slide_order" id="slide_order" value="<?php echo $slide_order;?>" placeholder="<?php echo lang_key('type_something');?>" />

				<span class="help-inline">&nbsp;</span>

				<?php echo form_error('slide_order'); ?>

			</div>

		</div>

		<div style="clear:both"></div>


		<div class="form-group">
			<div class="col-sm-12 col-md-12 col-lg-12">
				<input type="submit" value="Draft" class="btn btn-primary submit" action="2">

				<input type="submit" value="Publish" class="btn btn-success submit" action="1">

				<input type="submit" value="Delete" class="btn btn-danger submit" action="0">
			</div>
		</div>	

		<div style="margin-bottom:20px;"></div>


	 </div>
    </div>



	</form>

  </div>

</div>



<script type="text/javascript" src="<?php echo base_url('assets/tinymce/tinymce.min.js');?>"></script>

<script type="text/javascript">

var base_url = '<?php echo base_url();?>';
jQuery(document).ready(function(){

	jQuery('#featured_photo_input').change(function(){
        var val = jQuery(this).val();
        if(val!='')
        {
          var src = base_url+'uploads/slider/'+val;            
        }
        else
        {
          var src = base_url+'assets/admin/img/preview.jpg'
        }
        jQuery('#featured_photo').attr('src',src);
    }).change();

	jQuery('#layout').trigger('change');

	jQuery('.submit').click(function(e){

		jQuery('#action').val(jQuery(this).attr('action'));

	});


});


</script>

