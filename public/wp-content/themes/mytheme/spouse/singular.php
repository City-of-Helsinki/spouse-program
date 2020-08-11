<?php
get_header();
?>
    <div class="container-fluid">
        <main id="main-content" class="container-fluid" role="main">
            <div class="row">
              <?php if($thumbnail = get_the_post_thumbnail_url(get_the_ID(), 'full')):
                $position = get_field('hero_image_position');
                $style = "background-position: $position";
                ?>
                  <div class="col-12 hero-image" style='background-image:url(<?php echo $thumbnail; ?>); <?php echo $style ?>'>
                      <img role="presentation" alt="" class="wave" src="<?php echo get_template_directory_uri(); ?>/src/scss/icons/background-white-horizontal.svg">
                  </div>
              <?php endif; ?>
                <div class="col-12 offset-0 col-lg-6 offset-lg-3">
                    <h1><?php the_title(); ?></h1>
                  <?php
                  if (have_posts()) :
                    while (have_posts()) :
                      the_post();
                      the_content();
                    endwhile;
                  endif;
                  ?>
                </div>
            </div>
        </main><!-- #site-content -->
    </div>
<?php
get_footer();
