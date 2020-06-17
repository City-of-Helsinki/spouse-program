<?php
echo '<div class="row justify-content-center text-center">';

  // loop through the rows of data
  if( have_rows('icons')):

  while ( have_rows('icons') ) : the_row();
  $image = get_sub_field('icon');
  if(!$image){

    continue;
  }
  echo '<div class="col-12 col-md-4 ">';

    $url = get_sub_field('url');
    if($url):
        echo '<a href="'.$url.'">';
            echo '<img class="img-fluid" src="'.$image['url'].'" alt="'.esc_attr($image['alt']).'">';
            $title = get_sub_field('title');
            echo '<span>'.$title.'</span>';
        echo '</a>';
    endif;

  //col
  echo '</div>';

  endwhile;
  endif;

echo '</div>';
