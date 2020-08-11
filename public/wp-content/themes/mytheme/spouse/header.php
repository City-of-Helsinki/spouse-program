<!DOCTYPE html>

<?php spouse_access_control_check(); ?>

<html class="no-js" <?php language_attributes(); ?>>

<head>
    <meta charset="<?php bloginfo( 'charset' ); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0" >
    <link rel="profile" href="https://gmpg.org/xfn/11">
    <link href="https://fonts.googleapis.com/css2?family=Nunito:ital,wght@0,400;0,700;1,400&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Bitter:ital,wght@0,400;0,700;1,400&display=swap" rel="stylesheet">
    <?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>

<a href="#main-content" class="visually-hidden focusable">
    Skip to main content
</a>

<?php
wp_body_open();
?>

<header id="site-header" role="banner">
    <div class="container-fluid">
        <div class="row">
            <div class="col-6 col-sm-6 col-md-10">
                <div class="header-main-content nav justify-content-end">
                  <?php wp_nav_menu( array( 'menu' => 2) ); ?>
                </div>
            </div>
            <div class="pull-right header-right-content col-6 col-sm-6 col-md-2">
                <?php
                global $current_user; wp_get_current_user();
                /** Popups created with wow modal window -plugin */
                if (!is_user_logged_in()):
                ?>
                <a href="#" class="wow-modal-id-2">Log in</a>
                |
                <a href="#" class="wow-modal-id-1">Sign up</a>
                <?php
                else:
                  ?>
                    <a class="user-link" href="<?php echo get_edit_profile_url( $current_user->id ); ?>"><?php echo $current_user->user_login; ?></a>
                    |
                    <a href="<?php echo wp_logout_url(); ?>">Logout</a>
                <?php
                endif;
                ?>
            </div>
        </div>
    </div>
</header><!-- #site-header -->

<?php echo do_shortcode('[spouse_notice]'); ?>

<?php
// Output the menu modal.
get_template_part( 'template-parts/modal-menu' );
