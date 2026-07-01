<?php
/**
 * Pagination
 *
 * @package MangaPremium
 */

defined( 'ABSPATH' ) || exit;

function mp_pagination( $query = null, $mid = 2, $end = 1 ) {
	if ( ! $query ) {
		global $wp_query;
		$query = $wp_query;
	}

	$paged    = max( 1, get_query_var( 'paged' ) );
	$pages    = $query->max_num_pages;
	$show_all = false;

	if ( $pages <= 1 ) {
		return;
	}

	echo '<nav class="mp-pagination" aria-label="' . esc_attr__( 'Pagination', 'manga-premium' ) . '">';
	echo '<ul class="mp-pagination__list">';

	// Previous.
	if ( $paged > 1 ) {
		echo '<li><a class="mp-pagination__link mp-pagination__link--prev" href="' . esc_url( get_pagenum_link( $paged - 1 ) ) . '" aria-label="' . esc_attr__( 'Previous page', 'manga-premium' ) . '" rel="prev">';
		echo '<svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="15 18 9 12 15 6"/></svg>';
		echo '</a></li>';
	}

	// Page numbers.
	$dots = false;
	for ( $i = 1; $i <= $pages; $i++ ) {
		if ( $i === $paged ) {
			echo '<li><span class="mp-pagination__link mp-pagination__link--current" aria-current="page">' . esc_html( $i ) . '</span></li>';
			$dots = true;
		} elseif ( $i <= $end || ( $paged && $i >= $paged - $mid && $i <= $paged + $mid ) || $i > $pages - $end ) {
			echo '<li><a class="mp-pagination__link" href="' . esc_url( get_pagenum_link( $i ) ) . '">' . esc_html( $i ) . '</a></li>';
			$dots = true;
		} elseif ( $dots ) {
			echo '<li><span class="mp-pagination__dots">…</span></li>';
			$dots = false;
		}
	}

	// Next.
	if ( $paged < $pages ) {
		echo '<li><a class="mp-pagination__link mp-pagination__link--next" href="' . esc_url( get_pagenum_link( $paged + 1 ) ) . '" aria-label="' . esc_attr__( 'Next page', 'manga-premium' ) . '" rel="next">';
		echo '<svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="9 18 15 12 9 6"/></svg>';
		echo '</a></li>';
	}

	echo '</ul></nav>';
}
