<?php /* Template Name: Two-column-template */ ?>

<?php get_header(); ?>

<?php ?>
<?php if(get_field('additional_graphical_elements')): ?>
<main id="main-content" class="container-fluid sidewave" style="background-image:url(<?php echo get_template_directory_uri(); ?>/src/scss/icons/sidedecoration.svg)" role="main">
<?php else: ?>
<main id="main-content" class="container-fluid" role="main">

<?php endif; ?>
  <div class="row">
    <?php if($thumbnail = get_the_post_thumbnail_url(get_the_ID(), 'full')): ?>
    <div class="col-12 hero-image"style='background-image:url(<?php echo $thumbnail; ?>);'>
      <img role="presentation" alt="" class="wave " src="<?php echo get_template_directory_uri(); ?>/src/scss/icons/background-white-horizontal.svg">
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

    <div class="col-10 offset-1 col-lg-5 offset-lg-1">
    <?php
    // left column
    if( have_rows('left_column_content') ):
      echo '<div class="row">';
      while ( have_rows('left_column_content') ) : the_row();
        $type = get_sub_field('content_type');
        get_template_part('partials/'.$type);
      endwhile;
      echo '</div>';
    endif;
    ?>
    </div>

    <div class="col-10 offset-1 offset-lg-0 col-lg-5">
    <?php
    // right column
    if( have_rows('right_column_content') ):
      echo '<div class="row">';
      while ( have_rows('right_column_content') ) : the_row();
        $type = get_sub_field('content_type');
        get_template_part('partials/'.$type);
      endwhile;
      echo '</div>';
    endif;
    ?>
    </div>
  </div>
  <?php
    // show social sharing only if the page is not behind login
    if( ! spouse_is_restricted_page()):
  ?>
  <div class="row">
      <div class="col-6 mx-auto text-center">
          <?php dynamic_sidebar( 'social_title' ); ?>
          <?php echo do_shortcode('[SHARING_PLUS]'); ?>
      </div>
  </div>
  <?php endif; ?>
</main>


<?php get_footer(); ?>
