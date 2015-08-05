<link href="<?php echo base_url();?>assets/datatable/dataTables.bootstrap.css" rel="stylesheet">

<div class="row">

    <div class="col-md-12">

        <?php echo $this->session->flashdata('msg'); ?>

        <?php $page = ($this->uri->segment(5)!='')?$this->uri->segment(5):0;?>

        <div class="box">

            <div class="box-title">

                <h3><i class="fa fa-bars"></i> <?php echo lang_key('all_packages');?></h3>



                <div class="box-tool">

                    <a href="#" data-action="collapse"><i class="fa fa-chevron-up"></i></a>



                </div>

            </div>

            <div class="box-content">

                <?php $this->load->helper('text'); ?>

                <?php if ($packages->num_rows() <= 0) { ?>

                    <div class="alert alert-info"><?php echo lang_key('no_packages');?></div>

                <?php } else { ?>

                    <div id="no-more-tables">

                        <table id="all-posts" class="table table-hover">

                            <thead>

                            <tr>




                                <th class="numeric">#</th>



                                <th class="numeric"><?php echo lang_key('title');?></th>



                                <!-- <th class="numeric"><?php echo lang_key('description');?></th> -->



                                <th class="numeric"><?php echo lang_key('price');?> <?php echo get_currency_icon(get_settings('paypal_settings','currency','USD')).'('.get_settings('paypal_settings','currency','USD').')';?></th>



                                <th class="numeric"><?php echo lang_key('type');?></th>



                                <th class="numeric"><?php echo lang_key('expirtion_time');?></th>



                                <th class="numeric"><?php echo lang_key('options');?></th>



                            </tr>

                            </thead>

                            <tbody>

                            <?php $i = 1;

                            foreach ($packages->result() as $row): 
                                ?>

                                <tr>


                                    <td data-title="#" class="numeric"><?php echo $i; ?></td>


                                    <td data-title="<?php echo lang_key('title');?>" class="numeric">

                                        <a href="<?php echo site_url('admin/package/edit_package/'.$row->id);?>">

                                            <?php echo character_limiter($row->title,20); ?>

                                        </a>

                                    </td>



                                    <td data-title="<?php echo lang_key('price');?> <?php echo get_currency_icon(get_settings('paypal_settings','currency','USD')).'('.get_settings('paypal_settings','currency','USD').')';?>" class="numeric">

                                        <?php 

                                        echo $row->price;

                                        ?>

                                    </td>



                                    <td data-title="<?php echo lang_key('type');?>" class="numeric">

                                        

                                            <?php echo lang_key($row->type); ?>

                                        

                                    </td>



                                    <td data-title="<?php echo lang_key('expirtion_time');?>" class="numeric"><?php echo $row->expiration_time.' days';?></td>

                                

                                    <td data-title="<?php echo lang_key('options');?>" class="numeric">


                                        <div class="btn-group">

                                          <a class="btn btn-info dropdown-toggle" data-toggle="dropdown" href="#"><i class="fa fa-cog"></i> <?php echo lang_key('action');?> <span class="caret"></span></a>

                                          <ul class="dropdown-menu dropdown-info">

                                              <li><a href="<?php echo site_url('admin/package/edit_package/'.$row->id);?>" class="edit-location"><?php echo lang_key('edit');?></a></li>
                                              <li><a href="<?php echo site_url('admin/package/remove_package/'.$row->id); ?>"><?php echo lang_key('delete');?></a></li>

                                          </ul>

                                        </div>


                                    </td>



                                </tr>

                                <?php $i++;endforeach; ?>

                            </tbody>

                        </table>

                    </div>




                <?php } ?>

            </div>

        </div>

    </div>

</div>

<script src="<?php echo base_url();?>assets/datatable/jquery.dataTables.min.js"></script>
<script src="<?php echo base_url();?>assets/datatable/dataTables.bootstrap.js"></script>
<script type="text/javascript">

    jQuery('document').ready(function () {
        jQuery('#all-posts').dataTable();

    });



</script>