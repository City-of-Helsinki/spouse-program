<?php
get_header();
?>

<main id="site-content" role="main">
  <div class="container-fluid">
      <div class="row">
          <div class="col-12 col-sm-12 col-xl-5 cta-column">
              <div class="cta-background" style="background-image: url('<?php the_field('background'); ?>')">
                  <a href="<?php the_field('button_url'); ?>" class="<?php the_field('styles') ?>" ><?php echo the_field('button_text'); ?></a>
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
                    <div class="row">
                      <div class="col-4">
                          <img src="<?php the_field('image_1'); ?>"/>
                      </div>
                      <div class="col-4">
                          <img src="<?php the_field('image_2'); ?>"/>
                      </div>
                      <div class="col-4">
                          <img src="<?php the_field('image_3'); ?>"/>
                      </div>
                    </div>
                </div>
                  <i class="clearfix"></i>
              </div>
              <img class="overflow-wave d-none d-xl-block" src="<?php echo get_template_directory_uri(); ?>/src/scss/icons/background-white.svg">
              <i class="clearfix"></i>
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
