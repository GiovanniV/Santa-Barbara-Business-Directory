<div class="row">
    <div class="col-md-12">
        <div class="box">
            <div class="box-title">
                <h3><i class="fa fa-bars"></i><?php echo lang_key("site_settings") ?> </h3>

                <div class="box-tool">
                    <a href="#" data-action="collapse"><i class="fa fa-chevron-up"></i></a>
                </div>
            </div>
            <div class="box-content">
                <?php echo $this->session->flashdata('msg'); ?>
                <?php echo isset($msg)?$msg:'';?>
                <?php $settings = json_decode($settings);?>
                <form class="form-horizontal" action="<?php echo site_url('admin/system/savesitesettings/site_settings');?>" method="post">


                    <div class="form-group">
                        <label class="col-sm-3 col-lg-2 control-label"><?php echo lang_key('site_title'); ?></label>

                        <div class="col-sm-9 col-lg-10 controls">
                            <input type="text" name="site_title" value="<?php echo(isset($settings->site_title))?$settings->site_title:'';?>" placeholder="<?php echo lang_key('type_something');?>" class="form-control" >
                            <span class="help-inline">&nbsp;</span>
                            <?php echo form_error('site_title'); ?>
                        </div>

                    </div>

                    <div class="form-group">
                        <label class="col-sm-3 col-lg-2 control-label"><?php echo lang_key('footer_text'); ?></label>

                        <div class="col-sm-9 col-lg-10 controls">
                            <input type="text" name="footer_text" value="<?php echo(isset($settings->footer_text))?$settings->footer_text:'';?>" placeholder="<?php echo lang_key('type_something');?>" class="form-control" >
                            <span class="help-inline">&nbsp;</span>
                            <?php echo form_error('footer_text'); ?>
                        </div>

                    </div>

                    <div class="form-group">
                        <label class="col-sm-3 col-lg-2 control-label"><?php echo lang_key('site_logo'); ?></label>

                        <div class="col-sm-9 col-lg-10 controls">
                            <input type="hidden" name="site_logo" id="site_logo" value="<?php echo get_site_logo('name');?>">
                            <img class="thumbnail" id="site_logo_preview" src="<?php echo get_site_logo();?>" width="128">
                            <iframe src="<?php echo site_url('admin/system/site_logo_uploader');?>" style="border:0;margin:0;padding:0;height:130px;"></iframe>
                            <div class="clearfix"></div>
                            <span id="upload-error"><?php echo form_error('site_logo'); ?></span>
                        </div>
                    </div>


                    <div class="form-group">
                        <label class="col-sm-3 col-lg-2 control-label"><?php echo lang_key('site_language'); ?></label>

                        <div class="col-sm-9 col-md-3 controls">
                            <select name="site_lang" class="form-control">
                                <?php 
                                $CI = get_instance();
                                $CI->load->config('business_directory');
                                $languages = $CI->config->item('active_languages');
                                foreach($languages as $short_name=>$long_name){
                                ?>
                                    <?php $sel=($settings->site_lang==$short_name)?'selected="selected"':'';?>
                                    <option value="<?php echo $short_name;?>" <?php echo $sel;?>><?php echo $long_name;?></option>
                                <?php }?>
                            </select>
                            <span class="help-inline">&nbsp;</span>
                            <?php echo form_error('site_lang'); ?>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-3 col-lg-2 control-label"><?php echo lang_key('site_text_direction'); ?></label>
                        <div class="col-sm-9 col-md-3 controls">
                            <select name="site_direction" class="form-control">
                                <?php $options = array('ltr','rtl');?>
                                <?php foreach($options as $row){?>
                                    <?php $sel=($settings->site_direction==$row)?'selected="selected"':'';?>
                                    <option value="<?php echo $row;?>" <?php echo $sel;?>><?php echo $row;?></option>
                                <?php }?>
                            </select>
                            <input type="hidden" name="site_direction_rules" value="required">
                            <span class="help-inline">&nbsp;</span>
                            <?php echo form_error('site_direction'); ?>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-3 col-lg-2 control-label"><?php echo lang_key('per_page'); ?></label>

                        <div class="col-sm-9 col-md-2 controls">
                            <select name="per_page" class="form-control">
                                <?php $paging = array(5,6,9,10,12,15,18,20,24,28,30,33,36,40,50,100);?>
                                <?php foreach($paging as $row){?>
                                    <?php $sel=($settings->per_page==$row)?'selected="selected"':'';?>
                                    <option value="<?php echo $row;?>" <?php echo $sel;?>><?php echo $row;?></option>
                                <?php }?>
                            </select>
                            <span class="help-inline">&nbsp;</span>
                            <?php echo form_error('per_page'); ?>
                        </div>
                    </div>


                    <div class="form-group">
                        <label class="col-sm-3 col-lg-2 control-label"><?php echo lang_key('default_page_layout'); ?></label>
                        <div class="col-sm-9 col-md-4 controls">
                            <select name="default_layout" id="default_layout" class="form-control">
                                <?php $layouts = array('Left bar with content','Right bar with content','Only content')?>
                                <?php foreach($layouts as $key=>$row){?>
                                <?php $sel = ($key==$settings->default_layout)?'selected="selected"':'';?>
                                <option value="<?php echo $key;?>" <?php echo $sel;?>><?php echo $row;?></option>
                                <?php }?>
                            </select>
                            <span class="help-inline">&nbsp;</span>
                            <?php echo form_error('default_layout'); ?>
                        </div>
                    </div>



                    <div style="border-bottom:1px solid #aaa;font-weight:bold;font-size:14px;padding:0 0 5px 5px;"><?php echo lang_key('google_analytics_settings');?></div>
                    <div class="form-group">
                        <label class="col-sm-3 col-lg-2 control-label"><?php echo lang_key('tracking_code'); ?></label>
                        <div class="col-sm-9 col-lg-10 controls">
                            <textarea name="ga_tracking_code" class="form-control"><?php echo(isset($settings->ga_tracking_code))?$settings->ga_tracking_code:'';?></textarea>
                            <span class="help-inline">&nbsp;</span>
                            <?php echo form_error('ga_tracking_code'); ?>
                        </div>
                    </div>
                    <div style="border-bottom:1px solid #aaa;font-weight:bold;font-size:14px;padding:0 0 5px 5px;"><?php echo lang_key('default_seo_settings');?></div>

                    <div class="form-group">
                        <label class="col-sm-3 col-lg-2 control-label"><?php echo lang_key('meta_description'); ?></label>

                        <div class="col-sm-9 col-lg-10 controls">
                            <textarea name="meta_description" class="form-control"><?php echo(isset($settings->meta_description))?$settings->meta_description:'';?></textarea>
                            <span class="help-inline">&nbsp;</span>
                            <?php echo form_error('meta_description'); ?>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-3 col-lg-2 control-label"><?php echo lang_key('key_words'); ?></label>

                        <div class="col-sm-9 col-lg-10 controls">
                            <textarea name="key_words" class="form-control"><?php echo(isset($settings->key_words))?$settings->key_words:'';?></textarea>
                            <span class="help-inline">&nbsp;</span>
                            <?php echo form_error('key_words'); ?>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-3 col-lg-2 control-label"><?php echo lang_key('crawl_after'); ?>:</label>

                        <div class="col-sm-9 col-lg-10 controls">
                            <input type="text" name="crawl_after" class="form-control" value="<?php echo(isset($settings->crawl_after))?$settings->crawl_after:'';?>">
                            <span class="help-inline">&nbsp;</span>
                            <?php echo form_error('crawl_after'); ?>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-3 col-lg-2 control-label"></label>

                        <div class="col-sm-9 col-lg-10 controls">
                            <button class="btn btn-primary" type="submit"><i
                                    class="fa fa-check"></i><?php echo lang_key("update") ?></button>
                        </div>
                    </div>

                </form>
            </div>
        </div>
    </div>
</div>
