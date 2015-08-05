<!-- Bootstrap 3 Plan styles -->
<link id="plan-theme" href="<?php echo base_url();?>assets/admin/css/bootstrap.min.css" rel="stylesheet">
<script src="<?php echo base_url();?>assets/admin/js/jquery.min.js"></script>
<script>window.jQuery || document.write('<script src="<?php echo base_url();?>assets/admin/js/jquery.js">\x3C/script>')</script>
<script src="<?php echo base_url();?>assets/admin/js/jquery.form.js"></script>
<style type="text/css">
body{
	background-color: #fff;
}
</style>

<div id="trainingrecords-attachments" target=".trainingrecords-attachment-list">
	<div class="progress span3" style="display:none;margin:2px;padding:2px;">
	    <div class="bar"></div >
	    <div class="percent">0%</div >
	</div>

	<form action="<?php echo site_url('admin/blog/uploadfeaturedfile');?>" method="post" enctype="multipart/form-data">
	    <ol class="filelist">
	    </ol>	
	    	<input type="file" name="photoimg" style="height:auto;" >
	        <input type="submit" class="btn btn-info" value="Upload" style="margin-top:10px;">
	</form>    
<div class="status"></div>
</div>
<script type="text/javascript">
jQuery(document).ready(function(){
	var tab = 'trainingrecords-attachments';
	var target = jQuery('#'+tab).attr('target');
	var bar = jQuery('#'+tab+' > .progress > .bar');
	var percent = jQuery('#'+tab+' > .progress > .percent');
	var progress = jQuery('#'+tab+' > .progress');   
	jQuery('#'+tab+' > form').ajaxForm({
	    beforeSend: function() {
	        progress.show();
	        var percentVal = '0%';
	        bar.width(percentVal)
	        percent.html(percentVal);
	    },
	    uploadProgress: function(event, position, total, percentComplete) {
	        var percentVal = percentComplete + '%';
	        bar.width(percentVal)
	        percent.html(percentVal);
			//console.log(percentVal, position, total);
	    },
	    success: function() {
	        var percentVal = '100%';
	        bar.width(percentVal)
	        percent.html(percentVal);
	    },
		complete: function(xhr) {
			//alert(xhr.responseText);
			var response = jQuery.parseJSON(xhr.responseText);
			if(response.error==0)
			{
				var base_url = "<?php echo base_url();?>uploads/";
				//window.parent.jQuery('#featured_photo_input').attr("value",response.name);
				window.parent.jQuery('#featured_photo_input').attr("value",response.name);
				window.parent.jQuery('#featured_photo_input').trigger('change');
			}
			else
			{
				if(response.error=='upload_invalid_min_dimensions')
					response.error = 'Image needs to be minimum 256x256 px';
				var error = '<label class="col-sm-3 col-lg-2">&nbsp;</label><div class="col-sm-4 col-lg-5"><div class="alert alert-danger" style="margin-bottom:0;">'+response.error+'</div></div>';
				window.parent.jQuery('#featured-photo-error').html(error);
			}


			var percentVal = '0%';
			bar.width(percentVal)
	        percent.html(percentVal);
	        progress.hide();
			//status.html(xhr.responseText);
		}
	});
});
</script>
