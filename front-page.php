<?php
/**
 * Front Page / Homepage
 *
 * @package MangaPremium
 */

get_header();

$featured_count = intval( get_theme_mod( 'mp_featured_count', '6' ) );
$slider_layout  = get_theme_mod( 'mp_slider_layout', 'hero' );

// Featured Manga.
$featured = new WP_Query( array(
	'post_type'      => 'manga',
	'posts_per_page' => $featured_count,
	'post_status'    => 'publish',
	'meta_key'       => '_mp_rating',
	'orderby'        => 'meta_value_num',
	'order'          => 'DESC',
) );

// Trending (most views).
$trending = new WP_Query( array(
	'post_type'      => 'manga',
	'posts_per_page' => $featured_count,
	'post_status'    => 'publish',
	'meta_key'       => '_mp_views',
	'orderby'        => 'meta_value_num',
	'order'          => 'DESC',
) );

// Recently Updated.
$recent = new WP_Query( array(
	'post_type'      => 'manga',
	'posts_per_page' => $featured_count,
	'post_status'    => 'publish',
	'orderby'        => 'modified',
	'order'          => 'DESC',
) );

// Latest Chapters.
$latest_chapters = mp_get_latest_chapters( 10 );

// All genres.
$genres = get_terms( array(
	'taxonomy'   => 'manga_genre',
	'hide_empty' => true,
	'number'     => 20,
) );
?>

<!-- Hero Slider -->
<?php if ( $featured->have_posts() ) : ?>
<section class="mp-hero-section mp-section">
	<div class="mp-container">
		<div class="mp-slider mp-slider--<?php echo esc_attr( $slider_layout ); ?>" id="mp-hero-slider">
			<div class="mp-slider__track">
				<?php while ( $featured->have_posts() ) : $featured->the_post();
					$meta = mp_get_manga_meta( get_the_ID() );
				?>
					<div class="mp-slider__slide">
						<div class="mp-slider__slide-bg">
							<?php mp_the_cover( get_the_ID(), 'mp-banner', 'mp-slider__bg-img' ); ?>
						</div>
						<div class="mp-slider__slide-content">
							<div class="mp-slider__cover">
								<?php mp_the_cover( get_the_ID(), 'mp-cover' ); ?>
							</div>
							<div class="mp-slider__info">
								<div class="mp-slider__badges">
									<?php mp_status_badge( $meta['status'] ); ?>
									<?php if ( ! empty( $meta['type'] ) ) mp_type_badge( $meta['type'] ); ?>
								</div>
								<h2 class="mp-slider__title">
									<a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
								</h2>
								<p class="mp-slider__excerpt"><?php echo wp_trim_words( get_the_excerpt(), 35 ); ?></p>
								<div class="mp-slider__meta">
									<?php mp_rating_stars( $meta['rating'] ); ?>
									<span class="mp-slider__views">
										<svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>
										<?php echo esc_html( mp_format_number( $meta['views'] ) ); ?>
									</span>
								</div>
								<a href="<?php the_permalink(); ?>" class="mp-btn mp-btn--primary"><?php esc_html_e( 'Read Now', 'manga-premium' ); ?></a>
							</div>
						</div>
					</div>
				<?php endwhile; wp_reset_postdata(); ?>
			</div>
			<button class="mp-slider__arrow mp-slider__arrow--prev" aria-label="<?php esc_attr_e( 'Previous', 'manga-premium' ); ?>">
				<svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="15 18 9 12 15 6"/></svg>
			</button>
			<button class="mp-slider__arrow mp-slider__arrow--next" aria-label="<?php esc_attr_e( 'Next', 'manga-premium' ); ?>">
				<svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="9 18 15 12 9 6"/></svg>
			</button>
			<div class="mp-slider__dots"></div>
		</div>
	</div>
</section>
<?php endif; ?>

