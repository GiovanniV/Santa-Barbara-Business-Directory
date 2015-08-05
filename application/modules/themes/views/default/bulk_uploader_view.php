<script>
function sendFileToServer(formData,status,feature_img_progress)
{
    var uploadURL = '<?php echo site_url("user/uploadgalleryfile");?>'; //Upload URL
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
                            //console.log(percent);
                            //alert(percent);
                            var percentVal = percent+'%';
                            jQuery('#myModal .bar').width(percentVal);
                            jQuery('#myModal .percent').html(percentVal); 
                        }
                        status.setProgress(percent);
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
                var base_url  = '<?php echo base_url();?>';
                var target = jQuery('#photoimg').attr('target');
                var input  = jQuery('#photoimg').attr('input');

                var image_url = base_url+'uploads/gallery/'+response.name;
                var html = '<li style="margin:10px 10px 0 0;overflow:hidden">'+
                    '<input type="hidden" name="'+input+'[]" value="'+response.name+'" />'+
                    '<image src="'+image_url+'" style="height:100%"/>'+
                    '<div style="clear:both"></div>'+
                    '<div class="remove-image" onclick="jQuery(this).parent().remove();">X</div>'+
                    '</li>';
                jQuery( target ).prepend(html);
                jQuery(target+'-input').val

            } 
            jQuery('#myModal').modal('hide');
        
       
            //alert('end upload');
        }
    });
 
    status.setAbort(jqXHR);
}
 
var rowCount=0;
function createStatusbar(obj)
{
 
    this.setFileNameSize = function(name,size)
    {
    }
    this.setProgress = function(progress)
    {      
    }
    this.setAbort = function(jqxhr)
    {
    }
}
function handleFileUpload(files,obj)
{
   for (var i = 0; i < files.length; i++)
   {
        var fd = new FormData();
        fd.append('photoimg', files[i]);
        var feature_img_progress = 0;
        var status = new createStatusbar(obj); //Using this we can set progress.
        sendFileToServer(fd,status,feature_img_progress);
 
   }
}

</script>