<?php require 'home_custom_search.php';  ?>

<!-- Container -->
<div class="container main-container">

    <div class="row">

        <div class="col-md-9 col-sm-12 col-xs-12">
            <?php render_widgets('home_page');?>
        </div>


        <div class="col-md-3 col-sm-12 col-xs-12">
            <div class="sidebar">
                <?php require_once'sidebar.php';?>                   
            </div>
        </div>

    </div>
</div>
