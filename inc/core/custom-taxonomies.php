<?php
/**
 * Custom Taxonomies
 *
 * @package MangaPremium
 */

defined( 'ABSPATH' ) || exit;

function manga_premium_register_taxonomies() {
	$post_types = array( 'manga' );

	/* ─── Genre ─────────────────────────────────────── */
	register_taxonomy( 'manga_genre', $post_types, array(
		'labels' => array(
			'name'          => esc_html__( 'Genres', 'manga-premium' ),
			'singular_name' => esc_html__( 'Genre', 'manga-premium' ),
			'search_items'  => esc_html__( 'Search Genres', 'manga-premium' ),
			'all_items'     => esc_html__( 'All Genres', 'manga-premium' ),
			'edit_item'     => esc_html__( 'Edit Genre', 'manga-premium' ),
			'add_new_item'  => esc_html__( 'Add New Genre', 'manga-premium' ),
			'menu_name'     => esc_html__( 'Genres', 'manga-premium' ),
		),
		'public'             => true,
		'hierarchical'       => true,
		'show_in_rest'       => true,
		'rewrite'            => array( 'slug' => 'genre', 'with_front' => false ),
		'show_admin_column'  => true,
	) );

	/* ─── Tag ───────────────────────────────────────── */
	register_taxonomy( 'manga_tag', $post_types, array(
		'labels' => array(
			'name'          => esc_html__( 'Manga Tags', 'manga-premium' ),
			'singular_name' => esc_html__( 'Tag', 'manga-premium' ),
			'search_items'  => esc_html__( 'Search Tags', 'manga-premium' ),
			'all_items'     => esc_html__( 'All Tags', 'manga-premium' ),
			'add_new_item'  => esc_html__( 'Add New Tag', 'manga-premium' ),
			'menu_name'     => esc_html__( 'Tags', 'manga-premium' ),
		),
		'public'             => true,
		'hierarchical'       => false,
		'show_in_rest'       => true,
		'rewrite'            => array( 'slug' => 'tag', 'with_front' => false ),
		'show_admin_column'  => true,
	) );

	/* ─── Author (manga author) ─────────────────────── */
	register_taxonomy( 'manga_author', $post_types, array(
		'labels' => array(
			'name'          => esc_html__( 'Manga Authors', 'manga-premium' ),
			'singular_name' => esc_html__( 'Author', 'manga-premium' ),
			'search_items'  => esc_html__( 'Search Authors', 'manga-premium' ),
			'all_items'     => esc_html__( 'All Authors', 'manga-premium' ),
			'add_new_item'  => esc_html__( 'Add New Author', 'manga-premium' ),
			'menu_name'     => esc_html__( 'Authors', 'manga-premium' ),
		),
		'public'             => true,
		'hierarchical'       => false,
		'show_in_rest'       => true,
		'rewrite'            => array( 'slug' => 'manga-author', 'with_front' => false ),
		'show_admin_column'  => true,
	) );

	/* ─── Artist ────────────────────────────────────── */
	register_taxonomy( 'manga_artist', $post_types, array(
		'labels' => array(
			'name'          => esc_html__( 'Artists', 'manga-premium' ),
			'singular_name' => esc_html__( 'Artist', 'manga-premium' ),
			'search_items'  => esc_html__( 'Search Artists', 'manga-premium' ),
			'all_items'     => esc_html__( 'All Artists', 'manga-premium' ),
			'add_new_item'  => esc_html__( 'Add New Artist', 'manga-premium' ),
			'menu_name'     => esc_html__( 'Artists', 'manga-premium' ),
		),
		'public'             => true,
		'hierarchical'       => false,
		'show_in_rest'       => true,
		'rewrite'            => array( 'slug' => 'manga-artist', 'with_front' => false ),
		'show_admin_column'  => true,
	) );

	/* ─── Status ────────────────────────────────────── */
	register_taxonomy( 'manga_status', $post_types, array(
		'labels' => array(
			'name'          => esc_html__( 'Status', 'manga-premium' ),
			'singular_name' => esc_html__( 'Status', 'manga-premium' ),
			'search_items'  => esc_html__( 'Search Statuses', 'manga-premium' ),
			'all_items'     => esc_html__( 'All Statuses', 'manga-premium' ),
			'add_new_item'  => esc_html__( 'Add New Status', 'manga-premium' ),
			'menu_name'     => esc_html__( 'Status', 'manga-premium' ),
		),
		'public'             => true,
		'hierarchical'       => true,
		'show_in_rest'       => true,
		'rewrite'            => array( 'slug' => 'manga-status', 'with_front' => false ),
		'show_admin_column'  => true,
	) );

	/* ─── Type ──────────────────────────────────────── */
	register_taxonomy( 'manga_type', $post_types, array(
		'labels' => array(
			'name'          => esc_html__( 'Manga Types', 'manga-premium' ),
			'singular_name' => esc_html__( 'Type', 'manga-premium' ),
			'search_items'  => esc_html__( 'Search Types', 'manga-premium' ),
			'all_items'     => esc_html__( 'All Types', 'manga-premium' ),
			'add_new_item'  => esc_html__( 'Add New Type', 'manga-premium' ),
			'menu_name'     => esc_html__( 'Types', 'manga-premium' ),
		),
		'public'             => true,
		'hierarchical'       => true,
		'show_in_rest'       => true,
		'rewrite'            => array( 'slug' => 'manga-type', 'with_front' => false ),
		'show_admin_column'  => true,
	) );

	/* ─── Demographic ───────────────────────────────── */
	register_taxonomy( 'manga_demographic', $post_types, array(
		'labels' => array(
			'name'          => esc_html__( 'Demographics', 'manga-premium' ),
			'singular_name' => esc_html__( 'Demographic', 'manga-premium' ),
			'search_items'  => esc_html__( 'Search Demographics', 'manga-premium' ),
			'all_items'     => esc_html__( 'All Demographics', 'manga-premium' ),
			'add_new_item'  => esc_html__( 'Add New Demographic', 'manga-premium' ),
			'menu_name'     => esc_html__( 'Demographics', 'manga-premium' ),
		),
		'public'             => true,
		'hierarchical'       => true,
		'show_in_rest'       => true,
		'rewrite'            => array( 'slug' => 'demographic', 'with_front' => false ),
		'show_admin_column'  => true,
	) );

	/* ─── Magazine ──────────────────────────────────── */
	register_taxonomy( 'manga_magazine', $post_types, array(
		'labels' => array(
			'name'          => esc_html__( 'Magazines', 'manga-premium' ),
			'singular_name' => esc_html__( 'Magazine', 'manga-premium' ),
			'search_items'  => esc_html__( 'Search Magazines', 'manga-premium' ),
			'all_items'     => esc_html__( 'All Magazines', 'manga-premium' ),
			'add_new_item'  => esc_html__( 'Add New Magazine', 'manga-premium' ),
			'menu_name'     => esc_html__( 'Magazines', 'manga-premium' ),
		),
		'public'             => true,
		'hierarchical'       => false,
		'show_in_rest'       => true,
		'rewrite'            => array( 'slug' => 'magazine', 'with_front' => false ),
		'show_admin_column'  => true,
	) );
}
add_action( 'init', 'manga_premium_register_taxonomies' );
