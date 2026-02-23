<?php get_header(); ?>

<div class="site-content">


        <?php if ( is_home() && ! is_front_page() ) : ?>
            <div class="page-header">
                <h1><?php single_post_title(); ?></h1>
            </div>
        <?php endif; ?>

        <div class="with-sidebar">
            <div class="content-area">

                <?php if ( have_posts() ) : ?>

                    <div class="posts-list">
                        <?php while ( have_posts() ) : the_post(); ?>

                            <article id="post-<?php the_ID(); ?>" <?php post_class( 'post-card' ); ?>>

                                <?php if ( has_post_thumbnail() ) : ?>
                                    <div class="post-thumbnail">
                                        <a href="<?php the_permalink(); ?>">
                                            <?php the_post_thumbnail( 'mytheme-card', array( 'alt' => get_the_title() ) ); ?>
                                        </a>
                                    </div>
                                <?php endif; ?>

                                <div class="post-meta">
                                    <?php mytheme_posted_on(); ?>
                                    <span><?php mytheme_posted_by(); ?></span>
                                    <?php if ( has_category() ) : ?>
                                        <span><?php mytheme_category_list(); ?></span>
                                    <?php endif; ?>
                                </div>

                                <h2><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>

                                <div class="post-excerpt"><?php the_excerpt(); ?></div>

                                <a class="read-more" href="<?php the_permalink(); ?>"><?php esc_html_e( 'Read more &rarr;', 'mytheme' ); ?></a>

                            </article>

                        <?php endwhile; ?>
                    </div>

                    <?php mytheme_pagination(); ?>

                <?php else : ?>

                    <p><?php esc_html_e( 'No posts found.', 'mytheme' ); ?></p>

                <?php endif; ?>

            </div><!-- .content-area -->

            <aside class="sidebar" role="complementary">
                <?php get_sidebar(); ?>
            </aside>

        </div><!-- .with-sidebar -->
</div><!-- .site-content -->

<?php get_footer(); ?>
