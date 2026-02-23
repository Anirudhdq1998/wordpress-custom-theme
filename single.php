<?php get_header(); ?>

<div class="site-content">
    <div class="si-container">
        <div class="with-sidebar">

            <div class="content-area">
                <?php while ( have_posts() ) : the_post(); ?>

                    <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

                        <header class="entry-header">
                            <h1><?php the_title(); ?></h1>
                            <div class="post-meta">
                                <?php mytheme_posted_on(); ?>
                                <span><?php mytheme_posted_by(); ?></span>
                                <?php if ( has_category() ) : ?>
                                    <span><?php mytheme_category_list(); ?></span>
                                <?php endif; ?>
                            </div>
                        </header>

                        <?php if ( has_post_thumbnail() ) : ?>
                            <div class="entry-featured-image">
                                <?php the_post_thumbnail( 'mytheme-featured', array( 'alt' => get_the_title() ) ); ?>
                            </div>
                        <?php endif; ?>

                        <div class="entry-content">
                            <?php the_content(); ?>
                            <?php wp_link_pages(); ?>
                        </div>

                        <?php if ( has_tag() ) : ?>
                            <div class="post-tags">
                                <?php the_tags( '', ' ', '' ); ?>
                            </div>
                        <?php endif; ?>

                    </article>

                    <nav class="post-navigation">
                        <div class="nav-previous">
                            <?php $prev = get_previous_post(); ?>
                            <?php if ( $prev ) : ?>
                                <a href="<?php echo esc_url( get_permalink( $prev ) ); ?>">
                                    <span class="nav-label">&larr; <?php esc_html_e( 'Previous', 'mytheme' ); ?></span>
                                    <span class="nav-title"><?php echo esc_html( get_the_title( $prev ) ); ?></span>
                                </a>
                            <?php endif; ?>
                        </div>
                        <div class="nav-next">
                            <?php $next = get_next_post(); ?>
                            <?php if ( $next ) : ?>
                                <a href="<?php echo esc_url( get_permalink( $next ) ); ?>">
                                    <span class="nav-label"><?php esc_html_e( 'Next', 'mytheme' ); ?> &rarr;</span>
                                    <span class="nav-title"><?php echo esc_html( get_the_title( $next ) ); ?></span>
                                </a>
                            <?php endif; ?>
                        </div>
                    </nav>

                    <?php if ( comments_open() || get_comments_number() ) : ?>
                        <?php comments_template(); ?>
                    <?php endif; ?>

                <?php endwhile; ?>
            </div><!-- .content-area -->

            <aside class="sidebar" role="complementary">
                <?php get_sidebar(); ?>
            </aside>

        </div><!-- .with-sidebar -->
    </div><!-- .container -->
</div><!-- .site-content -->

<?php get_footer(); ?>
