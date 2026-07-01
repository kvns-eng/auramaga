<?php
/**
 * Reader Core
 *
 * Core reader functionality for displaying and managing chapter reading.
 *
 * @package Auramaga
 * @since 2.0.0
 */

defined( 'ABSPATH' ) || exit;

/**
 * Get Reader Settings
 *
 * @param int $user_id User ID (0 for defaults).
 * @return array Reader settings.
 * @since 2.0.0
 */
function auramaga_get_reader_settings( $user_id = 0 ) {
	$defaults = array(
		'mode'                => get_theme_mod( 'auramaga_reader_mode', 'longstrip' ),
		'background'          => get_theme_mod( 'auramaga_reader_background', 'dark' ),
		'image_fit'           => get_theme_mod( 'auramaga_reader_image_fit', 'width' ),
		'reading_direction'   => 'ltr',
		'keyboard_navigation' => true,
		'auto_save'           => true,
	);

	if ( ! $user_id ) {
		return $defaults;
	}

	$user_settings = get_user_meta( absint( $user_id ), 'auramaga_reader_settings', true );

	if ( ! is_array( $user_settings ) ) {
		return $defaults;
	}

	return wp_parse_args( $user_settings, $defaults );
}

/**
 * Update Reader Settings
 *
 * @param int $user_id User ID.
 * @param array $settings Settings array.
 * @return bool Success.
 * @since 2.0.0
 */
function auramaga_update_reader_settings( $user_id, $settings ) {
	if ( ! $user_id || ! is_array( $settings ) ) {
		return false;
	}

	$user = get_user_by( 'ID', absint( $user_id ) );
	if ( ! $user ) {
		return false;
	}

	$allowed_modes = array( 'longstrip', 'singlepage', 'doublepage' );
	$allowed_backgrounds = array( 'dark', 'light', 'sepia' );
	$allowed_fits = array( 'contain', 'width', 'original' );
	$allowed_directions = array( 'ltr', 'rtl' );

	$sanitized = array(
		'mode'              => in_array( $settings['mode'] ?? '', $allowed_modes, true ) ? $settings['mode'] : 'longstrip',
		'background'        => in_array( $settings['background'] ?? '', $allowed_backgrounds, true ) ? $settings['background'] : 'dark',
		'image_fit'         => in_array( $settings['image_fit'] ?? '', $allowed_fits, true ) ? $settings['image_fit'] : 'width',
		'reading_direction' => in_array( $settings['reading_direction'] ?? '', $allowed_directions, true ) ? $settings['reading_direction'] : 'ltr',
		'keyboard_navigation' => ! empty( $settings['keyboard_navigation'] ),
		'auto_save'         => ! empty( $settings['auto_save'] ),
	);

	update_user_meta( absint( $user_id ), 'auramaga_reader_settings', $sanitized );

	return true;
}

/**
 * Get Previous Chapter
 *
 * @param int $chapter_id Current chapter post ID.
 * @return WP_Post|null Previous chapter or null.
 * @since 2.0.0
 */
function auramaga_get_previous_chapter( $chapter_id ) {
	if ( ! $chapter_id ) {
		return null;
	}

	$chapter = get_post( $chapter_id );
	if ( ! $chapter || 'chapter' !== $chapter->post_type ) {
		return null;
	}

	$chapter_meta = auramaga_get_chapter_meta( $chapter_id );
	if ( ! $chapter_meta['manga_id'] ) {
		return null;
	}

	$current_num = $chapter_meta['chapter_number'];

	$args = array(
		'post_type'      => 'chapter',
		'posts_per_page' => 1,
		'post_status'    => 'publish',
		'meta_query'     => array(
			array(
				'key'   => '_auramaga_manga_id',
				'value' => $chapter_meta['manga_id'],
				'type'  => 'NUMERIC',
			),
		),
		'meta_key'       => '_auramaga_chapter_number',
		'orderby'        => 'meta_value_num',
		'order'          => 'DESC',
	);

	$query = new WP_Query( $args );

	if ( ! $query->have_posts() ) {
		return null;
	}

	while ( $query->have_posts() ) {
		$query->the_post();
		$prev_meta = auramaga_get_chapter_meta( get_the_ID() );

		if ( $prev_meta['chapter_number'] < $current_num ) {
			$result = get_post( get_the_ID() );
			wp_reset_postdata();
			return $result;
		}
	}

	wp_reset_postdata();
	return null;
}

/**
 * Get Next Chapter
 *
 * @param int $chapter_id Current chapter post ID.
 * @return WP_Post|null Next chapter or null.
 * @since 2.0.0
 */
function auramaga_get_next_chapter( $chapter_id ) {
	if ( ! $chapter_id ) {
		return null;
	}

	$chapter = get_post( $chapter_id );
	if ( ! $chapter || 'chapter' !== $chapter->post_type ) {
		return null;
	}

	$chapter_meta = auramaga_get_chapter_meta( $chapter_id );
	if ( ! $chapter_meta['manga_id'] ) {
		return null;
	}

	$current_num = $chapter_meta['chapter_number'];

	$args = array(
		'post_type'      => 'chapter',
		'posts_per_page' => 1,
		'post_status'    => 'publish',
		'meta_query'     => array(
			array(
				'key'   => '_auramaga_manga_id',
				'value' => $chapter_meta['manga_id'],
				'type'  => 'NUMERIC',
			),
		),
		'meta_key'       => '_auramaga_chapter_number',
		'orderby'        => 'meta_value_num',
		'order'          => 'ASC',
	);

	$query = new WP_Query( $args );

	if ( ! $query->have_posts() ) {
		return null;
	}

	while ( $query->have_posts() ) {
		$query->the_post();
		$next_meta = auramaga_get_chapter_meta( get_the_ID() );

		if ( $next_meta['chapter_number'] > $current_num ) {
			$result = get_post( get_the_ID() );
			wp_reset_postdata();
			return $result;
		}
	}

	wp_reset_postdata();
	return null;
}
