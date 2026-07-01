<?php
/**
 * Template Functions
 *
 * @package MangaPremium
 */

defined( 'ABSPATH' ) || exit;

/* ─── Meta Helper ─────────────────────────────────────── */
function mp_get_meta( $post_id, $key, $default = '' ) {
	$val = get_post_meta( $post_id, '_mp_' . $key, true );
	return '' !== $val ? $val : $default;
}

function mp_get_manga_meta( $post_id ) {
	return array(
		'status'       => mp_get_meta( $post_id, 'status', 'ongoing' ),
		'type'         => mp_get_meta( $post_id, 'type', 'manga' ),
		'release_year' => mp_get_meta( $post_id, 'release_year', '' ),
		'rating'       => floatval( mp_get_meta( $post_id, 'rating', '0' ) ),
		'rating_count' => intval( mp_get_meta( $post_id, 'rating_count', '0' ) ),
		'views'        => intval( mp_get_meta( $post_id, 'views', '0' ) ),
		'bookmarks'    => intval( mp_get_meta( $post_id, 'bookmarks', '0' ) ),
		'chapter_num'  => mp_get_meta( $post_id, 'chapter_number', '' ),
		'alt_titles'   => mp_get_meta( $post_id, 'alt_titles', '' ),
	);
}

/* ─── Chapter Meta ────────────────────────────────────── */
function mp_get_chapter_meta( $post_id ) {
	return array(
		'manga_id'      => mp_get_meta( $post_id, 'manga_id', '' ),
		'chapter_num'   => floatval( mp_get_meta( $post_id, 'chapter_number', '0' ) ),
		'volume_num'    => mp_get_meta( $post_id, 'volume_number', '' ),
		'page_count'    => intval( mp_get_meta( $post_id, 'page_count', '0' ) ),
		'views'         => intval( mp_get_meta( $post_id, 'views', '0' ) ),
	);
}

/* ─── Get Chapters for Manga ──────────────────────────── */
function mp_get_manga_chapters( $manga_id, $order = 'DESC', $limit = -1 ) {
	$args = array(
		'post_type'      => 'mp_chapter',
		'posts_per_page' => $limit,
		'post_status'    => 'publish',
		'meta_key'       => '_mp_chapter_number',
		'orderby'        => 'meta_value_num',
		'order'          => $order,
		'meta_query'     => array(
			array(
				'key'   => '_mp_manga_id',
				'value' => $manga_id,
			),
		),
	);
	return get_posts( $args );
}

/* ─── Get Latest Chapters (global) ────────────────────── */
function mp_get_latest_chapters( $limit = 10 ) {
	$args = array(
		'post_type'      => 'mp_chapter',
		'posts_per_page' => $limit,
		'post_status'    => 'publish',
		'meta_key'       => '_mp_chapter_number',
		'orderby'        => 'date',
		'order'          => 'DESC',
	);
	return get_posts( $args );
}

/* ─── Get Manga by Taxonomy ───────────────────────────── */
function mp_get_manga_by_tax( $taxonomy, $term_slug, $limit = 24, $offset = 0, $orderby = 'date', $order = 'DESC' ) {
	$args = array(
		'post_type'      => 'manga',
		'posts_per_page' => $limit,
		'offset'         => $offset,
		'post_status'    => 'publish',
		'orderby'        => $orderby,
		'order'          => $order,
		'tax_query'      => array(
			array(
				'taxonomy' => $taxonomy,
				'field'    => 'slug',
				'terms'    => $term_slug,
			),
		),
	);
	return new WP_Query( $args );
}

/* ─── Get Related Manga ──────────────────────────────── */
function mp_get_related_manga( $post_id, $limit = 6 ) {
	$genres = wp_get_post_terms( $post_id, 'manga_genre', array( 'fields' => 'ids' ) );

	if ( empty( $genres ) ) {
		return array();
	}

	$args = array(
		'post_type'      => 'manga',
		'posts_per_page' => $limit,
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

/* ─── Format Numbers ──────────────────────────────────── */
function mp_format_number( $number ) {
	$number = intval( $number );
	if ( $number >= 1000000 ) {
		return round( $number / 1000000, 1 ) . 'M';
	}
	if ( $number >= 1000 ) {
		return round( $number / 1000, 1 ) . 'K';
	}
	return (string) $number;
}

/* ─── Get Mapped Chapter URL ──────────────────────────── */
function mp_get_chapter_url( $chapter_post, $manga_slug = '' ) {
	if ( ! $manga_slug ) {
		$manga_id = mp_get_meta( $chapter_post->ID, 'manga_id', '' );
		if ( $manga_id ) {
			$manga_slug = get_post_field( 'post_name', $manga_id );
		}
	}
	$ch_num = mp_get_meta( $chapter_post->ID, 'chapter_number', '' );
	return home_url( '/manga/' . $manga_slug . '/chapter/' . $ch_num . '/' );
}

/* ─── Body Classes ────────────────────────────────────── */
function manga_premium_body_classes( $classes ) {
	if ( is_singular() ) {
		$classes[] = 'singular';
	}
	if ( is_singular( 'manga' ) ) {
		$classes[] = 'single-manga';
	}
	if ( is_singular( 'mp_chapter' ) ) {
		$classes[] = 'single-chapter';
		$classes[] = 'reader-page';
	}
	if ( is_post_type_archive( 'manga' ) ) {
		$classes[] = 'archive-manga';
	}
	return $classes;
}
add_filter( 'body_class', 'manga_premium_body_classes' );
