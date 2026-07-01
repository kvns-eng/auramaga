<?php
/**
 * Reading History Storage
 *
 * Manages user reading history stored in user meta.
 *
 * @package Auramaga
 * @since 2.0.0
 */

defined( 'ABSPATH' ) || exit;

/**
 * Get Reading History
 *
 * @param int $user_id User ID.
 * @return array Array of manga reading history.
 * @since 2.0.0
 */
function auramaga_get_reading_history( $user_id ) {
	if ( ! $user_id ) {
		return array();
	}

	$history = get_user_meta( absint( $user_id ), 'auramaga_reading_history', true );

	return is_array( $history ) ? $history : array();
}

/**
 * Get Current Reading State
 *
 * @param int $user_id User ID.
 * @return array Current reading state.
 * @since 2.0.0
 */
function auramaga_get_current_reading( $user_id ) {
	if ( ! $user_id ) {
		return array();
	}

	$current = get_user_meta( absint( $user_id ), 'auramaga_current_reading', true );

	return is_array( $current ) ? $current : array();
}

/**
 * Update Reading Progress
 *
 * @param int $user_id User ID.
 * @param int $manga_id Manga post ID.
 * @param int $chapter_id Chapter post ID.
 * @param int $page Current page.
 * @return bool Success.
 * @since 2.0.0
 */
function auramaga_update_reading_progress( $user_id, $manga_id, $chapter_id, $page = 1 ) {
	if ( ! $user_id || ! $manga_id || ! $chapter_id ) {
		return false;
	}

	$user_id = absint( $user_id );
	$manga_id = absint( $manga_id );
	$chapter_id = absint( $chapter_id );
	$page = absint( max( 1, $page ) );

	$user = get_user_by( 'ID', $user_id );
	if ( ! $user ) {
		return false;
	}

	$manga = get_post( $manga_id );
	if ( ! $manga || 'manga' !== $manga->post_type ) {
		return false;
	}

	$chapter = get_post( $chapter_id );
	if ( ! $chapter || 'chapter' !== $chapter->post_type ) {
		return false;
	}

	$chapter_meta = auramaga_get_chapter_meta( $chapter_id );

	// Update current reading state.
	$current_reading = array(
		'manga_id'     => $manga_id,
		'chapter_id'   => $chapter_id,
		'chapter_num'  => $chapter_meta['chapter_number'],
		'page'         => $page,
		'last_read'    => current_time( 'mysql' ),
	);

	update_user_meta( $user_id, 'auramaga_current_reading', $current_reading );

	// Add to history.
	$history = auramaga_get_reading_history( $user_id );

	if ( ! isset( $history[ $manga_id ] ) ) {
		$history[ $manga_id ] = array();
	}

	$history[ $manga_id ] = array(
		'chapter_id'   => $chapter_id,
		'chapter_num'  => $chapter_meta['chapter_number'],
		'page'         => $page,
		'last_read'    => current_time( 'mysql' ),
	);

	update_user_meta( $user_id, 'auramaga_reading_history', $history );

	return true;
}

/**
 * Get Continue Reading Manga
 *
 * @param int $user_id User ID.
 * @return array Manga and chapter for continue reading.
 * @since 2.0.0
 */
function auramaga_get_continue_reading( $user_id ) {
	if ( ! $user_id ) {
		return array();
	}

	$current = auramaga_get_current_reading( $user_id );

	if ( empty( $current ) || ! isset( $current['manga_id'] ) ) {
		return array();
	}

	$manga_id = absint( $current['manga_id'] );
	$chapter_id = absint( $current['chapter_id'] );

	$manga = get_post( $manga_id );
	$chapter = get_post( $chapter_id );

	if ( ! $manga || 'manga' !== $manga->post_type ) {
		return array();
	}

	if ( ! $chapter || 'chapter' !== $chapter->post_type ) {
		return array();
	}

	return array(
		'manga_id'    => $manga_id,
		'manga_title' => $manga->post_title,
		'manga_url'   => get_permalink( $manga_id ),
		'chapter_id'  => $chapter_id,
		'chapter_url' => get_permalink( $chapter_id ),
		'page'        => isset( $current['page'] ) ? absint( $current['page'] ) : 1,
		'last_read'   => isset( $current['last_read'] ) ? $current['last_read'] : '',
	);
}
