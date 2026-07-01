<?php
/**
 * Single Manga Template
 *
 * @package MangaPremium
 */

get_header();

if ( have_posts() ) : while ( have_posts() ) : the_post();

$meta     = mp_get_manga_meta( get_the_ID() );
$chapters = mp_get_manga_chapters( get_the_ID(), 'DESC' );
$first_ch = ! empty( $chapters ) ? end( $chapters ) : null;
$latest_ch = ! empty( $chapters ) ? $chapters[0] : null;
$manga_slug = get_post_field( 'post_name', get_the_ID() );

// Related manga.
$related = mp_get_related_manga( get_the_ID(), 6 );

// Genres and Tags.
$genre_terms = wp_get_post_terms( get_the_ID(), 'manga_genre', array( 'hide_empty' => false ) );
$tag_terms   = wp_get_post_terms( get_the_ID(), 'manga_tag', array( 'hide_empty' => false ) );
$author_term = wp_get_post_terms( get_the_ID(), 'manga_author', array( 'hide_empty' => false ) );
$artist_term = wp_get_post_terms( get_the_ID(), 'manga_artist', array( 'hide_empty' => false ) );
$status_term = wp_get_post_terms( get_the_ID(), 'manga_status', array( 'hide_empty' => false ) );
$type_term   = wp_get_post_terms( get_the_ID(), 'manga_type', array( 'hide_empty' => false ) );
?>

