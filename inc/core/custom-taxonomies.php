<?php
/**
 * Custom Taxonomies
 *
 * Registers all custom taxonomies for organizing manga content.
 *
 * @package Auramaga
 * @since 2.0.0
 */

defined( 'ABSPATH' ) || exit;

/**
 * Register Manga Taxonomies
 *
 * @since 2.0.0
 */
function auramaga_register_taxonomies() {
	$manga_post_type = array( 'manga' );

	// Genre - hierarchical.
	register_taxonomy(
		'manga_genre',
		$manga_post_type,
		array(
			'labels'            => array(
				'name'          => esc_html_x( 'Genres', 'taxonomy general name', 'auramaga' ),
				'singular_name' => esc_html_x( 'Genre', 'taxonomy singular name', 'auramaga' ),
				'search_items'  => esc_html__( 'Search Genres', 'auramaga' ),
				'all_items'     => esc_html__( 'All Genres', 'auramaga' ),
				'parent_item'   => esc_html__( 'Parent Genre', 'auramaga' ),
				'edit_item'     => esc_html__( 'Edit Genre', 'auramaga' ),
				'update_item'   => esc_html__( 'Update Genre', 'auramaga' ),
				'add_new_item'  => esc_html__( 'Add New Genre', 'auramaga' ),
				'new_item_name' => esc_html__( 'New Genre Name', 'auramaga' ),
				'menu_name'     => esc_html__( 'Genres', 'auramaga' ),
			),
			'hierarchical'      => true,
			'public'            => true,
			'show_ui'           => true,
			'show_admin_column' => true,
			'show_in_rest'      => true,
			'rewrite'           => array(
				'slug'       => 'manga/genre',
				'with_front' => false,
			),
		)
	);

	// Tag - non-hierarchical.
	register_taxonomy(
		'manga_tag',
		$manga_post_type,
		array(
			'labels'            => array(
				'name'          => esc_html_x( 'Tags', 'taxonomy general name', 'auramaga' ),
				'singular_name' => esc_html_x( 'Tag', 'taxonomy singular name', 'auramaga' ),
				'search_items'  => esc_html__( 'Search Tags', 'auramaga' ),
				'all_items'     => esc_html__( 'All Tags', 'auramaga' ),
				'edit_item'     => esc_html__( 'Edit Tag', 'auramaga' ),
				'update_item'   => esc_html__( 'Update Tag', 'auramaga' ),
				'add_new_item'  => esc_html__( 'Add New Tag', 'auramaga' ),
				'new_item_name' => esc_html__( 'New Tag Name', 'auramaga' ),
				'menu_name'     => esc_html__( 'Tags', 'auramaga' ),
			),
			'hierarchical'      => false,
			'public'            => true,
			'show_ui'           => true,
			'show_admin_column' => true,
			'show_in_rest'      => true,
			'rewrite'           => array(
				'slug'       => 'manga/tag',
				'with_front' => false,
			),
		)
	);

	// Author - non-hierarchical.
	register_taxonomy(
		'manga_author',
		$manga_post_type,
		array(
			'labels'            => array(
				'name'          => esc_html_x( 'Authors', 'taxonomy general name', 'auramaga' ),
				'singular_name' => esc_html_x( 'Author', 'taxonomy singular name', 'auramaga' ),
				'search_items'  => esc_html__( 'Search Authors', 'auramaga' ),
				'all_items'     => esc_html__( 'All Authors', 'auramaga' ),
				'edit_item'     => esc_html__( 'Edit Author', 'auramaga' ),
				'update_item'   => esc_html__( 'Update Author', 'auramaga' ),
				'add_new_item'  => esc_html__( 'Add New Author', 'auramaga' ),
				'new_item_name' => esc_html__( 'New Author Name', 'auramaga' ),
				'menu_name'     => esc_html__( 'Authors', 'auramaga' ),
			),
			'hierarchical'      => false,
			'public'            => true,
			'show_ui'           => true,
			'show_admin_column' => true,
			'show_in_rest'      => true,
			'rewrite'           => array(
				'slug'       => 'manga/author',
				'with_front' => false,
			),
		)
	);

	// Artist - non-hierarchical.
	register_taxonomy(
		'manga_artist',
		$manga_post_type,
		array(
			'labels'            => array(
				'name'          => esc_html_x( 'Artists', 'taxonomy general name', 'auramaga' ),
				'singular_name' => esc_html_x( 'Artist', 'taxonomy singular name', 'auramaga' ),
				'search_items'  => esc_html__( 'Search Artists', 'auramaga' ),
				'all_items'     => esc_html__( 'All Artists', 'auramaga' ),
				'edit_item'     => esc_html__( 'Edit Artist', 'auramaga' ),
				'update_item'   => esc_html__( 'Update Artist', 'auramaga' ),
				'add_new_item'  => esc_html__( 'Add New Artist', 'auramaga' ),
				'new_item_name' => esc_html__( 'New Artist Name', 'auramaga' ),
				'menu_name'     => esc_html__( 'Artists', 'auramaga' ),
			),
			'hierarchical'      => false,
			'public'            => true,
			'show_ui'           => true,
			'show_admin_column' => true,
			'show_in_rest'      => true,
			'rewrite'           => array(
				'slug'       => 'manga/artist',
				'with_front' => false,
			),
		)
	);

	// Status - hierarchical.
	register_taxonomy(
		'manga_status',
		$manga_post_type,
		array(
			'labels'            => array(
				'name'          => esc_html_x( 'Status', 'taxonomy general name', 'auramaga' ),
				'singular_name' => esc_html_x( 'Status', 'taxonomy singular name', 'auramaga' ),
				'search_items'  => esc_html__( 'Search Statuses', 'auramaga' ),
				'all_items'     => esc_html__( 'All Statuses', 'auramaga' ),
				'parent_item'   => esc_html__( 'Parent Status', 'auramaga' ),
				'edit_item'     => esc_html__( 'Edit Status', 'auramaga' ),
				'update_item'   => esc_html__( 'Update Status', 'auramaga' ),
				'add_new_item'  => esc_html__( 'Add New Status', 'auramaga' ),
				'new_item_name' => esc_html__( 'New Status Name', 'auramaga' ),
				'menu_name'     => esc_html__( 'Status', 'auramaga' ),
			),
			'hierarchical'      => true,
			'public'            => true,
			'show_ui'           => true,
			'show_admin_column' => true,
			'show_in_rest'      => true,
			'rewrite'           => array(
				'slug'       => 'manga/status',
				'with_front' => false,
			),
		)
	);

	// Type - hierarchical.
	register_taxonomy(
		'manga_type',
		$manga_post_type,
		array(
			'labels'            => array(
				'name'          => esc_html_x( 'Types', 'taxonomy general name', 'auramaga' ),
				'singular_name' => esc_html_x( 'Type', 'taxonomy singular name', 'auramaga' ),
				'search_items'  => esc_html__( 'Search Types', 'auramaga' ),
				'all_items'     => esc_html__( 'All Types', 'auramaga' ),
				'parent_item'   => esc_html__( 'Parent Type', 'auramaga' ),
				'edit_item'     => esc_html__( 'Edit Type', 'auramaga' ),
				'update_item'   => esc_html__( 'Update Type', 'auramaga' ),
				'add_new_item'  => esc_html__( 'Add New Type', 'auramaga' ),
				'new_item_name' => esc_html__( 'New Type Name', 'auramaga' ),
				'menu_name'     => esc_html__( 'Types', 'auramaga' ),
			),
			'hierarchical'      => true,
			'public'            => true,
			'show_ui'           => true,
			'show_admin_column' => true,
			'show_in_rest'      => true,
			'rewrite'           => array(
				'slug'       => 'manga/type',
				'with_front' => false,
			),
		)
	);

	// Demographic - hierarchical.
	register_taxonomy(
		'manga_demographic',
		$manga_post_type,
		array(
			'labels'            => array(
				'name'          => esc_html_x( 'Demographics', 'taxonomy general name', 'auramaga' ),
				'singular_name' => esc_html_x( 'Demographic', 'taxonomy singular name', 'auramaga' ),
				'search_items'  => esc_html__( 'Search Demographics', 'auramaga' ),
				'all_items'     => esc_html__( 'All Demographics', 'auramaga' ),
				'parent_item'   => esc_html__( 'Parent Demographic', 'auramaga' ),
				'edit_item'     => esc_html__( 'Edit Demographic', 'auramaga' ),
				'update_item'   => esc_html__( 'Update Demographic', 'auramaga' ),
				'add_new_item'  => esc_html__( 'Add New Demographic', 'auramaga' ),
				'new_item_name' => esc_html__( 'New Demographic Name', 'auramaga' ),
				'menu_name'     => esc_html__( 'Demographics', 'auramaga' ),
			),
			'hierarchical'      => true,
			'public'            => true,
			'show_ui'           => true,
			'show_admin_column' => true,
			'show_in_rest'      => true,
			'rewrite'           => array(
				'slug'       => 'manga/demographic',
				'with_front' => false,
			),
		)
	);

	// Magazine - non-hierarchical.
	register_taxonomy(
		'manga_magazine',
		$manga_post_type,
		array(
			'labels'            => array(
				'name'          => esc_html_x( 'Magazines', 'taxonomy general name', 'auramaga' ),
				'singular_name' => esc_html_x( 'Magazine', 'taxonomy singular name', 'auramaga' ),
				'search_items'  => esc_html__( 'Search Magazines', 'auramaga' ),
				'all_items'     => esc_html__( 'All Magazines', 'auramaga' ),
				'edit_item'     => esc_html__( 'Edit Magazine', 'auramaga' ),
				'update_item'   => esc_html__( 'Update Magazine', 'auramaga' ),
				'add_new_item'  => esc_html__( 'Add New Magazine', 'auramaga' ),
				'new_item_name' => esc_html__( 'New Magazine Name', 'auramaga' ),
				'menu_name'     => esc_html__( 'Magazines', 'auramaga' ),
			),
			'hierarchical'      => false,
			'public'            => true,
			'show_ui'           => true,
			'show_admin_column' => true,
			'show_in_rest'      => true,
			'rewrite'           => array(
				'slug'       => 'manga/magazine',
				'with_front' => false,
			),
		)
	);
}
add_action( 'init', 'auramaga_register_taxonomies', 11 );
