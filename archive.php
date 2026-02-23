<?php get_header(); ?>

<div class="site-content">
    <div class="si-container">

        <div class="page-header">
            <?php the_archive_title( '<h1>', '</h1>' ); ?>
            <?php the_archive_description( '<p>', '</p>' ); ?>
        </div>

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

            </div>

            <aside class="sidebar" role="complementary">
                <?php get_sidebar(); ?>
            </aside>
        </div>

    </div>
</div>

<?php get_footer(); ?>
