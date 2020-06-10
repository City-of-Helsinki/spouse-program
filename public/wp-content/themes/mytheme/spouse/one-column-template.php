<?php /*Template Name: One-column-template */ ?>

<?php get_header(); ?>

<main class="container-fluid" role="main-content">
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
</main>


<?php get_footer(); ?>
