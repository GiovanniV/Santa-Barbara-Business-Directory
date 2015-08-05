<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <title><?php echo translate(get_settings('site_settings', 'site_title', 'Whizz Business Directory')); ?>
        | <?php echo lang_key('admin_panel') ?></title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php include 'template/includes_top.php';?>
    <link rel="stylesheet" type="text/css" href="<?php echo base_url();?>assets/admin/css/loginpanel.css" />
    <style>
    .login-form-title {
      background-color: #2c3e50;
      color: #fff;
      font-weight: 100;
      padding: 3px 10px;
      -webkit-border-radius: 5px 5px 0px 0px;
      -moz-border-radius: 5px 5px 0px 0px;
      border-radius: 5px 5px 0px 0px;
    }
    </style>
</head>
<body class="login-page">
  <?php //include 'template/theme_settings.php';?>
    <div class="login-wrapper">
      <div style="text-align:center;width:340px;margin:0 auto;">        
              <?php if(isset($error))echo $error;?>
              <?php echo $this->session->flashdata('msg');?>
      </div>
      <form id="form-login" action="<?php echo site_url('admin/auth/login/');?>" method="post">
          
          <div class="login-form-title">
              <h4><i class="fa fa-lock"></i> <?php echo lang_key('product_admin_panel');?></h4>
           </div>


        <div class="form-group">
          <div class="controls">
                  <div class="input-group">
                      <span class="input-group-addon"><i class="fa fa-envelope-o"></i></span>
                      <input class="form-control" type="text" name="username" placeholder="<?php echo lang_key('username_or_email');?>">
                  </div>
          </div>
        </div>
        <div class="form-group">
          <div class="controls">
                  <div class="input-group">
                      <span class="input-group-addon"><i class="fa fa-key"></i></span>
                      <input class="form-control" type="password" name="password" placeholder="<?php echo lang_key('password');?>">
                  </div>
          </div>
        </div>
        
        <div class="form-group">
          <div class="controls">
                  <div class="input-group">
                      <span class="input-group-addon"><i class="fa fa-globe"></i></span>
                      <select name="lang" class="form-control">
                        <?php 
                          $CI = get_instance();
                          $CI->load->model('admin/system_model');
                          $languages = $CI->system_model->get_all_langs();
                          foreach ($languages as $lang=>$long_name) {
                        ?>
                            <option value="<?php echo $lang;?>"><?php echo $long_name;?></option>
                        <?php
                          }
                        ?>
                      </select>
                  </div>
          </div>
        </div>
        <?php if(constant("ENVIRONMENT")=='demo'){?>
        <div class="form-group">
          <div class="controls">
                  <div class="input-group">
                      Demo Admin : admin password: 12345
                  </div>
          </div>
        </div>
        <?php }?>

        <hr style="margin-bottom:0px;" />
        <div class="form-group">
          <div class="controls">
                  <button type="submit" class="btn btn-primary form-control" style="width:50%"><?php echo lang_key('login');?></button>
                  <a href="<?php echo site_url('account/recoverpassword');?>" class="goto-forgot" style="width:49%;margin-right:2px;"><?php echo lang_key('forgot_password');?>?</a>
          </div>
        </div>
        <hr/>
      </form>
          
    </div>
    <?php include 'template/includes_bottom.php';?>
</body>
</html>