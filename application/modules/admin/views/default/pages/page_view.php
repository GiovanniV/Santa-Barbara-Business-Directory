<div class="row">

  <div class="col-md-12">

	<form action="<?php echo site_url('admin/page/add');?>" method="post">

    <div class="box">

      <div class="box-title">

        <h3><i class="fa fa-bars"></i> <?php echo $title;?></h3>

        <div class="box-tool">

          <a href="#" data-action="collapse"><i class="fa fa-chevron-up"></i></a>



        </div>

      </div>

      <div class="box-content">





		<input type="hidden" id="action" name="action" value="1">

		<input type="hidden" name="action_type" value="<?php echo (isset($action_type))?$action_type:'insert';?>">

		<?php if(isset($page) && isset($page->id)){?>

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

			else if(isset($page) && isset($page->title))

				$title = $page->title;

		?>



		<div class="form-group">

			<label class="col-sm2 col-lg-2 control-label"><?php echo lang_key('menu_title');?></label>

			<div class="col-sm-5 col-lg-6 controls">

				<input type="text" class="form-control" name="title" id="title" value="<?php echo $title;?>" placeholder="<?php echo lang_key('type_something');?>" />

				<span class="help-inline">&nbsp;</span>

				<?php echo form_error('title'); ?>

			</div>

		</div>

		

		<div style="clear:both"></div>

		<?php 

			$alias = '';

			if(set_value('alias')!='')

				$alias = set_value('alias');

			else if(isset($page) && isset($page->alias))

				$alias = $page->alias;

		?>



		<div class="form-group">

			<label class="col-sm-2 col-md-2 col-lg-2 control-label"><?php echo lang_key('menu_alias');?></label>

			<div class="col-sm-2 col-lg-3 controls">

				<input type="text" class="form-control" name="alias" id="alias" value="<?php echo $alias;?>" placeholder="<?php echo lang_key('type_something');?>" />

				<span class="help-inline">&nbsp;</span>

				<?php echo form_error('alias'); ?>

			</div>

		</div>



		<div style="clear:both"></div>

		<?php 

			$show_in_menu = '';

			if(set_value('show_in_menu')!='')

				$show_in_menu = set_value('show_in_menu');

			else if(isset($page) && isset($page->show_in_menu))

				$show_in_menu = $page->show_in_menu;

		?>

		<div class="form-group">

			<label class="col-sm-2 col-md-2 col-lg-2 control-label"><?php echo lang_key('show_in_menu');?></label>

			<div class="col-sm-2 col-lg-3 controls">

				<select name="show_in_menu" id="show_in_menu" class="form-control">

					<?php $show_in_menus = array('No','Yes')?>

					<?php foreach($show_in_menus as $key=>$row){?>

					<?php $sel = ($key==$show_in_menu)?'selected="selected"':'';?>

					<option value="<?php echo $key;?>" <?php echo $sel;?>><?php echo $row;?></option>

					<?php }?>

				</select>

				<span class="help-inline">&nbsp;</span>

				<?php echo form_error('show_in_menu'); ?>

			</div>

		</div>





		<div style="clear:both"></div>

		<?php 

			$layout = '';

			if(set_value('layout')!='')

				$layout = set_value('layout');

			else if(isset($page) && isset($page->layout))

				$layout = $page->layout;

		?>

		<div class="form-group">

			<label class="col-sm-2 col-md-2 col-lg-2 control-label"><?php echo lang_key('page_layout');?></label>

			<div class="col-sm-2 col-lg-3 controls">

				<select name="layout" id="layout" class="form-control">

					<?php $layouts = array('Left bar with content','Right bar with content','Only content')?>

					<?php foreach($layouts as $key=>$row){?>

					<?php $sel = ($key==$layout)?'selected="selected"':'';?>

					<option value="<?php echo $key;?>" <?php echo $sel;?>><?php echo $row;?></option>

					<?php }?>

				</select>

				<span class="help-inline">&nbsp;</span>

			</div>

		</div>



		<div style="clear:both"></div>

		<?php 

			$content_from = '';

			if(set_value('content_from')!='')

				$content_from = set_value('content_from');

			else if(isset($page) && isset($page->content_from))

				$content_from = $page->content_from;

		?>

		<div class="form-group">

			<label class="col-sm-2 col-md-2 col-lg-2 control-label"><?php echo lang_key('content_from');?></label>

			<div class="col-sm-2 col-lg-3 controls">

				<select name="content_from" id="content_from" class="form-control" >

					<?php $content_froms = array('Url','Manual')?>

					<?php foreach($content_froms as $key=>$row){?>

					<?php $sel = ($row==$content_from)?'selected="selected"':'';?>

					<option value="<?php echo $row;?>" <?php echo $sel;?>><?php echo $row;?></option>

					<?php }?>

				</select>

				<span class="help-inline">&nbsp;</span>

				<?php echo form_error('content_from'); ?>

			</div>

		</div>



		<div style="clear:both"></div>

		<?php 

			$url = '';

			if(set_value('url')!='')

				$url = set_value('url');

			else if(isset($page) && isset($page->url))

				$url = $page->url;

		?>

		<div class="form-group url">

			<label class="col-sm-2 col-md-2 col-lg-2 control-label"><?php echo lang_key('url');?></label>

			<div class="col-sm-5 col-lg-6 controls">

				<input type="text" class="form-control" name="url" value="<?php echo $url;?>" placeholder="<?php echo lang_key('type_something');?>"  />

				<span class="help-inline">&nbsp;</span>

				<?php echo form_error('url'); ?>

			</div>

		</div>





		<div style="clear:both"></div>

		<div class="manual" style="min-height:500px;">

			<div class="left-bar" style="width:25%;float:left;margin:0">

				<label>Left bar</label>

				<?php 

					$sidebar = '';

					if(set_value('sidebar')!='')

						$sidebar = set_value('sidebar');

					else if(isset($page) && isset($page->sidebar))

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

					else if(isset($page) && isset($page->content))

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

					else if(isset($page) && isset($page->sidebar))

						$sidebar = $page->sidebar;

				?>		

				<textarea name="rightbar" class="rich" style="height:336px"><?php echo $sidebar;?></textarea>

			</div>

		</div>

		<div style="clear:both"></div>	

	 </div>

    </div>



    <div class="box">

      <div class="box-title">

        <h3><i class="fa fa-bars"></i> <?php echo lang_key('seo_options');?></h3>

        <div class="box-tool">

          <a href="#" data-action="collapse"><i class="fa fa-chevron-up"></i></a>

          <a href="#" data-action="close"><i class="fa fa-times"></i></a>

        </div>

      </div>

      <div class="box-content">

      		<?php 

      		$seo_settings = (isset($page->seo_settings) && $page->seo_settings!='')?(array)json_decode($page->seo_settings):array();

      		?>

	      	<div class="form-group">

				<label class="col-sm-2 col-md-2 col-lg-2 control-label"><?php echo lang_key('meta_description');?>:</label>

				<div class="col-sm-2 col-lg-3 controls">

					<textarea class="form-control" name="meta_description"><?php echo (isset($seo_settings['meta_description']))?$seo_settings['meta_description']:'';?></textarea>

					<span class="help-inline">&nbsp;</span>

					<?php echo form_error('meta_description'); ?>

				</div>

			</div>

			<div style="clear:both"></div>



			<div class="form-group">

				<label class="col-sm-2 col-md-2 col-lg-2 control-label"><?php echo lang_key('key_words');?>:</label>

				<div class="col-sm-2 col-lg-3 controls">

					<textarea class="form-control" name="key_words"><?php echo (isset($seo_settings['key_words']))?$seo_settings['key_words']:'';?></textarea>

					<span class="help-inline">&nbsp;</span>

					<?php echo form_error('key_words'); ?>

				</div>

			</div>

			<div style="clear:both"></div>



			<div class="form-group">

				<label class="col-sm-2 col-md-2 col-lg-2 control-label"><?php echo lang_key('crawl_after');?>:</label>

				<div class="col-sm-2 col-lg-3 controls">

					<input type="text" class="form-control" name="crawl_after" value="<?php echo (isset($seo_settings['crawl_after']))?$seo_settings['crawl_after']:'';?>">

					<span class="help-inline">&nbsp;</span>

					<?php echo form_error('crawl_after'); ?>

				</div>

			</div>

			<div style="clear:both"></div>



			<input type="submit" value="Draft" class="btn btn-primary submit" action="2">

			<input type="submit" value="Publish" class="btn btn-success submit" action="1">

			<input type="submit" value="Delete" class="btn btn-danger submit" action="0">

			<div style="margin-bottom:20px;"></div>



      </div>

    </div>



	</form>

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



	jQuery('#content_from').change(function(){

		var content_from = jQuery(this).val();

		if(content_from=='Manual')

		{

			jQuery('.manual').show();

			jQuery('.url').hide();

		}

		else

		{

			jQuery('.manual').hide();

			jQuery('.url').show();			

		}

	}).change();



	jQuery('#title').keyup(function(e){

		makealias(jQuery(this).val());

	});



	jQuery('#title').change(function(e){

		makealias(jQuery(this).val());

	}).change();

});



function makealias(val)

{

	val = val.toLowerCase();

	val = val.replace(/\s/g, '');

	val = val.replace('[', '');

	val = val.replace(']', '');

	jQuery('#alias').val(val);

}



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

