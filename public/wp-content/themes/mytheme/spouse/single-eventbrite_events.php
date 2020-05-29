<?php get_header(); ?>

<div class="container-fluid">
  <div class="row">
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
</div>

<?php get_footer(); ?>
