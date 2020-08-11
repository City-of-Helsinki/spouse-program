<?php
/**
 * Plugin Name: Spouse-notice
 * Description: Notice box that slides under the header.
 */

add_shortcode('spouse_notice', 'spouse_notice');

function spouse_notice(){
  $posts = spouse_get_latest_posts();

  if(!$posts){
    return;
  }

  spouse_print_notice($posts);
}

function spouse_get_latest_posts(){
  $options = [
    'post_type' => 'post',
    'post_status' => ['publish'],
    'orderby' => 'date',
    'order' => 'DESC',
    'limit' => 5,
    'date_query' => [[
      #'after' => strtotime("-7 days")
      'after' => '1 week ago',
    ]]
  ];
  return get_posts($options);
}

function spouse_print_notice($posts){

  echo '<div role="alert" class="spouse-notice d-none">';
  echo '<div class="row">';
    echo '<div class="col-10">';
    echo '<p><strong>Notice!</strong></p>';

    echo '<ul>';
      foreach($posts as $post) {
        ?>
        <a href="<?php echo get_permalink($post->ID); ?>">
          <li>
            <?php
            echo $post->post_title;
            ?>
          </li>
        </a>
        <?php
      }
      echo '<ul>';
    echo '</div>';
      echo '<div class="col-2">';
        echo '<button id="spouse-close-notification" aria-label="Close notification">X</button>';
      echo '</div>';
  echo '</div>';
?>
  </div>
  <script>
    (function(){

      var localstorageTag = 'hidenotification';
      var lastPostDate = '<?php echo $posts[0]->post_date; ?>';
      var element = document.getElementById('spouse-close-notification');

      if(window.localStorage.getItem(localstorageTag) === null){
        element.parentElement.parentElement.parentElement.classList.remove('d-none');
      } else {
        var postTime = new Date(lastPostDate);
        var postTime = Math.floor(postTime.getTime() / 1000);
        var hideTime = new Date(window.localStorage.getItem(localstorageTag));

        if(postTime > hideTime){
          element.parentElement.parentElement.parentElement.classList.remove('d-none');
        }
      }

      element.addEventListener('click', function(){
        element.parentElement.parentElement.parentElement.classList.add('d-none');
        window.localStorage.setItem(localstorageTag, Math.floor( new Date().getTime() / 1000 ));
      });

    })();
  </script>
  <?php

}
