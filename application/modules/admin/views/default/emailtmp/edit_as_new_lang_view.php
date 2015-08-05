<fieldset>
	<legend>Select Language & file</legend> 
	<label>Select Lang File</label> 
	<select name="sel_lang" id="sel_lang">
		<?php foreach($all_langs->result() as $row){?>
		<option value="<?php echo $row->id;?>"><?php echo $row->lang.' - '.$row->file;?></option>
		<?php }?>
	</select>
	<div style="clear:both;"></div>
	<?php $row = $all_langs->row();?>
	<a id="sel_lang_form" href="<?php echo site_url('admin/system/editlang/'.$row->id);?>" class="btn">Edit</a>
	<a id="edit_as_new_lang" href="<?php echo site_url('admin/system/editasnewlang/'.$row->id);?>" class="btn">Edit As New</a>
	<a id="delete_lang" href="<?php echo site_url('admin/system/deletelang/'.$row->id);?>" class="btn">Delete</a>
</fieldset>

<script type="text/javascript">
jQuery('#sel_lang').change(function(){
	jQuery('#sel_lang_form').attr('href',"<?php echo site_url('admin/system/editlang');?>"+"/"+jQuery(this).val());
	jQuery('#sel_lang_form').attr('href',"<?php echo site_url('admin/system/editasnewlang');?>"+"/"+jQuery(this).val());
	jQuery('#delete_lang').attr('href',"<?php echo site_url('admin/system/deletelang');?>"+"/"+jQuery(this).val());
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
<form action="<?php echo site_url('admin/system/addlang');?>" method="post">
<fieldset>
	<legend>New Lang File</legend> 
	<?php echo $this->session->flashdata('msg');?>
	<label>Lang</label> 
	<input type="text" name="lang" value="" placeholder="Your new Language name" class="input-xxlarge" ><?php echo form_error('title'); ?>
	<label>File</label> 
	<input readonly="readonly" type="text" name="file" value="<?php echo (isset($row->file))?$row->file:set_value('file');?>" placeholder="Type somethin" class="input-xxlarge" ><?php echo form_error('title'); ?>
	<label>Language</label> 
	<ol id="lang">
		<?php foreach($values as $key=>$val){?>
		<li>
			<div class="form-inline" style="margin-bottom:5px;">
			<input readonly="readonly" class="input-medium" style="margin-bottom:5px;" type="text" name="lang_key[]" value="<?php echo $key;?>" placeholder="Lang Key">
			<input class="input-medium" style="margin-bottom:5px;" type="text" name="lang_text[]" value="<?php echo $val;?>" placeholder="Lang Text">
			</div>
		</li>
		<?php }?>
	</ol>
<button type="submit" class="btn btn-primary">Save</button>
</fieldset>
</form>
<?php 
}
?>