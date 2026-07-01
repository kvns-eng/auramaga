<?php
/**
 * Asset Enqueue
 *
 * @package MangaPremium
 */

defined( 'ABSPATH' ) || exit;

function manga_premium_enqueue_styles() {
	wp_enqueue_style(
		'manga-premium-main',
		MP_URI . '/assets/css/main.css',
		array(),
		MP_VERSION
	);

	wp_enqueue_style(
		'manga-premium-responsive',
		MP_URI . '/assets/css/responsive.css',
		array( 'manga-premium-main' ),
		MP_VERSION
	);

	if ( is_singular( 'mp_chapter' ) ) {
		wp_enqueue_style(
			'manga-premium-reader',
			MP_URI . '/assets/css/reader.css',
			array( 'manga-premium-main' ),
			MP_VERSION
		);
	}
}
add_action( 'wp_enqueue_scripts', 'manga_premium_enqueue_styles' );

function manga_premium_enqueue_scripts() {
	wp_enqueue_script(
		'manga-premium-main',
		MP_URI . '/assets/js/main.js',
		array(),
		MP_VERSION,
		true
	);

	wp_localize_script( 'manga-premium-main', 'mpData', array(
		'ajaxUrl'  => admin_url( 'admin-ajax.php' ),
		'nonce'    => wp_create_nonce( 'mp-nonce' ),
		'siteUrl'  => home_url( '/' ),
		'i18n'     => array(
			'search'    => esc_html__( 'Search manga…', 'manga-premium' ),
			'noResults' => esc_html__( 'No results found.', 'manga-premium' ),
			'loading'   => esc_html__( 'Loading…', 'manga-premium' ),
		),
	) );

	if ( is_singular( 'mp_chapter' ) ) {
		wp_enqueue_script(
			'manga-premium-reader',
			MP_URI . '/assets/js/reader.js',
			array( 'manga-premium-main' ),
			MP_VERSION,
			true
		);
	}

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'manga_premium_enqueue_scripts' );

/* ─── Preload Critical Assets ─────────────────────────── */
function manga_premium_preload_assets() {
	echo '<link rel="preconnect" href="https://fonts.googleapis.com">' . "\n";
	echo '<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>' . "\n";
	echo '<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">' . "\n";
}
add_action( 'wp_head', 'manga_premium_preload_assets', 1 );
