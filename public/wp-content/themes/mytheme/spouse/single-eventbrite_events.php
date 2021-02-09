<?php get_header(); ?>

<main class="container-fluid">
  <div class="row">
    <?php if($thumbnail = get_the_post_thumbnail_url(get_the_ID(), 'full')):
      $position = get_field('hero_image_position') ? get_field('hero_image_position') : 'center';
      $style = "background-position: $position";
      ?>
        <div class="col-12 hero-image" style='background-image:url(<?php echo $thumbnail; ?>); <?php echo $style ?>'>
        </div>
    <?php endif; ?>
    <div class="col-12 text-center"><h1><?php echo the_title(); ?></h1></div>
    <?php
    if(is_user_logged_in()){
      ?>
        <aside class="d-none d-md-none d-lg-block col-lg-3 col-xl-3 menu">
            <div class="sidebar-menu-wrap">
                <h2>Menu</h2>
                <nav aria-label="Submenu">
                  <?php
                  wp_nav_menu( array(
                    'theme_location' => 'sidebar-menu',
                    'container_class' => 'sidebar-menu' ) );
                  ?>
                </nav>
            </div>
        </aside>
      <?php
    }
    ?>
    <div class="col-12 col-sm-4">
        <div class="single-event-meta" style="color:black;">
            <?php echo apply_filters( 'the_content', get_the_content() ); ?>
        </div>
    </div>
    <div class="col-12 col-sm-4">
        <div class="single-event-content">

            <p><?php echo apply_filters( 'the_content', $post->post_content); ?></p>
            <?php echo get_field('description') ?>
        </div>
    </div>
  </div>
</main>

<?php get_footer(); ?>
