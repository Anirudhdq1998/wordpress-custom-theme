<div class="sidebar">
    <?php if ( is_active_sidebar( 'sidebar-1' ) ) : ?>
        <?php dynamic_sidebar( 'sidebar-1' ); ?>
    <?php else : ?>

        <div class="widget">
            <h3 class="widget-title"><?php esc_html_e( 'Search', 'mytheme' ); ?></h3>
            <?php get_search_form(); ?>
        </div>

        <div class="widget">
            <h3 class="widget-title"><?php esc_html_e( 'Recent Posts', 'mytheme' ); ?></h3>
            <?php
            $recent = new WP_Query( array( 'posts_per_page' => 5 ) );
            if ( $recent->have_posts() ) :
                echo '<ul>';
                while ( $recent->have_posts() ) : $recent->the_post();
                    echo '<li><a href="' . esc_url( get_permalink() ) . '">' . esc_html( get_the_title() ) . '</a></li>';
                endwhile;
                echo '</ul>';
                wp_reset_postdata();
            endif;
            ?>
        </div>

        <div class="widget">
            <h3 class="widget-title"><?php esc_html_e( 'Categories', 'mytheme' ); ?></h3>
            <ul>
                <?php
                $cats = get_categories( array( 'hide_empty' => true ) );
                foreach ( $cats as $cat ) :
                    echo '<li><a href="' . esc_url( get_category_link( $cat->term_id ) ) . '">' . esc_html( $cat->name ) . ' (' . (int) $cat->count . ')</a></li>';
                endforeach;
                ?>
            </ul>
        </div>

    <?php endif; ?>
</div>
