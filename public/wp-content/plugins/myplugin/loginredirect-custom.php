<?php
/**
 * Plugin Name: Loginredirect-custom
 * Description: Redirect login user to custom page
 */

function loginredirect_redirect_to_homepage($redirect_to, $request, $user) {
//is there a user to check?
  if ( isset( $user->roles ) && is_array( $user->roles ) ) {
    //check for admins
    if ( in_array( 'administrator', $user->roles ) ) {
      // redirect them to the default place
      return $redirect_to;
    } else {
      return home_url();
    }
  } else {
    return $redirect_to;
  }
}

add_filter( 'login_redirect', 'loginredirect_redirect_to_homepage' );
