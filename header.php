<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo( 'charset' ); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php wp_head(); ?>

  

<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

<a class="skip-link screen-reader-text" href="#main"><?php esc_html_e( 'Skip to content', 'mytheme' ); ?></a>

<!-- ===========================
     DESKTOP HEADER (1025px+)
=========================== -->
<header class="site-header">

    <!-- Logo -->
    <div class="header-logo">
        <?php
        if ( function_exists( 'the_custom_logo' ) ) {
            the_custom_logo();
        }
        ?>
    </div>

    <!-- Primary Navigation -->
    <nav class="header-nav" role="navigation" aria-label="<?php esc_attr_e( 'Primary', 'mytheme' ); ?>">
        <?php
        wp_nav_menu( array(
            'theme_location' => 'primary',
            'menu_id'        => 'primary-menu-list',
            'container'      => false,
            'fallback_cb'    => '__return_false',
        ) );
        ?>
    </nav>

    <!-- Language + Book Now -->
    <div class="header-actions">

        <div class="lang-switcher" title="Switch Language">
            <!-- Globe icon -->
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none"
                 stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                <circle cx="12" cy="12" r="10"/>
                <line x1="2" y1="12" x2="22" y2="12"/>
                <path d="M12 2a15.3 15.3 0 0 1 4 10 15.3 15.3 0 0 1-4 10
                         15.3 15.3 0 0 1-4-10 15.3 15.3 0 0 1 4-10z"/>
            </svg>
            <span>EN</span>
        </div>

        <a href="#book" class="btn-book-now">Book Now</a>

    </div>
</header>

<!-- ===========================
     MOBILE HEADER (≤1024px)
=========================== -->
<header class="site-header-mobile">
    <div class="sat-mobile-header si-container">
        <div class="test">
            <div class="mobile-menu">
                <?php
                if ( function_exists( 'the_custom_logo' ) ) {
                    the_custom_logo();
                }
                ?>
                <nav class="top_menu mob-nav-menu">
                    <div class="cdo-menu-overflow">
                        <?php
                        wp_nav_menu( array(
                            'theme_location' => 'primary',
                            'menu_id'        => 'primary-menu-list',
                            'container'      => false,
                            'fallback_cb'    => '__return_false',
                        ) );
                        ?>
                    </div>
                </nav>
				  <div class="toggleButton"><span></span></div>
            </div>
        </div>

      

        <nav class="main-nav" id="primary-menu" role="navigation"
             aria-label="<?php esc_attr_e( 'Primary', 'mytheme' ); ?>">
            <?php
            wp_nav_menu( array(
                'theme_location' => 'primary',
                'menu_id'        => 'primary-menu-list',
                'container'      => false,
                'fallback_cb'    => '__return_false',
            ) );
            ?>
        </nav>
    </div>

    <div>
        <button class="book-now">Book Now</button>
    </div>
</header>

<div id="page">
<main id="main" role="main">