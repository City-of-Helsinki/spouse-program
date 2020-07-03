<?php
/**
 * Plugin Name: CF7-custom
 * Description: Contact form 7 custom functionalities
 */

// Catch sign in form submission
add_action("wpcf7_before_send_mail", "spouse_create_user_on_signup_form_submission");

function spouse_create_user_on_signup_form_submission(&$contact_form) {
  if ($contact_form->id() != 22) {
    return;
  }

  $form = WPCF7_Submission::get_instance();
  $values = $form->get_posted_data();

  $email = sanitize_email($values['email']);
  $username = sanitize_text_field($values['username']);
  $password = spouse_random_str(20);

  $result = wp_create_user($username, $password, $email);

  if (is_wp_error($result)) {
    return __('Could not create user.', 'custom');
  }

  $user = get_user_by('id', $result);
  $reset_key = get_password_reset_key($user);
  $user_login = $user->user_login;
  $reset_link = '<a href="' . wp_login_url()."/resetpass/?key=$reset_key&login=" . rawurlencode($user_login) . '">' . wp_login_url()."/resetpass/?key=$reset_key&login=" . rawurlencode($user_login) . '</a>';

  $blogName = get_bloginfo('name');
  $message = "Hi $username,<br>";
  $message .= "An account has been created on $blogName for email address $email <br>";
  $message .= "Click here to set the password for your account: <br>";
  $message .= "$reset_link <br>";

  $subject = __("Your account on ".get_bloginfo( 'name'));
  $headers = [];
  add_filter( 'wp_mail_content_type', function( $content_type ) {return 'text/html';});
  $headers[] = "From: Spouse program \r\n";

  if(!wp_mail($email, $subject, $message, $headers)) {
    // TODO: add some sort of error logging to project maybe.
    // Mails won't go through on dev environment so not gonna kill this one at the moment.
  }

  // Reset content-type to avoid conflicts -- http://core.trac.wordpress.org/ticket/23578
  remove_filter( 'wp_mail_content_type', 'set_html_content_type' );

}

function spouse_create_event_on_form_submission(&$contact_form){
  global $current_user;

  if ($contact_form->id() != 593) {
    return;
  }

  $form = WPCF7_Submission::get_instance();
  $values = $form->get_posted_data();

  $title = sanitize_text_field($values['event-title']);
  $description = sanitize_textarea_field($values['description']);

  $eventdata = array(
    'post_title'   => $title,
    'post_content' => $description,
    'post_type'    => 'eventbrite_events',
    'post_status'  => 'pending',
    'post_author'  => get_current_user_id(),
  );

  wp_insert_post($eventdata);

}

// Catch sign in form submission
add_action("wpcf7_before_send_mail", "spouse_create_event_on_form_submission");

function spouse_random_str(
  $length,
  $keyspace = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ-_.,'
)
{
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

