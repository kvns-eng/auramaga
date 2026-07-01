<?php
/**
 * Template Tags
 *
 * Display helper functions for rendering content in templates.
 *
 * @package Auramaga
 * @since 2.0.0
 */

defined( 'ABSPATH' ) || exit;

/**
 * Get Cover Image URL
 *
 * @param int $post_id Post ID.
 * @param string $size Image size.
 * @return string Image URL or empty string.
 * @since 2.0.0
 */
function auramaga_get_cover_url( $post_id, $size = 'auramaga-manga-cover' ) {
	if ( ! $post_id ) {
		return '';
	}

	if ( has_post_thumbnail( $post_id ) ) {
		$url = get_the_post_thumbnail_url( $post_id, $size );
		if ( $url ) {
			return $url;
		}
	}

	return '';
}

/**
 * Display Cover Image
 *
 * @param int $post_id Post ID.
 * @param string $size Image size.
 * @param string $class Additional CSS class.
 * @since 2.0.0
 */
function auramaga_the_cover( $post_id, $size = 'auramaga-manga-cover', $class = '' ) {
	if ( ! $post_id ) {
		return;
	}

	$url = auramaga_get_cover_url( $post_id, $size );
	$title = get_the_title( $post_id );

	if ( $url ) {
		$classes = 'cover-image';
		if ( $class ) {
			$classes .= ' ' . sanitize_html_class( $class );
		}
		echo '<img class="' . esc_attr( $classes ) . '" src="' . esc_url( $url ) . '" alt="' . esc_attr( $title ) . '" loading="lazy">';
	} else {
		echo '<div class="cover-placeholder"><span>' . esc_html( mb_substr( $title, 0, 1 ) ) . '</span></div>';
	}
}

/**
 * Display Status Badge
 *
 * @param string $status Status key.
 * @since 2.0.0
 */
function auramaga_status_badge( $status ) {
	$status = sanitize_text_field( $status );

	$labels = array(
		'ongoing'   => esc_html__( 'Ongoing', 'auramaga' ),
		'completed' => esc_html__( 'Completed', 'auramaga' ),
		'hiatus'    => esc_html__( 'Hiatus', 'auramaga' ),
		'dropped'   => esc_html__( 'Dropped', 'auramaga' ),
		'upcoming'  => esc_html__( 'Upcoming', 'auramaga' ),
	);

	$label = isset( $labels[ $status ] ) ? $labels[ $status ] : ucfirst( $status );

	?>
	<span class="badge badge-status badge-<?php echo esc_attr( $status ); ?>">
		<?php echo esc_html( $label ); ?>
	</span>
	<?php
}

/**
 * Display Type Badge
 *
 * @param string $type Type key.
 * @since 2.0.0
 */
function auramaga_type_badge( $type ) {
	$type = sanitize_text_field( $type );

	$labels = array(
		'manga'         => esc_html__( 'Manga', 'auramaga' ),
		'manhwa'        => esc_html__( 'Manhwa', 'auramaga' ),
		'manhua'        => esc_html__( 'Manhua', 'auramaga' ),
		'comic'         => esc_html__( 'Comic', 'auramaga' ),
		'oneshot'       => esc_html__( 'One-Shot', 'auramaga' ),
		'doujinshi'     => esc_html__( 'Doujinshi', 'auramaga' ),
		'light_novel'   => esc_html__( 'Light Novel', 'auramaga' ),
	);

	$label = isset( $labels[ $type ] ) ? $labels[ $type ] : ucfirst( $type );

	?>
	<span class="badge badge-type badge-<?php echo esc_attr( $type ); ?>">
		<?php echo esc_html( $label ); ?>
	</span>
	<?php
}

/**
 * Display Rating Stars
 *
 * @param float $rating Rating value (0-5).
 * @param bool $show_number Show rating number.
 * @since 2.0.0
 */
function auramaga_rating_stars( $rating, $show_number = true ) {
	$rating = floatval( $rating );
	$full   = floor( $rating );
	$half   = ( $rating - $full ) >= 0.5 ? 1 : 0;
	$empty  = 5 - $full - $half;

	?>
	<span class="rating" aria-label="<?php echo esc_attr( sprintf( esc_html__( 'Rating: %.1f out of 5', 'auramaga' ), $rating ) ); ?>">
		<span class="rating-stars">
			<?php
			for ( $i = 0; $i < $full; $i++ ) {
				echo '<svg class="star star-full" width="14" height="14" viewBox="0 0 24 24" fill="currentColor"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"></path></svg>';
			}
			?>
			<?php
			if ( $half ) {
				echo '<svg class="star star-half" width="14" height="14" viewBox="0 0 24 24"><defs><linearGradient id="half"><stop offset="50%" stop-color="currentColor"></stop><stop offset="50%" stop-color="rgba(0,0,0,0.1)"></stop></linearGradient></defs><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z" fill="url(#half)"></path></svg>';
			}
			?>
			<?php
			for ( $i = 0; $i < $empty; $i++ ) {
				echo '<svg class="star star-empty" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"></path></svg>';
			}
			?>
		</span>
		<?php
		if ( $show_number ) {
			echo ' <span class="rating-number">' . esc_html( number_format( $rating, 1 ) ) . '</span>';
		}
		?>
	</span>
	<?php
}

/**
 * Display Time Ago
 *
 * @param string $date Date string.
 * @return string Relative time.
 * @since 2.0.0
 */
function auramaga_time_ago( $date ) {
	$time = strtotime( $date );

	if ( ! $time ) {
		return '';
	}

	$diff = time() - $time;

	if ( $diff < 60 ) {
		return esc_html__( 'Just now', 'auramaga' );
	}

	if ( $diff < 3600 ) {
		return sprintf( esc_html__( '%dm ago', 'auramaga' ), floor( $diff / 60 ) );
	}

	if ( $diff < 86400 ) {
		return sprintf( esc_html__( '%dh ago', 'auramaga' ), floor( $diff / 3600 ) );
	}

	if ( $diff < 604800 ) {
		return sprintf( esc_html__( '%dd ago', 'auramaga' ), floor( $diff / 86400 ) );
	}

	if ( $diff < 2592000 ) {
		return sprintf( esc_html__( '%dw ago', 'auramaga' ), floor( $diff / 604800 ) );
	}

	return date_i18n( get_option( 'date_format' ), $time );
}

/**
 * Display Time Ago
 *
 * @param string $date Date string.
 * @since 2.0.0
 */
function auramaga_the_time_ago( $date ) {
	echo esc_html( auramaga_time_ago( $date ) );
}
