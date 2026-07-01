<?php
/**
 * Search Results
 *
 * @package MangaPremium
 */

get_header();
?>

<div class="mp-section">
	<div class="mp-container">
		<?php mp_breadcrumbs(); ?>

		<div class="mp-archive-header">
			<h1 class="mp-archive-header__title">
				<?php echo esc_html( sprintf( __( 'Search: "%s"', 'manga-premium' ), get_search_query() ) ); ?>
			</h1>
			<p class="mp-archive-header__subtitle">
				<?php
				global $wp_query;
				echo esc_html( sprintf(
					_n( '%d result found', '%d results found', $wp_query->found_posts, 'manga-premium' ),
					$wp_query->found_posts
				) );
				?>
			</p>
		</div>

		<!-- Search Form -->
		<div class="mp-search-box">
			<?php mp_search_form(); ?>
		</div>

		<?php if ( have_posts() ) : ?>
			<div class="mp-grid mp-grid--2col mp-grid--3col-md mp-grid--4col-lg">
				<?php while ( have_posts() ) : the_post();
					if ( 'manga' === get_post_type() ) {
						mp_manga_card( get_the_ID(), true, 'mp-card--sm' );
					} else {
					?>
						<div class="mp-grid__item">
							<article class="mp-post-card">
								<a href="<?php the_permalink(); ?>" class="mp-post-card__link">
									<h3 class="mp-post-card__title"><?php the_title(); ?></h3>
									<p class="mp-post-card__excerpt"><?php echo wp_trim_words( get_the_excerpt(), 15 ); ?></p>
								</a>
							</article>
						</div>
					<?php
					}
				endwhile; ?>
			</div>
			<?php mp_pagination(); ?>
		<?php else : ?>
			<div class="mp-empty">
				<svg class="mp-empty__icon" width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><circle cx="11" cy="11" r="8"/><path d="M21 21l-4.35-4.35"/></svg>
				<h2 class="mp-empty__title"><?php esc_html_e( 'No results found', 'manga-premium' ); ?></h2>
				<p class="mp-empty__text"><?php esc_html_e( 'Try different keywords or check the spelling.', 'manga-premium' ); ?></p>
			</div>
		<?php endif; ?>
	</div>
</div>

<?php get_footer(); ?>
