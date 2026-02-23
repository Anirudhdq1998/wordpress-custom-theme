</main>
</div>
<footer class="site-footer">
    <div class="custom-container">
        <?php
        $sidebars_start    = ['footer-1'];
        $sidebars_grouped  = ['footer-2','footer-3','footer-4','footer-5','footer-6','footer-7'];
        $sidebars_end      = ['footer-8'];

        $any_active = array_filter(
            array_merge( $sidebars_start, $sidebars_grouped, $sidebars_end ),
            'is_active_sidebar'
        );

        if ( $any_active ) : ?>
        <div class="footer-widgets">

            <?php /* Column 1 */ ?>
            <?php if ( is_active_sidebar( 'footer-1' ) ) : ?>
                <div class="footer-widget-col footer-widget-col--1">
                    <?php dynamic_sidebar( 'footer-1' ); ?>
                </div>
            <?php endif; ?>

            <?php /* Columns 2–7 wrapped */ ?>
            <?php $grouped_active = array_filter( $sidebars_grouped, 'is_active_sidebar' ); ?>
            <?php if ( $grouped_active ) : ?>
                <div class="footer-widget-group">
                    <?php foreach ( $sidebars_grouped as $sidebar ) : ?>
                        <?php if ( is_active_sidebar( $sidebar ) ) : ?>
                            <div class="footer-widget-col">
                                <?php dynamic_sidebar( $sidebar ); ?>
                            </div>
                        <?php endif; ?>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>

            <?php /* Column 8 — separated */ ?>
            <?php if ( is_active_sidebar( 'footer-8' ) ) : ?>
                <div class="footer-widget-col footer-widget-col--separated">
                    <?php dynamic_sidebar( 'footer-8' ); ?>
                </div>
            <?php endif; ?>

        </div>
        <?php endif; ?>

        <div class="footer-bottom">
        
            <?php
            wp_nav_menu( array(
                'theme_location' => 'footer',
                'container'      => 'nav',
                'container_class'=> 'footer-nav',
                'depth'          => 1,
                'fallback_cb'    => false,
            ) );
            ?>
        </div>
    </div>
</footer>
<?php wp_footer(); ?>
</body>
</html>