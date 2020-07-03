<?php /*Template Name: Main-page-template */ ?>

<?php
get_header();
?>
<main id="site-content" role="main">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12 col-sm-12 col-xl-3 menu">
                <?php wp_nav_menu(array('menu' => 7));  ?>
            </div>
            <div class="col-12 col-sm-12 col-lg-6 col-xl-6 main-content">
                <div class="row">
                <div class="main-content-container">
                  <?php
                  if (have_posts()) :
                    while (have_posts()) :
                      the_post();
                  ?>
                  <?php
                      the_content();
                    endwhile;
                  endif;
                  ?>
                </div>
                </div>
            </div>
            <div class="col-12 col-sm-12 col-lg-6 col-xl-3 events-column">
                <h2>Upcoming events</h2>
              <?php echo do_shortcode('[spouse-events]'); ?>
            </div>
        </div>
    </div>
</main><!-- #site-content -->

<?php
get_footer();
?>