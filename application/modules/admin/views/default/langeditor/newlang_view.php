<div class="row">
	<div class="col-md-12">
		<div class="box">
			<div class="box-title">
				<h3><i class="fa fa-bars"></i> Create language</h3>
				<div class="box-tool">
					<a href="#" data-action="collapse"><i class="fa fa-chevron-up"></i></a>

				</div>
			</div>
			<div class="box-content">

				<form action="<?php echo site_url('admin/system/savelang');?>" method="post">
					<?php echo $this->session->flashdata('msg');?>
					<div class="form-group">
						<label class="col-sm-1 col-lg-1 control-label"><?php echo lang_key('language');?></label>
						<div class="col-sm-2 col-lg-3 controls">
							<input type="text" name="lang" value="<?php echo set_value('lang');?>" placeholder="<?php echo lang_key('type_something');?>" class="form-control" >
							<span class="help-inline">&nbsp;</span>
							<?php echo form_error('lang'); ?>
						</div>
					</div>
					<div class="clearfix"></div>
					<div class="form-group">
						<label class="col-sm-1 col-lg-1 control-label"><?php echo lang_key('short_name');?></label>
						<div class="col-sm-2 col-lg-3 controls">
							<input type="text" name="short_name" value="<?php echo set_value('short_name');?>" placeholder="<?php echo lang_key('type_something');?>" class="form-control" >
							<span class="help-inline">&nbsp;</span>
							<?php echo form_error('short_name'); ?>
						</div>
					</div>
					<div class="clearfix"></div>
					<label class="col-sm-1 col-lg-1 control-label"><?php echo lang_key('language');?></label> 
					<ol id="lang">
						<li>
							<div class="form-inline" style="margin-bottom:5px;">
							<input class="form-control" type="text" name="lang_key[]" placeholder="Lang Key">
							<input class="form-control" type="text" name="lang_text[]" placeholder="Lang Text">
							<a href="javascript:void(0);" class="remove" style="color:#F00;font-weight:bold;">X</a>
							</div>
						</li>
					</ol>
					<a href="javascript:void(0);" class="addanother btn btn-info" style="margin-left:25px;margin-bottom:5px;"><?php echo lang_key('add_another');?></a><br/>
					<button type="submit" class="btn btn-primary"><?php echo lang_key('save');?></button>
				</form>

			</div>
		</div>
	</div>
</div>					
<script type="text/javascript">
jQuery('.addanother').click(function(){
	jQuery('#lang').append('<li>'+
							'<div class="form-inline" style="margin-bottom:5px;">'+
							'<input class="form-control" type="text" name="lang_key[]" placeholder="Lang Key">'+
							'<input class="form-control" type="text" name=lang_text[] placeholder="Lang Text" style="margin-top:5px;">'+
							'<a href="javascript:void(0);" class="remove" style="margin-left:4px;color:#F00;font-weight:bold;">X</a></div></li>');
	jQuery('.remove').click(function(){
		jQuery(this).parent().parent().remove();
	});
});

jQuery('.remove').click(function(){
	jQuery(this).parent().parent().remove();
});
</script>