<?php
if ( is_user_logged_in() && !current_user_can('administrator') && !current_user_can('editor')) {
    if(wp_redirect('main-page')) {
      exit;
    }
}
?>
<?php
get_header();
?>

<main id="site-content" role="main">
  <div class="container-fluid">
      <div class="row">
          <div class="col-12 col-sm-12 col-xl-5 cta-column">
              <div class="cta-background" style="background-image: url(<?php echo get_the_post_thumbnail_url(get_the_ID(), 'full'); ?>);">
                  <?php $buttonEnabled = get_field('enable_cta-button') ?>
                  <?php if($buttonEnabled): ?>
                    <?php get_template_part('partials/cta'); ?>
                  <?php endif; ?>
              </div>
          </div>
          <div class="col-12 col-sm-12 col-lg-6 col-xl-4 main-content">
              <div class="main-content-container">
                <?php
                if (have_posts()) :
                while (have_posts()) :
                    the_post();
                    the_content();
                endwhile;
                endif;
                ?>
                <div class="small-images clearfix">
                    <div class="row mx-auto">
                        <?php
                        while ( have_rows('images') ) : the_row();
                          $img = get_sub_field('image');
                        ?>
                        <div class="col-4">
                            <img src="<?php echo $img; ?>"/>
                        </div>
                        <?php
                        endwhile;
                        ?>
                    </div>
                </div>
              </div>
              <img class="overflow-wave d-none d-xl-block" src="<?php echo get_template_directory_uri(); ?>/src/scss/icons/background-white.svg">
          </div>
          <div class="col-12 col-sm-12 col-lg-6 col-xl-3 events-column">
              <h2>Upcoming events</h2>
              <?php echo do_shortcode('[spouse-events]'); ?>
          </div>
      </div>
  </div>
</main><!-- #site-content -->

<?php # get_template_part( 'template-parts/footer-menus-widgets' ); ?>

<?php
get_footer();
