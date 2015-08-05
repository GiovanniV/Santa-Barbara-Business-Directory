<link href="<?php echo base_url();?>assets/datatable/dataTables.bootstrap.css" rel="stylesheet">

<div class="row">

  <div class="col-md-12">

    <div class="box">

      <div class="box-title">

        <h3><i class="fa fa-bars"></i> <?php echo lang_key('all_posts');?></h3>

        <div class="box-tool">

          <a href="#" data-action="collapse"><i class="fa fa-chevron-up"></i></a>


        </div>

      </div>

      <div class="box-content">

        <?php $this->load->helper('text');?>

        <?php echo $this->session->flashdata('msg');?>

        <?php if($posts->num_rows()<=0){?>

        <div class="alert alert-info"><?php echo lang_key('no_posts');?></div>

        <?php }else{?>

        <div id="no-more-tables">

        <table id="all-posts" class="table table-hover">

           <thead>

               <tr>

                  <th class="numeric">#</th>

                  <th class="numeric"><?php echo lang_key('type');?></th>

                  <th class="numeric"><?php echo lang_key('title');?></th>

                  <th class="numeric"><?php echo lang_key('description');?></th>

                  <th class="numeric"><?php echo lang_key('status');?></th>

                  <th class="numeric"><?php echo lang_key('actions');?></th>

               </tr>

           </thead>

           <tbody>

        	<?php $i=1;foreach($posts->result() as $row):?>

               <tr>

                  <td data-title="#" class="numeric"><?php echo $i;?></td>

                  <td data-title="<?php echo lang_key('type');?>" class="numeric"><?php echo lang_key($row->type);?></td>

                  <td data-title="<?php echo lang_key('title');?>" class="numeric"><a href="<?php echo site_url('admin/blog/manage/'.$row->id);?>"><?php echo get_blog_data_by_lang($row,'title');?></a></td>

                  <td data-title="<?php echo lang_key('description');?>" class="numeric"><?php echo truncate(encode_html(get_blog_data_by_lang($row,'description')),30,'...',false);?></td>

                  <td data-title="<?php echo lang_key('status');?>" class="numeric">

                    <?php if($row->status==1)

                          $status = '<span class="label label-success">'.lang_key('published').'</span>';

                          else if($row->status==2)

                          $status = '<span class="label label-warning">'.lang_key('drafted').'</span>';

                        echo $status;

                    ?>

                  </td>

                  

                   <?php $curr_page = ($this->uri->segment(5)!='')?$this->uri->segment(5):0;?>

                   <td data-title="<?php echo lang_key('actions');?>" class="numeric">

                       <div class="btn-group">

                           <a class="btn btn-info dropdown-toggle" data-toggle="dropdown" href="#"><i class="fa fa-cog"></i> <?php echo lang_key('action');?> <span class="caret"></span></a>

                           <ul class="dropdown-menu dropdown-info">

                               <li><a href="<?php echo site_url('admin/blog/manage/'.$row->id);?>" class="edit-location"><?php echo lang_key('edit');?></a></li>

                               <li><a href="<?php echo site_url('admin/blog/delete/'.$curr_page.'/'.$row->id);?>"><?php echo lang_key('delete');?></a></li>

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
<script src="<?php echo base_url();?>assets/datatable/jquery.dataTables.min.js"></script>
<script src="<?php echo base_url();?>assets/datatable/dataTables.bootstrap.js"></script>
<script type="text/javascript">
jQuery(document).ready(function(){
    jQuery('#all-posts').dataTable();
});
</script>