<?php
/**
 * Template Functions
 *
 * Core template helper functions for querying and manipulating manga and chapter data.
 *
 * @package Auramaga
 * @since 2.0.0
 */

defined( 'ABSPATH' ) || exit;

/**
 * Get Post Meta with Default
 *
 * @param int $post_id Post ID.
 * @param string $key Meta key (without prefix).
 * @param string $default Default value.
 * @return mixed Meta value or default.
 * @since 2.0.0
 */
function auramaga_get_meta( $post_id, $key, $default = '' ) {
	if ( ! $post_id ) {
		return $default;
	}
	$val = get_post_meta( $post_id, '_auramaga_' . $key, true );
	return ( '' !== $val ) ? $val : $default;
}

/**
 * Get Manga Meta
 *
 * @param int $post_id Manga post ID.
 * @return array Manga metadata.
 * @since 2.0.0
 */
function auramaga_get_manga_meta( $post_id ) {
	return array(
		'status'           => auramaga_get_meta( $post_id, 'status', 'ongoing' ),
		'type'             => auramaga_get_meta( $post_id, 'type', 'manga' ),
		'release_year'     => absint( auramaga_get_meta( $post_id, 'release_year', 0 ) ),
		'rating'           => floatval( auramaga_get_meta( $post_id, 'rating', 0 ) ),
		'rating_count'     => absint( auramaga_get_meta( $post_id, 'rating_count', 0 ) ),
		'views'            => absint( auramaga_get_meta( $post_id, 'views', 0 ) ),
		'bookmark_count'   => absint( auramaga_get_meta( $post_id, 'bookmark_count', 0 ) ),
		'favorite_count'   => absint( auramaga_get_meta( $post_id, 'favorite_count', 0 ) ),
		'alt_titles'       => sanitize_text_field( auramaga_get_meta( $post_id, 'alt_titles', '' ) ),
		'language'         => sanitize_text_field( auramaga_get_meta( $post_id, 'language', 'en' ) ),
		'age_rating'       => sanitize_text_field( auramaga_get_meta( $post_id, 'age_rating', 'all-ages' ) ),
		'publisher'        => sanitize_text_field( auramaga_get_meta( $post_id, 'publisher', '' ) ),
		'serialization'    => sanitize_text_field( auramaga_get_meta( $post_id, 'serialization', '' ) ),
		'total_chapters'   => absint( auramaga_get_meta( $post_id, 'total_chapters', 0 ) ),
		'last_updated'     => sanitize_text_field( auramaga_get_meta( $post_id, 'last_updated', '' ) ),
		'reading_direction' => sanitize_text_field( auramaga_get_meta( $post_id, 'reading_direction', 'ltr' ) ),
	);
}

/**
 * Get Chapter Meta
 *
 * @param int $post_id Chapter post ID.
 * @return array Chapter metadata.
 * @since 2.0.0
 */
function auramaga_get_chapter_meta( $post_id ) {
	return array(
		'manga_id'          => absint( auramaga_get_meta( $post_id, 'manga_id', 0 ) ),
		'chapter_number'    => floatval( auramaga_get_meta( $post_id, 'chapter_number', 0 ) ),
		'volume_number'     => sanitize_text_field( auramaga_get_meta( $post_id, 'volume_number', '' ) ),
		'chapter_title'     => sanitize_text_field( auramaga_get_meta( $post_id, 'chapter_title', '' ) ),
		'upload_date'       => sanitize_text_field( auramaga_get_meta( $post_id, 'upload_date', '' ) ),
		'page_count'        => absint( auramaga_get_meta( $post_id, 'page_count', 0 ) ),
		'views'             => absint( auramaga_get_meta( $post_id, 'views', 0 ) ),
		'reading_direction' => sanitize_text_field( auramaga_get_meta( $post_id, 'reading_direction', 'ltr' ) ),
	);
}

/**
 * Get Chapters for Manga
 *
 * @param int $manga_id Manga post ID.
 * @param string $order ASC or DESC.
 * @param int $limit Number of chapters to return (-1 for all).
 * @return array Array of chapter post objects.
 * @since 2.0.0
 */
function auramaga_get_manga_chapters( $manga_id, $order = 'DESC', $limit = -1 ) {
	if ( ! $manga_id ) {
		return array();
	}

	$args = array(
		'post_type'      => 'chapter',
		'posts_per_page' => $limit,
		'post_status'    => 'publish',
		'meta_key'       => '_auramaga_chapter_number',
		'orderby'        => 'meta_value_num',
		'order'          => sanitize_text_field( $order ),
		'meta_query'     => array(
			array(
				'key'   => '_auramaga_manga_id',
				'value' => $manga_id,
				'compare' => '=',
				'type'  => 'NUMERIC',
			),
		),
	);

	return get_posts( $args );
}

/**
 * Get Latest Chapters
 *
 * @param int $limit Number of chapters to return.
 * @return array Array of chapter post objects.
 * @since 2.0.0
 */
function auramaga_get_latest_chapters( $limit = 10 ) {
	$args = array(
		'post_type'      => 'chapter',
		'posts_per_page' => absint( $limit ),
		'post_status'    => 'publish',
		'orderby'        => 'date',
		'order'          => 'DESC',
	);

	return get_posts( $args );
}

/**
 * Get Manga by Taxonomy
 *
 * @param string $taxonomy Taxonomy name.
 * @param string $term_slug Term slug.
 * @param int $limit Posts per page.
 * @param int $offset Posts offset.
 * @param string $orderby Order by field.
 * @param string $order ASC or DESC.
 * @return WP_Query Query object.
 * @since 2.0.0
 */
