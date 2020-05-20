<!DOCTYPE html>

<html class="no-js" <?php language_attributes(); ?>>

<head>
    <meta charset="<?php bloginfo( 'charset' ); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0" >
    <link rel="profile" href="https://gmpg.org/xfn/11">
    <?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>

<?php
wp_body_open();
?>

<header id="site-header" role="banner">
    <div class="container-fluid">
        <div class="row">
            <div class="header-left-content col-2 d-md-none col-xl-2">
            </div>
            <div class="col-6 col-sm-6 col-md-9">
                <div class="header-main-content nav justify-content-end">
                  <?php wp_nav_menu( array( 'main_menu' => 'new-menu') ); ?>
                </div>
            </div>
            <div class="header-right-content col-4 col-sm-4 col-md-3">
                <span class="wow-modal-id-2">Log in</span>
                |
                <span class="wow-modal-id-1">Sign up</span>
            </div>
        </div>
    </div>
</header><!-- #site-header -->

<?php
// Output the menu modal.
get_template_part( 'template-parts/modal-menu' );
