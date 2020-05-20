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
            <div class="col-3">
            </div>
            <div class="col-5">
                <div class="menu-container nav">
                  <?php wp_nav_menu( array( 'main_menu' => 'new-menu') ); ?>
                </div>
            </div>
            <div class="col-2">
                log in | sign up
            </div>
        </div>
    </div>
</header><!-- #site-header -->

<?php
// Output the menu modal.
get_template_part( 'template-parts/modal-menu' );
