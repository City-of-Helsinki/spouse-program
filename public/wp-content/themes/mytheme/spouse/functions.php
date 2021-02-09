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

  if ( is_page_template('archives.php') ) {
    wp_enqueue_script('news-visited', get_template_directory_uri() . '/js/news-visited.js');
  }
  wp_enqueue_script('wow-modal-focus', get_template_directory_uri() . '/js/wow-modal-focus.js');
  wp_enqueue_script('target-blank-accessible', get_template_directory_uri() . '/js/targetblank.js');
}
add_action('wp_enqueue_scripts', 'spouse_enqueue_scripts');

if ( function_exists('register_sidebar') ) {

  $footerWidgets = [
    'footer_content_left' => 'footer content left',
    'footer_content' => 'footer content middle',
    'footer_content_right' => 'footer content right',
  ];
  $otherWidgets = [
    'social_title' => 'Social sharing title',
    'sidebar_menu' => 'Sidebar menu on main page'
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

  foreach($otherWidgets as $key => $widget) {
    register_sidebar([
        'name' => __($widget),
        'id' => $key,
        'description' => "Content widget: $key",
        'before_widget' => '',
        'after_widget' => '',
        'before_title' => '',
        'after_title' => '',
      ]
    );
  }

}

add_action( 'init', 'spouse_add_shortcodes' );

function spouse_add_shortcodes() {
  // Login form as shortcode.
  add_shortcode( 'custom-login-form', 'spouse_login_form_shortcode' );
}

function spouse_login_form_shortcode() {
  $form = wp_login_form( array( 'echo' => false ) );
  $form = str_replace('type="password"', 'type="password" autocomplete="password"', $form);
  $form = str_replace('name="log"', 'name="log" autocomplete="username"', $form);
  return $form;
}

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
      return true;
  }
  return false;
}

function spouse_is_user_allowed_page(){
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

add_action('after_setup_theme', 'spouse_remove_admin_bar');

function spouse_remove_admin_bar() {
  if (!current_user_can('administrator') && !current_user_can('editor')) {
    show_admin_bar(false);
  }
}

function spouse_edit_role_caps() {
  $role = get_role( 'editor' );

  $allowed = [
    'manage_options',
    'edit_users',
    'delete_users',
    'create_users',
    'list_users',
    'remove_users',
    'promote_users',
    'mc_add_events',
    'mc_approve_events',
    'mc_manage_events',
    'mc_edit_cats',
    'mc_edit_styles',
    'mc_edit_behaviors',
    'mc_edit_templates',
    'mc_edit_settings',
    'mc_edit_locations',
  ];
  foreach($allowed as $capability) {
      $role->add_cap( $capability, true );
  }
}

// Add simple_role capabilities, priority must be after the initial role definition.
add_action( 'init', 'spouse_edit_role_caps', 11 );

add_filter( 'flamingo_map_meta_cap', 'spouse_flamingo_map_meta_cap' );

function spouse_flamingo_map_meta_cap( $meta_caps ) {
  $meta_caps = array_merge( $meta_caps, array(
    'flamingo_edit_contacts' => 'edit_pages',
    'flamingo_edit_inbound_messages' => 'edit_pages',
  ) );

  return $meta_caps;
}

add_action( 'admin_init', 'spouse_remove_menu_pages' );

function spouse_remove_menu_pages() {
    if(current_user_can('administrator')){
      return;
    }
    remove_menu_page( 'admin.php?page=wp-mailplus-settings' );
    remove_menu_page( 'themes.php' );
    remove_menu_page( 'plugins.php' );
    remove_menu_page( 'tools.php' );
    remove_menu_page( 'options-general.php' );
    remove_menu_page( 'edit.php?post_type=acf' );
    remove_menu_page( 'admin.php?page=theseoframework-settings' );
    remove_menu_page( 'admin.php?page=mobile-menu-options' );
    remove_menu_page( 'admin.php?page=sharing-plus' );
    remove_menu_page( 'admin.php?page=wow-company' );
}

//List archives by year, then month
function wp_custom_archive($args = '') {
  global $wpdb, $wp_locale;

  $defaults = array(
    'limit' => '',
    'format' => 'html', 'before' => '',
    'after' => '', 'show_post_count' => false,
    'echo' => 1
  );

  $r = wp_parse_args( $args, $defaults );
  extract( $r, EXTR_SKIP );

  // over-ride general date format ? 0 = no: use the date format set in Options, 1 = yes: over-ride
  $archive_date_format_over_ride = 0;

  // options for daily archive (only if you over-ride the general date format)
  $archive_day_date_format = 'Y/m/d';

  // options for weekly archive (only if you over-ride the general date format)
  $archive_week_start_date_format = 'Y/m/d';
  $archive_week_end_date_format   = 'Y/m/d';

  if ( !$archive_date_format_over_ride ) {
    $archive_day_date_format = get_option('date_format');
    $archive_week_start_date_format = get_option('date_format');
    $archive_week_end_date_format = get_option('date_format');
  }

  //filters
  $where = apply_filters('customarchives_where', "WHERE post_type = 'post' AND post_status = 'publish'", $r );
  $join = apply_filters('customarchives_join', "", $r);

  $output = '<ul>';

  $query = "SELECT YEAR(post_date) AS `year`, MONTH(post_date) AS `month`, count(ID) as posts FROM $wpdb->posts $join $where GROUP BY YEAR(post_date), MONTH(post_date) ORDER BY post_date DESC $limit";
  $key = md5($query);
  $cache = wp_cache_get( 'wp_custom_archive' , 'general');
  if ( !isset( $cache[ $key ] ) ) {
    $arcresults = $wpdb->get_results($query);
    $cache[ $key ] = $arcresults;
    wp_cache_set( 'wp_custom_archive', $cache, 'general' );
  } else {
    $arcresults = $cache[ $key ];
  }
  if ( $arcresults ) {
    foreach ( (array) $arcresults as $arcresult ) {
      $url = get_month_link( $arcresult->year, $arcresult->month );
      $year_url = get_year_link($arcresult->year);
      /* translators: 1: month name, 2: 4-digit year */
      $text = sprintf(__('%s'), $wp_locale->get_month($arcresult->month));
      $year_text = sprintf('%d', $arcresult->year);
      $year_output = get_archives_link($year_url, $year_text, 'html', '','');
      $output .= ( $arcresult->year != $temp_year ) ? $year_output : '';
      #$output .= get_archives_link($url, $text, 'html', '<span class="month">', '</span>');

      $temp_year = $arcresult->year;
    }
  }

  $output .= '</ul>';

  echo $output;
}
