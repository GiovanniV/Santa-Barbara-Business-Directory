<div class="row">

    <div class="col-md-12">
        <form action= "<?php echo site_url('admin/system/get_site_map_xml')?>" method="post">
        <div class="box">
            <div class="box-title">
                <h3><i class="fa fa-bars"></i> <?php echo lang_key("generate_site_map"); ?></h3>
                <div class="box-tool">
                    <a href="#" data-action="collapse"><i class="fa fa-chevron-up"></i></a>
                </div>
            </div>

            <div class="box-content">

                <?php echo $this->session->flashdata('msg');?>
                <!--<i><?php /*echo lang_key("sitemap_info_msg"); */?></i>-->
                <ul class="sitemap-options">
                    <li class="col-md-12 ">
                        <label><input type="checkbox" value="1" name="pages" >  <?php echo lang_key("pages"); ?></label>
                    </li>
                    <li class="col-md-12 ">
                        <label><input type="checkbox" value="2" name="blog_post" >  <?php echo lang_key("blog_posts"); ?></label>
                    </li>
                    <li class="col-md-12 ">
                        <label>
                            <input type="checkbox" value="3" name="estate" >  <?php echo lang_key("ads"); ?></label>
                    </li>
                </ul>

                <div style="clear: both"></div>

                <button class="btn btn-primary" type="submit"><i class="fa fa-check"></i><?php echo lang_key("create_xml"); ?></button>
                <?php if(@file_exists('./sitemap.xml')){?>
                <a class="btn btn-success" href="<?php echo base_url('sitemap.xml')?>" target="_blank"><?php echo lang_key("view_xml"); ?></a>
                <?php }?>

                <div style="clear: both"></div>
            </div>

        </div>
        </form>
    </div>

</div>

<style type="">
.sitemap-options{
    list-style: none;
    padding: 0;
    margin: 0;
}
</style>


