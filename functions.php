<?php
/**
 * Manga Premium – Main Theme Functions
 *
 * @package MangaPremium
 * @since 1.0.0
 */

defined( 'ABSPATH' ) || exit;

define( 'MP_VERSION', '1.0.0' );
define( 'MP_DIR', get_template_directory() );
define( 'MP_URI', get_template_directory_uri() );

/* ─── Theme Setup ─────────────────────────────────────── */
function manga_premium_setup() {
	// Text domain.
	load_theme_textdomain( 'manga-premium', MP_DIR . '/languages' );

	// Theme support.
	add_theme_support( 'automatic-feed-links' );
	add_theme_support( 'title-tag' );
	add_theme_support( 'post-thumbnails' );
	add_theme_support( 'html5', array(
		'search-form', 'comment-form', 'comment-list',
		'gallery', 'caption', 'style', 'script',
	) );
	add_theme_support( 'customize-selective-refresh-widgets' );
	add_theme_support( 'responsive-embeds' );
	add_theme_support( 'wp-block-styles' );
	add_theme_support( 'editor-styles' );

	// Custom logo.
	add_theme_support( 'custom-logo', array(
		'height'      => 60,
		'width'       => 200,
		'flex-height' => true,
		'flex-width'  => true,
	) );

	// Custom background.
	add_theme_support( 'custom-background', array(
		'default-color' => 'f8f8f8',
	) );

	// Register navigation menus.
	register_nav_menus( array(
		'primary'  => esc_html__( 'Primary Menu', 'manga-premium' ),
		'mobile'   => esc_html__( 'Mobile Menu', 'manga-premium' ),
		'footer'   => esc_html__( 'Footer Menu', 'manga-premium' ),
	) );

	// Image sizes.
	add_image_size( 'mp-cover', 400, 560, true );
	add_image_size( 'mp-cover-thumb', 120, 168, true );
	add_image_size( 'mp-banner', 1200, 480, true );
	add_image_size( 'mp-slider', 1400, 560, true );
}
add_action( 'after_setup_theme', 'manga_premium_setup' );

/* ─── Content Width ───────────────────────────────────── */
function manga_premium_content_width() {
	$GLOBALS['content_width'] = apply_filters( 'manga_premium_content_width', 1200 );
}
add_action( 'after_setup_theme', 'manga_premium_content_width', 0 );

/* ─── Include Modular Files ───────────────────────────── */
require_once MP_DIR . '/inc/core/custom-post-types.php';
require_once MP_DIR . '/inc/core/custom-taxonomies.php';
require_once MP_DIR . '/inc/core/template-functions.php';
require_once MP_DIR . '/inc/core/template-tags.php';
require_once MP_DIR . '/inc/core/enqueue.php';
require_once MP_DIR . '/inc/core/theme-options.php';
require_once MP_DIR . '/inc/core/breadcrumbs.php';
require_once MP_DIR . '/inc/core/pagination.php';
require_once MP_DIR . '/inc/core/ajax-handlers.php';
require_once MP_DIR . '/inc/core/class-manga-walker-nav.php';
require_once MP_DIR . '/inc/ui/card-ui.php';
require_once MP_DIR . '/inc/ui/comment-ui.php';
require_once MP_DIR . '/inc/ui/search-ui.php';
require_once MP_DIR . '/inc/reader/reader-core.php';

/* ─── Widgets ─────────────────────────────────────────── */
function manga_premium_widgets_init() {
	register_sidebar( array(
		'name'          => esc_html__( 'Main Sidebar', 'manga-premium' ),
		'id'            => 'sidebar-main',
		'description'   => esc_html__( 'Right sidebar widget area.', 'manga-premium' ),
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget'  => '</div>',
		'before_title'  => '<h4 class="widget-title">',
		'after_title'   => '</h4>',
	) );

	register_sidebar( array(
		'name'          => esc_html__( 'Footer Column 1', 'manga-premium' ),
		'id'            => 'footer-1',
		'description'   => esc_html__( 'Footer widget column 1.', 'manga-premium' ),
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget'  => '</div>',
		'before_title'  => '<h4 class="widget-title">',
		'after_title'   => '</h4>',
	) );

	register_sidebar( array(
		'name'          => esc_html__( 'Footer Column 2', 'manga-premium' ),
		'id'            => 'footer-2',
		'description'   => esc_html__( 'Footer widget column 2.', 'manga-premium' ),
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget'  => '</div>',
		'before_title'  => '<h4 class="widget-title">',
		'after_title'   => '</h4>',
	) );

	register_sidebar( array(
		'name'          => esc_html__( 'Footer Column 3', 'manga-premium' ),
		'id'            => 'footer-3',
		'description'   => esc_html__( 'Footer widget column 3.', 'manga-premium' ),
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget'  => '</div>',
		'before_title'  => '<h4 class="widget-title">',
		'after_title'   => '</h4>',
	) );
}
add_action( 'widgets_init', 'manga_premium_widgets_init' );
