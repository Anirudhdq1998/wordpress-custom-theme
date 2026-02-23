<?php
/**
 * MyTheme functions
 *
 * @package MyTheme
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

// ── Theme Setup ──────────────────────────────────
function mytheme_setup() {
    load_theme_textdomain( 'mytheme', get_template_directory() . '/languages' );

    add_theme_support( 'automatic-feed-links' );
    add_theme_support( 'title-tag' );
    add_theme_support( 'post-thumbnails' );
    add_theme_support( 'html5', array( 'search-form', 'comment-form', 'comment-list', 'gallery', 'caption' ) );
    add_theme_support( 'align-wide' );
    add_theme_support( 'responsive-embeds' );
    add_theme_support( 'custom-logo', array( 'height' => 60, 'width' => 180, 'flex-width' => true ) );
    add_theme_support( 'custom-background' );

    add_image_size( 'mytheme-card',     720, 405, true );
    add_image_size( 'mytheme-featured', 1200, 600, true );

    register_nav_menus( array(
        'primary' => __( 'Primary Menu', 'mytheme' ),
        'footer'  => __( 'Footer Menu', 'mytheme' ),
    ) );

    global $content_width;
    if ( ! isset( $content_width ) ) {
        $content_width = 740;
    }
}
add_action( 'after_setup_theme', 'mytheme_setup' );

// ── Enqueue ──────────────────────────────────────
function mytheme_scripts() {
    wp_enqueue_style( 'mytheme-style', get_stylesheet_uri(), array(), '1.0.0' );
    wp_enqueue_script( 'mytheme-main', get_template_directory_uri() . '/js/main.js', array(), '1.0.0', true );

    if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
        wp_enqueue_script( 'comment-reply' );
    }
	
	wp_enqueue_style( 'google-fonts-roboto', 'https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100..900;1,100..900&display=swap', array(), null );
}
add_action( 'wp_enqueue_scripts', 'mytheme_scripts' );

// ── Widgets ──────────────────────────────────────
function mytheme_widgets_init() {
    register_sidebar( array(
        'id'            => 'sidebar-1',
        'name'          => __( 'Sidebar', 'mytheme' ),
        'before_widget' => '<div id="%1$s" class="widget %2$s">',
        'after_widget'  => '</div>',
        'before_title'  => '<h3 class="widget-title">',
        'after_title'   => '</h3>',
    ) );

    register_sidebar( array(
        'id'            => 'footer-1',
        'name'          => __( 'Footer Column 1', 'mytheme' ),
        'before_widget' => '<div id="%1$s" class="footer-widget %2$s">',
        'after_widget'  => '</div>',
        'before_title'  => '<h4 class="footer-widget-title">',
        'after_title'   => '</h4>',
    ) );

    register_sidebar( array(
        'id'            => 'footer-2',
        'name'          => __( 'Footer Column 2', 'mytheme' ),
        'before_widget' => '<div id="%1$s" class="footer-widget %2$s">',
        'after_widget'  => '</div>',
        'before_title'  => '<h4 class="footer-widget-title">',
        'after_title'   => '</h4>',
    ) );

    register_sidebar( array(
        'id'            => 'footer-3',
        'name'          => __( 'Footer Column 3', 'mytheme' ),
        'before_widget' => '<div id="%1$s" class="footer-widget %2$s">',
        'after_widget'  => '</div>',
        'before_title'  => '<h4 class="footer-widget-title">',
        'after_title'   => '</h4>',
    ) );
for ( $i = 1; $i <= 8; $i++ ) {
    register_sidebar( array(
        'name'          => sprintf( __( 'Footer %d', 'mytheme' ), $i ),
        'id'            => 'footer-' . $i,
        'before_widget' => '<div class="widget %2$s">',
        'after_widget'  => '</div>',
        'before_title'  => '<h4 class="widget-title">',
        'after_title'   => '</h4>',
    ) );
}
}
add_action( 'widgets_init', 'mytheme_widgets_init' );



// ── Helpers ──────────────────────────────────────

function mytheme_posted_on() {
    echo '<time datetime="' . esc_attr( get_the_date( 'c' ) ) . '">' . esc_html( get_the_date() ) . '</time>';
}

function mytheme_posted_by() {
    $author_url  = get_author_posts_url( get_the_author_meta( 'ID' ) );
    $author_name = get_the_author();
    echo '<a href="' . esc_url( $author_url ) . '">' . esc_html( $author_name ) . '</a>';
}

function mytheme_category_list() {
    $categories = get_the_category();
    if ( ! $categories ) return;
    $list = array();
    foreach ( $categories as $cat ) {
        $list[] = '<a href="' . esc_url( get_category_link( $cat->term_id ) ) . '">' . esc_html( $cat->name ) . '</a>';
    }
    echo implode( ', ', $list );
}

function mytheme_pagination() {
    global $wp_query;
    $total   = $wp_query->max_num_pages;
    $current = max( 1, get_query_var( 'paged' ) );
    if ( $total <= 1 ) return;

    $links = paginate_links( array(
        'base'      => str_replace( 999999999, '%#%', esc_url( get_pagenum_link( 999999999 ) ) ),
        'format'    => '?paged=%#%',
        'current'   => $current,
        'total'     => $total,
        'type'      => 'array',
        'prev_text' => '&larr; ' . __( 'Prev', 'mytheme' ),
        'next_text' => __( 'Next', 'mytheme' ) . ' &rarr;',
    ) );

    if ( $links ) {
        echo '<nav class="pagination">';
        foreach ( $links as $link ) {
            echo wp_kses_post( $link );
        }
        echo '</nav>';
    }
}

// Trim excerpt
add_filter( 'excerpt_length', function() { return 25; } );
add_filter( 'excerpt_more',   function() { return '&hellip;'; } );

// Remove wp_generator tag
remove_action( 'wp_head', 'wp_generator' );

//add SVG to allowed file uploads
function add_file_types_to_uploads($file_types){

	$new_filetypes = array();
	$new_filetypes['svg'] = 'image/svg+xml';
	$file_types = array_merge($file_types, $new_filetypes );

	return $file_types; 
} 
add_action('upload_mimes', 'add_file_types_to_uploads');

// Cars CPT
require_once get_template_directory() . '/inc/cars-cpt.php';
require_once get_template_directory() . '/inc/cars-ajax.php';
require_once get_template_directory() . '/inc/cars-shortcode.php';
