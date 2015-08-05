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
              <?php if(isset($error))echo $error;?>
              <?php echo $this->session->flashdata('msg');?>
      </div>
      <form id="form-login" action="<?php echo site_url('admin/auth/signup/');?>" method="post">
          
          <div class="login-form-title">
              <h4><i class="fa fa-lock"></i> Sign Up As Agent</h4>
           </div>
           

        <div class="form-group">
          <div class="controls">
                  <div class="input-group">
                      <span class="input-group-addon"><i class="fa fa-user"></i></span>
                      <input class="form-control" type="text" value="<?php echo set_value('first_name'); ?>" name="first_name" placeholder="First Name">

                  </div>
              <?php echo form_error('first_name'); ?>
          </div>
        </div>
          <div class="form-group">
              <div class="controls">
                  <div class="input-group">
                      <span class="input-group-addon"><i class="fa fa-user"></i></span>
                      <input class="form-control" type="text" value="<?php echo set_value('last_name'); ?>" name="last_name" placeholder="Last Name">

                  </div>
                  <?php echo form_error('last_name'); ?>
              </div>
          </div>
          <div class="form-group">
              <div class="controls">
                  <div class="input-group">
                      <span class="input-group-addon"><i class="fa fa-bars"></i></span>
                      <input class="form-control" type="text" value="<?php echo set_value('user_name'); ?>" name="user_name" placeholder="Username">
                  </div>
                  <?php echo form_error('user_name'); ?>
              </div>
          </div>
        <div class="form-group">
          <div class="controls">
                  <div class="input-group">
                      <span class="input-group-addon"><i class="fa fa-key"></i></span>
                      <input class="form-control" type="password" name="password" placeholder="Password">
                  </div>
              <?php echo form_error('password'); ?>
          </div>
        </div>
          <div class="form-group">
              <div class="controls">
                  <div class="input-group">
                      <span class="input-group-addon"><i class="fa fa-key"></i></span>
                      <input class="form-control" type="password" name="re_password" placeholder="Confirm Password">
                  </div>
              </div>
          </div>

          <div class="form-group">
              <div class="controls">
                  <div class="input-group">
                      <span class="input-group-addon"><i class="fa fa-envelope-o"></i></span>
                      <input class="form-control" type="text" value="<?php echo set_value('user_email'); ?>" name="user_email" placeholder="Email">
                  </div>
                  <?php echo form_error('user_email'); ?>

              </div>
          </div>

          <div class="form-group">
              <div class="controls">
                  <div class="input-group">
                      <span class="input-group-addon"><i class="fa fa-envelope-o"></i></span>
                      <select>
                        <?php foreach ($packages->result() as $package) {
                          ?>
                          <option value="<?php echo $package->id;?>"><?php echo $package->title;?></option>
                          <?php
                        }?>
                      </select>
                  </div>
                  <?php echo form_error('user_email'); ?>

              </div>
          </div>
        <hr style="margin-bottom:0px;" />
        <div class="form-group">
          <div class="controls">
                  <a href="<?php echo site_url('admin/auth/');?>" class="goto-forgot pull-left btn btn-info form-control" style="width:49%;margin-right:2px;">Log In</a>
                  <button type="submit" class="btn btn-primary form-control" style="width:50%">Sign Up</button>
                  <a href="<?php echo site_url('admin/auth/forgotpass');?>" class="goto-forgot" style="width:49%;margin-right:2px;">Forgot password?</a>
          </div>
        </div>
        <hr/>
      </form>
          
    </div>
    <?php include 'template/includes_bottom.php';?>
</body>
</html>