function auramaga_get_manga_by_tax( $taxonomy, $term_slug, $limit = 24, $offset = 0, $orderby = 'date', $order = 'DESC' ) {
	$args = array(
		'post_type'      => 'manga',
		'posts_per_page' => absint( $limit ),
		'offset'         => absint( $offset ),
		'post_status'    => 'publish',
		'orderby'        => sanitize_text_field( $orderby ),
		'order'          => sanitize_text_field( $order ),
		'tax_query'      => array(
			array(
				'taxonomy' => sanitize_text_field( $taxonomy ),
				'field'    => 'slug',
				'terms'    => sanitize_text_field( $term_slug ),
			),
		),
	);

	return new WP_Query( $args );
}

/**
 * Get Related Manga
 *
 * @param int $post_id Manga post ID.
 * @param int $limit Number of related manga to return.
 * @return array Array of manga post objects.
 * @since 2.0.0
 */
function auramaga_get_related_manga( $post_id, $limit = 6 ) {
	if ( ! $post_id ) {
		return array();
	}

	$genres = wp_get_post_terms( $post_id, 'manga_genre', array( 'fields' => 'ids' ) );

	if ( empty( $genres ) || is_wp_error( $genres ) ) {
		return array();
	}

	$args = array(
		'post_type'      => 'manga',
		'posts_per_page' => absint( $limit ),
		'post_status'    => 'publish',
		'post__not_in'   => array( $post_id ),
		'orderby'        => 'rand',
		'tax_query'      => array(
			array(
				'taxonomy' => 'manga_genre',
				'field'    => 'id',
				'terms'    => $genres,
			),
		),
	);

	return get_posts( $args );
}

/**
 * Get Popular Manga
 *
 * @param int $limit Number of manga to return.
 * @return array Array of manga post objects.
 * @since 2.0.0
 */
function auramaga_get_popular_manga( $limit = 6 ) {
	$args = array(
		'post_type'      => 'manga',
		'posts_per_page' => absint( $limit ),
		'post_status'    => 'publish',
		'meta_key'       => '_auramaga_rating',
		'orderby'        => 'meta_value_num',
		'order'          => 'DESC',
	);

	return get_posts( $args );
}

/**
 * Get Trending Manga
 *
 * @param int $limit Number of manga to return.
 * @return array Array of manga post objects.
 * @since 2.0.0
 */
function auramaga_get_trending_manga( $limit = 6 ) {
	$args = array(
		'post_type'      => 'manga',
		'posts_per_page' => absint( $limit ),
		'post_status'    => 'publish',
		'meta_key'       => '_auramaga_views',
		'orderby'        => 'meta_value_num',
		'order'          => 'DESC',
	);

	return get_posts( $args );
}

/**
 * Increment View Count
 *
 * @param int $post_id Post ID.
 * @since 2.0.0
 */
function auramaga_increment_views( $post_id ) {
	if ( ! $post_id ) {
		return;
	}

	$current = absint( auramaga_get_meta( $post_id, 'views', 0 ) );
	update_post_meta( $post_id, '_auramaga_views', $current + 1 );
}

/**
 * Format Large Numbers
 *
 * @param int|float $number Number to format.
 * @return string Formatted number.
 * @since 2.0.0
 */
function auramaga_format_number( $number ) {
	$number = floatval( $number );

	if ( $number >= 1000000 ) {
		return round( $number / 1000000, 1 ) . 'M';
	}

	if ( $number >= 1000 ) {
		return round( $number / 1000, 1 ) . 'K';
	}

	return (string) intval( $number );
}

/**
 * Get First Available Chapter
 *
 * @param int $manga_id Manga post ID.
 * @return WP_Post|null First chapter or null.
 * @since 2.0.0
 */
function auramaga_get_first_chapter( $manga_id ) {
	if ( ! $manga_id ) {
		return null;
	}

	$chapters = auramaga_get_manga_chapters( $manga_id, 'ASC', 1 );

	return ! empty( $chapters ) ? $chapters[0] : null;
}

/**
 * Get Latest Available Chapter
 *
 * @param int $manga_id Manga post ID.
 * @return WP_Post|null Latest chapter or null.
 * @since 2.0.0
 */
function auramaga_get_latest_chapter( $manga_id ) {
	if ( ! $manga_id ) {
		return null;
	}

	$chapters = auramaga_get_manga_chapters( $manga_id, 'DESC', 1 );

	return ! empty( $chapters ) ? $chapters[0] : null;
}

/**
 * Add Body Classes
 *
 * @param array $classes Body classes.
 * @return array Modified classes.
 * @since 2.0.0
 */
function auramaga_body_classes( $classes ) {
	if ( is_singular() ) {
		$classes[] = 'singular';

		if ( is_singular( 'manga' ) ) {
			$classes[] = 'single-manga';
		}

		if ( is_singular( 'chapter' ) ) {
			$classes[] = 'single-chapter';
			$classes[] = 'reader-page';
		}
	}

	if ( is_post_type_archive( 'manga' ) ) {
		$classes[] = 'archive-manga';
	}

	if ( is_tax( array( 'manga_genre', 'manga_tag', 'manga_author', 'manga_artist', 'manga_status', 'manga_type', 'manga_demographic', 'manga_magazine' ) ) ) {
		$classes[] = 'taxonomy-manga';
	}

	return $classes;
}
add_filter( 'body_class', 'auramaga_body_classes' );
