<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <title>Memento | Admin Panel</title>
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
              <?php echo $this->session->flashdata('msg');?>
              <?php echo form_error('user_email'); ?>
      </div>
      <form id="form-login" action="<?php echo site_url('admin/auth/recoverpassword/');?>" method="post">
          
          <div class="login-form-title">
              <h4><i class="fa fa-lock"></i> Recover password</h4>
           </div>

        <div class="form-group">
          <div class="controls">
                  <div class="input-group">
                      <span class="input-group-addon"><i class="fa fa-envelope-o"></i></span>
                      <input class="form-control" type="text" name="user_email" placeholder="Email">
                  </div>
          </div>
        </div>
        <hr style="margin-bottom:0px;" />
        <div class="form-group">
          <div class="controls">
                  <a href="<?php echo site_url('admin');?>" class="goto-forgot pull-left btn btn-info form-control" style="width:49%;margin-right:2px;">Sign in</a>
                  <button type="submit" class="btn btn-primary form-control" style="width:50%">Recover</button>
          </div>
        </div>
        <hr/>
      </form>
          
    </div>
    <?php include 'template/includes_bottom.php';?>
</body>
</html>