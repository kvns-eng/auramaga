<?php
/**
 * Index Template (fallback)
 *
 * @package MangaPremium
 */

get_header();
?>

<div class="mp-container mp-section">
	<?php mp_breadcrumbs(); ?>

	<div class="mp-layout">
		<div class="mp-layout__main">
			<?php if ( have_posts() ) : ?>
				<div class="mp-grid mp-grid--2col mp-grid--3col-md mp-grid--4col-lg">
					<?php while ( have_posts() ) : the_post(); ?>
						<div class="mp-grid__item">
							<article class="mp-post-card">
								<a href="<?php the_permalink(); ?>" class="mp-post-card__link">
									<?php if ( has_post_thumbnail() ) : ?>
										<div class="mp-post-card__thumb">
											<?php the_post_thumbnail( 'medium' ); ?>
										</div>
									<?php endif; ?>
									<h3 class="mp-post-card__title"><?php the_title(); ?></h3>
									<p class="mp-post-card__excerpt"><?php echo wp_trim_words( get_the_excerpt(), 15 ); ?></p>
									<time class="mp-post-card__date" datetime="<?php echo esc_attr( get_the_date( 'c' ) ); ?>"><?php echo esc_html( get_the_date() ); ?></time>
								</a>
							</article>
						</div>
					<?php endwhile; ?>
				</div>
				<?php mp_pagination(); ?>
			<?php else : ?>
				<div class="mp-empty">
					<h2 class="mp-empty__title"><?php esc_html_e( 'Nothing Found', 'manga-premium' ); ?></h2>
					<p class="mp-empty__text"><?php esc_html_e( 'It seems we can\'t find what you\'re looking for.', 'manga-premium' ); ?></p>
				</div>
			<?php endif; ?>
		</div>

		<?php get_sidebar(); ?>
	</div>
</div>

<?php get_footer(); ?>
