<?php
/**
 * Template Tags
 *
 * @package MangaPremium
 */

defined( 'ABSPATH' ) || exit;

function mp_get_manga_url( $manga_id ) {
	return get_permalink( $manga_id );
}

function mp_get_cover_url( $post_id, $size = 'mp-cover' ) {
	if ( has_post_thumbnail( $post_id ) ) {
		$img = get_the_post_thumbnail_url( $post_id, $size );
		if ( $img ) {
			return $img;
		}
	}
	return '';
}

function mp_get_cover_placeholder( $title = '' ) {
	$char = $title ? mb_substr( $title, 0, 1 ) : '?';
	return '<div class="mp-cover-placeholder"><span>' . esc_html( $char ) . '</span></div>';
}

function mp_the_cover( $post_id, $size = 'mp-cover', $extra_class = '' ) {
	$url = mp_get_cover_url( $post_id, $size );
	if ( $url ) {
		echo '<img class="mp-cover-img ' . esc_attr( $extra_class ) . '" src="' . esc_url( $url ) . '" alt="' . esc_attr( get_the_title( $post_id ) ) . '" loading="lazy">';
	} else {
		echo mp_get_cover_placeholder( get_the_title( $post_id ) );
	}
}

function mp_status_badge( $status ) {
	$classes = array( 'mp-badge' );
	$labels  = array(
		'ongoing'   => esc_html__( 'Ongoing', 'manga-premium' ),
		'completed' => esc_html__( 'Completed', 'manga-premium' ),
		'hiatus'    => esc_html__( 'Hiatus', 'manga-premium' ),
		'dropped'   => esc_html__( 'Dropped', 'manga-premium' ),
		'upcoming'  => esc_html__( 'Upcoming', 'manga-premium' ),
	);

	$classes[] = 'mp-badge--' . sanitize_html_class( $status );
	$label     = isset( $labels[ $status ] ) ? $labels[ $status ] : ucfirst( $status );

	echo '<span class="' . esc_attr( implode( ' ', $classes ) ) . '">' . esc_html( $label ) . '</span>';
}

function mp_type_badge( $type ) {
	$labels = array(
		'manga'        => 'Manga',
		'manhwa'       => 'Manhwa',
		'manhua'       => 'Manhua',
		'comic'        => 'Comic',
		'oneshot'      => 'One-Shot',
		'doujinshi'    => 'Doujinshi',
		'light_novel'  => 'Light Novel',
	);
	$label = isset( $labels[ $type ] ) ? $labels[ $type ] : ucfirst( $type );
	echo '<span class="mp-badge mp-badge--type">' . esc_html( $label ) . '</span>';
}

function mp_rating_stars( $rating, $show_number = true ) {
	$full  = floor( $rating );
	$half  = ( $rating - $full ) >= 0.5 ? 1 : 0;
	$empty = 5 - $full - $half;

	echo '<span class="mp-rating" aria-label="' . esc_attr( sprintf( __( 'Rating: %.1f out of 5', 'manga-premium' ), $rating ) ) . '">';
	echo '<span class="mp-rating__stars">';
	for ( $i = 0; $i < $full; $i++ ) {
		echo '<svg class="mp-icon-star mp-icon-star--full" width="14" height="14" viewBox="0 0 24 24" fill="currentColor"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/></svg>';
	}
	if ( $half ) {
		echo '<svg class="mp-icon-star mp-icon-star--half" width="14" height="14" viewBox="0 0 24 24"><defs><linearGradient id="half"><stop offset="50%" stop-color="currentColor"/><stop offset="50%" stop-color="transparent"/></linearGradient></defs><path fill="url(#half)" stroke="currentColor" stroke-width="1" d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/></svg>';
	}
	for ( $i = 0; $i < $empty; $i++ ) {
		echo '<svg class="mp-icon-star mp-icon-star--empty" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/></svg>';
	}
	echo '</span>';
	if ( $show_number ) {
		echo ' <span class="mp-rating__number">' . esc_html( number_format( $rating, 1 ) ) . '</span>';
	}
	echo '</span>';
}

function mp_time_ago( $date ) {
	$time = strtotime( $date );
	if ( ! $time ) {
		return '';
	}
	$diff = time() - $time;
	if ( $diff < 60 ) {
		return esc_html__( 'Just now', 'manga-premium' );
	}
	if ( $diff < 3600 ) {
		return sprintf( esc_html__( '%dm ago', 'manga-premium' ), floor( $diff / 60 ) );
	}
	if ( $diff < 86400 ) {
		return sprintf( esc_html__( '%dh ago', 'manga-premium' ), floor( $diff / 3600 ) );
	}
	if ( $diff < 604800 ) {
		return sprintf( esc_html__( '%dd ago', 'manga-premium' ), floor( $diff / 86400 ) );
	}
	if ( $diff < 2592000 ) {
		return sprintf( esc_html__( '%dw ago', 'manga-premium' ), floor( $diff / 604800 ) );
	}
	return date_i18n( get_option( 'date_format' ), $time );
}
