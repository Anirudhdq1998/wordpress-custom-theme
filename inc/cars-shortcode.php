<?php
if (!defined('ABSPATH')) exit;

// Enqueue CSS & JS
function cars_enqueue_assets() {
    wp_enqueue_style(
        'cars-style',
        get_template_directory_uri() . '/assets/css/cars.css',
        array(),
        '1.0.0'
    );

    wp_enqueue_script(
        'cars-script',
        get_template_directory_uri() . '/assets/js/cars.js',
        array(),
        '1.0.0',
        true 
    );

    wp_localize_script('cars-script', 'CARS_AJAX', array(
        'ajaxurl' => admin_url('admin-ajax.php'),
        'nonce'   => wp_create_nonce('cars_ajax_nonce'),
    ));
}
add_action('wp_enqueue_scripts', 'cars_enqueue_assets');

// Shortcode
function cars_filter_shortcode() {
    $category = isset($_GET['car_cat'])  ? sanitize_text_field($_GET['car_cat'])  : '';
    $paged    = isset($_GET['car_page']) ? absint($_GET['car_page'])               : 1;

    ob_start(); ?>

    <div class="cars-filter-section"
         data-category="<?php echo esc_attr($category); ?>"
         data-paged="<?php echo esc_attr($paged); ?>">
		
<!-- Filter -->
<div class="filter-controls">
    <form method="get" id="cars-filter-form">
        <div class="filter-input-group">
            <span class="filter-icon"><svg width="19" height="19" viewBox="0 0 19 19" fill="none" xmlns="http://www.w3.org/2000/svg">
<path d="M17.7026 3.66225C17.5061 3.23475 17.0899 2.96875 16.6167 2.96875H2.3833C1.91008 2.96875 1.49386 3.23475 1.29674 3.66225C1.10139 4.08619 1.16908 4.57069 1.47308 4.92575L1.47368 4.92634L7.12499 11.5015V16.625C7.12499 16.8441 7.24552 17.0454 7.43849 17.1487C7.52636 17.1956 7.62255 17.2188 7.71874 17.2188C7.83393 17.2188 7.94852 17.1849 8.04827 17.119L11.6108 14.744C11.7758 14.6336 11.875 14.4483 11.875 14.25V11.5015L17.5269 4.92634C17.8309 4.57069 17.8986 4.08619 17.7026 3.66225Z" fill="white"/>
</svg>
</span>
            <select name="car_cat" id="car-category-select">
                <option value="">Filter By</option>
                <?php
                $categories = get_terms(array('taxonomy' => 'category', 'hide_empty' => true));
                foreach ($categories as $cat) {
                    $selected = ($category === $cat->slug) ? 'selected' : '';
                    echo '<option value="' . esc_attr($cat->slug) . '" ' . $selected . '>' . esc_html($cat->name) . '</option>';
                }
                ?>
            </select>
			 <span class="filter-arrow">
        <svg width="29" height="29" viewBox="0 0 29 29" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M22.4637 9.0625L23.5625 10.235L14.5 19.9375L5.4375 10.235L6.53066 9.0625L14.5 17.5869L22.4637 9.0625Z" fill="white"/>
        </svg>
    </span>
        </div>
        <button type="button" class="filter-apply-btn" onclick="filterCars()">
            Apply <span class="apply-arrow"><svg width="37" height="37" viewBox="0 0 37 37" fill="none" xmlns="http://www.w3.org/2000/svg">
<path d="M14.1966 10.7212C14.2712 10.6469 14.3597 10.5879 14.4571 10.5479C14.5545 10.5078 14.6588 10.4873 14.7641 10.4876L24.9478 10.5606C25.0534 10.561 25.1579 10.5822 25.2553 10.6231C25.3527 10.664 25.441 10.7238 25.5151 10.799C25.5893 10.8743 25.6478 10.9634 25.6873 11.0614C25.7268 11.1593 25.7466 11.2641 25.7454 11.3698L25.6724 21.5534C25.6716 21.6589 25.6501 21.7632 25.609 21.8604C25.568 21.9576 25.5081 22.0457 25.433 22.1198C25.3579 22.1939 25.2689 22.2524 25.1711 22.2921C25.0734 22.3318 24.9688 22.3518 24.8633 22.351C24.7578 22.3503 24.6534 22.3288 24.5563 22.2877C24.4591 22.2466 24.3709 22.1868 24.2969 22.1117C24.2228 22.0365 24.1643 21.9475 24.1246 21.8498C24.0849 21.752 24.0649 21.6474 24.0656 21.5419L24.1386 12.156L14.7526 12.0944C14.647 12.0941 14.5424 12.0728 14.4451 12.0319C14.3477 11.991 14.2594 11.9312 14.1852 11.856C14.1111 11.7808 14.0526 11.6916 14.013 11.5936C13.9735 11.4957 13.9538 11.3909 13.955 11.2853C13.9562 11.18 13.9781 11.0759 14.0196 10.9791C14.0611 10.8824 14.1212 10.7947 14.1966 10.7212Z" fill="white"/>
<path d="M10.7048 24.275L24.3803 10.7941C24.5314 10.6452 24.7356 10.5623 24.9478 10.5639C25.16 10.5654 25.3629 10.6511 25.5118 10.8023C25.6608 10.9534 25.7436 11.1575 25.7421 11.3697C25.7406 11.5819 25.6548 11.7848 25.5037 11.9338L11.8282 25.4147C11.6771 25.5636 11.473 25.6465 11.2608 25.645C11.0486 25.6434 10.8457 25.5577 10.6967 25.4066C10.5477 25.2554 10.4649 25.0513 10.4664 24.8391C10.4679 24.6269 10.5537 24.424 10.7048 24.275Z" fill="white"/>
</svg>
</span>
        </button>
    </form>

    <div id="cars-clear-filter"
         class="filter-tag"
         style="display:<?php echo $category ? 'flex' : 'none'; ?>;">
        <span id="cars-current-filter">
            <?php
            if ($category) {
                $cat_obj = get_term_by('slug', $category, 'category');
                echo $cat_obj ? 'Showing: ' . esc_html($cat_obj->name) : '';
            }
            ?>
        </span>
        <a href="#" class="filter-tag__close" onclick="clearFilter(); return false;">✕</a>
    </div>
</div>
        <!-- Cars Grid -->
        <div class="car-grid" id="cars-grid"></div>

        <!-- Pagination -->
        <nav class="cars-pagination" id="cars-pagination" aria-label="Cars pagination"></nav>

        <!-- Info -->
        <p class="pagination-info" id="pagination-info"></p>

    </div>

    <?php
    return ob_get_clean();
}
add_shortcode('cars_display', 'cars_filter_shortcode');

