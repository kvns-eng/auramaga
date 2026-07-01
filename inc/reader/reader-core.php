<?php
/**
 * Reader Core
 *
 * @package MangaPremium
 */

defined( 'ABSPATH' ) || exit;

function mp_reader_data() {
	if ( ! is_singular( 'mp_chapter' ) ) {
		return;
	}

	$post       = get_post();
	$meta       = mp_get_chapter_meta( $post->ID );
	$manga_id   = $meta['manga_id'];
	$manga_slug = $manga_id ? get_post_field( 'post_name', $manga_id ) : '';

	// Get chapter images from page content or meta.
	$pages = get_post_meta( $post->ID, '_mp_pages', true );
	if ( ! is_array( $pages ) || empty( $pages ) ) {
		// Fallback: parse gallery from content.
		$pages = array();
		if ( preg_match_all( '/<img[^>]+src=["\']([^"\']+)["\']/', $post->post_content, $matches ) ) {
			$pages = $matches[1];
		}
	}

	$nav = array(
		'prev' => null,
		'next' => null,
		'all'  => array(),
	);

	$all_chapters = mp_get_manga_chapters( $manga_id, 'ASC' );
	$nav['all']   = $all_chapters;

	$current_idx = array_search( $post->ID, wp_list_pluck( $all_chapters, 'ID' ) );
	if ( false !== $current_idx ) {
		if ( $current_idx > 0 ) {
			$prev = $all_chapters[ $current_idx - 1 ];
			$nav['prev'] = array(
				'url'   => mp_get_chapter_url( $prev, $manga_slug ),
				'label' => 'Ch. ' . mp_get_meta( $prev->ID, 'chapter_number', '' ),
			);
		}
		if ( $current_idx < count( $all_chapters ) - 1 ) {
			$next = $all_chapters[ $current_idx + 1 ];
			$nav['next'] = array(
				'url'   => mp_get_chapter_url( $next, $manga_slug ),
				'label' => 'Ch. ' . mp_get_meta( $next->ID, 'chapter_number', '' ),
			);
		}
	}

	$reader_data = array(
		'mangaId'     => $manga_id,
		'mangaTitle'  => $manga_id ? get_the_title( $manga_id ) : '',
		'mangaUrl'    => $manga_id ? get_permalink( $manga_id ) : '',
		'chapterId'   => $post->ID,
		'chapterNum'  => $meta['chapter_num'],
		'pages'       => $pages,
		'nav'         => $nav,
		'nonce'       => wp_create_nonce( 'mp-nonce' ),
	);

	wp_localize_script( 'manga-premium-reader', 'mpReaderData', $reader_data );
}
add_action( 'wp_enqueue_scripts', 'mp_reader_data', 20 );
