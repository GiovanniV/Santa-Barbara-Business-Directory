<link href="<?php echo base_url();?>assets/datatable/dataTables.bootstrap.css" rel="stylesheet">

<div class="row">

    <div class="col-md-12">

        <?php echo $this->session->flashdata('msg'); ?>

        <div class="box">

            <div class="box-title">

                <h3><i class="fa fa-bars"></i> <?php echo lang_key('all_users'); ?></h3>

                <?php $page = ($this->uri->segment(5)!='')?$this->uri->segment(5):0;?>

                <div class="box-tool">

                    <a href="#" data-action="collapse"><i class="fa fa-chevron-up"></i></a>

                </div>

            </div>
            <div class="box-content">
                <?php $this->load->helper('text'); ?>
                <?php if ($posts->num_rows() <= 0) { ?>
                    <div class="alert alert-info"><?php echo lang_key('no_pages'); ?></div>
                <?php } else { ?>
                    <a href="<?php echo site_url('admin/users/create');?>" class="btn btn-success"><?php echo lang_key('create_user'); ?></a>
                    <a href="<?php echo site_url('admin/users/exportemails');?>" class="btn btn-info"><?php echo lang_key('export_user_email'); ?></a>
                    <div style="clear:both;margin-top:20px;"></div>
                    <div id="no-more-tables">
                        <table id="all-posts" class="table table-hover">
                            <thead>
                            <tr>
                                <th class="numeric">#</th>
                                <th class="numeric"><?php echo lang_key('image'); ?></th>
                                <th class="numeric"><?php echo lang_key('name'); ?></th>
                                <th class="numeric"><?php echo lang_key('type');?></th>
                                <th class="numeric"><?php echo lang_key('email'); ?></th>
                                <th class="numeric"><?php echo lang_key('gender'); ?></th>
                                <th class="numeric"><?php echo lang_key('status');?></th>
                                <th class="numeric"><?php echo lang_key('options');?></th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php $i = 1;

                            foreach ($posts->result() as $row): ?>

                                <tr>
                                    <td data-title="#" class="numeric"><?php echo $i; ?></td>
                                    <td data-title="<?php echo lang_key('image'); ?>" class="numeric">

                                        <img src="<?php echo get_profile_photo_by_id($row->id,'thumb'); ?>" class="thumbnail" style="height:36px;">

                                    </td>
                                    <td data-title="<?php echo lang_key('name'); ?>" class="numeric"><a

                                            href="<?php echo site_url('admin/users/detail/' . $row->id); ?>"><?php echo $row->user_name; ?></a>

                                    </td>
                                    <td data-title="<?php echo lang_key('type');?>"  class="numeric">
                                    <?php 
                                        echo get_user_type_by_id($row->user_type);
                                    ?>
                                    </td>
                                    <td data-title="<?php echo lang_key('email'); ?>" class="numeric"><?php echo $row->user_email;; ?></td>
                                    <td data-title="<?php echo lang_key('gender'); ?>"

                                        class="numeric"><?php echo ($row->gender == '') ? 'N/A' : $row->gender; ?></td>
                                    <td data-title="<?php echo lang_key('status');?>" class="numeric">

                                        <?php

                                        if ($row->confirmed != 1)

                                            echo '<div class="label label-info">Pending</div>';

                                        else if ($row->banned == 1)

                                            echo '<div class="label label-danger">Banned</div>';

                                        else {

                                            echo '<div class="label label-success">Active</div>';

                                        }

                                        ?>

                                    </td>

                                    <td data-title="<?php echo lang_key('options');?>" class="numeric">



                                        <div class="btn-group">



                                            <a class="btn btn-info dropdown-toggle" data-toggle="dropdown"

                                               href=""><i class="fa fa-cog"></i> <?php echo lang_key('action');?> <span

                                                    class="caret"></span></a>



                                            <ul class="dropdown-menu dropdown-info">

                                                <!--li><a href="<?php echo site_url('admin/userdetail/' . $row->user_name) ?>"

                                                       target="_blank">Profile</a></li-->
                                                <li><a href="<?php echo site_url('admin/edituser/' . $row->id); ?>"><?php echo lang_key('edit');?></a>

                                                </li>

                                                <li><a href="<?php echo site_url('admin/userdetail/' . $row->id); ?>">Detail</a>

                                                </li>

                                                <?php if($row->confirmation_key!=''){?>

                                                <li><a href="<?php echo site_url('admin/confirmuser/'.$page.'/'. $row->id); ?>">Confirm</a>

                                                </li>

                                                <?php }?>                                        


                                                <?php if($row->user_type!=1){?>

                                                    <li><a href="<?php echo site_url('admin/deleteuser/'.$page.'/'. $row->id); ?>"><?php echo lang_key('delete');?></a>

                                                    </li>

                                                    <?php

                                                    if ($row->banned == 1) {

                                                        ?>

                                                        <li>

                                                            <a href="<?php echo site_url('admin/users/unban_user/' . $row->id . '/' . $this->uri->segment(5)); ?>">Un-Ban</a>

                                                        </li>

                                                    <?php

                                                    } else {

                                                        ?>



                                                        <li>

                                                            <a href="<?php echo site_url('admin/users/ban_user/' . $row->id . '/' . $this->uri->segment(5)); ?>">Ban</a>

                                                        </li>

                                                    <?php

                                                    }

                                                }

                                                ?>

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
    jQuery('#searchkey').keyup(function () {

        var val = jQuery(this).val();

        var loadUrl = '<?php echo site_url('admin/search/');?>';

        jQuery("#bookings").html(ajax_load).load(loadUrl, {'key': val});
    });

    var ajax_load = '<div class="box">loading...</div>';

    jQuery('document').ready(function () {

        jQuery('#all-posts').dataTable();

        jQuery.ajaxSetup({
            cache: false
        });
    });



</script>