<div class="mp-section">
	<div class="mp-container">
		<?php mp_breadcrumbs(); ?>

		<!-- Banner & Cover -->
		<div class="mp-manga-banner">
			<div class="mp-manga-banner__bg">
				<?php mp_the_cover( get_the_ID(), 'mp-banner', 'mp-manga-banner__bg-img' ); ?>
				<div class="mp-manga-banner__overlay"></div>
			</div>

			<div class="mp-manga-banner__content">
				<div class="mp-manga-banner__cover">
					<?php mp_the_cover( get_the_ID(), 'mp-cover' ); ?>
				</div>

				<div class="mp-manga-banner__info">
					<div class="mp-manga-banner__badges">
						<?php mp_status_badge( $meta['status'] ); ?>
						<?php if ( ! empty( $meta['type'] ) ) mp_type_badge( $meta['type'] ); ?>
						<?php if ( ! empty( $type_term ) && ! is_wp_error( $type_term ) ) : ?>
							<span class="mp-badge mp-badge--type"><?php echo esc_html( $type_term[0]->name ); ?></span>
						<?php endif; ?>
					</div>

					<h1 class="mp-manga-banner__title"><?php the_title(); ?></h1>

					<?php if ( ! empty( $meta['alt_titles'] ) ) : ?>
						<p class="mp-manga-banner__alt"><?php echo esc_html( $meta['alt_titles'] ); ?></p>
					<?php endif; ?>

					<!-- Action Buttons -->
					<div class="mp-manga-actions">
						<?php if ( $first_ch ) :
							$ch_slug = mp_get_meta( $first_ch->ID, 'chapter_number', '' );
						?>
							<a href="<?php echo esc_url( home_url( '/manga/' . $manga_slug . '/chapter/' . $ch_slug . '/' ) ); ?>" class="mp-btn mp-btn--primary">
								<svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20"/><path d="M6.5 2H20v20H6.5A2.5 2.5 0 0 1 4 19.5v-15A2.5 2.5 0 0 1 6.5 2z"/></svg>
								<?php esc_html_e( 'Read First', 'manga-premium' ); ?>
							</a>
						<?php endif; ?>

						<?php if ( $latest_ch ) :
							$lch_num = mp_get_meta( $latest_ch->ID, 'chapter_number', '' );
						?>
							<a href="<?php echo esc_url( home_url( '/manga/' . $manga_slug . '/chapter/' . $lch_num . '/' ) ); ?>" class="mp-btn mp-btn--secondary">
								<svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
								<?php echo esc_html( sprintf( __( 'Latest: Ch. %s', 'manga-premium' ), $lch_num ) ); ?>
							</a>
						<?php endif; ?>

						<button class="mp-btn mp-btn--ghost mp-bookmark-btn" data-manga-id="<?php echo esc_attr( get_the_ID() ); ?>" aria-label="<?php esc_attr_e( 'Bookmark', 'manga-premium' ); ?>">
							<svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M19 21l-7-5-7 5V5a2 2 0 0 1 2-2h10a2 2 0 0 1 2 2z"/></svg>
						</button>
						<button class="mp-btn mp-btn--ghost" aria-label="<?php esc_attr_e( 'Favorite', 'manga-premium' ); ?>">
							<svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"/></svg>
						</button>
						<button class="mp-btn mp-btn--ghost mp-share-btn" aria-label="<?php esc_attr_e( 'Share', 'manga-premium' ); ?>">
							<svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="18" cy="5" r="3"/><circle cx="6" cy="12" r="3"/><circle cx="18" cy="19" r="3"/><line x1="8.59" y1="13.51" x2="15.42" y2="17.49"/><line x1="15.41" y1="6.51" x2="8.59" y2="10.49"/></svg>
						</button>
					</div>

					<!-- Meta Cards -->
					<div class="mp-manga-stats">
						<div class="mp-stat-card">
							<span class="mp-stat-card__icon"><svg width="16" height="16" viewBox="0 0 24 24" fill="var(--mp-primary)"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/></svg></span>
							<span class="mp-stat-card__value"><?php echo esc_html( number_format( $meta['rating'], 1 ) ); ?></span>
							<span class="mp-stat-card__label"><?php echo esc_html( sprintf( __( '%s votes', 'manga-premium' ), mp_format_number( $meta['rating_count'] ) ) ); ?></span>
						</div>
						<div class="mp-stat-card">
							<span class="mp-stat-card__icon"><svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="var(--mp-primary)" stroke-width="2"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg></span>
							<span class="mp-stat-card__value"><?php echo esc_html( mp_format_number( $meta['views'] ) ); ?></span>
							<span class="mp-stat-card__label"><?php esc_html_e( 'Views', 'manga-premium' ); ?></span>
						</div>
						<div class="mp-stat-card">
							<span class="mp-stat-card__icon"><svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="var(--mp-primary)" stroke-width="2"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/></svg></span>
							<span class="mp-stat-card__value"><?php echo esc_html( count( $chapters ) ); ?></span>
							<span class="mp-stat-card__label"><?php esc_html_e( 'Chapters', 'manga-premium' ); ?></span>
						</div>
						<div class="mp-stat-card">
							<span class="mp-stat-card__icon"><svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="var(--mp-primary)" stroke-width="2"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg></span>
							<span class="mp-stat-card__value"><?php echo esc_html( $meta['release_year'] ?: '—' ); ?></span>
							<span class="mp-stat-card__label"><?php esc_html_e( 'Year', 'manga-premium' ); ?></span>
						</div>
					</div>

					<!-- Author / Artist -->
					<div class="mp-manga-credits">
						<?php if ( ! empty( $author_term ) && ! is_wp_error( $author_term ) ) : ?>
							<span class="mp-manga-credit">
								<svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
								<?php esc_html_e( 'Author:', 'manga-premium' ); ?> <a href="<?php echo esc_url( get_term_link( $author_term[0] ) ); ?>"><?php echo esc_html( $author_term[0]->name ); ?></a>
							</span>
						<?php endif; ?>
						<?php if ( ! empty( $artist_term ) && ! is_wp_error( $artist_term ) ) : ?>
							<span class="mp-manga-credit">
								<svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 19l7-7 3 3-7 7-3-3z"/><path d="M18 13l-1.5-7.5L2 2l3.5 14.5L13 18l5-5z"/></svg>
								<?php esc_html_e( 'Artist:', 'manga-premium' ); ?> <a href="<?php echo esc_url( get_term_link( $artist_term[0] ) ); ?>"><?php echo esc_html( $artist_term[0]->name ); ?></a>
							</span>
						<?php endif; ?>
					</div>

					<!-- Genres & Tags -->
					<?php if ( ! empty( $genre_terms ) && ! is_wp_error( $genre_terms ) ) : ?>
						<div class="mp-manga-genres">
							<?php foreach ( $genre_terms as $genre ) : ?>
								<a href="<?php echo esc_url( get_term_link( $genre ) ); ?>" class="mp-pill"><?php echo esc_html( $genre->name ); ?></a>
							<?php endforeach; ?>
						</div>
					<?php endif; ?>

					<?php if ( ! empty( $tag_terms ) && ! is_wp_error( $tag_terms ) ) : ?>
						<div class="mp-manga-tags">
							<?php foreach ( $tag_terms as $tag ) : ?>
								<a href="<?php echo esc_url( get_term_link( $tag ) ); ?>" class="mp-tag">#<?php echo esc_html( $tag->name ); ?></a>
							<?php endforeach; ?>
						</div>
					<?php endif; ?>
				</div>
			</div>
		</div>

		<!-- Content Grid -->
		<div class="mp-layout mp-layout--manga-detail">
			<div class="mp-layout__main">
				<!-- Synopsis -->
				<section class="mp-card-block">
					<h2 class="mp-card-block__title">
						<svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="var(--mp-primary)" stroke-width="2"><path d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20"/><path d="M6.5 2H20v20H6.5A2.5 2.5 0 0 1 4 19.5v-15A2.5 2.5 0 0 1 6.5 2z"/></svg>
						<?php esc_html_e( 'Synopsis', 'manga-premium' ); ?>
					</h2>
					<div class="mp-card-block__body mp-synopsis">
						<?php echo wp_kses_post( get_the_content() ); ?>
					</div>
				</section>

				<!-- Chapter List -->
				<section class="mp-card-block">
					<h2 class="mp-card-block__title">
						<svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="var(--mp-primary)" stroke-width="2"><line x1="8" y1="6" x2="21" y2="6"/><line x1="8" y1="12" x2="21" y2="12"/><line x1="8" y1="18" x2="21" y2="18"/><line x1="3" y1="6" x2="3.01" y2="6"/><line x1="3" y1="12" x2="3.01" y2="12"/><line x1="3" y1="18" x2="3.01" y2="18"/></svg>
						<?php echo esc_html( sprintf( __( 'Chapters (%d)', 'manga-premium' ), count( $chapters ) ) ); ?>
					</h2>
					<div class="mp-chapter-list">
						<?php foreach ( $chapters as $ch ) :
							$ch_num = mp_get_meta( $ch->ID, 'chapter_number', '' );
						?>
							<a href="<?php echo esc_url( home_url( '/manga/' . $manga_slug . '/chapter/' . $ch_num . '/' ) ); ?>" class="mp-chapter-row">
								<span class="mp-chapter-row__num">Ch. <?php echo esc_html( $ch_num ); ?></span>
								<span class="mp-chapter-row__title"><?php echo esc_html( $ch->post_title ); ?></span>
								<span class="mp-chapter-row__date"><?php echo esc_html( get_the_date( '', $ch ) ); ?></span>
							</a>
						<?php endforeach; ?>
					</div>
				</section>

				<!-- Comments -->
				<?php if ( comments_open() || get_comments_number() ) : ?>
					<section class="mp-card-block">
						<h2 class="mp-card-block__title">
							<svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="var(--mp-primary)" stroke-width="2"><path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/></svg>
							<?php esc_html_e( 'Comments', 'manga-premium' ); ?>
						</h2>
						<?php comments_template( '', true ); ?>
					</section>
				<?php endif; ?>
			</div>

			<!-- Sidebar -->
			<aside class="mp-layout__sidebar">
				<!-- Related Manga -->
				<?php if ( ! empty( $related ) ) : ?>
					<div class="mp-widget">
						<h3 class="mp-widget__title"><?php esc_html_e( 'Related Manga', 'manga-premium' ); ?></h3>
						<div class="mp-widget__content">
							<?php foreach ( $related as $r ) :
								mp_manga_list_item( $r->ID );
							endforeach; ?>
						</div>
					</div>
				<?php endif; ?>

				<?php get_sidebar(); ?>
			</aside>
		</div>
	</div>
</div>

<?php endwhile; endif; get_footer(); ?>
