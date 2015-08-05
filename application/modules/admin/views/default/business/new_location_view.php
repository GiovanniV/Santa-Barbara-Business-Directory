<?php echo $this->session->flashdata('msg');?>
<h4>New <?php echo $type;?></h4>
<hr/>

<form action="<?php echo site_url('admin/business/savelocation');?>" method="post" id="save-location-form">
<input type="hidden" name="type" value="<?php echo $type;?>" />	
<?php if($type=='state' || $type=="city"){?>
<label>Select Country</label>
<select name="country" id="country" class="form-control country-<?php echo $type;?>">
	<option value=""> Select a country</option>
	<?php 
	foreach ($countries->result() as $row) {
		$sel = (set_value('country')==$row->id)?'selected="selected"':'';
		echo '<option value="'.$row->id.'" '.$sel.'>'.$row->name.'</option>';
	}
	?>
</select>	
<?php echo form_error('country');?>
<?php }?>

<?php if($type=="city"){?>
    <?php $state_active = get_settings('business_settings', 'show_state_province', 'yes'); ?>
    <?php if($state_active == 'yes'){ ?>
        <label>Select State</label>
        <select name="state" id="state" class="form-control state-drop">

        </select>
        <?php echo form_error('state');?>
    <?php } ?>

<?php }?>


<label><?php echo $type;?> names :</label>
<textarea class="form-control" style="height:260px;" name="locations" ></textarea>
<div class="alert alert-info">Put one or more <?php echo $type;?> name as "," (comma) separated. Like Newyork,Dallas,idaho</div>
<?php echo form_error('locations');?>
<div class="clearfix"></div>
<input type="submit" value="Save" class="btn btn-success" style="margin-top:10px;" >
</form>


<script type="text/javascript">
	jQuery('#save-location-form').submit(function(event){
		event.preventDefault();
		var loadUrl = jQuery(this).attr('action');
		jQuery("#location-model  .modal-body").html("Updating...");
		jQuery.post(
			loadUrl,
			jQuery(this).serialize(),
			function(responseText){
				jQuery("#location-model  .modal-body").html(responseText);
			},
			"html"
		);

	});


    var site_url = '<?php echo site_url();?>';
    jQuery('#country').change(function(){
        var val = jQuery(this).val();
        var loadUrl = site_url+'/show/get_locations_by_parent_ajax/'+val;
        jQuery.post(
            loadUrl,
            {},
            function(responseText){
                jQuery('#state').html(responseText);
                var sel_country = '<?php echo (set_value("country")!='')?set_value("country"):'';?>';
                var sel_state   = '<?php echo (set_value("state")!='')?set_value("state"):'';?>';
                if(val==sel_country)
                jQuery('#state').val(sel_state);
                else
                jQuery('#state').val('');
                jQuery('#state').focus();
                jQuery('#state').trigger('change');
            }
        );
     }).change();
</script>	