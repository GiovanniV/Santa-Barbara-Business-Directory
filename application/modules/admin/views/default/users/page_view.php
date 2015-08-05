<div class="row">
  <div class="col-md-12">
    <div class="box">
      <div class="box-title">
        <h3><i class="fa fa-bars"></i> <?php echo lang_key('edit_page');?></h3>
        <div class="box-tool">
          <a href="#" data-action="collapse"><i class="fa fa-chevron-up"></i></a>

        </div>
      </div>
      <div class="box-content">

		<form action="<?php echo site_url('admin/page/add');?>" method="post">
		<input type="hidden" id="action" name="action" value="1">
		<input type="hidden" name="action_type" value="<?php echo (isset($action_type))?$action_type:'insert';?>">
		<?php if(isset($page->id)){?>
		<input type="hidden" name="id" value="<?php echo $page->id;?>">
		<?php }?>
		<?php echo $this->session->flashdata('msg');?>
		<input type="submit" value="Draft" class="btn btn-primary submit" action="2">
		<input type="submit" value="Publish" class="btn btn-success submit" action="1">
		<input type="submit" value="Delete" class="btn btn-danger submit" action="0">
		<div style="margin-bottom:20px;"></div>

		<?php 
			$title = '';
			if(set_value('title')!='')
				$title = set_value('title');
			else if(isset($page->title))
				$title = $page->title;
		?>

		<div class="form-group">
			<label class="col-sm-1 col-lg-1 control-label"><?php echo lang_key('menu_title');?></label>
			<div class="col-sm-2 col-lg-3 controls">
				<input type="text" class="form-control" name="title" value="<?php echo $title;?>" placeholder="<?php echo lang_key('type_something');?>" />
				<span class="help-inline">&nbsp;</span>
				<?php echo form_error('title'); ?>
			</div>
		</div>
		
		<div style="clear:both"></div>
		<?php 
			$layout = '';
			if(set_value('layout')!='')
				$layout = set_value('layout');
			else if(isset($page->layout))
				$layout = $page->layout;
		?>
		<div class="form-group">
			<label class="col-sm-1 col-lg-1 control-label"><?php echo lang_key('page_layout');?></label>
			<div class="col-sm-2 col-lg-3 controls">
				<select name="layout" id="layout" class="form-control">
					<?php $layouts = array('Left bar with content','Right bar with content','Only content')?>
					<?php foreach($layouts as $key=>$row){?>
					<?php $sel = ($key==$layout)?'selected="selected"':'';?>
					<option value="<?php echo $key;?>" <?php echo $sel;?>><?php echo $row;?></option>
					<?php }?>
				</select>
				<span class="help-inline">&nbsp;</span>
				<?php echo form_error('title'); ?>
			</div>
		</div>


		<div style="clear:both"></div>
		<div style="min-height:500px;">
			<div class="left-bar" style="width:25%;float:left;margin:0">
				<label>Left bar</label>
				<?php 
					$sidebar = '';
					if(set_value('sidebar')!='')
						$sidebar = set_value('sidebar');
					else if(isset($page->sidebar))
						$sidebar = $page->sidebar;
				?>		
				<textarea name="leftbar" class="rich" style="height:336px"><?php echo $sidebar;?></textarea>
			</div>
			<div class="main-content" style="width:75%;float:left;margin:0">
				<label><?php echo lang_key('content');?></label>
				<?php 
					$content = '';
					if(set_value('content')!='')
						$content = set_value('content');
					else if(isset($page->content))
						$content = $page->content;
				?>		
				<textarea name="content" class="rich" style="height:434px"><?php echo $content;?></textarea>
			</div>
			<div class="right-bar" style="width:25%;float:left;margin:0">
				<label>Right bar</label>
				<?php 
					$sidebar = '';
					if(set_value('sidebar')!='')
						$sidebar = set_value('sidebar');
					else if(isset($page->sidebar))
						$sidebar = $page->sidebar;
				?>		
				<textarea name="rightbar" class="rich" style="height:336px"><?php echo $sidebar;?></textarea>
			</div>
		</div>
	 </div>
    </div>
  </div>
</div>

<script type="text/javascript" src="<?php echo base_url('assets/tinymce/tinymce.min.js');?>"></script>
<script type="text/javascript">
tinymce.init({
	convert_urls : 0,
    selector: ".rich",
    plugins: [
         "advlist autolink link image lists charmap print preview hr anchor pagebreak spellchecker",
         "searchreplace wordcount visualblocks visualchars code fullscreen insertdatetime media nonbreaking",
         "save code table contextmenu directionality emoticons template paste textcolor"
   ]
 });
jQuery(document).ready(function(){
	jQuery('#layout').trigger('change');
	jQuery('.submit').click(function(e){
		jQuery('#action').val(jQuery(this).attr('action'));
	});
});

jQuery('#layout').change(function(){
	var val = jQuery(this).val();
	if(val==2)
	{
		jQuery('.left-bar').hide();
		jQuery('.right-bar').hide();
		jQuery('.main-content').css('width','100%');
	}
	else if(val==0)
	{
		jQuery('.left-bar').show();
		jQuery('.right-bar').hide();
		jQuery('.main-content').css('width','75%');
		
	}
	else if(val==1)
	{
		jQuery('.left-bar').hide();
		jQuery('.right-bar').show();
		jQuery('.main-content').css('width','75%');		
	}		
});
</script>
