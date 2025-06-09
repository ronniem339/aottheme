<?php
/**
 * The header for the Allout Travel theme
 *
 * @package Allout_Travel
 */

?>
<!doctype html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo( 'charset' ); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="profile" href="https://gmpg.org/xfn/11">

    <?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

<div id="page" class="site">
    <a class="skip-link sr-only" href="#content"><?php esc_html_e( 'Skip to content', 'allout-travel' ); ?></a>

    <header id="masthead" class="site-header">
        <div class="container">
            <div class="site-branding"> <?php // This is the main flex container for the header bar ?>

                <div class="site-logo-container">
                    <?php
                    if ( function_exists( 'the_custom_logo' ) && has_custom_logo() ) {
                        the_custom_logo();
                    } else {
                        echo '<h1 class="site-title"><a href="' . esc_url( home_url( '/' ) ) . '" rel="home">' . esc_html( get_bloginfo( 'name' ) ) . '</a></h1>';
                    }
                    ?>
                </div><?php // New wrapper for everything on the right side of the header ?>
                <div class="header-right-area">
    <?php // The Mobile Menu Toggle now comes BEFORE the nav it controls ?>
    <button class="menu-toggle" aria-controls="primary-menu" aria-expanded="false">
        <span class="sr-only"><?php esc_html_e( 'Primary Menu', 'allout-travel' ); ?></span>
        <span class="icon-bar"></span>
    </button>

    <nav id="site-navigation" class="main-navigation">
        <?php
        wp_nav_menu(
            array(
                'theme_location' => 'primary',
                'menu_id'        => 'primary-menu',
                'container'      => false,
                'fallback_cb'    => false,
            )
        );
        ?>
    </nav><div class="header-search">
        <?php get_search_form(); ?>
    </div><div class="header-social-icons">
        <a href="https://www.instagram.com/allout.travel/" target="_blank" rel="noopener noreferrer" aria-label="<?php esc_attr_e('Follow All Out Travel on Instagram', 'allout-travel'); ?>" title="<?php esc_attr_e('Instagram', 'allout-travel'); ?>">
            <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-instagram"><rect x="2" y="2" width="20" height="20" rx="5" ry="5"></rect><path d="M16 11.37A4 4 0 1 1 12.63 8 4 4 0 0 1 16 11.37z"></path><line x1="17.5" y1="6.5" x2="17.51" y2="6.5"></line></svg>
        </a>
        <a href="https://www.youtube.com/embed/YOUR_VIDEO_ID_HERE3" target="_blank" rel="noopener noreferrer" aria-label="<?php esc_attr_e('Subscribe to All Out Travel on YouTube', 'allout-travel'); ?>" title="<?php esc_attr_e('YouTube', 'allout-travel'); ?>">
            <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-youtube"><path d="M22.54 6.42a2.78 2.78 0 0 0-1.94-2C18.88 4 12 4 12 4s-6.88 0-8.6.46a2.78 2.78 0 0 0-1.94 2A29 29 0 0 0 1 11.75a29 29 0 0 0 .46 5.33A2.78 2.78 0 0 0 3.4 19c1.72.46 8.6.46 8.6.46s6.88 0 8.6-.46a2.78 2.78 0 0 0 1.94-2A29 29 0 0 0 23 11.75a29 29 0 0 0-.46-5.33z"></path><polygon points="9.75 15.02 15.5 11.75 9.75 8.48 9.75 15.02"></polygon></svg>
        </a>
    </div></div>

              </div></div></header><div id="content" class="site-content">
        <div class="container">