// Simple 5-car shortcode (no filter, no pagination)
function cars_simple_shortcode() {
    ob_start();

    $args = array(
        'post_type'      => 'cars',
        'posts_per_page' => 5,
        'post_status'    => 'publish',
        'orderby'        => 'date',
        'order'          => 'DESC',
    );

    $cars_query = new WP_Query($args);

    if (!$cars_query->have_posts()) : ?>
        <p>No cars found.</p>
        <?php
        return ob_get_clean();
    endif;

    $posts = $cars_query->posts;
    wp_reset_postdata();
    ?>

    <div class="cars-showcase">

        <?php
        // ---- FEATURED POST (first) ----
        $featured = $posts[0];
        setup_postdata($GLOBALS['post'] = $featured);
        ?>
        <div class="cars-featured">
            <?php if (has_post_thumbnail($featured->ID)) : ?>
                <a href="<?php the_permalink(); ?>" class="cars-featured__image-wrap">
                    <?php echo get_the_post_thumbnail($featured->ID, 'large', array('class' => 'cars-featured__img')); ?>
                    <span class="cars-featured__badge">Featured</span>
                </a>
            <?php endif; ?>

            <div class="cars-featured__body">
                <?php
                $cats = get_the_category($featured->ID);
                if ($cats) : ?>
                    <div class="car-categories">
                        <?php foreach ($cats as $cat) : ?>
                            <span class="category-badge"><?php echo esc_html($cat->name); ?></span>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>

                <h2 class="cars-featured__title">
                    <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                </h2>

                <p class="cars-featured__excerpt">
                    <?php echo wp_trim_words(get_the_excerpt(), 25); ?>
                </p>

                <a href="<?php the_permalink(); ?>" class="cars-btn">Book Now</a>
            </div>
        </div>

        <?php
        // ---- 4 SMALL POSTS (2x2 grid) ----
        $small_posts = array_slice($posts, 1, 4);
        if (!empty($small_posts)) : ?>
            <div class="cars-grid-2x2">
                <?php foreach ($small_posts as $post) :
                    setup_postdata($GLOBALS['post'] = $post); ?>
                    <div class="car-card">
                        <?php if (has_post_thumbnail($post->ID)) : ?>
                            <a href="<?php the_permalink(); ?>" class="car-card__image-wrap">
                                <?php echo get_the_post_thumbnail($post->ID, 'medium', array('class' => 'car-card__img')); ?>
                            </a>
                        <?php endif; ?>

                        <div class="car-card__body">
                            <?php
                            $cats = get_the_category($post->ID);
                            if ($cats) : ?>
                                <div class="car-categories">
                                    <span class="category-badge"><?php echo esc_html($cats[0]->name); ?></span>
                                </div>
                            <?php endif; ?>

                            <h3 class="car-card__title">
                                <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                            </h3>

                            <p class="car-card__excerpt">
                                <?php echo wp_trim_words(get_the_excerpt(), 12); ?>
                            </p>

                            <a href="<?php the_permalink(); ?>" class="cars-btn cars-btn--small">Book Now</a>
                        </div>
                    </div>
                <?php endforeach;
                wp_reset_postdata(); ?>
            </div>
        <?php endif; ?>

    </div>
    <?php
    return ob_get_clean();
}
add_shortcode('cars_simple', 'cars_simple_shortcode');