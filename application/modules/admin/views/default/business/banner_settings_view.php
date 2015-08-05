<style type="text/css">
.file-upload{
    margin:0 !important;
    padding:0 !important;
    list-style: none;
}
.file-upload li{
    clear: both;
}
</style>
<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>assets/admin/assets/bootstrap-colorpicker/css/colorpicker.css" />
<?php

?>
<div class="row">
  <div class="col-md-12">
    <?php echo $this->session->flashdata('msg');?>
    <form class="form-horizontal" id="addpackage" action="<?php echo site_url('admin/business/savebannersettings');?>" method="post">

    <div class="box">

      <div class="box-title">
        <h3><i class="fa fa-bars"></i> <?php echo lang_key('banner_settings');?></h3>
        <div class="box-tool">
          <a href="#" data-action="collapse"><i class="fa fa-chevron-up"></i></a>
        </div>
      </div>

      <div class="box-content">

          <div class="form-group">
            <label class="col-sm-3 col-lg-2 control-label"><?php echo lang_key('top_bar_bg');?>:</label>
              <div class="col-sm-5 col-lg-3 controls">
                  <?php $v = (set_value('top_bar_bg_color')!='')?set_value('top_bar_bg_color'):get_settings('banner_settings','top_bar_bg_color', '#ffffff');?>
                  <div class="input-group color colorpicker-default" data-color="<?php echo $v;?>" data-color-format="rgba">
                    <span class="input-group-addon"><i style="background-color: <?php echo $v;?>;"></i></span>
                    <input type="text" name="top_bar_bg_color" class="form-control" value="<?php echo $v;?>">
                  </div>
              </div>
          </div>

          <div class="form-group">
            <label class="col-sm-3 col-lg-2 control-label"><?php echo lang_key('menu_background');?>:</label>
              <div class="col-sm-5 col-lg-3 controls">
                  <?php $v = (set_value('menu_bg_color')!='')?set_value('menu_bg_color'):get_settings('banner_settings','menu_bg_color', '#ffffff');?>
                  <div class="input-group color colorpicker-default" data-color="<?php echo $v;?>" data-color-format="rgba">
                    <span class="input-group-addon"><i style="background-color: <?php echo $v;?>;"></i></span>
                    <input type="text" name="menu_bg_color" class="form-control" value="<?php echo $v;?>">
                  </div>
              </div>
          </div>

          <div class="form-group">
            <label class="col-sm-3 col-lg-2 control-label"><?php echo lang_key('menu_text_color');?>:</label>
              <div class="col-sm-5 col-lg-3 controls">
                  <?php $v = (set_value('menu_text_color')!='')?set_value('menu_text_color'):get_settings('banner_settings','menu_text_color', '#ffffff');?>
                  <div class="input-group color colorpicker-default" data-color="<?php echo $v;?>" data-color-format="rgba">
                    <span class="input-group-addon"><i style="background-color: <?php echo $v;?>;"></i></span>
                    <input type="text" name="menu_text_color" class="form-control" value="<?php echo $v;?>">
                  </div>
              </div>
          </div>

          <div class="form-group">
            <label class="col-sm-3 col-lg-2 control-label"><?php echo lang_key('activated_menu_text_color');?>:</label>
              <div class="col-sm-5 col-lg-3 controls">
                  <?php $v = (set_value('active_menu_text_color')!='')?set_value('active_menu_text_color'):get_settings('banner_settings','active_menu_text_color', '#ffffff');?>
                  <div class="input-group color colorpicker-default" data-color="<?php echo $v;?>" data-color-format="rgba">
                    <span class="input-group-addon"><i style="background-color: <?php echo $v;?>;"></i></span>
                    <input type="text" name="active_menu_text_color" class="form-control" value="<?php echo $v;?>">
                  </div>
              </div>
          </div>

          <div class="form-group">
              <label class="col-sm-3 col-lg-2 control-label"><?php echo lang_key('banner_type');?>:</label>
              <div class="col-sm-4 col-lg-5 controls">
                  <?php $options = array("Parallax Slider","Google Map", "Layer Slider");?>
                  <select id="banner_type" name="banner_type" class="form-control input-sm">
                      <?php $v = (set_value('banner_type')!='')?set_value('banner_type'):get_settings('banner_settings','banner_type','Slider');?>
                      <?php foreach ($options as $option) { 
                            $sel = ($option==$v)?'selected="selected"':'';
                        ?>
                          <option value="<?php echo $option;?>" <?php echo $sel;?>><?php echo lang_key($option);?></option>
                      <?php } ?>
                  </select>
                  <span class="help-inline">&nbsp;</span>
                  <?php echo form_error('banner_type'); ?>
              </div>
          </div>

      </div>
    </div>
    <!-- end image box -->
    <div class="box">

        <div class="box-title">
            <h3><i class="fa fa-bars"></i>Map  Settings</h3>
            <div class="box-tool">
                <a href="#" data-action="collapse"><i class="fa fa-chevron-up"></i></a>
            </div>
        </div>
        <div class="box-content">
            <div class="form-group">
                <label class="col-sm-3 col-lg-2 control-label"><?php echo lang_key('latitude');?>:</label>
                <div class="col-sm-4 col-lg-5 controls">
                    <?php $v = (set_value('map_latitude')!='')?set_value('map_latitude'):get_settings('banner_settings','map_latitude', 37.2718745);?>
                    <input class="form-control" type="text" name="map_latitude" id="map_latitude" value="<?php echo $v;?>">
                    <span class="help-inline">&nbsp;</span>
                </div>
            </div>

            <div class="form-group">
                <label class="col-sm-3 col-lg-2 control-label"><?php echo lang_key('longitude')?>:</label>
                <div class="col-sm-4 col-lg-5 controls">
                    <?php $v = (set_value('map_longitude')!='')?set_value('map_longitude'):get_settings('banner_settings','map_longitude',-119.2704153);?>
                    <input class="form-control" type="text" name="map_longitude" id="map_longitude" value="<?php echo $v;?>">
                    <span class="help-inline">&nbsp;</span>
                </div>
            </div>

            <div class="form-group">
                <label class="col-sm-3 col-lg-2 control-label"><?php echo lang_key('map_zoom');?>:</label>
                <div class="col-sm-4 col-lg-5 controls">
                    <?php $v = (set_value('map_zoom')!='')?set_value('map_zoom'):get_settings('banner_settings','map_zoom', 8);?>
                    <select id="map_zoom" name="map_zoom" class="form-control input-sm">
                        <?php for($i=1;$i<=18; $i++){
                            $sel = ($i==$v)?'selected="selected"':''; ?>
                        <option value="<?php echo $i; ?>" <?php echo $sel;?>><?php echo $i; ?></option>
                        <?php } ?>
                    </select>
