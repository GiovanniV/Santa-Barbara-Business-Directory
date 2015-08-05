<div class="row">

	<div class="col-md-12">

		<div class="box">

			<div class="box-title">

				<h3><i class="fa fa-bars"></i> <?php echo lang_key('select_language');?>/h3>

				<div class="box-tool">

					<a href="#" data-action="collapse"><i class="fa fa-chevron-up"></i></a>



				</div>

			</div>

			<div class="box-content">

				<label><?php echo lang_key('select_language_file');?></label> 

				<select name="sel_lang" id="sel_lang" class="form-control input-sm">
					
					<?php foreach($all_langs->result() as $row){
							$sel = ($this->uri->segment(5)==$row->id)?'selected="selected"':'';
						?>

					<option value="<?php echo $row->id;?>" <?php echo $sel;?>><?php echo $row->lang.' - '.$row->short_name;?></option>

					<?php }?>

				</select>

				<div style="clear:both;margin-top:20px;"></div>

				<?php $row = $all_langs->row();?>

				<a id="sel_lang_form" href="<?php echo site_url('admin/system/editlang/'.$row->id);?>" class="btn btn-primary"><?php echo lang_key('edit');?></a>

				<!--a id="edit_as_new_lang" href="<?php echo site_url('admin/system/editasnewlang/'.$row->id);?>" class="btn btn-info">Edit As New</a-->

				<a id="delete_lang" href="<?php echo site_url('admin/system/deletelang/'.$row->id);?>" class="btn btn-danger"><?php echo lang_key('delete');?></a>

				<a id="export_file" href="<?php echo site_url('admin/system/exportlangfile/'.$row->id);?>" class="btn btn-info"><?php echo lang_key('export_to_file');?></a>

				<a id="import_file" href="<?php echo site_url('admin/system/importlangfile/'.$row->id);?>" class="btn btn-warning"><?php echo lang_key('import_from_file');?></a>

			</div>

		</div>

	</div>

</div>	







<script type="text/javascript">

jQuery('#sel_lang').change(function(){

	jQuery('#sel_lang_form').attr('href',"<?php echo site_url('admin/system/editlang');?>"+"/"+jQuery(this).val());

	jQuery('#edit_as_new_lang').attr('href',"<?php echo site_url('admin/system/editasnewlang');?>"+"/"+jQuery(this).val());

	jQuery('#delete_lang').attr('href',"<?php echo site_url('admin/system/deletelang');?>"+"/"+jQuery(this).val());

	jQuery('#export_file').attr('href',"<?php echo site_url('admin/system/exportlangfile');?>"+"/"+jQuery(this).val());

	jQuery('#import_file').attr('href',"<?php echo site_url('admin/system/importlangfile');?>"+"/"+jQuery(this).val());

});

</script>



<?php 

if($lang->num_rows()<=0)

{

	echo '<div class="alert alert-info input-xxlarge" style="margin-top:20px;">Select a lang file and click edit</div>';

}

else

{

	$row = $lang->row();

	$values = json_decode($row->values);

?>



<div style="clear:both;margin-top:30px;"></div>



<div class="row">

	<div class="col-md-12">

		<div class="box">

			<div class="box-title">

				<h3><i class="fa fa-bars"></i> Edit language</h3>

				<div class="box-tool">

					<a href="#" data-action="collapse"><i class="fa fa-chevron-up"></i></a>



				</div>

			</div>

			<div class="box-content">



				<form action="<?php echo site_url('admin/system/updatelang');?>" method="post">

					<?php echo $this->session->flashdata('msg');?>

					<input type="hidden" name="id" value="<?php echo $row->id;?>" />



					<label><b>Language :</b> 

						<?php echo (isset($row->lang))?$row->lang:set_value('lang');?>, <b>Short name :</b> <?php echo (isset($row->short_name))?$row->short_name:set_value('short_name');?></label> 

						<input type="hidden" name="lang" value="<?php echo (isset($row->lang))?$row->lang:set_value('lang');?>">

						<?php echo form_error('lang'); ?>

						<input type="hidden" name="short_name" value="<?php echo (isset($row->short_name))?$row->short_name:set_value('short_name');?>" >

						<?php echo form_error('short_name'); ?>

					<div class="clearfix" style="margin-top:30px;"></div>



					<ol id="lang">

						<?php foreach($values as $key=>$val){?>

						<li>

							<div class="form-inline" style="margin-bottom:5px;">

							<input class="form-control" style="margin-bottom:5px;" type="text" name="lang_key[]" value="<?php echo $key;?>" placeholder="Lang Key">

							<input class="form-control" style="margin-bottom:5px;" type="text" name="lang_text[]" value="<?php echo strip_tags($val);?>" placeholder="Lang Text">

							</div>

						</li>

						<?php }?>

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

<?php 

}

?>