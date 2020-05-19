<?php
get_header();
?>

<main id="site-content" role="main">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
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
    </div>
</main><!-- #site-content -->

<?php get_template_part( 'template-parts/footer-menus-widgets' ); ?>

<?php
get_footer();
