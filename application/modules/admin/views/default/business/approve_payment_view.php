<link href="<?php echo base_url();?>assets/datatable/dataTables.bootstrap.css" rel="stylesheet">
<div class="row">
  

  <div class="col-md-12">

    <div class="box">

      <div class="box-title">

        <h3><i class="fa fa-bars"></i> <?php echo lang_key('payment_history');?></h3>

        <div class="box-tool">

          <a href="#" data-action="collapse"><i class="fa fa-chevron-up"></i></a>


        </div>

      </div>

      <div class="box-content">

        <?php echo $this->session->flashdata('msg');?>

        <?php if($trans->num_rows()<=0){?>

        <div class="alert alert-info"><?php echo lang_key('no_posts_found');?></div>

        <?php }else{?>
        
        <div id="no-more-tables" class="table-responsive" style="border:0">

        <table id="all-transaction" class="table table-hover table-advance">

           <thead>

               <tr>

                  <th class="numeric"><?php echo lang_key('transaction_id');?></th>

                  <th class="numeric"><?php echo lang_key('post_id');?></th>

                  <th class="numeric"><?php echo lang_key('amount');?></th>

                  <th class="numeric"><?php echo lang_key('request_date');?></th>
                  
                  <th class="numeric"><?php echo lang_key('expiration_date');?></th>
                  
                  <th class="numeric"><?php echo lang_key('amount');?></th>
                  
                  <th class="numeric"><?php echo lang_key('payment_for');?></th>

                  <th class="numeric"><?php echo lang_key('status');?></th>

                  <th class="numeric"><?php echo lang_key('actions');?></th>

               </tr>

           </thead>

           <tbody>

        	<?php foreach($trans->result() as $row):  ?>

               <tr>

                  <td data-title="<?php echo lang_key('transaction_id');?>" class="numeric"><?php echo $row->unique_id?></td>

                  <td data-title="<?php echo lang_key('post_id');?>" class="numeric"><?php echo $row->post_id;?></td>

                  <td data-title="<?php echo lang_key('amount');?>" class="numeric"><?php echo $row->amount;?></td>

                  <td data-title="<?php echo lang_key('request_date');?>" class="numeric"><?php echo $row->request_date;?></td>
                  
                  <td data-title="<?php echo lang_key('expiration_date');?>" class="numeric"><?php echo $row->expiration_date;?></td>
                  
                  <td data-title="<?php echo lang_key('amount');?>" class="numeric"><?php echo $row->amount;?></td>
                  
                  <td data-title="<?php echo lang_key('payment_for');?>" class="numeric"><?php echo lang_key($row->payment_type);?></td>

                  <td data-title="<?php echo lang_key('status');?>" class="numeric"><?php echo get_payment_status_title_by_value($row->is_active,'labelled');?></td>

                  <td data-title="<?php echo lang_key('actions');?>" class="numeric">

                    <div class="btn-group">

                      <a class="btn btn-info dropdown-toggle" data-toggle="dropdown" href="#"><i class="fa fa-cog"></i> <?php echo lang_key('action');?> <span class="caret"></span></a>

                      <ul class="dropdown-menu dropdown-info">
                      <?php if(is_admin()){?>
                        <?php if($row->is_active==2){?>
                            <?php if($row->payment_type=='post') {?>
                              <li><a href="<?php echo site_url('admin/business/approveposttransaction/'.$row->unique_id);?>"><?php echo lang_key('approve');?></a></li>
                            <?php }?>
                            <?php if($row->payment_type=='post_renew') {?>
                              <li><a href="<?php echo site_url('admin/business/approveposttransaction/'.$row->unique_id);?>"><?php echo lang_key('approve');?></a></li>
                            <?php }?>
                            <?php if($row->payment_type=='feature') {?>
                              <li><a href="<?php echo site_url('admin/business/approvefeaturetransaction/'.$row->unique_id);?>"><?php echo lang_key('approve');?></a></li>
                            <?php }?>
                            <?php if($row->payment_type=='feature_renew') {?>
                              <li><a href="<?php echo site_url('admin/business/approvefeaturerenewtransaction/'.$row->unique_id);?>"><?php echo lang_key('approve');?></a></li>
                            <?php }?>
                        <?php }?>
                          <li><a href="<?php echo site_url('admin/business/deletetransaction/'.$row->unique_id);?>"><?php echo lang_key('delete');?></a></li>
                      <?php }?>
                      </ul>

                    </div>

                  </td>

               </tr>

            <?php endforeach;?>   

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
    jQuery('#all-transaction').dataTable();
});
</script>
