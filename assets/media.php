  	<div id="myModal" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">

	<div class="modal-header" style="padding: 0 15px;">

	<button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>

	<h6 id="myModalLabel">Media Manager</h6>

	</div>

	<div class="modal-body">

		<ul class="nav nav-tabs" id="myTab">

	    	<li class="active"><a href="#upload" data-toggle="tab">Upload</a></li>

	    	<li><a href="#gallery" data-toggle="tab">Gallery</a></li>

	    </ul>

	    

	    <div class="tab-conten" id="myTabConten" style="min-height:300px;">

            <div id="upload" class="tab-pane fade in active">

            	<form id="imageform" method="post" enctype="multipart/form-data" action='<?php echo site_url('media/upload');?>'>

            					

					<div style="position:relative;">

					<a class="btn" href="javascript:void(0);">

						Choose File...

						<input type="file" name="photoimg" id="photoimg" style='position:absolute;z-index:2;top:0;left:0;filter: alpha(opacity=0);-ms-filter:"progid:DXImageTransform.Microsoft.Alpha(Opacity=0)";opacity:0;background-color:transparent;color:transparent;' name="file_source" size="40"  onchange='jQuery("#upload-file-info").html(jQuery(this).val());'>

					</a>

					<br/>

					<span class="label label-info" id="upload-file-info" style="width:300px;"></span>

					</div>					

				</form>

				<div id="preview_panel">

				<div id="preview" style="margin:15px 0;">

				</div>

				<button class="btn primary useimg" style="display:none;">Use this</button>

				</div>				

            </div>

            <div id="gallery" class="tab-pane fade">

            </div>

       </div>

       

	</div>

	<div class="modal-footer">

<!--	<button class="btn" data-dismiss="modal" aria-hidden="true">Close</button>-->

<!--	<button class="btn btn-primary">Save changes</button>-->

	</div>

	</div>



	<script type="text/javascript">

	var target = '';

	jQuery('.mediaupload').click(function(e){

		e.preventDefault();

		target = jQuery(this).attr('target');

		jQuery('#myModal').modal('show');

	});



	jQuery('#myTab a').click(function (e) {

        e.preventDefault();

        if(jQuery(this).attr('href')=='#upload')

		{

        	jQuery('#imageform').show();

        	jQuery('#preview_panel').show();

        	jQuery('#gallery').hide();

		}

        else if(jQuery(this).attr('href')=='#gallery')

		{

			jQuery('#imageform').hide();

        	jQuery('#preview_panel').hide();

			

			jQuery('#gallery').show();

			

			jQuery.ajaxSetup ({

				cache: false

			});

			var ajax_load = "Loading...";

			var loadUrl = "<?php echo site_url();?>/media/allmedias";

			jQuery("#gallery")

					.html(ajax_load)

					.load(loadUrl);			

		}

        jQuery(this).tab('show');

    });

    

    jQuery('.useimg').click(function(){

    	jQuery('#'+target).val(img);

    	jQuery('#'+target+'_preview').html('<img src="<?php echo base_url('assets/images/thumb')?>/'+img+'" alt="Uploading...."//>');

		jQuery('#myModal').modal('hide');

    });



    jQuery(document).ready(function(){		

		jQuery('#photoimg').change(function(){

			jQuery("#preview").html('');

			jQuery("#preview").html('Uploading..');

			jQuery("#imageform").ajaxForm({

				target: '#preview'

			}).submit();

			

		});

	});



	jQuery('.paging-ajax ul li a').click(function (e) {

        e.preventDefault();

        jQuery.ajaxSetup ({

			cache: false

		});

		var ajax_load = "Loading...";

		var loadUrl = jQuery(this).attr('href');

		jQuery("#gallery")

				.html(ajax_load)

				.load(loadUrl);	

	});

	

	</script>