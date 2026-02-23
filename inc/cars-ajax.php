<?php
if (!defined('ABSPATH')) exit;

add_action('wp_ajax_cars_load_page',        'cars_ajax_load_page');
add_action('wp_ajax_nopriv_cars_load_page', 'cars_ajax_load_page');

function cars_ajax_load_page() {
    check_ajax_referer('cars_ajax_nonce', 'nonce');

    $paged    = isset($_POST['paged'])    ? absint($_POST['paged'])                  : 1;
    $category = isset($_POST['category']) ? sanitize_text_field($_POST['category'])  : '';
    $per_page = 5;

    $args = array(
        'post_type'      => 'cars',
        'posts_per_page' => $per_page,
        'paged'          => $paged,
        'post_status'    => 'publish',
        'orderby'        => 'date',
        'order'          => 'DESC',
    );

    if ($category) {
        $args['tax_query'] = array(
            array(
                'taxonomy' => 'category',
                'field'    => 'slug',
                'terms'    => $category,
            )
        );
    }

    $cars_query  = new WP_Query($args);
    $total_pages = $cars_query->max_num_pages;
    $total_posts = $cars_query->found_posts;

    ob_start();

    if ($cars_query->have_posts()) :
        while ($cars_query->have_posts()) : $cars_query->the_post(); ?>
            <div class="car-card">
                <?php if (has_post_thumbnail()) : ?>
                    <a class="car-img" href="<?php the_permalink(); ?>">
                        <?php the_post_thumbnail('medium', array('class' => 'car-poster')); ?>
                    </a>
                <?php endif; ?>
<div class="wrapped">
	 <h3><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
                <button><a href="<?php the_permalink(); ?>">Book Now</a></button>
	  <?php $car_cats = get_the_category();
                if ($car_cats) : ?>
                    <div class="car-categories">
                        <?php foreach ($car_cats as $cat) : ?>
                            <span class="category-badge"><?php echo esc_html($cat->name); ?></span>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
				</div>
               

              

                <p><?php echo wp_trim_words(get_the_excerpt(), 20); ?></p>
            </div>
        <?php endwhile;
        wp_reset_postdata();
    else : ?>
        <div class="no-cars">
            <p>No cars found<?php echo $category ? ' in "' . esc_html(get_term_by('slug', $category, 'category')->name) . '"' : ''; ?>.</p>
        </div>
    <?php endif;

    $html = ob_get_clean();

    wp_send_json_success(array(
        'html'        => $html,
        'total_pages' => (int) $total_pages,
        'total_posts' => (int) $total_posts,
        'paged'       => (int) $paged,
    ));
}