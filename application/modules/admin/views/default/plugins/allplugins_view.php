<div class="row">
  <div class="col-md-12">
    <div class="box">
      <div class="box-title">
        <h3><i class="fa fa-bars"></i><?php echo lang_key('all_plugins');?></h3>
        <div class="box-tool">
          <a href="#" data-action="collapse"><i class="fa fa-chevron-up"></i></a>

        </div>
      </div>
      <div class="box-content">

        <?php echo $this->session->flashdata('msg');?>
        <a href="<?php echo site_url('admin/plugins');?>" class="btn btn-primary" style="margin-bottom:15px;">Add new</a>
        <?php if($posts->num_rows()<=0){?>
        <div class="alert alert-info"><?php echo lang_key('no_plugins');?></div>
        <?php }else{?>
        <div id="no-more-tables">
        <table class="table table-striped">
           <thead>
               <tr>
                  <th class="numeric">#</th>
                  <th class="numeric"><?php echo lang_key('name_and_version');?></th>
                  <th class="numeric"><?php echo lang_key('status');?></th>
                  <th class="numeric"><?php echo lang_key('actions');?></th>
               </tr>
           </thead>
           <tbody>
        	<?php $i=1;foreach($posts->result() as $row):?>
               <?php $data = json_decode($row->plugin);?>
               <tr>
                  <td data-title="#" class="numeric"><?php echo $i;?></td>
                  <td data-title="<?php echo lang_key('name_and_version');?>" class="numeric"><?php echo $data->name.'('.$data->version.')'.'<br/>';?>
                  <?php $update = json_decode(file_get_contents($data->url));
                  		echo ($update->status=='avl')?'Update Available('.$update->version.').<a target="_blank" href="'.$update->url.'">View</a>':'';
                  ?>
                  </td>
                  <td data-title="<?php echo lang_key('status');?>" class="numeric"><?php echo ($row->status==1)?'Enabled':'Disabled';?></td>
                  <td data-title="Actions" class="numeric">
                  	<div class="btn-group">
                        <button data-toggle="dropdown" class="btn dropdown-toggle"><?php echo lang_key('action');?> <span class="caret"></span></button>
                        <ul class="dropdown-menu">
                          <li>
                          	<?php if($row->status==1){?>
                          	<a href="<?php echo site_url('admin/plugins/disable/'.$row->id);?>">Disable</a>
                          	<?php }else{?>
                          	<a href="<?php echo site_url('admin/plugins/enable/'.$row->id);?>">Enable</a>                  	
                          	<?php }?>
                          </li>
                        </ul>
                      </div>
                  </td>
               </tr>
            <?php $i++;endforeach;?>   
           </tbody>
        </table>
        </div>
        <?php }?>
        </div>
    </div>
  </div>
</div> 