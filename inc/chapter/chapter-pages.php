<?php
/**
 * Chapter Pages Management
 *
 * Handles chapter page storage using WordPress attachment IDs.
 *
 * @package Auramaga
 * @since 2.0.0
 */

defined( 'ABSPATH' ) || exit;

/**
 * Get Chapter Pages
 *
 * @param int $chapter_id Chapter post ID.
 * @return array Array of attachment objects.
 * @since 2.0.0
 */
function auramaga_get_chapter_pages( $chapter_id ) {
	if ( ! $chapter_id ) {
		return array();
	}

	$page_ids = get_post_meta( $chapter_id, '_auramaga_chapter_pages', true );

	if ( empty( $page_ids ) || ! is_array( $page_ids ) ) {
		return array();
	}

	$pages = array();
	foreach ( $page_ids as $attachment_id ) {
		$attachment = get_post( absint( $attachment_id ) );
		if ( $attachment && 'attachment' === $attachment->post_type ) {
			$pages[] = $attachment;
		}
	}

	return $pages;
}

/**
 * Add Chapter Page
 *
 * @param int $chapter_id Chapter post ID.
 * @param int $attachment_id Attachment ID.
 * @return bool Success.
 * @since 2.0.0
 */
function auramaga_add_chapter_page( $chapter_id, $attachment_id ) {
	if ( ! $chapter_id || ! $attachment_id ) {
		return false;
	}

	$attachment_id = absint( $attachment_id );
	$attachment = get_post( $attachment_id );

	if ( ! $attachment || 'attachment' !== $attachment->post_type ) {
		return false;
	}

	$page_ids = get_post_meta( $chapter_id, '_auramaga_chapter_pages', true );

	if ( ! is_array( $page_ids ) ) {
		$page_ids = array();
	}

	if ( ! in_array( $attachment_id, $page_ids, true ) ) {
		$page_ids[] = $attachment_id;
	}

	update_post_meta( $chapter_id, '_auramaga_chapter_pages', $page_ids );
	update_post_meta( $chapter_id, '_auramaga_page_count', count( $page_ids ) );

	return true;
}

/**
 * Remove Chapter Page
 *
 * @param int $chapter_id Chapter post ID.
 * @param int $attachment_id Attachment ID.
 * @return bool Success.
 * @since 2.0.0
 */
function auramaga_remove_chapter_page( $chapter_id, $attachment_id ) {
	if ( ! $chapter_id || ! $attachment_id ) {
		return false;
	}

	$attachment_id = absint( $attachment_id );
	$page_ids = get_post_meta( $chapter_id, '_auramaga_chapter_pages', true );

	if ( ! is_array( $page_ids ) ) {
		return false;
	}

	$page_ids = array_diff( $page_ids, array( $attachment_id ) );
	$page_ids = array_values( $page_ids );

	update_post_meta( $chapter_id, '_auramaga_chapter_pages', $page_ids );
	update_post_meta( $chapter_id, '_auramaga_page_count', count( $page_ids ) );

	return true;
}

/**
 * Reorder Chapter Pages
 *
 * @param int $chapter_id Chapter post ID.
 * @param array $order New page order (attachment IDs).
 * @return bool Success.
 * @since 2.0.0
 */
function auramaga_reorder_chapter_pages( $chapter_id, $order ) {
	if ( ! $chapter_id || ! is_array( $order ) ) {
		return false;
	}

	$sanitized_order = array_map( 'absint', $order );
	update_post_meta( $chapter_id, '_auramaga_chapter_pages', $sanitized_order );

	return true;
}

/**
 * Get Chapter Page URL
 *
 * @param int $chapter_id Chapter post ID.
 * @param int $page_number Page number (1-based).
 * @return string Image URL or empty string.
 * @since 2.0.0
 */
function auramaga_get_chapter_page_url( $chapter_id, $page_number ) {
	if ( ! $chapter_id || $page_number < 1 ) {
		return '';
	}

	$pages = auramaga_get_chapter_pages( $chapter_id );

	if ( empty( $pages ) || ! isset( $pages[ $page_number - 1 ] ) ) {
		return '';
	}

	$attachment = $pages[ $page_number - 1 ];
	$url = wp_get_attachment_image_url( $attachment->ID, 'auramaga-chapter-page' );

	return $url ? $url : '';
}
