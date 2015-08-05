<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title>Santa Barbara Installation</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">

    <!-- Le styles -->
    <link href="<?php echo base_url();?>assets/admin/assets/css/bootstrap.css" rel="stylesheet">
    <style>
      body {
        padding-top: 60px; /* 60px to make the container go all the way to the bottom of the topbar */
      }
    </style>
    <link href="<?php echo base_url();?>assets/admin/assets/css/bootstrap-responsive.css" rel="stylesheet">

    <!-- HTML5 shim, for IE6-8 support of HTML5 elements -->
    <!--[if lt IE 9]>
      <script src="<?php echo base_url();?>assets/admin/assets/js/html5shiv.js"></script>
    <![endif]-->

    <!-- Fav and touch icons -->
    <link rel="apple-touch-icon-precomposed" sizes="144x144" href="<?php echo base_url();?>assets/admin/assets/ico/apple-touch-icon-144-precomposed.png">
    <link rel="apple-touch-icon-precomposed" sizes="114x114" href="<?php echo base_url();?>assets/admin/assets/ico/apple-touch-icon-114-precomposed.png">
    <link rel="apple-touch-icon-precomposed" sizes="72x72" href="<?php echo base_url();?>assets/admin/assets/ico/apple-touch-icon-72-precomposed.png">
    <link rel="apple-touch-icon-precomposed" href="<?php echo base_url();?>assets/admin/assets/ico/apple-touch-icon-57-precomposed.png">
    <link rel="shortcut icon" href="<?php echo base_url();?>assets/admin/assets/ico/favicon.png">
  	<link type="text/css" href="<?php echo base_url();?>assets/admin/assets/css/bootstrap-timepicker.min.css" />
  	<link type="text/css" href="<?php echo base_url();?>assets/admin/assets/css/jquery-ui.css" />

  </head>

  <body>
	<?php $menu = $this->uri->segment(2);?>
    <div class="navbar navbar-inverse navbar-fixed-top">
      <div class="navbar-inner">
        <div class="container">
          <a class="brand" href="<?php echo site_url('install');?>">Santa Barbara Installation</a>
          <div class="nav-collapse collapse">
            <ul class="nav">
              <?php $actv = '';if($menu=='dbsetup' || $menu=='savedbsettings')$actv='active';?>
              <li class="<?php echo $actv;?>"><a href="#">Database</a></li>
              <?php $actv = '';if($menu=='accountsetup' || $menu=='saveaccountsettings')$actv='active';?>
              <li class="<?php echo $actv;?>"><a href="#">Account</a></li>
            </ul>
          </div><!--/.nav-collapse -->
        </div>
      </div>
    </div>

    <div class="container">
	<?php if(isset($content))echo $content;?>
    </div> <!-- /container -->

	<div id="footer">
      <div class="container">
        <p class="muted credit">Developed By <a href="http://www.dbcinfotech.net">dbcinfotech</a></p>
      </div>
    </div>
    
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
	<script src="<?php echo base_url();?>assets/admin/assets/js/prettify.js"></script>
	<script src="<?php echo base_url();?>assets/admin/assets/js/bootstrap-timepicker.min.js"></script> 
	<script src="<?php echo base_url();?>assets/admin/assets/js/jquery-ui.js"></script> 	
<script type="text/javascript">
jQuery('.time-pick').timepicker();
jQuery( ".spinner" ).spinner({min: 0, max: 10});
</script>
  </body>
</html>
