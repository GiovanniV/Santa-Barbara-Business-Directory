<link href="<?php echo base_url();?>assets/datatable/dataTables.bootstrap.css" rel="stylesheet">
<?php
$curr_page = $this->uri->segment(5);
if($curr_page=='')
  $curr_page = 0;
?>
<div class="row">

  <div class="col-md-12">

      <?php $state_active = get_settings('business_settings', 'show_state_province', 'yes'); ?>
    <a href="<?php echo site_url('admin/business/newlocation/country');?>" class="btn btn-success add-location"><?php echo lang_key('add_country');?></a>

      <?php if($state_active == 'yes'){ ?>
          <a href="<?php echo site_url('admin/business/newlocation/state');?>" class="btn btn-info add-location"><?php echo lang_key('add_state');?></a>
      <?php } ?>

    <a href="<?php echo site_url('admin/business/newlocation/city');?>" class="btn btn-warning add-location"><?php echo lang_key('add_city');?></a>
    <div style="clear:both;margin-top:20px;"></div>

    <div class="box">

      <div class="box-title">

        <h3><i class="fa fa-bars"></i> <?php echo lang_key('all_locations');?></h3>

        <div class="box-tool">

          <a href="#" data-action="collapse"><i class="fa fa-chevron-up"></i></a>


        </div>

      </div>

      <div class="box-content">

        <?php echo $this->session->flashdata('msg');?>

        <?php if(count($posts)<=0){?>

        <div class="alert alert-info"><?php echo lang_key('no_locations');?></div>

        <?php }else{?>

        <div class="row">
          <div class="col-md-4 col-sm-4 col-xs-12 pull-right">
            
            <form action="<?php echo site_url('admin/business/locations/0');?>" method="post" id="table-search-from" class="form-inline pull-right">
              <div class="">
                <label class="sr-only" for="exampleInputAmount"><?php echo lang_key('search');?>:</label>
                <div class="input-group">
                  <input type="text" name="key" class="form-control" id="key" placeholder="<?php echo lang_key('location_name');?>">
                  <div class="input-group-addon search-plain" style="cursor:pointer;border-radius:0 5px 5px 0"><i class="fa fa-search"></i></div>
                </div>
              </div>
            </form>

          </div>

        </div>

        <div id="no-more-tables">

        <table id="all-posts" class="table table-hover">

           <thead>

               <tr>

                  <th class="numeric">#</th>

                  <th class="numeric"><?php echo lang_key('name');?></th>

                  <th class="numeric"><?php echo lang_key('type');?></th>

                  <th class="numeric"><?php echo lang_key('parent');?></th>

                  <th class="numeric"><?php echo lang_key('actions');?></th>

               </tr>

           </thead>

           <tbody>

        	<?php $i=1;foreach($posts->result() as $row):
                $dash = '';
                // if($row->type=='state')
                //   $dash = '|___';
                // elseif($row->type=='city')
                //   $dash = '&nbsp;&nbsp;&nbsp;&nbsp;|___';
          ?>

               <tr>

                  <td data-title="#" class="numeric"><?php echo $i;?></td>

                  <td data-title="<?php echo lang_key('name');?>" class="numeric"><?php echo $dash.' '.$row->name;?></td>

                  <td data-title="<?php echo lang_key('type');?>" class="numeric"><?php echo $row->type;?></td>

                  <td data-title="<?php echo lang_key('parent');?>" class="numeric">

                    <?php echo get_location_name_by_id($row->parent);?>

                  </td>

                  <td data-title="<?php echo lang_key('actions');?>" class="numeric">

                    <div class="btn-group">

                      <a class="btn btn-info dropdown-toggle" data-toggle="dropdown" href="#"><i class="fa fa-cog"></i> <?php echo lang_key('action');?> <span class="caret"></span></a>

                      <ul class="dropdown-menu dropdown-info">

                          <li><a href="<?php echo site_url('admin/business/editlocation/'.$row->type.'/'.$row->id);?>" class="edit-location"><?php echo lang_key('edit');?></a></li>
                          <li><a href="<?php echo site_url('admin/business/deletelocation/'.$curr_page.'/'.$row->id);?>"><?php echo lang_key('delete');?></a></li>

                      </ul>

                    </div>

                  </td>

               </tr>

            <?php $i++;endforeach;?>   

           </tbody>

        </table>

        <div class="pagination pull-right">
            <ul class="pagination pagination-colory"><?php echo (isset($pages))?$pages:'';?></ul>
        </div>
        <div class="clearfix"></div>

        </div>


        <?php }?>

        </div>

    </div>

  </div>

</div>


<!-- Modal -->
<div class="modal fade" id="location-model" style="display: none;" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header" style="border-bottom:0px;">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
          </div>
            <div class="modal-body"  style="padding-top:0px;">
            </div>
        </div>
    </div>
</div>

<script src="<?php echo base_url();?>assets/datatable/jquery.dataTables.min.js"></script>
<script src="<?php echo base_url();?>assets/datatable/dataTables.bootstrap.js"></script>
<script type="text/javascript">
jQuery(document).ready(function(){
    //jQuery('#all-posts').dataTable();
    
    jQuery(".add-location").click(function(event){
        event.preventDefault();
        var loadUrl = jQuery(this).attr("href");
        jQuery('#location-model').modal('show');
        jQuery("#location-model  .modal-body").html("Loading...");
        jQuery.get(
                loadUrl,
                {},
                function(responseText){
                    jQuery("#location-model  .modal-body").html(responseText);
                },
                "html"
            );
    });

    jQuery(".edit-location").click(function(event){
        event.preventDefault();
        var loadUrl = jQuery(this).attr("href");
        jQuery('#location-model').modal('show');
        jQuery("#location-model  .modal-body").html("Loading...");
        jQuery.get(
                loadUrl,
                {},
                function(responseText){
                    jQuery("#location-model  .modal-body").html(responseText);
                },
                "html"
            );
    });

    jQuery('#location-model').on('hidden.bs.modal', function () {
        location.reload();
    });

});
</script>
