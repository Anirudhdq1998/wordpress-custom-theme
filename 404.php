<?php get_header(); ?>

<div class="site-content">
    <div class="container">
        <div class="error-404">
            <div class="error-number">404</div>
            <h1><?php esc_html_e( 'Page Not Found', 'mytheme' ); ?></h1>
            <p><?php esc_html_e( 'The page you are looking for does not exist.', 'mytheme' ); ?></p>
            <?php get_search_form(); ?>
            <p style="margin-top:1.5rem;">
                <a href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php esc_html_e( '&larr; Back to Home', 'mytheme' ); ?></a>
            </p>
        </div>
    </div>
</div>

<?php get_footer(); ?>
