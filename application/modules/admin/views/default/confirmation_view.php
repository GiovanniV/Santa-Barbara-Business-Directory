<div class="alert alert-danger">
    <button type="button" class="close" data-dismiss="alert">&times;</button>
    <strong>Warning!</strong> <?php echo lang_key('delete_warning'); ?>
</div>
<a href="<?php echo $url."/$id/yes";?>" class="btn btn-success"><?php echo lang_key('yes'); ?></a><a href="<?php echo $url."/$id/no";?>" class="btn btn-inverse" style="margin-left:10px;"><?php echo lang_key('no'); ?></a>