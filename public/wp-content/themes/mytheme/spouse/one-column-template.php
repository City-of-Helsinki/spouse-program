<?php /*Template Name: One-column-template */ ?>

<?php get_header(); ?>

<?php if(get_field('additional_graphical_elements')): ?>
<main id="main-content" class="container-fluid sidewave" style="background-image:url(<?php echo get_template_directory_uri(); ?>/src/scss/icons/sidedecoration.svg)" role="main">
<?php else: ?>
<main id="main-content" class="container-fluid" role="main">

<?php endif; ?>
    <div class="row">
        <?php if($thumbnail = get_the_post_thumbnail_url(get_the_ID(), 'full')):
        $position = get_field('hero_image_position');
        $style = "background-position: $position";
        ?>
        <div class="col-12 hero-image" style='background-image:url(<?php echo $thumbnail; ?>); <?php echo $style ?>'>
          <img role="presentation" alt="" class="wave" src="<?php echo get_template_directory_uri(); ?>/src/scss/icons/background-white-horizontal.svg">
        </div>
        <?php endif; ?>

        <?php
            if(spouse_is_restricted_page()){
                ?>
            <div class="col-12 col-sm-12 col-lg-3 menu">

              <?php
              wp_nav_menu( array(
                'theme_location' => 'sidebar-menu',
                'container_class' => 'sidebar-menu' ) );
              ?>

              <?php #wp_nav_menu(array('menu' => 7));  ?>
            </div>
            <?php
            }
        ?>

        <?php if(spouse_is_restricted_page()): ?>
            <div class="col-10 offset-1 col-lg-6 offset-lg-0">
        <?php else: ?>
            <div class="col-10 offset-1 col-lg-6 offset-lg-3">
        <?php endif; ?>
            <h1><?php the_title(); ?></h1>
        <?php
        // center
        if (have_rows('left_column_content')):
          echo '<div class="row">';
          while (have_rows('left_column_content')) : the_row();
            $type = get_sub_field('content_type');
            get_template_part('partials/'.$type);
          endwhile;
          echo '</div>';
        endif;
        ?>
        </div>
          <?php
          if(spouse_is_restricted_page()){
            ?>
              <div class="col-12 col-sm-12 col-lg-4 col-xl-3 events-column">
                  <h2>Upcoming events</h2>
                <?php echo do_shortcode('[spouse-events]'); ?>
              </div>
            <?php
          }
          ?>
    </div>
  <?php
  // show social sharing only if the page is not behind login
  if( ! spouse_is_restricted_page()):
    ?>
      <div class="row">
          <div class="col-6 mx-auto text-center">
            <h4><?php dynamic_sidebar( 'social_title' ); ?></h4>
            <?php echo do_shortcode('[SHARING_PLUS]'); ?>
          </div>
      </div>
  <?php endif; ?>
</main>

<?php get_footer(); ?>
