<?php get_header(); ?>

<div class="site-content">
    <div class="container">

        <div class="page-header">
            <h1>
                <?php
                printf(
                    esc_html__( 'Search Results for: %s', 'mytheme' ),
                    '<em>' . esc_html( get_search_query() ) . '</em>'
                );
                ?>
            </h1>
        </div>

        <div class="with-sidebar">
            <div class="content-area">

                <?php if ( have_posts() ) : ?>
                    <div class="posts-list">
                        <?php while ( have_posts() ) : the_post(); ?>
                            <article id="post-<?php the_ID(); ?>" <?php post_class( 'post-card' ); ?>>
                                <div class="post-meta">
                                    <?php mytheme_posted_on(); ?>
                                </div>
                                <h2><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
                                <div class="post-excerpt"><?php the_excerpt(); ?></div>
                                <a class="read-more" href="<?php the_permalink(); ?>"><?php esc_html_e( 'Read more &rarr;', 'mytheme' ); ?></a>
                            </article>
                        <?php endwhile; ?>
                    </div>
                    <?php mytheme_pagination(); ?>
                <?php else : ?>
                    <p><?php esc_html_e( 'Nothing found. Try a different search.', 'mytheme' ); ?></p>
                    <?php get_search_form(); ?>
                <?php endif; ?>

            </div>

            <aside class="sidebar" role="complementary">
                <?php get_sidebar(); ?>
            </aside>
        </div>

    </div>
</div>

<?php get_footer(); ?>
