<div class="row">
    <div class="col-md-12">
        <div class="box">
            <div class="box-title">
                <h3><i class="fa fa-bars"></i><?php echo lang_key("edit_email_template") ?> </h3>

                <div class="box-tool">
                    <a href="#" data-action="collapse"><i class="fa fa-chevron-up"></i></a>
                    <a href="#" data-action="close"><i class="fa fa-times"></i></a></div>
            </div>
            <div class="box-content">

            <div class="col-md-3 col-sm-3">
                <ul class="email-tmpl-menu">
                    <?php foreach($emails->result() as $row){ 
                        $class = ($this->uri->segment(5)==$row->id)?'active':'';
                    ?>
                    <li class="<?php echo $class;?>"><a href="<?php echo site_url('admin/system/emailtmpl/'.$row->id);?>"><?php echo lang_key($row->email_name);?></a></li>
                    <?php } ?>
                </ul>  
                <div style="clear:both;margin-top:30px"></div>               
            </div>

            <div class="col-md-9 col-sm-9">

                <?php
                if($email->num_rows()<=0)
                {
                    echo '<div class="alert alert-info input-xxlarge" style="margin-top:20px;">'.lang_key('click_and_edit').'</div>';
                }
                else
                {
                    $row = $email->row();
                    $values = json_decode($row->values);
                    ?>

                    
                    <form class="form-horizontal" action="<?php echo site_url('admin/system/updateemail');?>" method="post">
                            <?php echo $this->session->flashdata('msg');?>
                            <input type="hidden" name="id" value="<?php echo $row->id;?>" />

                        <div class="form-group">
                            <label class="col-sm-3 col-lg-2 control-label"><?php echo lang_key('subject'); ?></label>

                            <div class="col-sm-9 col-lg-10 controls">
                                <input type="text" name="subject" value="<?php echo (isset($values->subject))?$values->subject:set_value('subject');?>" placeholder="<?php echo lang_key('type_something');?>" class="form-control" >
                                <?php echo form_error('subject'); ?>

                                <span class="help-inline">&nbsp;</span>

                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-3 col-lg-2 control-label"><?php echo lang_key('body'); ?></label>

                            <div class="col-sm-9 col-lg-10 controls">
                                <textarea style="height:250px;" name="body" placeholder="<?php echo lang_key('type_something');?>" class="form-control" ><?php echo (isset($values->body))?$values->body:set_value('body');?></textarea>
                                <?php echo form_error('body'); ?>

                                <input type="hidden" name="avl_vars" value="<?php echo (isset($values->avl_vars))?$values->avl_vars:set_value('avl_vars');?>" />
                                <div class="alert alert-info input-xxlarge" style="margin-top:20px;"><?php echo lang_key('available_variables'); ?> : <?php echo $values->avl_vars;?></div>

                                <span class="help-inline">&nbsp;</span>

                            </div>
                        </div>



                        <div class="form-group">
                            <label class="col-sm-3 col-lg-2 control-label"></label>

                            <div class="col-sm-9 col-lg-10 controls">
                                <button class="btn btn-primary" type="submit"><i
                                        class="fa fa-check"></i><?php echo lang_key("save") ?></button>
                            </div>
                        </div>
                    </form>
                <?php
                }
                ?>
            </div>


                <!--div class="clearfix"></div>
                <div class="form-group">
                    <label class="col-sm-3 col-lg-2 control-label"></label>

                    <div class="col-sm-9 col-lg-10 controls">
                        <?php $row = $emails->row();?>
                        <a  id="edit_tmpl" href="<?php echo site_url('admin/system/emailtmpl/'.$row->id);?>" class="btn btn-primary">
                            <i class="fa fa-check"></i><?php echo lang_key("Edit") ?></a>
                    </div>
                </div-->
            <div class="clearfix"></div>
                

            </div>
        </div>
    </div>
</div>




<script type="text/javascript">
    jQuery('#sel_tmpl').change(function(){
        jQuery('#edit_tmpl').attr('href',"<?php echo site_url('admin/system/emailtmpl');?>"+"/"+jQuery(this).val());
    });
</script>
