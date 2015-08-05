 <!--Rickh Text Editor-->
<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>assets/admin/assets/bootstrap-wysihtml5/bootstrap-wysihtml5.css" />
<div class="row">
  <div class="col-md-12">
    <?php echo $this->session->flashdata('msg');?>

       <form class="form-horizontal" action="<?php echo site_url('admin/business/sendbulkemail');?>" method="post">

        <div class="box">

          <div class="box-title">
            <h3><i class="fa fa-bars"></i><?php echo lang_key('bulk_email'); ?></h3>
            <div class="box-tool">
              <a href="#" data-action="collapse"><i class="fa fa-chevron-up"></i></a>
            </div>
          </div>

          <div class="box-content">

         <div class="form-group">
              <label class="col-sm-3 col-lg-2 control-label"><?php echo lang_key('to');?> :</label>
              <div class="col-sm-4 col-lg-5 controls">
                <select class="form-control col-md-12 to-emails" name="to[]" id="to" multiple="multiple">
                  <?php
                  $emails = array();
                  foreach($posts->result() as $row){  
                    $val = $row->value;
                    $val = json_decode($val);
                    if(isset($emails[$val->sender_email])==FALSE)
                    {
                      $emails[$val->sender_email] = 1;
                      $sel = (isset($_POST['to']) && in_array($val->sender_email, $_POST['to']))?'selected="selected"':'';
                  ?>
                    <option value="<?php echo $val->sender_email;?>" <?php echo $sel;?>><?php echo $val->sender_email;?></option>
                  <?php
                    }
                  }
                  ?>
                </select>
                <?php echo form_error('to');?>
                <span class="help-inline"><a href="#" onclick="jQuery('#to option').prop('selected', true);"><?php echo lang_key('all');?></a>&nbsp;|&nbsp;
                <a href="#" onclick="jQuery('#to option').prop('selected', false);"><?php echo lang_key('none');?></a></span>
              </div>    
        </div>
        <div style="clear:both"></div>

        <div class="form-group">
              <label class="col-sm-3 col-lg-2 control-label"><?php echo lang_key('subject'); ?> :</label>
              <div class="col-sm-4 col-lg-5 controls">
                <input class="form-control col-md-12" type="text" name="subject" value="<?php echo set_value('subject');?>" />
                <?php echo form_error('subject');?>
                <span class="help-inline">&nbsp;</span>
              </div>
        </div>      
        <div style="clear:both"></div>

        <div class="form-group">
              <label class="col-sm-3 col-lg-2 control-label"><?php echo lang_key('message'); ?> :</label>
              <div class="col-sm-4 col-lg-5 controls">
                <textarea class="form-control wysihtml5" name="message" style="min-height:300px"><?php echo set_value('message');?></textarea>
                <?php echo form_error('message');?>
              <span class="help-inline">&nbsp;</span>
              </div>  
        </div>
        <div style="clear:both"></div>

        <div class="form-group">
              <label class="col-sm-3 col-lg-2 control-label">&nbsp;</label>
              <div class="col-sm-4 col-lg-5 controls">
              <button class="btn btn-primary" type="submit"><?php echo lang_key('send'); ?></button>
              <span class="help-inline">&nbsp;</span>
              </div>  
        </div>
        <div style="clear:both"></div>
        

        </div>
      </div>  

      </form>
  </div>
</div>      
<!--Rich text editor-->
<script src="<?php echo base_url();?>assets/admin/assets/bootstrap-wysihtml5/wysihtml5-0.3.0.js"></script> 
<script src="<?php echo base_url();?>assets/admin/assets/bootstrap-wysihtml5/bootstrap-wysihtml5.js"></script>
