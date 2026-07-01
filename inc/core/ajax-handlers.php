<?php
/**
 * AJAX Handlers
 *
 * @package MangaPremium
 */

defined( 'ABSPATH' ) || exit;

/* ─── Live Search ─────────────────────────────────────── */
function mp_ajax_search() {
	check_ajax_referer( 'mp-nonce', 'nonce' );

	$query = isset( $_POST['q'] ) ? sanitize_text_field( wp_unslash( $_POST['q'] ) ) : '';

	if ( strlen( $query ) < 2 ) {
		wp_send_json_success( array( 'results' => array() ) );
	}

	$args = array(
		'post_type'      => 'manga',
		's'              => $query,
		'posts_per_page' => 8,
		'post_status'    => 'publish',
	);

	$results = array();
	$wpq     = new WP_Query( $args );

	if ( $wpq->have_posts() ) {
		while ( $wpq->have_posts() ) {
			$wpq->the_post();
			$meta    = mp_get_manga_meta( get_the_ID() );
			$results[] = array(
				'id'     => get_the_ID(),
				'title'  => get_the_title(),
				'url'    => get_permalink(),
				'cover'  => mp_get_cover_url( get_the_ID(), 'mp-cover-thumb' ),
				'status' => $meta['status'],
				'rating' => $meta['rating'],
			);
		}
		wp_reset_postdata();
	}

	wp_send_json_success( array( 'results' => $results ) );
}
add_action( 'wp_ajax_mp_search', 'mp_ajax_search' );
add_action( 'wp_ajax_nopriv_mp_search', 'mp_ajax_search' );

/* ─── Save Reading Progress ───────────────────────────── */
function mp_save_progress() {
	check_ajax_referer( 'mp-nonce', 'nonce' );

	$manga_id   = isset( $_POST['manga_id'] ) ? absint( $_POST['manga_id'] ) : 0;
	$chapter_id = isset( $_POST['chapter_id'] ) ? absint( $_POST['chapter_id'] ) : 0;
	$page       = isset( $_POST['page'] ) ? absint( $_POST['page'] ) : 1;
	$user_id    = get_current_user_id();

	if ( ! $manga_id || ! $chapter_id ) {
		wp_send_json_error( 'Invalid data' );
	}

	$progress_key = 'mp_progress_' . $manga_id;

	if ( $user_id ) {
		// Logged-in user: save to user meta.
		$progresses = get_user_meta( $user_id, 'mp_reading_progress', true );
		if ( ! is_array( $progresses ) ) {
			$progresses = array();
		}
		$progresses[ $manga_id ] = array(
			'chapter_id'   => $chapter_id,
			'chapter_num'  => mp_get_meta( $chapter_id, 'chapter_number', '' ),
			'page'         => $page,
			'last_read'    => current_time( 'mysql' ),
		);
		update_user_meta( $user_id, 'mp_reading_progress', $progresses );
	} else {
		// Guest: use transients (24-hour expiry).
		$progresses = get_transient( $progress_key );
		if ( ! is_array( $progresses ) ) {
			$progresses = array();
		}
		$progresses = array(
			'chapter_id'   => $chapter_id,
			'chapter_num'  => mp_get_meta( $chapter_id, 'chapter_number', '' ),
			'page'         => $page,
			'last_read'    => current_time( 'mysql' ),
		);
		set_transient( $progress_key, $progresses, DAY_IN_SECONDS );
	}

	wp_send_json_success( array( 'saved' => true ) );
}
add_action( 'wp_ajax_mp_save_progress', 'mp_save_progress' );
add_action( 'wp_ajax_nopriv_mp_save_progress', 'mp_save_progress' );

/* ─── Toggle Bookmark ─────────────────────────────────── */
function mp_toggle_bookmark() {
	check_ajax_referer( 'mp-nonce', 'nonce' );

	$manga_id = isset( $_POST['manga_id'] ) ? absint( $_POST['manga_id'] ) : 0;
	$user_id  = get_current_user_id();

	if ( ! $manga_id ) {
		wp_send_json_error( 'Invalid manga ID' );
	}

	if ( ! $user_id ) {
		wp_send_json_error( 'Please log in to bookmark' );
	}

	$bookmarks = get_user_meta( $user_id, 'mp_bookmarks', true );
	if ( ! is_array( $bookmarks ) ) {
		$bookmarks = array();
	}

	if ( in_array( $manga_id, $bookmarks, true ) ) {
		$bookmarks = array_diff( $bookmarks, array( $manga_id ) );
		$bookmarked = false;
	} else {
		$bookmarks[] = $manga_id;
		$bookmarked = true;
	}

	$bookmarks = array_values( array_unique( $bookmarks ) );
	update_user_meta( $user_id, 'mp_bookmarks', $bookmarks );

	wp_send_json_success( array( 'bookmarked' => $bookmarked ) );
}
add_action( 'wp_ajax_mp_toggle_bookmark', 'mp_toggle_bookmark' );