<!--                    <input class="form-control" type="text" name="map_zoom" id="map_zoom" value="--><?php //echo $v;?><!--">-->
                    <span class="help-inline">&nbsp;</span>
                </div>
            </div>
        </div>
    </div>

    <div class="box">

      <div class="box-title">
        <h3><i class="fa fa-bars"></i> <?php echo lang_key('search_panel_settings');?></h3>
        <div class="box-tool">
          <a href="#" data-action="collapse"><i class="fa fa-chevron-up"></i></a>
        </div>
      </div>

      <div class="box-content">

          <div class="form-group">
            <label class="col-sm-3 col-lg-2 control-label"><?php echo lang_key('search_panel_bg_color');?>:</label>
              <div class="col-sm-5 col-lg-3 controls">
                  <?php $v = (set_value('search_panel_bg_color')!='')?set_value('search_panel_bg_color'):get_settings('banner_settings','search_panel_bg_color', '#ffffff');?>
                  <div class="input-group color colorpicker-default" data-color="<?php echo $v;?>" data-color-format="rgba">
                    <span class="input-group-addon"><i style="background-color: <?php echo $v;?>;"></i></span>
                    <input type="text" name="search_panel_bg_color" class="form-control" value="<?php echo $v;?>">
                  </div>
              </div>
          </div>


          <div class="form-group">
            <label class="col-sm-3 col-lg-2 control-label">&nbsp;</label>
              <div class="col-sm-9 col-lg-10 controls">
                  <?php $v = (set_value('show_bg_image')!='')?set_value('show_bg_image'):get_settings('banner_settings','show_bg_image', '0');?>
                  <div class="input-group show_bg_image" data-color="<?php echo $v;?>" data-color-format="rgba">
                  <label>
                    <?php $chk = ($v==1)?'checked="checked"':'';?>
                    <input style="width:40px;" type="checkbox" name="show_bg_image" id="show_bg_image" class="form-control" value="1" <?php echo $chk;?>>
                    <?php echo lang_key('show_background_image');?>
                  </label>
                  </div>
              </div>
          </div>

          <div class="form-group bg-img">
                <label class="col-sm-3 col-lg-2 control-label">&nbsp;</label>
                <div class="col-sm-4 col-lg-5 controls">
                    <?php $featured_img = (set_value('search_bg')!='')?set_value('search_bg'):get_settings('banner_settings','search_bg','skyline.jpg');?>
                    <img class="" id="search_bg_preview" src="" style="width:300px;">
                    <span id="search_bg-error"><?php echo form_error('search_bg')?></span> 
                </div>
                <div class="clearfix"></div>                   
          </div>

            <div class="form-group bg-img">
                <label class="col-sm-3 col-lg-2 control-label"><?php echo lang_key('bg_image');?>:</label>
                <div class="col-sm-4 col-lg-5 controls">                    
                    <input type="hidden" name="search_bg" id="search_bg" value="<?php echo $featured_img;?>">                    
                    <iframe src="<?php echo site_url('admin/business/searchbguploader');?>" style="border:0;margin:0;padding:0;height:130px;"></iframe>
                    <span class="help-inline">&nbsp;</span>
                </div>          
            </div>
            <div class="clearfix"></div>

      </div> 
    </div>
    <input type="submit" value="<?php echo lang_key('update');?>" class="btn btn-success">     
    </form>

  </div>
</div>
<script type="text/javascript">
var base_url = '<?php echo base_url();?>';
jQuery(document).ready(function(){
    jQuery('#banner_type').change(function(){
        var val = jQuery(this).val();
        if(val=='Slider')
        {
            jQuery('#slider-panel').show();
            jQuery('#map-panel').hide();

        }
        else
        {
            jQuery('#map-panel').show();
            jQuery('#slider-panel').hide();
        }
    }).change();

    jQuery('#search_bg').change(function(){
            var val = jQuery(this).val();
            var src = base_url+'uploads/banner/'+val;
            jQuery('#search_bg_preview').attr('src',src);
    }).change();

    show_hide_image_panel();

    jQuery('#show_bg_image').click(function(){
      show_hide_image_panel();
    });
});

function show_hide_image_panel()
{
  if(jQuery('#show_bg_image').attr('checked')=='checked')
  {
    jQuery('.bg-img').show();
  }
  else
  {
    jQuery('.bg-img').hide();
  }
}


</script>
<script src="<?php echo base_url();?>assets/admin/assets/bootstrap-colorpicker/js/bootstrap-colorpicker.js"></script>