<!-- Main Content + Sidebar -->
<div class="mp-container">
	<div class="mp-layout mp-layout--home">
		<div class="mp-layout__main">

			<!-- Popular / Featured -->
			<section class="mp-section">
				<div class="mp-section__header">
					<div>
						<h2 class="mp-section__title">
							<svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/></svg>
							<?php esc_html_e( 'Popular Titles', 'manga-premium' ); ?>
						</h2>
						<p class="mp-section__subtitle"><?php esc_html_e( 'Top-rated manga loved by the community', 'manga-premium' ); ?></p>
					</div>
					<a href="<?php echo esc_url( get_post_type_archive_link( 'manga' ) ); ?>" class="mp-btn mp-btn--ghost"><?php esc_html_e( 'View All', 'manga-premium' ); ?> →</a>
				</div>
				<div class="mp-grid mp-grid--2col mp-grid--3col-md mp-grid--3col-lg">
					<?php
					$popular = new WP_Query( array(
						'post_type'      => 'manga',
						'posts_per_page' => 6,
						'post_status'    => 'publish',
						'meta_key'       => '_mp_rating',
						'orderby'        => 'meta_value_num',
						'order'          => 'DESC',
					) );
					while ( $popular->have_posts() ) : $popular->the_post();
						mp_manga_card( get_the_ID(), true );
					endwhile;
					wp_reset_postdata();
					?>
				</div>
			</section>

			<!-- Latest Updates -->
			<section class="mp-section">
				<div class="mp-section__header">
					<div>
						<h2 class="mp-section__title">
							<svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
							<?php esc_html_e( 'Latest Updates', 'manga-premium' ); ?>
						</h2>
						<p class="mp-section__subtitle"><?php esc_html_e( 'Fresh chapters just released', 'manga-premium' ); ?></p>
					</div>
				</div>
				<div class="mp-grid mp-grid--2col mp-grid--3col-md mp-grid--3col-lg">
					<?php while ( $recent->have_posts() ) : $recent->the_post();
						mp_manga_card( get_the_ID(), true );
					endwhile;
					wp_reset_postdata();
					?>
				</div>
			</section>

			<!-- Trending -->
			<section class="mp-section">
				<div class="mp-section__header">
					<div>
						<h2 class="mp-section__title">
							<svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="23 6 13.5 15.5 8.5 10.5 1 18"/><polyline points="17 6 23 6 23 12"/></svg>
							<?php esc_html_e( 'Trending', 'manga-premium' ); ?>
						</h2>
						<p class="mp-section__subtitle"><?php esc_html_e( 'Rising in popularity this week', 'manga-premium' ); ?></p>
					</div>
				</div>
				<div class="mp-grid mp-grid--2col mp-grid--3col-md mp-grid--3col-lg">
					<?php while ( $trending->have_posts() ) : $trending->the_post();
						mp_manga_card( get_the_ID(), true );
					endwhile;
					wp_reset_postdata();
					?>
				</div>
			</section>
		</div>

		<!-- Sidebar -->
		<aside class="mp-layout__sidebar" role="complementary">
			<!-- Latest Chapters -->
			<div class="mp-widget">
				<h3 class="mp-widget__title">
					<svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20"/><path d="M6.5 2H20v20H6.5A2.5 2.5 0 0 1 4 19.5v-15A2.5 2.5 0 0 1 6.5 2z"/></svg>
					<?php esc_html_e( 'Recently Updated', 'manga-premium' ); ?>
				</h3>
				<div class="mp-widget__content">
					<?php foreach ( $latest_chapters as $ch ) :
						$manga_id   = mp_get_meta( $ch->ID, 'manga_id', '' );
						$ch_num     = mp_get_meta( $ch->ID, 'chapter_number', '0' );
						$manga_slug = $manga_id ? get_post_field( 'post_name', $manga_id ) : '';
					?>
						<a href="<?php echo esc_url( home_url( '/manga/' . $manga_slug . '/chapter/' . $ch_num . '/' ) ); ?>" class="mp-latest-item">
							<span class="mp-latest-item__thumb">
								<?php mp_the_cover( $manga_id, 'mp-cover-thumb' ); ?>
							</span>
							<span class="mp-latest-item__info">
								<span class="mp-latest-item__title"><?php echo esc_html( get_the_title( $manga_id ) ); ?></span>
								<span class="mp-latest-item__chapter">Ch. <?php echo esc_html( $ch_num ); ?></span>
							</span>
							<span class="mp-latest-item__time"><?php echo mp_time_ago( $ch->post_date ); ?></span>
						</a>
					<?php endforeach; ?>
				</div>
			</div>

			<!-- Genres -->
			<?php if ( ! empty( $genres ) && ! is_wp_error( $genres ) ) : ?>
				<div class="mp-widget">
					<h3 class="mp-widget__title">
						<svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M20.59 13.41l-7.17 7.17a2 2 0 0 1-2.83 0L2 12V2h10l8.59 8.59a2 2 0 0 1 0 2.82z"/><line x1="7" y1="7" x2="7.01" y2="7"/></svg>
						<?php esc_html_e( 'Genres', 'manga-premium' ); ?>
					</h3>
					<div class="mp-genre-pills">
						<?php foreach ( $genres as $genre ) : ?>
							<a href="<?php echo esc_url( get_term_link( $genre ) ); ?>" class="mp-pill"><?php echo esc_html( $genre->name ); ?></a>
						<?php endforeach; ?>
					</div>
				</div>
			<?php endif; ?>

			<!-- Reading Status -->
			<div class="mp-widget">
				<h3 class="mp-widget__title">
					<svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/></svg>
					<?php esc_html_e( 'Status', 'manga-premium' ); ?>
				</h3>
				<div class="mp-status-grid">
					<?php
					$statuses = get_terms( array(
						'taxonomy'   => 'manga_status',
						'hide_empty' => true,
					) );
					if ( ! is_wp_error( $statuses ) ) :
						foreach ( $statuses as $status ) :
					?>
						<a href="<?php echo esc_url( get_term_link( $status ) ); ?>" class="mp-status-link mp-status-link--<?php echo esc_attr( $status->slug ); ?>">
							<span class="mp-status-link__dot"></span>
							<?php echo esc_html( $status->name ); ?>
							<span class="mp-status-link__count"><?php echo esc_html( $status->count ); ?></span>
						</a>
					<?php
						endforeach;
					endif;
					?>
				</div>
			</div>

			<?php get_sidebar(); ?>
		</aside>
	</div>
</div>

<?php get_footer(); ?>
