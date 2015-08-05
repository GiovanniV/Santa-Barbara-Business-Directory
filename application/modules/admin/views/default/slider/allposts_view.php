<?php $curr_page = ($this->uri->segment(5)!='')?$this->uri->segment(5):0;?>

<div class="row">

  <div class="col-md-12">

    <div class="box">

      <div class="box-title">

        <h3><i class="fa fa-bars"></i> <?php echo lang_key('all_slides');?></h3>

        <div class="box-tool">

          <a href="#" data-action="collapse"><i class="fa fa-chevron-up"></i></a>


        </div>

      </div>

      <div class="box-content">

        <?php $this->load->helper('text');?>

        <?php echo $this->session->flashdata('msg');?>

        <?php if($posts->num_rows()<=0){?>

        <div class="alert alert-info"><?php echo lang_key('no_slide');?></div>

        <?php }else{?>

        <form action="<?php echo site_url('admin/slider/saveorder');?>" method="post">
        <div id="no-more-tables">

        <table id="sort" class="table table-hover">

           <thead>

               <tr>

                  <th class="numeric">#</th>

                  <th class="numeric"><?php echo lang_key('image');?></th>

                  <th class="numeric"><?php echo lang_key('title');?></th>

                  <th class="numeric"><?php echo lang_key('description');?></th>

                  <th class="numeric"><?php echo lang_key('slide_order');?></th>

                  <th class="numeric"><?php echo lang_key('status');?></th>

                  <th class="numeric"><?php echo lang_key('actions');?></th>

               </tr>

           </thead>

           <tbody>

        	<?php $i=1;foreach($posts->result() as $row):?>

               <tr>

                  <td data-title="#" class="numeric">
                    <?php echo $i;?>
                    <input type="hidden" name="id[]" value="<?php echo $row->id;?>">
                  </td>

                  <td data-title="<?php echo lang_key('featured_img');?>" class="numeric"><img style="width:50px;" src="<?php echo get_slider_photo_by_name($row->featured_img);?>" alt="img" /></td>
                  
                  <td data-title="<?php echo lang_key('title');?>" class="numeric"><a href="<?php echo site_url('admin/slider/manage/'.$row->id);?>"><?php echo $row->title;?></a></td>

                  <td data-title="<?php echo lang_key('description');?>" class="numeric"><?php echo truncate(encode_html($row->description),30,'...',false);?></td>

                  <td data-title="<?php echo lang_key('slide_order');?>" class="numeric"><?php echo $row->slide_order?></td>

                  <td data-title="<?php echo lang_key('status');?>" class="numeric">

                    <?php if($row->status==1)

                          $status = '<span class="label label-success">Published</span>';

                          else if($row->status==2)

                          $status = '<span class="label label-warning">Drafted</span>';

                        echo $status;

                    ?>

                  </td>



                   <td data-title="<?php echo lang_key('actions');?>" class="numeric">

                       <div class="btn-group">

                           <a class="btn btn-info dropdown-toggle" data-toggle="dropdown" href="#"><i class="fa fa-cog"></i> <?php echo lang_key('action');?> <span class="caret"></span></a>

                           <ul class="dropdown-menu dropdown-info">

                               <li><a href="<?php echo site_url('admin/slider/manage/'.$row->id);?>" class="edit-location"><?php echo lang_key('edit');?></a></li>

                               <li><a href="<?php echo site_url('admin/slider/delete/'.$curr_page.'/'.$row->id);?>"><?php echo lang_key('delete');?></a></li>

                           </ul>

                       </div>

                   </td>

               </tr>

            <?php $i++;endforeach;?>   

           </tbody>

        </table>

        </div>
        <span>You can drag drop to sort the table rows. After sorting save the order</span><br/><br/>
        <input type="submit" value="<?php echo lang_key('save_order')?>" class="btn btn-success">
        </form>

        <div class="pagination"><ul class="pagination pagination-colory"><?php echo $pages;?></ul></div>

        <?php }?>

        </div>

    </div>

  </div>

</div>

<script type="text/javascript">
jQuery(document).ready(function(){
  // Return a helper with preserved width of cells
  var fixHelper = function(e, ui) {
    ui.children().each(function() {
      $(this).width($(this).width());
    });
    return ui;
  };

  $("#sort tbody").sortable({
    helper: fixHelper
  }).disableSelection();

});
</script>
<style type="text/css">
#sort tr{
  cursor: move;
}
</style>