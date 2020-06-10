<?php /* Template Name: Two-column-template */ ?>

<?php get_header(); ?>

<main class="container-fluid" role="main-content">
  <div class="row">
    <?php if($thumbnail = get_the_post_thumbnail_url(get_the_ID(), 'full')): ?>
    <div class="col-12 hero-image"style='background-image:url(<?php echo $thumbnail; ?>);'>
      <img class="wave " src="<?php echo get_template_directory_uri(); ?>/src/scss/icons/background-white-horizontal.svg">
    </div>
    <?php endif; ?>

    <div class="col-12">
      <?php
      if (have_posts()) :
        while (have_posts()) :
          the_post();
          ?>
            <h1><?php echo get_the_title(); ?></h1>
        <?php
        endwhile;
      endif;
      ?>
    </div>

    <div class="col-10 offset-1 col-lg-4 offset-lg-2">
    <?php
    // left column
    if( have_rows('left_column_content') ):
      while ( have_rows('left_column_content') ) : the_row();
        $type = get_sub_field('content_type');
        get_template_part('partials/'.$type);
      endwhile;
    endif;
    ?>
    </div>

    <div class="col-10 offset-1 offset-lg-0 col-lg-4">
    <?php
    // right column
    if( have_rows('right_column_content') ):
      while ( have_rows('right_column_content') ) : the_row();
        $type = get_sub_field('content_type');
        get_template_part('partials/'.$type);
      endwhile;
    endif;
    ?>
    </div>


  </div>
</main>


<?php get_footer(); ?>
