<?php
/*
Template Name: Archives
*/

get_header();
?>

<main id="main-content" role="main">
  <div class="container-fluid">
      <div class="row">
          <div class="col-12 text-center">
            <h1><?php echo get_the_title(); ?></h1>
          </div>
      </div>
    <div class="row">

        <aside class="col-12 order-last order-lg-first col-lg-3 archive">
            <h2>Filter news by year</h2>
            <?php
            wp_custom_archive();
            ?>
        </aside>
        <div class="col-12 offset-0 col-lg-6">
        <?php
        if (have_posts()) :
        while (have_posts()) :
          the_post();
          the_content();
        endwhile;
        endif;
        ?>
        <?php
        $options = [
          'post_status' => 'publish',
          'orderby' => 'date',
          'order' => 'DESC',
          'numberposts' => 15,
        ];
        $posts = get_posts($options);
        ?>
        <ul class="list-unstyled">
        <?php
        foreach($posts as $post){
        ?><li><?php
        $date = new DateTime($post->post_date);
        echo '<a href="'.get_permalink($post).'">';
        echo $date->format('Y-m-d').' '.$post->post_title;
        echo '</a>';
        echo '<hr>';
        ?></li><?php
        }
        ?>
        </ul>

        </div>
    </div>
  </div>
</main>

<?php
get_footer();
