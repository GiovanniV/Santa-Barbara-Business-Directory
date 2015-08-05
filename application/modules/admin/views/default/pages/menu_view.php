<script src="<?php echo base_url();?>assets/admin/js/jquery.nestable.js"></script>
<link href="<?php echo base_url();?>assets/admin/css/nestable.css" rel="stylesheet">

<div class="row">
  <div class="col-md-12">
    <div class="box">
      <div class="box-title">
        <h3><i class="fa fa-bars"></i><?php echo lang_key('manage_menu');?></h3>
        <div class="box-tool">
          <a href="#" data-action="collapse"><i class="fa fa-chevron-up"></i></a>

        </div>
      </div>
      <div class="box-content">

            <?php echo $this->session->flashdata('msg');?>
            <form id="menu-form" action="<?php echo site_url('admin/page/update_menu');?>" method="post">
                <?php
                    $CI = get_instance();
                    $CI->page_model->init();
                ?>
                <div class="dd" id="nestable">
                    <ol class="dd-list">
                        <?php 
                            $menu_pages = array();
                            foreach ($CI->page_model->get_menu() as $li) {
                                array_push($menu_pages,$li->id);
//                               echo $li->id.' - '.$li->parent;
                                if($li->parent==0)
                                $CI->page_model->render_menu($li->id,0);
                            }

                            $not_menu_pages = $CI->page_model->get_pages_not_in_menu($menu_pages);
                            foreach ($not_menu_pages as $li) {
                                 $CI->page_model->render_menu($li->id,0);
                            }
                        ?>
                    </ol>
                </div>
                <input type="hidden" name="top_menu" id="top_menu" values="[]">
                <div style="clear:both"></div>
               	<input id="submit" type="submit" value="<?php echo lang_key('save');?>" class="btn btn-success">
            </form>
        </div>
    </div>
  </div>
</div>            

<script type="text/javascript">

jQuery(document).ready(function()
{

    var updateOutput = function(e)
    {
        var list   = e.length ? e : jQuery(e.target),
            output = list.data('output');
        if (window.JSON) {
            output.val(window.JSON.stringify(list.nestable('serialize')));//, null, 2));
        } else {
            output.val('JSON browser support required for this demo.');
        }
    };

    // activate Nestable for list 1
    jQuery('#nestable').nestable({
        group: 1
    })
    .on('change', updateOutput);
    

    // output initial serialised data
    updateOutput(jQuery('#nestable').data('output', jQuery('#nestable-output')));

    jQuery('#nestable-menu').on('click', function(e)
    {
        var target = jQuery(e.target),
            action = target.data('action');
        if (action === 'expand-all') {
            jQuery('.dd').nestable('expandAll');
        }
        if (action === 'collapse-all') {
            jQuery('.dd').nestable('collapseAll');
        }
    });
    jQuery('#menu-form').submit(function(e){
        var data = [];
		jQuery('.dd-item').each(function(){
			var id 		= jQuery(this).attr('data-id');
			var parent  = jQuery(this).parent().parent().attr('data-id');
			if(typeof parent == 'undefined')
				parent = 0;
			var menu = {'id':id,'parent':parent};
            data.push(menu);
		}); 
        jQuery('#top_menu').val(JSON.stringify(data));
    });
});
</script>