<?php
/**
 * Plugin Name: Loginredirect-custom
 * Description: Redirect login user to custom page
 */

function loginredirect_redirect_to_homepage($url) {
  $user = wp_get_current_user();

  //is there a user to check?
  if ( isset( $user->roles ) && is_array( $user->roles ) ) {
    //check for admins
    if ( in_array( 'administrator', $user->roles ) ) {
      // redirect them to the default place
      return get_option('siteurl') . '/wp-admin/index.php';
    } else {
      return home_url();
    }
  } else {
    return get_option('siteurl') . '/wp-admin/index.php';
  }
}

add_filter( 'login_redirect', 'loginredirect_redirect_to_homepage' );
