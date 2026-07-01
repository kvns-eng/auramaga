<?php
/**
 * Bookmarks Storage
 *
 * Manages user bookmarks stored in user meta.
 *
 * @package Auramaga
 * @since 2.0.0
 */

defined( 'ABSPATH' ) || exit;

/**
 * Get User Bookmarks
 *
 * @param int $user_id User ID.
 * @return array Array of manga IDs.
 * @since 2.0.0
 */
function auramaga_get_user_bookmarks( $user_id ) {
	if ( ! $user_id ) {
		return array();
	}

	$bookmarks = get_user_meta( absint( $user_id ), 'auramaga_bookmarks', true );

	return is_array( $bookmarks ) ? $bookmarks : array();
}

/**
 * Add Bookmark
 *
 * @param int $user_id User ID.
 * @param int $manga_id Manga post ID.
 * @return bool Success.
 * @since 2.0.0
 */
function auramaga_add_bookmark( $user_id, $manga_id ) {
	if ( ! $user_id || ! $manga_id ) {
		return false;
	}

	$user_id = absint( $user_id );
	$manga_id = absint( $manga_id );

	$user = get_user_by( 'ID', $user_id );
	if ( ! $user ) {
		return false;
	}

	$manga = get_post( $manga_id );
	if ( ! $manga || 'manga' !== $manga->post_type ) {
		return false;
	}

	$bookmarks = auramaga_get_user_bookmarks( $user_id );

	if ( ! in_array( $manga_id, $bookmarks, true ) ) {
		$bookmarks[] = $manga_id;
		update_user_meta( $user_id, 'auramaga_bookmarks', $bookmarks );
	}

	// Update bookmark count on manga post.
	$bookmark_count = absint( get_post_meta( $manga_id, '_auramaga_bookmark_count', true ) );
	update_post_meta( $manga_id, '_auramaga_bookmark_count', $bookmark_count + 1 );

	return true;
}

/**
 * Remove Bookmark
 *
 * @param int $user_id User ID.
 * @param int $manga_id Manga post ID.
 * @return bool Success.
 * @since 2.0.0
 */
function auramaga_remove_bookmark( $user_id, $manga_id ) {
	if ( ! $user_id || ! $manga_id ) {
		return false;
	}

	$user_id = absint( $user_id );
	$manga_id = absint( $manga_id );

	$bookmarks = auramaga_get_user_bookmarks( $user_id );
	$bookmarks = array_diff( $bookmarks, array( $manga_id ) );
	$bookmarks = array_values( $bookmarks );

	update_user_meta( $user_id, 'auramaga_bookmarks', $bookmarks );

	// Update bookmark count on manga post.
	$bookmark_count = absint( get_post_meta( $manga_id, '_auramaga_bookmark_count', true ) );
	if ( $bookmark_count > 0 ) {
		update_post_meta( $manga_id, '_auramaga_bookmark_count', $bookmark_count - 1 );
	}

	return true;
}

/**
 * Check if Bookmarked
 *
 * @param int $user_id User ID.
 * @param int $manga_id Manga post ID.
 * @return bool True if bookmarked.
 * @since 2.0.0
 */
function auramaga_is_bookmarked( $user_id, $manga_id ) {
	if ( ! $user_id || ! $manga_id ) {
		return false;
	}

	$bookmarks = auramaga_get_user_bookmarks( $user_id );
	return in_array( absint( $manga_id ), $bookmarks, true );
}
