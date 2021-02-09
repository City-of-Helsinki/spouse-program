<?php
get_header();
?>
<main id="main-content" role="main">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12 offset-0 col-lg-6 offset-lg-3">
              <?php
              if (have_posts()) :
                while (have_posts()) :
                  echo '<h1>'.get_the_title().'</h1>';
                  the_post();
                  the_content();
                endwhile;
              endif;
              ?>
            </div>
        </div>
    </div>
</main>
<?php
get_footer();
