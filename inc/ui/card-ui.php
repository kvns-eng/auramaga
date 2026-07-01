<?php
/**
 * Card UI Component
 *
 * Renders manga cards for grid displays.
 *
 * @package Auramaga
 * @since 2.0.0
 */

defined( 'ABSPATH' ) || exit;

/**
 * Display Manga Card
 *
 * @param int $manga_id Manga post ID.
 * @param bool $show_excerpt Show excerpt.
 * @param string $class Additional CSS class.
 * @since 2.0.0
 */
function auramaga_manga_card( $manga_id, $show_excerpt = true, $class = '' ) {
	if ( ! $manga_id ) {
		return;
	}

	$manga = get_post( $manga_id );

	if ( ! $manga || 'manga' !== $manga->post_type ) {
		return;
	}

	$meta = auramaga_get_manga_meta( $manga_id );
	$cover_url = auramaga_get_cover_url( $manga_id, 'auramaga-manga-cover' );
	$card_class = 'manga-card';

	if ( $class ) {
		$card_class .= ' ' . sanitize_html_class( $class );
	}

	?>
	<div class="<?php echo esc_attr( $card_class ); ?>">
		<div class="card-image">
			<a href="<?php echo esc_url( get_permalink( $manga_id ) ); ?>" class="card-image-link">
				<?php if ( $cover_url ) : ?>
					<img src="<?php echo esc_url( $cover_url ); ?>" alt="<?php echo esc_attr( $manga->post_title ); ?>" loading="lazy" class="card-image-img">
				<?php else : ?>
					<div class="card-image-placeholder">
						<span><?php echo esc_html( mb_substr( $manga->post_title, 0, 1 ) ); ?></span>
					</div>
				<?php endif; ?>
			</a>
		</div>

		<div class="card-content">
			<div class="card-badges">
				<?php auramaga_status_badge( $meta['status'] ); ?>
			</div>

			<h3 class="card-title">
				<a href="<?php echo esc_url( get_permalink( $manga_id ) ); ?>">
					<?php echo esc_html( $manga->post_title ); ?>
				</a>
			</h3>

			<?php if ( $show_excerpt && $manga->post_excerpt ) : ?>
				<p class="card-excerpt"><?php echo esc_html( wp_trim_words( $manga->post_excerpt, 15 ) ); ?></p>
			<?php endif; ?>

			<div class="card-meta">
				<?php if ( $meta['rating'] > 0 ) : ?>
					<?php auramaga_rating_stars( $meta['rating'], false ); ?>
					<span class="meta-value"><?php echo esc_html( number_format( $meta['rating'], 1 ) ); ?></span>
				<?php endif; ?>

				<?php if ( $meta['views'] > 0 ) : ?>
					<span class="meta-item">
						<svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path><circle cx="12" cy="12" r="3"></circle></svg>
						<?php echo esc_html( auramaga_format_number( $meta['views'] ) ); ?>
					</span>
				<?php endif; ?>
			</div>
		</div>
	</div>
	<?php
}

/**
 * Display Manga List Item
 *
 * @param int $manga_id Manga post ID.
 * @since 2.0.0
 */
function auramaga_manga_list_item( $manga_id ) {
	if ( ! $manga_id ) {
		return;
	}

	$manga = get_post( $manga_id );

	if ( ! $manga || 'manga' !== $manga->post_type ) {
		return;
	}

	$cover_url = auramaga_get_cover_url( $manga_id, 'auramaga-manga-thumb' );

	?>
	<a href="<?php echo esc_url( get_permalink( $manga_id ) ); ?>" class="list-item">
		<div class="list-item-thumb">
			<?php if ( $cover_url ) : ?>
				<img src="<?php echo esc_url( $cover_url ); ?>" alt="<?php echo esc_attr( $manga->post_title ); ?>" loading="lazy">
			<?php else : ?>
				<div class="thumb-placeholder"><span><?php echo esc_html( mb_substr( $manga->post_title, 0, 1 ) ); ?></span></div>
			<?php endif; ?>
		</div>
		<div class="list-item-content">
			<h4 class="list-item-title"><?php echo esc_html( $manga->post_title ); ?></h4>
		</div>
	</a>
	<?php
}
