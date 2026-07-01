<?php
/**
 * Custom Post Types
 *
 * @package MangaPremium
 */

defined( 'ABSPATH' ) || exit;

function manga_premium_register_post_types() {
	/* ─── Manga CPT ─────────────────────────────────── */
	$labels = array(
		'name'               => esc_html__( 'Manga', 'manga-premium' ),
		'singular_name'      => esc_html__( 'Manga', 'manga-premium' ),
		'menu_name'          => esc_html__( 'Manga', 'manga-premium' ),
		'add_new'            => esc_html__( 'Add New Manga', 'manga-premium' ),
		'add_new_item'       => esc_html__( 'Add New Manga', 'manga-premium' ),
		'edit_item'          => esc_html__( 'Edit Manga', 'manga-premium' ),
		'new_item'           => esc_html__( 'New Manga', 'manga-premium' ),
		'view_item'          => esc_html__( 'View Manga', 'manga-premium' ),
		'search_items'       => esc_html__( 'Search Manga', 'manga-premium' ),
		'not_found'          => esc_html__( 'No manga found.', 'manga-premium' ),
		'not_found_in_trash' => esc_html__( 'No manga found in Trash.', 'manga-premium' ),
		'all_items'          => esc_html__( 'All Manga', 'manga-premium' ),
	);

	register_post_type( 'manga', array(
		'labels'       => $labels,
		'public'       => true,
		'has_archive'  => true,
		'rewrite'      => array( 'slug' => 'manga', 'with_front' => false ),
		'supports'     => array( 'title', 'editor', 'thumbnail', 'excerpt', 'comments', 'custom-fields' ),
		'menu_icon'    => 'dashicons-book-alt',
		'show_in_rest' => true,
		'taxonomies'   => array( 'manga_genre', 'manga_tag' ),
	) );

	/* ─── Chapter CPT ───────────────────────────────── */
	$ch_labels = array(
		'name'               => esc_html__( 'Chapters', 'manga-premium' ),
		'singular_name'      => esc_html__( 'Chapter', 'manga-premium' ),
		'menu_name'          => esc_html__( 'Chapters', 'manga-premium' ),
		'add_new'            => esc_html__( 'Add New Chapter', 'manga-premium' ),
		'add_new_item'       => esc_html__( 'Add New Chapter', 'manga-premium' ),
		'edit_item'          => esc_html__( 'Edit Chapter', 'manga-premium' ),
		'new_item'           => esc_html__( 'New Chapter', 'manga-premium' ),
		'search_items'       => esc_html__( 'Search Chapters', 'manga-premium' ),
		'not_found'          => esc_html__( 'No chapters found.', 'manga-premium' ),
		'all_items'          => esc_html__( 'All Chapters', 'manga-premium' ),
	);

	register_post_type( 'mp_chapter', array(
		'labels'       => $ch_labels,
		'public'       => true,
		'has_archive'  => false,
		'rewrite'      => array( 'slug' => 'chapter', 'with_front' => false ),
		'supports'     => array( 'title', 'custom-fields', 'page-attributes' ),
		'menu_icon'    => 'dashicons-media-document',
		'show_in_rest' => true,
	) );
}
add_action( 'init', 'manga_premium_register_post_types' );

/* ─── Flush Rewrite Rules on Theme Activation ─────────── */
function manga_premium_rewrite_flush() {
	manga_premium_register_post_types();
	flush_rewrite_rules();
}
add_action( 'after_switch_theme', 'manga_premium_rewrite_flush' );
