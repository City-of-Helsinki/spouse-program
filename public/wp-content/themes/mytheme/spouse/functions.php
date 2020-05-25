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
