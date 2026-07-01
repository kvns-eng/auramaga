<?php
/**
 * Custom Post Types
 *
 * Registers Manga and Chapter custom post types with proper capabilities,
 * labels, and rewrite rules.
 *
 * @package Auramaga
 * @since 2.0.0
 */

defined( 'ABSPATH' ) || exit;

/**
 * Register Manga CPT
 *
 * @since 2.0.0
 */
function auramaga_register_manga_post_type() {
	$labels = array(
		'name'                  => esc_html_x( 'Manga', 'Post Type General Name', 'auramaga' ),
		'singular_name'         => esc_html_x( 'Manga', 'Post Type Singular Name', 'auramaga' ),
		'menu_name'             => esc_html__( 'Manga', 'auramaga' ),
		'name_admin_bar'        => esc_html__( 'Manga', 'auramaga' ),
		'archives'              => esc_html__( 'Manga Archives', 'auramaga' ),
		'attributes'            => esc_html__( 'Manga Attributes', 'auramaga' ),
		'parent_item_colon'     => esc_html__( 'Parent Manga:', 'auramaga' ),
		'all_items'             => esc_html__( 'All Manga', 'auramaga' ),
		'add_new_item'          => esc_html__( 'Add New Manga', 'auramaga' ),
		'add_new'               => esc_html__( 'Add New', 'auramaga' ),
		'new_item'              => esc_html__( 'New Manga', 'auramaga' ),
		'edit_item'             => esc_html__( 'Edit Manga', 'auramaga' ),
		'update_item'           => esc_html__( 'Update Manga', 'auramaga' ),
		'view_item'             => esc_html__( 'View Manga', 'auramaga' ),
		'view_items'            => esc_html__( 'View Manga', 'auramaga' ),
		'search_items'          => esc_html__( 'Search Manga', 'auramaga' ),
		'not_found'             => esc_html__( 'Not found', 'auramaga' ),
		'not_found_in_trash'    => esc_html__( 'Not found in Trash', 'auramaga' ),
		'featured_image'        => esc_html__( 'Featured Image', 'auramaga' ),
		'set_featured_image'    => esc_html__( 'Set featured image', 'auramaga' ),
		'remove_featured_image' => esc_html__( 'Remove featured image', 'auramaga' ),
		'use_featured_image'    => esc_html__( 'Use as featured image', 'auramaga' ),
		'insert_into_item'      => esc_html__( 'Insert into manga', 'auramaga' ),
		'uploaded_to_this_item' => esc_html__( 'Uploaded to this manga', 'auramaga' ),
		'items_list'            => esc_html__( 'Manga list', 'auramaga' ),
		'items_list_navigation' => esc_html__( 'Manga list navigation', 'auramaga' ),
		'filter_items_list'     => esc_html__( 'Filter manga list', 'auramaga' ),
	);

	$capabilities = array(
		'edit_post'             => 'edit_manga',
		'read_post'             => 'read_manga',
		'delete_post'           => 'delete_manga',
		'edit_posts'            => 'edit_mangas',
		'edit_others_posts'     => 'edit_others_mangas',
		'publish_posts'         => 'publish_mangas',
		'read_private_posts'    => 'read_private_mangas',
		'delete_posts'          => 'delete_mangas',
		'delete_private_posts'  => 'delete_private_mangas',
		'delete_published_posts' => 'delete_published_mangas',
	);

	$args = array(
		'label'              => esc_html__( 'Manga', 'auramaga' ),
		'description'        => esc_html__( 'Manga post type', 'auramaga' ),
		'labels'             => $labels,
		'supports'           => array( 'title', 'editor', 'thumbnail', 'excerpt', 'comments', 'custom-fields', 'author' ),
		'taxonomies'         => array( 'manga_genre', 'manga_tag', 'manga_author', 'manga_artist', 'manga_status', 'manga_type', 'manga_demographic', 'manga_magazine' ),
		'hierarchical'       => false,
		'public'             => true,
		'show_ui'            => true,
		'show_in_menu'       => true,
		'menu_position'      => 5,
		'menu_icon'          => 'dashicons-book-alt',
		'show_in_admin_bar'  => true,
		'show_in_nav_menus'  => true,
		'show_in_rest'       => true,
		'rest_base'          => 'manga',
		'rest_controller_class' => 'WP_REST_Posts_Controller',
		'has_archive'        => true,
		'rewrite'            => array(
			'slug'       => 'manga',
			'with_front' => false,
			'pages'      => true,
			'feeds'      => true,
		),
		'delete_with_user'   => false,
		'map_meta_cap'       => true,
		'capabilities'       => $capabilities,
	);

	register_post_type( 'manga', $args );
}
add_action( 'init', 'auramaga_register_manga_post_type', 10 );

