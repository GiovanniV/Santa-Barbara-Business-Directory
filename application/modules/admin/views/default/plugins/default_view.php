<div class="row">
  <div class="col-md-12">
    <div class="box">
      <div class="box-title">
        <h3><i class="fa fa-bars"></i><?php echo lang_key('install_updates');?></h3>
        <div class="box-tool">
          <a href="#" data-action="collapse"><i class="fa fa-chevron-up"></i></a>

        </div>
      </div>
      <div class="box-content">

		<?php echo $this->session->flashdata('msg');?>
		<form action="<?php echo site_url('admin/plugins/upload/');?>" method="post" enctype="multipart/form-data">
		<input type="file" name="plugin" />

		<button class="btn btn-primary" type="submit" style="margin-top:15px;"><i class="fa fa-check"></i><?php echo lang_key('upload_and_install');?></button>
		</form>
		
	</div>
    </div>
  </div>
</div>