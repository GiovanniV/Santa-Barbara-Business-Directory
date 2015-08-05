<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <title>Dbcadmin | Admin Panel</title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php include 'template/includes_top.php';?>
    <link rel="stylesheet" type="text/css" href="<?php echo base_url();?>assets/admin/css/signin.css" />
    <style type="text/css">
    .domreg{min-height: 400px;background: #fff;width:90%;margin:0 auto;border-radius: 4px;padding: 15px;text-align: center;}
    </style>
</head>
<body>
  <?php //include 'template/theme_settings.php';?>
    <div class="container" id="main-container">
        <div class="domreg">
          <h4>Please register your Santa Barbara with dbcinfotech</h4>
          <p>You need to register you copy of Santa Barbara first with dbcinfotech.</p>
          <div class="row" style="text-align:center">
              <div class="col-md-4" stye="margin:0 auto;"></div>
              <div class="col-md-4" stye="margin:0 auto;">
                <?php echo $this->session->flashdata('msg');?>
              <form action="<?php echo site_url('admin/purchase/addkey');?>" method="POST" class="form-horaizontal">
                <label>Santa Barbara setup url : </label>
                <input type="text" name="domain" value="<?php echo base_url();?>" class="form-control input-md-3" readonly="readonly">
                <label>Item id : </label>
                <input type="text" name="item_id" value="" plcaholder="" class="form-control input-md-3">   
                <label>Purchase Key : </label>
                <input type="text" name="purchase_key" value="" plcaholder="" class="form-control input-md-3"> 
                <input type="hidden" name="form_key" value="<?php echo $this->session->userdata('form_key');?>"/>        
                <input type="submit" value="save" class="btn btn-success" style="margin-top:10px;">
              </form>
              </div>
              <div class="col-md-4" stye="margin:0 auto;"></div>
          </div>  
        </div>
    </div>
    <?php include 'template/includes_bottom.php';?>
</body>
</html>