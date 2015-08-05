<!-- Page heading two starts -->
<div class="page-heading-two">
    <div class="container">
        <h2><?php echo lang_key('sitemap'); ?></h2>
        <div class="breads">
            <a href="<?php echo site_url(); ?>"><?php echo lang_key('home'); ?></a> / <?php echo lang_key('sitemap'); ?>
        </div>
        <div class="clearfix"></div>
    </div>
</div>

<div class="container">

    <div class="sitemap">


        <div class="row">
            <div class="col-md-12 col-sm-13">
                <!-- Heading -->
                <h4><i class="fa fa-comment color"></i> <?php echo lang_key('sitemap'); ?></h4>
                <hr />
                <ul class="list-3">
                    <?php foreach($links->url as $url){?>
                        <li><a href="<?php echo $url->loc;?>"><?php echo $url->loc;?></a></li>
                    <?php }?>

                </ul>
                <!-- Heading -->

            </div>
        </div>
    </div>

</div>
</div>

<!-- Main content ends -->