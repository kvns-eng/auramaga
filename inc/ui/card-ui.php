<?php
/**
 * Manga Card UI
 *
 * @package MangaPremium
 */

defined( 'ABSPATH' ) || exit;

function mp_manga_card( $post_id = 0, $show_chapters = true, $extra_class = '' ) {
	if ( ! $post_id ) {
		$post_id = get_the_ID();
	}

	$title   = get_the_title( $post_id );
	$meta    = mp_get_manga_meta( $post_id );
	$genres  = wp_get_post_terms( $post_id, 'manga_genre', array( 'fields' => 'names' ) );
	$chapters = $show_chapters ? mp_get_manga_chapters( $post_id, 'DESC', 3 ) : array();

	?>
	<article class="mp-card <?php echo esc_attr( $extra_class ); ?>" data-manga-id="<?php echo esc_attr( $post_id ); ?>">
		<a href="<?php echo esc_url( get_permalink( $post_id ) ); ?>" class="mp-card__cover-link" aria-label="<?php echo esc_attr( $title ); ?>">
			<div class="mp-card__cover">
				<?php mp_the_cover( $post_id, 'mp-cover', 'mp-card__img' ); ?>
				<div class="mp-card__overlay"></div>
				<?php mp_status_badge( $meta['status'] ); ?>
				<div class="mp-card__hover-info">
					<?php mp_rating_stars( $meta['rating'], false ); ?>
				</div>
			</div>
		</a>

		<div class="mp-card__body">
			<a href="<?php echo esc_url( get_permalink( $post_id ) ); ?>" class="mp-card__title-link">
				<h3 class="mp-card__title"><?php echo esc_html( $title ); ?></h3>
			</a>

			<?php if ( ! empty( $genres ) ) : ?>
				<div class="mp-card__genres">
					<?php foreach ( array_slice( $genres, 0, 2 ) as $genre ) : ?>
						<span class="mp-card__genre"><?php echo esc_html( $genre ); ?></span>
					<?php endforeach; ?>
				</div>
			<?php endif; ?>

			<?php if ( $show_chapters && ! empty( $chapters ) ) : ?>
				<div class="mp-card__chapters">
					<?php foreach ( $chapters as $ch ) :
						$ch_num   = mp_get_meta( $ch->ID, 'chapter_number', '0' );
						$manga_slug = get_post_field( 'post_name', $post_id );
					?>
						<a href="<?php echo esc_url( home_url( '/manga/' . $manga_slug . '/chapter/' . $ch_num . '/' ) ); ?>" class="mp-card__chapter">
							<span class="mp-card__chapter-num">Ch. <?php echo esc_html( $ch_num ); ?></span>
							<span class="mp-card__chapter-time"><?php echo mp_time_ago( $ch->post_date ); ?></span>
						</a>
					<?php endforeach; ?>
				</div>
			<?php endif; ?>

			<div class="mp-card__meta">
				<span class="mp-card__meta-item">
					<svg width="12" height="12" viewBox="0 0 24 24" fill="currentColor"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/></svg>
					<?php echo esc_html( number_format( $meta['rating'], 1 ) ); ?>
				</span>
				<span class="mp-card__meta-item">
					<svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>
					<?php echo esc_html( mp_format_number( $meta['views'] ) ); ?>
				</span>
			</div>
		</div>
	</article>
	<?php
}

function mp_manga_list_item( $post_id = 0 ) {
	if ( ! $post_id ) {
		$post_id = get_the_ID();
	}

	$title = get_the_title( $post_id );
	$meta  = mp_get_manga_meta( $post_id );
	?>
	<a href="<?php echo esc_url( get_permalink( $post_id ) ); ?>" class="mp-list-item">
		<div class="mp-list-item__thumb">
			<?php mp_the_cover( $post_id, 'mp-cover-thumb' ); ?>
		</div>
		<div class="mp-list-item__info">
			<span class="mp-list-item__title"><?php echo esc_html( $title ); ?></span>
			<span class="mp-list-item__meta"><?php mp_rating_stars( $meta['rating'] ); ?></span>
		</div>
	</a>
	<?php
}
