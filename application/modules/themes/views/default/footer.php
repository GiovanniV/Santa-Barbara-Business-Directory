
<footer>
    <!-- Container -->
    <div class="container">
        <!-- Footer Content -->
            <!-- Paragraph -->
            <p class="pull-left"><?php echo translate(get_settings('site_settings','footer_text','copyright@'));?></p>
            <?php render_widget('footer_links') ?>
            <!-- Clearfix -->
            <div class="clearfix"></div>
    </div>
</footer>