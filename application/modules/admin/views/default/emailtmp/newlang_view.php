<form action="<?php echo site_url('admin/system/savelang');?>" method="post">
<fieldset>
	<legend>New Lang File</legend> 
	<?php echo $this->session->flashdata('msg');?>
	<label>Lang</label> 
	<input type="text" name="lang" value="<?php echo set_value('lang');?>" placeholder="Type somethin" class="input-xxlarge" ><?php echo form_error('title'); ?>
	<label>File</label> 
	<input type="text" name="file" value="<?php echo set_value('file');?>" placeholder="Type somethin" class="input-xxlarge" ><?php echo form_error('title'); ?>
	<label>Language</label> 
	<ol id="lang">
		<li>
			<input class="span2" type="text" name="lang_key[]" placeholder="Lang Key">
			<input class="span3" type="text" name="lang_text[]" placeholder="Lang Text">
			<a href="javascript:void(0);" class="remove" style="color:#F00;font-weight:bold;">X</a>
		</li>
	</ol>
	<a href="javascript:void(0);" class="addanother btn btn-primary" style="margin-left:25px;margin-bottom:5px;">Add another</a><br/>
<button type="submit" class="btn">Save</button>
</fieldset>
</form>
<script type="text/javascript">
jQuery('.addanother').click(function(){
	jQuery('#lang').append('<li>'+
							'<input class="span2" type="text" name="lang_key[]" placeholder="Lang Key">'+
							'<input class="span3" type="text" name=lang_text[] placeholder="Lang Text" placeholder=".span1" style="margin-left:4px;">'+
							'<a href="javascript:void(0);" class="remove" style="margin-left:4px;color:#F00;font-weight:bold;">X</a></li>');
	jQuery('.remove').click(function(){
		jQuery(this).parent().remove();
	});
});

jQuery('.remove').click(function(){
	jQuery(this).parent().remove();
});
</script>