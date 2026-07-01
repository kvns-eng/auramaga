<?php
/**
 * Auramaga Theme Functions
 *
 * Main theme bootstrap file. Initializes all theme functionality,
 * registers post types, taxonomies, and includes modular components.
 *
 * @package Auramaga
 * @since 2.0.0
 */

defined( 'ABSPATH' ) || exit;

// Define theme constants.
define( 'AURAMAGA_VERSION', '2.0.0' );
define( 'AURAMAGA_DIR', get_template_directory() );
define( 'AURAMAGA_URI', get_template_directory_uri() );
define( 'AURAMAGA_ASSETS', AURAMAGA_URI . '/assets' );
define( 'AURAMAGA_INC', AURAMAGA_DIR . '/inc' );

// Require PHP 8.1+.
if ( version_compare( PHP_VERSION, '8.1', '<' ) ) {
	wp_die( 'Auramaga requires PHP 8.1 or higher.' );
}

/**
 * Theme Setup
 *
 * @since 2.0.0
 */
function auramaga_setup() {
	// Load text domain for translations.
	load_theme_textdomain( 'auramaga', AURAMAGA_DIR . '/languages' );

	// Add theme support.
	add_theme_support( 'automatic-feed-links' );
	add_theme_support( 'title-tag' );
	add_theme_support( 'post-thumbnails' );
	add_theme_support(
		'html5',
		array(
			'search-form',
			'comment-form',
			'comment-list',
			'gallery',
			'caption',
			'style',
			'script',
		)
	);
	add_theme_support( 'customize-selective-refresh-widgets' );
	add_theme_support( 'responsive-embeds' );
	add_theme_support( 'wp-block-styles' );
	add_theme_support( 'editor-styles' );
	add_theme_support( 'dark-editor-style' );

	// Custom logo.
	add_theme_support(
		'custom-logo',
		array(
			'height'      => 60,
			'width'       => 200,
			'flex-height' => true,
			'flex-width'  => true,
		)
	);

	// Custom background.
	add_theme_support(
		'custom-background',
		array(
			'default-color' => 'ffffff',
		)
	);

	// Register navigation menus.
	register_nav_menus(
		array(
			'primary' => esc_html__( 'Primary Menu', 'auramaga' ),
			'mobile'  => esc_html__( 'Mobile Menu', 'auramaga' ),
			'footer'  => esc_html__( 'Footer Menu', 'auramaga' ),
		)
	);

	// Add custom image sizes.
	add_image_size( 'auramaga-manga-cover', 400, 560, true );
	add_image_size( 'auramaga-manga-thumb', 120, 168, true );
	add_image_size( 'auramaga-manga-banner', 1200, 480, true );
	add_image_size( 'auramaga-hero-slider', 1400, 560, true );
	add_image_size( 'auramaga-chapter-page', 1000, 1500, false );
}
add_action( 'after_setup_theme', 'auramaga_setup' );

/**
 * Set Content Width
 *
 * @since 2.0.0
 */
function auramaga_content_width() {
	$GLOBALS['content_width'] = apply_filters( 'auramaga_content_width', 1200 );
}
add_action( 'after_setup_theme', 'auramaga_content_width', 0 );

/**
 * Include Core Theme Files
 *
 * @since 2.0.0
 */
require_once AURAMAGA_INC . '/core/custom-post-types.php';
require_once AURAMAGA_INC . '/core/custom-taxonomies.php';
require_once AURAMAGA_INC . '/core/template-functions.php';
require_once AURAMAGA_INC . '/core/template-tags.php';
require_once AURAMAGA_INC . '/core/enqueue.php';
require_once AURAMAGA_INC . '/core/theme-options.php';
require_once AURAMAGA_INC . '/core/ajax-handlers.php';
require_once AURAMAGA_INC . '/core/breadcrumbs.php';
require_once AURAMAGA_INC . '/core/pagination.php';
require_once AURAMAGA_INC . '/core/class-manga-walker-nav.php';
require_once AURAMAGA_INC . '/ui/card-ui.php';
require_once AURAMAGA_INC . '/ui/search-ui.php';
require_once AURAMAGA_INC . '/chapter/chapter-pages.php';
require_once AURAMAGA_INC . '/storage/bookmarks-storage.php';
require_once AURAMAGA_INC . '/storage/favorites-storage.php';
require_once AURAMAGA_INC . '/storage/history-storage.php';
require_once AURAMAGA_INC . '/reader/reader-core.php';

/**
 * Register Theme Widgets
 *
 * @since 2.0.0
 */
function auramaga_widgets_init() {
	register_sidebar(
		array(
			'name'          => esc_html__( 'Primary Sidebar', 'auramaga' ),
			'id'            => 'primary-sidebar',
			'description'   => esc_html__( 'Main sidebar widget area', 'auramaga' ),
			'before_widget' => '<div id="%1\$s" class="widget %2\$s">',
			'after_widget'  => '</div>',
			'before_title'  => '<h3 class="widget-title">',
			'after_title'   => '</h3>',
		)
	);

	register_sidebar(
		array(
			'name'          => esc_html__( 'Footer Column 1', 'auramaga' ),
			'id'            => 'footer-1',
			'description'   => esc_html__( 'Footer column 1', 'auramaga' ),
			'before_widget' => '<div id="%1\$s" class="widget %2\$s">',
			'after_widget'  => '</div>',
			'before_title'  => '<h4 class="widget-title">',
			'after_title'   => '</h4>',
		)
	);

	register_sidebar(
		array(
			'name'          => esc_html__( 'Footer Column 2', 'auramaga' ),
			'id'            => 'footer-2',
			'description'   => esc_html__( 'Footer column 2', 'auramaga' ),
			'before_widget' => '<div id="%1\$s" class="widget %2\$s">',
			'after_widget'  => '</div>',
			'before_title'  => '<h4 class="widget-title">',
			'after_title'   => '</h4>',
		)
	);

	register_sidebar(
		array(
			'name'          => esc_html__( 'Footer Column 3', 'auramaga' ),
			'id'            => 'footer-3',
			'description'   => esc_html__( 'Footer column 3', 'auramaga' ),
			'before_widget' => '<div id="%1\$s" class="widget %2\$s">',
			'after_widget'  => '</div>',
			'before_title'  => '<h4 class="widget-title">',
			'after_title'   => '</h4>',
		)
	);
}
add_action( 'widgets_init', 'auramaga_widgets_init' );

/**
 * Flush Rewrite Rules on Theme Activation
 *
 * @since 2.0.0
 */
function auramaga_activation() {
	// Ensure post types are registered.
	auramaga_register_post_types();
	auramaga_register_taxonomies();
	
	// Flush rewrite rules.
	flush_rewrite_rules();
}
add_action( 'after_switch_theme', 'auramaga_activation' );
