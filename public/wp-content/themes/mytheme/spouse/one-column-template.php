<?php /*Template Name: One-column-template */ ?>

<?php get_header(); ?>

<main class="container-fluid sidewave" style="background-image:url(<?php echo get_template_directory_uri(); ?>/src/scss/icons/sidedecoration.svg)" role="main-content">
    <div class="row">
        <?php if($thumbnail = get_the_post_thumbnail_url(get_the_ID(), 'full')): ?>
        <div class="col-12 hero-image"style='background-image:url(<?php echo $thumbnail; ?>);'>
          <img class="wave" src="<?php echo get_template_directory_uri(); ?>/src/scss/icons/background-white-horizontal.svg">
        </div>
        <?php endif; ?>
        <div class="col-10 offset-1 col-lg-6 offset-lg-3">
            <h1><?php the_title(); ?></h1>
        <?php
        // center
        if (have_rows('content')):
          while (have_rows('content')) : the_row();
            $type = get_sub_field('content_type');
            get_template_part('partials/'.$type);
          endwhile;
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
              <h4>Spread the word on social media</h4>
            <?php echo do_shortcode('[SHARING_PLUS]'); ?>
          </div>
      </div>
  <?php endif; ?>
</main>

<?php get_footer(); ?>