/**
 * Register Chapter CPT
 *
 * @since 2.0.0
 */
function auramaga_register_chapter_post_type() {
	$labels = array(
		'name'                  => esc_html_x( 'Chapters', 'Post Type General Name', 'auramaga' ),
		'singular_name'         => esc_html_x( 'Chapter', 'Post Type Singular Name', 'auramaga' ),
		'menu_name'             => esc_html__( 'Chapters', 'auramaga' ),
		'name_admin_bar'        => esc_html__( 'Chapter', 'auramaga' ),
		'archives'              => esc_html__( 'Chapter Archives', 'auramaga' ),
		'attributes'            => esc_html__( 'Chapter Attributes', 'auramaga' ),
		'parent_item_colon'     => esc_html__( 'Parent Item:', 'auramaga' ),
		'all_items'             => esc_html__( 'All Chapters', 'auramaga' ),
		'add_new_item'          => esc_html__( 'Add New Chapter', 'auramaga' ),
		'add_new'               => esc_html__( 'Add New', 'auramaga' ),
		'new_item'              => esc_html__( 'New Chapter', 'auramaga' ),
		'edit_item'             => esc_html__( 'Edit Chapter', 'auramaga' ),
		'update_item'           => esc_html__( 'Update Chapter', 'auramaga' ),
		'view_item'             => esc_html__( 'View Chapter', 'auramaga' ),
		'view_items'            => esc_html__( 'View Chapters', 'auramaga' ),
		'search_items'          => esc_html__( 'Search Chapters', 'auramaga' ),
		'not_found'             => esc_html__( 'Not found', 'auramaga' ),
		'not_found_in_trash'    => esc_html__( 'Not found in Trash', 'auramaga' ),
		'featured_image'        => esc_html__( 'Chapter Cover', 'auramaga' ),
		'set_featured_image'    => esc_html__( 'Set chapter cover', 'auramaga' ),
		'remove_featured_image' => esc_html__( 'Remove chapter cover', 'auramaga' ),
		'use_featured_image'    => esc_html__( 'Use as chapter cover', 'auramaga' ),
		'insert_into_item'      => esc_html__( 'Insert into chapter', 'auramaga' ),
		'uploaded_to_this_item' => esc_html__( 'Uploaded to this chapter', 'auramaga' ),
		'items_list'            => esc_html__( 'Chapters list', 'auramaga' ),
		'items_list_navigation' => esc_html__( 'Chapters list navigation', 'auramaga' ),
		'filter_items_list'     => esc_html__( 'Filter chapters list', 'auramaga' ),
	);

	$capabilities = array(
		'edit_post'             => 'edit_chapter',
		'read_post'             => 'read_chapter',
		'delete_post'           => 'delete_chapter',
		'edit_posts'            => 'edit_chapters',
		'edit_others_posts'     => 'edit_others_chapters',
		'publish_posts'         => 'publish_chapters',
		'read_private_posts'    => 'read_private_chapters',
		'delete_posts'          => 'delete_chapters',
		'delete_private_posts'  => 'delete_private_chapters',
		'delete_published_posts' => 'delete_published_chapters',
	);

	$args = array(
		'label'              => esc_html__( 'Chapters', 'auramaga' ),
		'description'        => esc_html__( 'Manga chapter post type', 'auramaga' ),
		'labels'             => $labels,
		'supports'           => array( 'title', 'custom-fields', 'page-attributes', 'comments', 'author' ),
		'hierarchical'       => false,
		'public'             => true,
		'publicly_queryable' => true,
		'show_ui'            => true,
		'show_in_menu'       => 'edit.php?post_type=manga',
		'show_in_admin_bar'  => true,
		'show_in_nav_menus'  => false,
		'show_in_rest'       => true,
		'rest_base'          => 'chapters',
		'rest_controller_class' => 'WP_REST_Posts_Controller',
		'has_archive'        => false,
		'rewrite'            => array(
			'slug'       => 'chapter',
			'with_front' => false,
		),
		'delete_with_user'   => false,
		'map_meta_cap'       => true,
		'capabilities'       => $capabilities,
	);

	register_post_type( 'chapter', $args );
}
add_action( 'init', 'auramaga_register_chapter_post_type', 10 );

/**
 * Wrapper for theme activation
 *
 * @since 2.0.0
 */
function auramaga_register_post_types() {
	auramaga_register_manga_post_type();
	auramaga_register_chapter_post_type();
}
