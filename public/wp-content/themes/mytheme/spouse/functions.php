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

// Catch sign in form submission
add_action("wpcf7_before_send_mail", "spouse_create_user_on_signup_form_submission");

function spouse_create_user_on_signup_form_submission(&$contact_form) {

  // TODO: check that this is right form: contact-form-1

  $form = WPCF7_Submission::get_instance();
  $value = $form->get_posted_data();

  $email = sanitize_email($value['email']);
  $username = sanitize_text_field($value['name']);
  $password = spouse_random_str(20);

  $result = wp_create_user($username, $password, $email);

  if ( is_wp_error($result) ){
    show_message($result);
    #echo $result->get_error_message();
  }

  $user = get_user_by('id', $result);
  $reset_key = get_password_reset_key( $user );
  $user_login = $user->user_login;
  $reset_link = '<a href="' . wp_login_url()."/resetpass/?key=$reset_key&login=" . rawurlencode($user_login) . '">' . wp_login_url()."/resetpass/?key=$reset_key&login=" . rawurlencode($user_login) . '</a>';

  $message = "Hi $username,<br>";
  $message .= "An account has been created on get_bloginfo('name') for email address $email<br>";
  $message .= "Click here to set the password for your account: <br>";
  $message .= "$reset_link <br>";

  $subject = __("Your account on ".get_bloginfo( 'name'));
  $headers = [];
  add_filter( 'wp_mail_content_type', function( $content_type ) {return 'text/html';});
  $headers[] = "From: Spouse program \r\n";

  if(!wp_mail( $email, $subject, $message, $headers)) {
    show_message('Could not send the login link. Please contact us for further instructions');
  }

  // Reset content-type to avoid conflicts -- http://core.trac.wordpress.org/ticket/23578
  remove_filter( 'wp_mail_content_type', 'set_html_content_type' );

  // If you want to skip mailing the data, you can do it...
  #$contact_form->skip_mail = true;

}

function spouse_random_str(
  $length,
  $keyspace = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ-_.,'
) {
  $str = '';
  $max = mb_strlen($keyspace, '8bit') - 1;
  if ($max < 1) {
    throw new Exception('$keyspace must be at least two characters long');
  }
  for ($i = 0; $i < $length; ++$i) {
    $str .= $keyspace[random_int(0, $max)];
  }
  return $str;
}


  function dtc_send_password_reset_mail($user_id){

    $user = get_user_by('id', $user_id);
    $firstname = $user->first_name;
    $email = $user->user_email;
    $adt_rp_key = get_password_reset_key( $user );
    $user_login = $user->user_login;
    $rp_link = '<a href="' . wp_login_url()."/resetpass/?key=$adt_rp_key&login=" . rawurlencode($user_login) . '">' . wp_login_url()."/resetpass/?key=$adt_rp_key&login=" . rawurlencode($user_login) . '</a>';

    if ($firstname == "") $firstname = "gebruiker";
    $message = "Hi ".$firstname.",<br>";
    $message .= "An account has been created on ".get_bloginfo( 'name' )." for email address ".$email."<br>";
    $message .= "Click here to set the password for your account: <br>";
    $message .= $rp_link.'<br>';

    //deze functie moet je zelf nog toevoegen.
   $subject = __("Your account on ".get_bloginfo( 'name'));
   $headers = array();

   add_filter( 'wp_mail_content_type', function( $content_type ) {return 'text/html';});
   $headers[] = 'From: Your company name <info@your-domain.com>'."\r\n";
   wp_mail( $email, $subject, $message, $headers);

   // Reset content-type to avoid conflicts -- http://core.trac.wordpress.org/ticket/23578
   remove_filter( 'wp_mail_content_type', 'set_html_content_type' );
}




