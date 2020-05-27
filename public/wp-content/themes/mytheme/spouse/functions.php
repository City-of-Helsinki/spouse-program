<?php

add_theme_support( 'widgets' );

// add main menu
function spouse_menu() {
  register_nav_menu('main-menu',__( 'Main menu' ));
}
add_action( 'init', 'spouse_menu' );

// add styles and javascripts
function spouse_enqueue_scripts() {
  wp_enqueue_style('bootstrap', get_template_directory_uri() . '/node_modules/bootstrap/dist/css/bootstrap.css');
  wp_enqueue_style('style', get_stylesheet_uri());
}
add_action('wp_enqueue_scripts', 'spouse_enqueue_scripts');

if ( function_exists('register_sidebar') ) {
  // Footer widget
  register_sidebar([
      'name' => __('footer content'),
      'id' => 'footer_content',
      'description' => 'This is the content that is shown in site footer',
      'before_widget' => '<div class="footer-content">',
      'after_widget' => '</div>',
      'before_title' => '<h3>',
      'after_title' => '</h3>',
    ]
  );
}

add_action( 'init', 'spouse_add_shortcodes' );

function spouse_add_shortcodes() {
  add_shortcode( 'custom-login-form', 'spouse_login_form_shortcode' );
}

function spouse_login_form_shortcode() {
  return wp_login_form( array( 'echo' => false ) );
}

function spouse_get_events(){
  $args = [
    'post_type' => 'eventbrite_events',
  ];
  #get_posts($args);

  $posts = wp_get_recent_posts($args, OBJECT);

  foreach($posts as $post){

    $color = '#fff';
    $startDate = null;

    $terms = get_the_terms($post->ID, 'eventbrite_category');

    if(is_wp_error($terms) && $terms !== FALSE){
      return $terms->get_error_message();
    }

    $icon = get_field('icon', $post->ID);

    if($term = reset($terms)) {
      $color = acf_get_field('event_color', $term);
      $category = $term->name;
    }

    if($dateData = get_post_meta($post->ID, 'event_start_date')) {

      $date = new \DateTime();
      $date->setTimestamp(strtotime($dateData[0]));
      $startDate = $date->format('d/m');

      $hour = get_post_meta($post->ID, 'event_start_hour')[0];
      $minute = get_post_meta($post->ID, 'event_start_minute')[0];
      $meridian = get_post_meta($post->ID, 'event_start_meridian')[0];
      $startTime = "$hour:$minute $meridian";
    }

    ?>
    <div class="event">
    <?php if(is_user_logged_in()): ?>
      <a href="<?php echo get_permalink($post) ?>">
    <?php endif; ?>
          <div class="event-color" <?php if(isset($color) && $color): ?>style="background-color:<?php echo $color['value']; ?>" <?php endif; ?>></div>
          <div class="event-content">
              <div class="event-start"><?php echo $startDate; ?></div>
              <div class="text-content">
                <span class=""><?php echo $category ?></span>
                <p><?php echo $startTime; ?> @ <?php echo get_post_meta($post->ID, 'venue_name')[0]; ?></p>
                <p><?php echo get_post_meta($post->ID, 'venue_address')[0]; ?> <?php echo get_post_meta($post->ID, 'venue_city')[0]; ?></p>
              </div>
          </div>
          <div class="event-icon"><img src="<?php echo $icon ?>"></div>
    <?php if(is_user_logged_in()): ?>
      </a>
    <?php endif; ?>
    </div>
    <?php

  }
}

add_shortcode('spouse-events', 'spouse_get_events');
