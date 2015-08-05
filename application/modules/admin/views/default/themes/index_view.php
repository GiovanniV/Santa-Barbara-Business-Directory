<?php echo $this->session->flashdata('msg');?>

<div class="row">
  <div class="col-md-12">
    <div class="box">
      <div class="box-title">
        <h3><i class="fa fa-bars"></i> <?php echo lang_key('active_theme'); ?></h3>
        <div class="box-tool">
          <a href="#" data-action="collapse"><i class="fa fa-chevron-up"></i></a>

        </div>
      </div>
      <div class="box-content">
        <?php 
        $theme = get_active_theme();

        $file   = './application/modules/themes/views/'.$theme.'/assets/config.xml';
        @$xmlstr = file_get_contents($file);
        if($xmlstr=='')
        {
          echo 'Theme config file not found';die;
        }
        $xml    = simplexml_load_string($xmlstr);
        @$config = $xml->xpath('//config');
        ?>
        <div class="row bs-examples">
          <div class="col-xs-6 col-md-4">
            <a href="javascript:void(0);" class="thumbnail">
              <img alt="" src="<?php echo base_url('application/modules/themes/views/'.$theme.'/assets/screen.jpg');?>">
            </a>
            <h4><?php echo $config[0]->name;?></h4>
            <p><?php echo 'Version : '.$config[0]->version.' <br/> Author : '.$config[0]->author;?></p> 
          </div>
        </div>  

      </div>
    </div>
  </div>
</div>

<div class="row">
  <div class="col-md-12">
    <div class="box">
      <div class="box-title">
        <h3><i class="fa fa-bars"></i> <?php echo lang_key('available_themes'); ?></h3>
        <div class="box-tool">
          <a href="#" data-action="collapse"><i class="fa fa-chevron-up"></i></a>

        </div>
      </div>
      <div class="box-content">

        <div class="row bs-examples">
        <?php
          $this->load->helper('directory');
          $map = directory_map('./application/modules/themes/views', 1);
          foreach ($map as $theme) 
          {
              if($theme==get_active_theme())continue;
              $file   = './application/modules/themes/views/'.$theme.'/assets/config.xml';
              $xmlstr = file_get_contents($file);
              $xml  = simplexml_load_string($xmlstr);
              $config = $xml->xpath('//config');
          ?>
              <div class="col-xs-6 col-md-4" style="margin-bottom:30px;">
                <a href="javascript:void(0);" class="thumbnail">
                  <img alt="" src="<?php echo base_url('application/modules/themes/views/'.$theme.'/assets/screen.jpg');?>">
                </a>
                <h4><?php echo $config[0]->name;?></h4>
                <p><?php echo 'Version : '.$config[0]->version.' <br/> Author : '.$config[0]->author;?></p>
                <form action="<?php echo site_url('admin/themes/activate');?>" method="post">
                  <input type="hidden" name="theme" value="<?php echo $theme;?>" />
                  <button class="btn btn-primary" type="submit"><i class="fa fa-check"></i> <?php echo lang_key('activate'); ?></button>
                </form> 
              </div>
         <?php
          }
          ?>
        </div>

      </div>
    </div>
  </div>
</div>