<link href="<?php echo theme_url();?>/assets/layerslider/css/layerslider.css" rel="stylesheet">
<script src="<?php echo theme_url();?>/assets/layerslider/js/greensock.js" type="text/javascript"></script>
<!-- LayerSlider script files -->
<script src="<?php echo theme_url();?>/assets/layerslider/js/layerslider.transitions.js" type="text/javascript"></script>
<script src="<?php echo theme_url();?>/assets/layerslider/js/layerslider.kreaturamedia.jquery.js" type="text/javascript"></script>

<style>

    /*
        You can add your custom layer styles
        in the style attribute of the layer,
        to a style element or
        to an external css file
    */

    #layerslider * {
        font-family: Lato, 'Open Sans', sans-serif;
    }

</style>
<div id="layerslider" style="width:100%;height:500px;">
    <div class="ls-slide" data-ls="transition2d:1;timeshift:-1000;">
        <img src="<?php echo base_url('uploads/images/banner2.jpg');?>" class="ls-bg" alt="Slide background"/>
		<img class="ls-l ls-linkto-3" style="top:460px;left:610px;white-space: nowrap;" data-ls="offsetxin:-50;delayin:1000;rotatein:-40;offsetxout:-50;rotateout:-40;" src="<?php echo theme_url();?>/assets/layerslider/img/left.png" alt="slide-image">
        <img class="ls-l ls-linkto-2" style="top:460px;left:650px;white-space: nowrap;" data-ls="offsetxin:50;delayin:1000;offsetxout:50;" src="<?php echo theme_url();?>/assets/layerslider/img/right.png" alt="slide-image">
    </div>
    <div class="ls-slide" data-ls="transition2d:1;timeshift:-1000;">
        <img src="<?php echo base_url('uploads/images/banner1.jpg');?>" class="ls-bg" alt="Slide background"/>        
        <img class="ls-l ls-linkto-2" style="top:430px;left:960px;white-space: nowrap;" data-ls="offsetxin:-50;delayin:1000;offsetxout:-50;" src="<?php echo theme_url();?>/assets/layerslider/img/left.png" alt="slide-image">
        <img class="ls-l ls-linkto-1" style="top:430px;left:1000px;white-space: nowrap;" data-ls="offsetxin:50;delayin:1000;offsetxout:50;" src="<?php echo theme_url();?>/assets/layerslider/img/right.png" alt="slide-image">
    </div>
</div>
</div>

<!-- Initializing the slider -->
<script>
    var skins_path = '<?php echo theme_url();?>/assets/layerslider/skins/'
    jQuery("#layerslider").layerSlider({
        responsive: false,
        responsiveUnder: 1280,
        layersContainer: 1280,
        skin: 'noskin',
        hoverPrevNext: false,
        skinsPath: skins_path
    });
</script>