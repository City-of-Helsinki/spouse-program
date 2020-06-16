<?php

add_theme_support( 'widgets' );
add_theme_support( 'post-thumbnails' );

// add main menu
function spouse_menu() {
  register_nav_menu('main-menu', __( 'Main menu' ));
  register_nav_menu('sidebar-menu', __('Sidebar menu on main page') );
}
add_action( 'init', 'spouse_menu' );

// add styles and javascripts
function spouse_enqueue_scripts() {
  wp_enqueue_style('bootstrap', get_template_directory_uri() . '/dist/bootstrap/dist/css/bootstrap.css');
  wp_enqueue_style('style', get_stylesheet_uri());
}
add_action('wp_enqueue_scripts', 'spouse_enqueue_scripts');

if ( function_exists('register_sidebar') ) {
  // Footer widgets
  $footerWidgets = [
    'footer_content_left' => 'footer content left',
    'footer_content' => 'footer content middle',
    'footer_content_right' => 'footer content right'
  ];
  foreach($footerWidgets as $key => $widget){
    register_sidebar([
        'name' => __($widget),
        'id' => $key,
        'description' => 'This is the content that is shown in site footer',
        'before_widget' => '<div class="footer-content">',
        'after_widget' => '</div>',
        'before_title' => '<h3>',
        'after_title' => '</h3>',
      ]
    );
  }
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

  $posts = wp_get_recent_posts($args, OBJECT);

  if(!$posts) {
      return;
  }

  foreach($posts as $post){

    $color = '#fff';
    $startDate = null;

    $terms = get_the_terms($post->ID, 'eventbrite_category');

    if(is_wp_error($terms) && $terms !== FALSE){
      return $terms->get_error_message();
    }

    $icon = get_field('icon', $post->ID);

    if($terms && $term = reset($terms)) {
      $color = get_field('event_color', $term);
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

    <?php if(is_user_logged_in()): ?>
      <a href="<?php echo get_permalink($post) ?>">

    <?php endif; ?>
      <div class="event clearfix">
          <div class="event-color" <?php if(isset($color) && $color): ?>style="background-color:<?php echo $color; ?>" <?php endif; ?>></div>
          <div class="event-start"><?php echo $startDate; ?></div>
          <div class="event-content">
              <div class="text-content">
                <span class=""><?php echo $category ?></span>
                <p><?php echo $startTime; ?> @ <?php echo get_post_meta($post->ID, 'venue_name')[0]; ?></p>
                <p><?php echo get_post_meta($post->ID, 'venue_address')[0]; ?> <?php echo get_post_meta($post->ID, 'venue_city')[0]; ?></p>
              </div>
          </div>
          <div class="event-icon"><img src="<?php echo $icon ?>"></div>
          <i class="clearfix"></i>
      </div>
    <?php if(is_user_logged_in()): ?>
      </a>
    <?php endif; ?>

    <?php

  }
}
add_shortcode('spouse-events', 'spouse_get_events');

function spouse_get_template_part($slug, $name = null) {

  do_action("ccm_get_template_part_{$slug}", $slug, $name);

  $templates = array();
  if (isset($name))
    $templates[] = "{$slug}-{$name}.php";

  $templates[] = "{$slug}.php";

  spouse_get_template_path($templates, true, false);
}

function spouse_get_template_path($template_names, $load = false, $require_once = true ) {
  $located = '';
  foreach ( (array) $template_names as $template_name ) {
    if ( !$template_name )
      continue;

    /* search file within the PLUGIN_DIR_PATH only */
    if ( file_exists(PLUGIN_DIR_PATH . $template_name)) {
      $located = PLUGIN_DIR_PATH . $template_name;
      break;
    }
  }

  if ( $load && '' != $located )
    load_template( $located, $require_once );

  return $located;
}

function spouse_create_posttypes() {
  register_post_type( 'People',
    array(
      'labels' => array(
        'name' => __( 'People' ),
        'singular_name' => __( 'Person' )
      ),
      'public' => true,
      'has_archive' => true,
      'rewrite' => array('slug' => 'People'),
      'show_in_rest' => true,
      'supports' => array(),
    )
  );
}
add_action( 'init', 'spouse_create_posttypes' );

function spouse_access_control_check(){
    global $post;
    if($check = get_field('authenticated_users_only', $post)){
        if(!is_user_logged_in()){
          wp_redirect('front-page');
        }
    }
}

function spouse_is_restricted_page(){
  global $post;
  if($check = get_field('authenticated_users_only', $post)){
    if(!is_user_logged_in()){
      return true;
    }
  }
  return false;
}

function remove_editor() {
  if (isset($_GET['post'])) {
    $id = $_GET['post'];
    $template = get_post_meta($id, '_wp_page_template', true);
    switch ($template) {
      case 'one-column-template.php':
      case 'two-column-template.php':
        remove_post_type_support('page', 'editor');
        break;
      default :
        // Don't remove any other template.
        break;
    }
  }
}
add_action('init', 'remove_editor');
