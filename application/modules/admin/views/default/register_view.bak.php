<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title>Sign in</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">

    <!-- Le styles -->
    <link href="<?php echo site_url();?>assets/admin/assets/css/bootstrap.css" rel="stylesheet">
    <style type="text/css">
      body {
        padding-top: 40px;
        padding-bottom: 40px;
        background-color: #f5f5f5;
      }

      .form-signin {
        max-width: 300px;
        padding: 19px 29px 29px;
        margin: 0 auto 20px;
        background-color: #fff;
        border: 1px solid #e5e5e5;
        -webkit-border-radius: 5px;
           -moz-border-radius: 5px;
                border-radius: 5px;
        -webkit-box-shadow: 0 1px 2px rgba(0,0,0,.05);
           -moz-box-shadow: 0 1px 2px rgba(0,0,0,.05);
                box-shadow: 0 1px 2px rgba(0,0,0,.05);
      }
      .form-signin .form-signin-heading,
      .form-signin .checkbox {
        margin-bottom: 10px;
      }
      .form-signin input[type="text"],
      .form-signin input[type="password"] {
        font-size: 16px;
        height: auto;
        margin-bottom: 15px;
        padding: 7px 9px;
      }

    </style>
    <link href="<?php echo site_url();?>assets/admin/assets/css/bootstrap-responsive.css" rel="stylesheet">

    <!-- HTML5 shim, for IE6-8 support of HTML5 elements -->
    <!--[if lt IE 9]>
      <script src="<?php echo base_url();?>assets/admin/assets/js/html5shiv.js"></script>
    <![endif]-->

    <!-- Fav and touch icons -->
    <link rel="apple-touch-icon-precomposed" sizes="144x144" href="<?php echo site_url();?>assets/admin/assets/ico/apple-touch-icon-144-precomposed.png">
    <link rel="apple-touch-icon-precomposed" sizes="114x114" href="<?php echo site_url();?>assets/admin/assets/ico/apple-touch-icon-114-precomposed.png">
      <link rel="apple-touch-icon-precomposed" sizes="72x72" href="<?php echo site_url();?>assets/admin/assets/ico/apple-touch-icon-72-precomposed.png">
                    <link rel="apple-touch-icon-precomposed" href="<?php echo site_url();?>assets/admin/assets/ico/apple-touch-icon-57-precomposed.png">
                                   <link rel="shortcut icon" href="<?php echo site_url();?>assets/admin/assets/ico/favicon.png">
  </head>

  <body>

    <div class="container">
      <?php echo $this->session->flash_data('msg');?>
      <form action="<?php echo site_url('admin/auth/signup/');?>" method="post" class="form-signin">
        <h2 class="form-signin-heading">Create Account</h2>
        <input type="text" class="input-block-level" placeholder="User Name" name="username">
        <input type="text" class="input-block-level" placeholder="User Email" name="useremail">
        <input type="password" class="input-block-level" placeholder="Password" name="password">
        <input type="password" class="input-block-level" placeholder="Retype Password" name="repassword">
        <label class="checkbox">
          <input type="checkbox" value="remember-me" name="remember"> Remember me
        </label>
        <button class="btn btn-large btn-primary" type="submit">Sign Up</button>
        <a href="#">Forgot Password</a><a style="margin-left:10px;" href="<?php echo site_url('admin');?>">Signin</a>
        <?php if(isset($error))echo $error;?>
      </form>

    </div> <!-- /container -->

    <!-- Le javascript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="<?php echo base_url();?>assets/admin/assets/js/jquery.js"></script>
    <script src="<?php echo base_url();?>assets/admin/assets/js/bootstrap-transition.js"></script>
    <script src="<?php echo base_url();?>assets/admin/assets/js/bootstrap-alert.js"></script>
    <script src="<?php echo base_url();?>assets/admin/assets/js/bootstrap-modal.js"></script>
    <script src="<?php echo base_url();?>assets/admin/assets/js/bootstrap-dropdown.js"></script>
    <script src="<?php echo base_url();?>assets/admin/assets/js/bootstrap-scrollspy.js"></script>
    <script src="<?php echo base_url();?>assets/admin/assets/js/bootstrap-tab.js"></script>
    <script src="<?php echo base_url();?>assets/admin/assets/js/bootstrap-tooltip.js"></script>
    <script src="<?php echo base_url();?>assets/admin/assets/js/bootstrap-popover.js"></script>
    <script src="<?php echo base_url();?>assets/admin/assets/js/bootstrap-button.js"></script>
    <script src="<?php echo base_url();?>assets/admin/assets/js/bootstrap-collapse.js"></script>
    <script src="<?php echo base_url();?>assets/admin/assets/js/bootstrap-carousel.js"></script>
    <script src="<?php echo base_url();?>assets/admin/assets/js/bootstrap-typeahead.js"></script>

  </body>
</html>
