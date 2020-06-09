<?php get_header(); ?>

<div class="container-fluid">
  <div class="row">
    <!--
    <div class="d-none col-md-4"></div>
    -->
    <div class="col-4 col-md-4">

    </div>
    <div class="col-12 col-md-4">
      <?php
      if (have_posts()) :
        while (have_posts()) :
          the_post();
          the_content();
        endwhile;
      endif;
      ?>
    </div>
    <div class="d-none col-md-4">

    </div>
  </div>
</div>


<?php get_footer(); ?>
