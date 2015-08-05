<?php echo $this->session->flashdata('msg');?>
<form role="form" action="<?php echo site_url('show/sendemailtoagent/'.$post->created_by);?>" method="post" id="message-form">
    <input type="hidden" name="unique_id" value="<?php echo $post->unique_id;?>">
    <input type="hidden" name="title" value="<?php echo get_post_data_by_lang($post,'title'); ?>">
    <input type="hidden" name="url" value="<?php echo post_detail_url($post); ?>">
    <input type="hidden" name="to_email" value="<?php echo $post->email; ?>">

    <div class="row">
        <div class="col-md-4 col-sm-4">
            <div class="form-group">
                <label for="enquiryInput1"><?php echo lang_key('name'); ?></label>
                <input type="text" placeholder="<?php echo lang_key('name'); ?>" value="<?php echo set_value('sender_name');?>" name="sender_name" id="sender_name" class="form-control">
                <?php echo form_error('sender_name');?>
            </div>
        </div>
        <div class="col-md-4 col-sm-4">
            <div class="form-group">
                <label for="enquiryInput2"><?php echo lang_key('email'); ?></label>
                <input type="text" placeholder="<?php echo lang_key('email'); ?>" value="<?php echo set_value('sender_email');?>" name="sender_email" id="sender_email" class="form-control">
                <?php echo form_error('sender_email');?>
            </div>
        </div>
        <div class="col-md-4 col-sm-4">
            <div class="form-group">
                <label for="enquiryInput3"><?php echo lang_key('phone'); ?></label>
                <input type="text" placeholder="<?php echo lang_key('phone'); ?>" value="<?php echo set_value('phone');?>" name="phone" id="phone" class="form-control">
                <?php echo form_error('phone');?>
            </div>
        </div>
    </div>
    <div class="form-group">
        <label for="enquiryInput3"><?php echo lang_key('subject'); ?></label>
        <input type="text" placeholder="<?php echo lang_key('subject'); ?>" value="<?php echo set_value('subject');?>" name="subject" id="subject" class="form-control">
        <?php echo form_error('subject');?>
    </div>
    <div class="form-group">
        <label for="enquiryInput4"><?php echo lang_key('message'); ?></label>
        <textarea rows="7" placeholder="<?php echo lang_key('message'); ?>" name="msg" id="msg" class="form-control"><?php echo set_value('msg');?></textarea>
        <?php echo form_error('msg');?>
    </div>
    <div class="row">
        <div class="col-sm-12">
            <span class="agent-form-question"><?php echo (isset($question))?$question:'';?></span>
            <input type="text" name="ans" value="" class="form-control agent-form-answer-input">
            <div class="clearfix"></div><?php echo form_error('ans');?>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-12">
            <div class="checkbox">
                <label>
                    <input type="checkbox" name="terms_conditon" id="terms_conditon" <?php echo (isset($_POST['terms_conditon']))?'checked':'';?>>
                    <?php echo sprintf(lang_key('agree_terms'),'<a target="_blank" href="'.site_url('show/terms').'">','</a>');?>
                </label>
                <?php echo form_error('terms_conditon');?>
            </div>
        </div>
    </div>

    <div class="clear-top-margin"></div>
    <button class="btn btn-color" type="submit"><?php echo lang_key('send'); ?></button> &nbsp; <button class="btn btn-white" type="submit"><?php echo lang_key('reset'); ?></button>
</form>