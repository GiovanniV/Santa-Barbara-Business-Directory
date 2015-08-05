<form action="<?php echo site_url('install/saveaccountsettings');?>" method="post">
<fieldset>
	<legend>Account setup:</legend>
	<?php echo $this->session->flashdata('msg');?> 
	<label>User Name :</label> 
	<input type="text" name="user_name" value="<?php if(set_value('user_name')!='')echo set_value('user_name');else echo 'admin';?>" placeholder="User Name" class="input-xxlarge" >
	<?php echo form_error('user_name'); ?>
	<label>First Name :</label> 
	<input type="text" name="first_name" value="<?php if(set_value('first_name')!='')echo set_value('first_name');else echo '';?>" placeholder="First Name" class="input-xxlarge" >
	<?php echo form_error('first_name'); ?>
	<label>Last Name :</label> 
	<input type="text" name="last_name" value="<?php if(set_value('last_name')!='')echo set_value('last_name');else echo '';?>" placeholder="Last Name" class="input-xxlarge" >
	<?php echo form_error('last_name'); ?>
	<label>Gender :</label>
	<select id="gender" name="gender">
		<option value="male">Male</option>
		<option value="female">Female</option>
	</select> 
	<?php echo form_error('gender'); ?>
	
	<label>User Email :</label> 
	<input type="text" name="user_email" value="<?php if(set_value('user_email')!='')echo set_value('user_email');else echo '';?>" placeholder="User Email" class="input-xxlarge" >
	<?php echo form_error('user_email'); ?>
	<label>User Password :</label> 
	<input type="password"  name="password" class="input-xxlarge" >
	<?php echo form_error('password'); ?>
	<label>Retype Password :</label> 
	<input type="password" name="re_password" class="input-xxlarge" >
	<?php echo form_error('re_password'); ?>
	<label>Encryption Key :</label> 
	<input type="text" name="enc_key" value="<?php if(set_value('enc_key')!='')echo set_value('enc_key');else echo 'dbc';?>" class="input-xxlarge" >
	<?php echo form_error('enc_key'); ?>	
    <div style="clear:both;"></div> 
<button type="submit" class="btn btn-success">Save & Next</button>
</fieldset>
</form>