<div class="row">
    <div class="col-md-12">
        <?php echo $this->session->flashdata('msg');?>
        <div class="box">
            <div class="box-title">
                <h3><i class="fa fa-bars"></i><?php echo lang_key('create_widget');?></h3>
                <div class="box-tool">
                    <a href="#" data-action="collapse"><i class="fa fa-chevron-up"></i></a>

                </div>
            </div>
            <div class="box-content">
                <form action="<?php echo site_url('admin/widgets/create');?>" method="post">
                    <div class="form-group">
                        <label class="col-sm-2 col-lg-1 control-label"><?php echo lang_key('name');?>:</label>
                        <div class="col-sm-4 col-lg-5 controls">
                            <input type="text" name="name" value="" placeholder="<?php echo lang_key('type_something');?>" class="form-control input-sm" >
                            <span class="help-inline">&nbsp;</span>
                            <?php echo form_error("name");?>
                        </div>
                    </div>
                    <div class="clearfix"></div>
                    <div class="form-group">
                        <label class="col-sm-2 col-lg-1 control-label">&nbsp;</label>
                        <div class="col-sm-4 col-lg-5 controls">
                            <button class="btn btn-primary" type="submit"><i class="fa fa-check"></i> <?php echo lang_key('create');?></button>
                        </div>
                    </div>
                    <div class="clearfix"></div>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-12">
        <div class="box">
            <div class="box-title">
                <h3><i class="fa fa-bars"></i> <?php echo lang_key('all_widgets');?></h3>
                <div class="box-tool">
                    <a href="#" data-action="collapse"><i class="fa fa-chevron-up"></i></a>

                </div>
            </div>
            <div class="box-content">
                <div id="no-more-tables">
                    <table class="table table-hover">
                        <thead>
                        <tr>
                            <th class="numeric">#</th>
                            <th class="numeric"><?php echo lang_key('widget_name');?></th>
                            <th class="numeric"><?php echo lang_key('activate_deactivate');?></th>
                            <th class="numeric"><?php echo lang_key('actions');?></th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php $i=1; foreach($widgets->result() as $row){?>
                        <tr>
                            <td data-title="#" class="numeric"><?php echo $i;?></td>
                            <input type="hidden" name="widget[]" value="<?php echo $row->name;?>">
                            <td data-title="<?php echo lang_key('widget_name');?>" class="numeric"><?php echo $row->name;?></td>
                            <td data-title="<?php echo lang_key('activate_deactivate');?>" class="numeric">
                                <?php if($row->status==1){?>
                                    <a href="<?php echo site_url('admin/widgets/setstatus/'.$row->alias.'/0');?>" style="" class="btn btn-warning">Deactivate</a>
                                <?php }else{?>
                                    <a href="<?php echo site_url('admin/widgets/setstatus/'.$row->alias.'/1');?>" style="" class="btn btn-success">Activate</a>
                                <?php }?>
                            </td>
                            <td data-title="<?php echo lang_key('actions');?>" class="numeric">
                                <div class="btn-group">
                                    <a class="btn btn-info dropdown-toggle" data-toggle="dropdown" href="#"><i class="fa fa-cog"></i> <?php echo lang_key('action');?> <span class="caret"></span></a>
                                    <ul class="dropdown-menu dropdown-info">
                                        <li><a href="<?php echo site_url('admin/widgets/edit/'.$row->alias);?>" class="edit-widget"><?php echo lang_key('edit');?></a></li>
                                        <?php if($row->editable==1){?>
                                        <li><a href="<?php echo site_url('admin/widgets/setstatus/'.$row->alias.'/2');?>"><?php echo lang_key('delete');?></a></li>
                                        <?php }?>
                                    </ul>
                                </div>
                            </td>

                        </tr>
                        <?php $i++;}?>
                        </tbody>
                        </table>
                    </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="editWidgetModal" style="display: none;" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-body">
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
jQuery(document).ready(function(){
    
    jQuery(".edit-widget").click(function(event){
        event.preventDefault();
        var loadUrl = jQuery(this).attr("href");
        jQuery('#editWidgetModal').modal('show');
        jQuery("#editWidgetModal  .modal-body").html("Loading...");
        jQuery.post(
                loadUrl,
                {},
                function(responseText){
                    jQuery("#editWidgetModal  .modal-body").html(responseText);
                },
                "html"
            );
    });
});
</script>
