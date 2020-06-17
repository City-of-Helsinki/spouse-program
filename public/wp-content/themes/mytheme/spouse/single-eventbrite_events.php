<?php get_header(); ?>

<main class="container-fluid">
  <div class="row">
    <?php if($thumbnail = get_the_post_thumbnail_url(get_the_ID(), 'full')):
      $position = get_field('hero_image_position') ? get_field('hero_image_position') : 'center';
      $style = "background-position: $position";
      ?>
        <div class="col-12 hero-image" style='background-image:url(<?php echo $thumbnail; ?>); <?php echo $style ?>'>
            <!--
            <img role="presentation" alt="" class="wave" src="<?php echo get_template_directory_uri(); ?>/src/scss/icons/background-white-horizontal.svg">
            -->
        </div>
    <?php endif; ?>
    <div class="col-12 col-sm-4">
        <div class="single-event-meta">
            <?php echo apply_filters( 'the_content', get_the_content() ); ?>
        </div>
    </div>
    <div class="col-12 col-sm-4">
        <div class="single-event-content">
            <h1><?php echo the_title(); ?></h1>
            <p><?php echo $post->post_content; ?></p>
            <?php echo get_field('description') ?>
        </div>
    </div>
    <div class="col-12 col-sm-4">
        <div class="single-event-registration"></div>
    </div>
  </div>
</main>

<?php get_footer(); ?>
