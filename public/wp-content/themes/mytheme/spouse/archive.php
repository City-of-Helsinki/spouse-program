<?php
get_header();
?>
  <main id="main-content" role="main">
    <div class="container-fluid">
      <div class="row">
        <div class="col-12 text-center archive">
          <h1><?php echo single_cat_title() ?></h1>
        </div>

        <aside class="col-12 col-lg-3 archive menu">
          <?php if(single_cat_title('', false) == 'News'): ?>
          <h2>Filter news by year</h2>
          <nav aria-label="Submenu">
          <?php
          wp_custom_archive();
          ?>
          </nav>
          <?php endif; ?>
        </aside>

      <div class="col-12 offset-0 col-lg-6">
        <?php
        if (have_posts()) :
          while (have_posts()) :
            the_post();
            ?>
            <ul class="list-unstyled">
              <?php
                ?><li><?php
                $date = new DateTime($post->post_date);
                echo '<a href="'.get_permalink($post).'">';
                echo $date->format('Y-m-d').' '.$post->post_title;
                echo '</a>';
                echo '<hr>';
                ?></li><?php
          endwhile;
        endif;
        ?>
      </div>
    </div>
  </div>
</main>
<?php
get_footer();
