<form action="<?php echo site_url('install/savedbsettings');?>" method="post">
<fieldset>
	<legend>Database setup:</legend> 
	<?php echo $this->session->flashdata('msg');?>
	<label>DB Host :</label> 
	<input type="text" name="db_host" value="<?php if(set_value('db_host')!='')echo set_value('db_host');else echo 'localhost';?>" placeholder="Db Host" class="input-xxlarge" >
	<?php echo form_error('db_host'); ?>
	<label>DB UserName :</label> 
	<input type="text" name="db_user" value="<?php if(set_value('db_user')!='')echo set_value('db_user');else echo 'root';?>" placeholder="Db Username" class="input-xxlarge" >
	<?php echo form_error('db_user'); ?>
	<label>DB Password :</label> 
	<input type="text" name="db_pass" value="<?php if(set_value('db_pass')!='')echo set_value('db_pass');else echo '1234';?>" placeholder="" class="input-xxlarge" >
	<?php echo form_error('db_pass'); ?>
	<label>DB Name :</label> 
	<input type="text" name="db_name" value="<?php if(set_value('db_name')!='')echo set_value('db_name');else echo 'bizdir';?>" placeholder="Db name" class="input-xxlarge" >
	<?php echo form_error('db_name'); ?>
	<label>DB Table Prefix :</label> 
	<input type="text" name="db_prefix" value="<?php if(set_value('db_prefix')!='')echo set_value('db_prefix');else echo 'dbc_';?>" placeholder="Db tableprefix" class="input-xxlarge" >
	<?php echo form_error('db_prefix'); ?>
    
    <div style="clear:both;"></div> 
<button type="submit" class="btn btn-success">Save & Next</button>
</fieldset>
</form>