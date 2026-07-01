<?php
/**
 * Favorites Storage
 *
 * Manages user favorites stored in user meta.
 *
 * @package Auramaga
 * @since 2.0.0
 */

defined( 'ABSPATH' ) || exit;

/**
 * Get User Favorites
 *
 * @param int $user_id User ID.
 * @return array Array of manga IDs with ratings.
 * @since 2.0.0
 */
function auramaga_get_user_favorites( $user_id ) {
	if ( ! $user_id ) {
		return array();
	}

	$favorites = get_user_meta( absint( $user_id ), 'auramaga_favorites', true );

	return is_array( $favorites ) ? $favorites : array();
}

/**
 * Add Favorite
 *
 * @param int $user_id User ID.
 * @param int $manga_id Manga post ID.
 * @param int $rating Rating (1-5).
 * @return bool Success.
 * @since 2.0.0
 */
function auramaga_add_favorite( $user_id, $manga_id, $rating = 5 ) {
	if ( ! $user_id || ! $manga_id ) {
		return false;
	}

	$user_id = absint( $user_id );
	$manga_id = absint( $manga_id );
	$rating = absint( min( max( $rating, 1 ), 5 ) );

	$user = get_user_by( 'ID', $user_id );
	if ( ! $user ) {
		return false;
	}

	$manga = get_post( $manga_id );
	if ( ! $manga || 'manga' !== $manga->post_type ) {
		return false;
	}

	$favorites = auramaga_get_user_favorites( $user_id );

	$favorites[ $manga_id ] = array(
		'rating'     => $rating,
		'date_added' => current_time( 'mysql' ),
	);

	update_user_meta( $user_id, 'auramaga_favorites', $favorites );

	// Update favorite count on manga post.
	$favorite_count = absint( get_post_meta( $manga_id, '_auramaga_favorite_count', true ) );
	update_post_meta( $manga_id, '_auramaga_favorite_count', $favorite_count + 1 );

	return true;
}

/**
 * Remove Favorite
 *
 * @param int $user_id User ID.
 * @param int $manga_id Manga post ID.
 * @return bool Success.
 * @since 2.0.0
 */
function auramaga_remove_favorite( $user_id, $manga_id ) {
	if ( ! $user_id || ! $manga_id ) {
		return false;
	}

	$user_id = absint( $user_id );
	$manga_id = absint( $manga_id );

	$favorites = auramaga_get_user_favorites( $user_id );
	unset( $favorites[ $manga_id ] );

	update_user_meta( $user_id, 'auramaga_favorites', $favorites );

	// Update favorite count on manga post.
	$favorite_count = absint( get_post_meta( $manga_id, '_auramaga_favorite_count', true ) );
	if ( $favorite_count > 0 ) {
		update_post_meta( $manga_id, '_auramaga_favorite_count', $favorite_count - 1 );
	}

	return true;
}

/**
 * Check if Favorited
 *
 * @param int $user_id User ID.
 * @param int $manga_id Manga post ID.
 * @return bool True if favorited.
 * @since 2.0.0
 */
function auramaga_is_favorited( $user_id, $manga_id ) {
	if ( ! $user_id || ! $manga_id ) {
		return false;
	}

	$favorites = auramaga_get_user_favorites( $user_id );
	return isset( $favorites[ absint( $manga_id ) ] );
}

/**
 * Get Favorite Rating
 *
 * @param int $user_id User ID.
 * @param int $manga_id Manga post ID.
 * @return int Rating (0 if not favorited).
 * @since 2.0.0
 */
function auramaga_get_favorite_rating( $user_id, $manga_id ) {
	if ( ! $user_id || ! $manga_id ) {
		return 0;
	}

	$favorites = auramaga_get_user_favorites( $user_id );
	$manga_id = absint( $manga_id );

	return isset( $favorites[ $manga_id ]['rating'] ) ? absint( $favorites[ $manga_id ]['rating'] ) : 0;
}
