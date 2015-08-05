
<form id="uploader-form" action="<?php echo site_url('user/uploadgalleryfile');?>" method="post" enctype="multipart/form-data" style="display:none">
    <input type="file" name="photoimg[]" id="photoimg" style="height:auto;" multiple>
</form>

<form id="featured-uploader-form" action="<?php echo site_url('user/uploadfeaturedfile');?>" method="post" enctype="multipart/form-data" style="display:none">
    <input type="file" name="photoimg" id="photoimg_featured" style="height:auto;" >
</form>

<form id="logo-uploader-form" action="<?php echo site_url('user/uploadlogofile');?>" method="post" enctype="multipart/form-data" style="display:none">
    <input type="file" name="photoimg" id="photoimg_logo" style="height:auto;" >
</form>

<div id="myModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">

    <div class="modal-dialog">

        <div class="modal-content">
            <div class="modal-body">
                <div class="progress span3 progress-bar-span">
                    <div class="bar"></div >
                    <div class="percent">0%</div >
                </div>
            </div>
        </div>    
    </div>    
</div>    


<style type="text/css">
.bar{
    background: none repeat scroll 0 0 #78a;
    border-radius: 3px;
    height: 17px;
}
</style>

<script type="text/javascript">
jQuery(document).ready(function(){
    var feature_img_progress = 0;
    var pre_loader;
    var post_loader;

    jQuery('#photoimg').change(function(){
        var files = $("#photoimg")[0].files;
        handleFileUpload(files,$("#dragandrophandler"));
    });

    jQuery('#photoimg_featured').change(function(){
        
            var formData = new FormData();
            var files = $("#photoimg_featured")[0].files;
            formData.append('photoimg', files[0]);

            var uploadURL = '<?php echo site_url("user/uploadfeaturedfile");?>'; //Upload URL
            var extraData ={}; //Extra Data.
            var jqXHR=$.ajax({
                    xhr: function() {
                    var xhrobj = $.ajaxSettings.xhr();
                    if (xhrobj.upload) {
                            xhrobj.upload.addEventListener('progress', function(event) {
                                var percent = 0;
                                var position = event.loaded || event.position;
                                var total = event.total;
                                if (event.lengthComputable) {
                                    percent = (position / total * 100);
                                    var percentVal = percent+'%';
                                    jQuery('#myModal .bar').width(percentVal);
                                    jQuery('#myModal .percent').html(percentVal); 
                                }
                                
                            }, false);
                        }
                    return xhrobj;
                },
            url: uploadURL,
            type: "POST",
            contentType:false,
            processData: false,
                cache: false,
                data: formData,
                beforeSend: function() {
                    jQuery('#myModal').modal('show');
                    var percentVal = '0%';
                    jQuery('#myModal .bar').width(percentVal);
                    jQuery('#myModal .percent').html(percentVal);   
                },
                success: function(data){
                 
                    var percentVal = '100%';
                    jQuery('#myModal .bar').width(percentVal);
                    jQuery('#myModal .percent').html(percentVal);

                    var response = jQuery.parseJSON(data);
                    if(response.error==0)
                    {
                        jQuery('#featured-img-input').val(response.name);
                        jQuery('#featured-img-input').trigger('change');
                        jQuery('#myModal').modal('hide');

                    }
                    else
                    {
                        if(response.error){
                            var massage = response.error;
                            jQuery('#myModal').modal('hide');
                            alert(massage);
                        }
                    }
                    jQuery('#myModal').modal('hide');               
                }
            });

    });


    jQuery('#photoimg_logo').change(function(){
        
            var formData = new FormData();
            var files = $("#photoimg_logo")[0].files;
            formData.append('photoimg', files[0]);

            var uploadURL = '<?php echo site_url("user/uploadlogofile");?>'; //Upload URL
            var extraData ={}; //Extra Data.
            var jqXHR=$.ajax({
                    xhr: function() {
                    var xhrobj = $.ajaxSettings.xhr();
                    if (xhrobj.upload) {
                            xhrobj.upload.addEventListener('progress', function(event) {
                                var percent = 0;
                                var position = event.loaded || event.position;
                                var total = event.total;
                                if (event.lengthComputable) {
                                    percent = (position / total * 100);
                                    var percentVal = percent+'%';
                                    jQuery('#myModal .bar').width(percentVal);
                                    jQuery('#myModal .percent').html(percentVal); 
                                }
                                
                            }, false);
                        }
                    return xhrobj;
                },
            url: uploadURL,
            type: "POST",
            contentType:false,
            processData: false,
                cache: false,
                data: formData,
                beforeSend: function() {
                    jQuery('#myModal').modal('show');
                    var percentVal = '0%';
                    jQuery('#myModal .bar').width(percentVal);
                    jQuery('#myModal .percent').html(percentVal);   
                },
                success: function(data){
                 
                    var percentVal = '100%';
                    jQuery('#myModal .bar').width(percentVal);
                    jQuery('#myModal .percent').html(percentVal);

                    var response = jQuery.parseJSON(data);
                    if(response.error==0)
                    {
                        jQuery('#business-logo-input').val(response.name);
                        jQuery('#business-logo-input').trigger('change');
                        jQuery('#myModal').modal('hide');

                    }
                    else
                    {
                        if(response.error){
                            var massage = response.error;
                            jQuery('#myModal').modal('hide');
                            alert(massage);
                        }
                    }
                    jQuery('#myModal').modal('hide');               
                }
            });

    });

});
</script>