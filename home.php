<?php
/**
 * Home (Blog) Template
 *
 * @package MangaPremium
 */

get_header();
?>

<div class="mp-section">
	<div class="mp-container">
		<?php mp_breadcrumbs(); ?>

		<div class="mp-layout">
			<div class="mp-layout__main">
				<?php if ( have_posts() ) : ?>
					<div class="mp-grid mp-grid--2col">
						<?php while ( have_posts() ) : the_post(); ?>
							<div class="mp-grid__item">
								<article class="mp-post-card">
									<a href="<?php the_permalink(); ?>" class="mp-post-card__link">
										<?php if ( has_post_thumbnail() ) : ?>
											<div class="mp-post-card__thumb"><?php the_post_thumbnail( 'medium' ); ?></div>
										<?php endif; ?>
										<h3 class="mp-post-card__title"><?php the_title(); ?></h3>
										<p class="mp-post-card__excerpt"><?php echo wp_trim_words( get_the_excerpt(), 20 ); ?></p>
										<time class="mp-post-card__date" datetime="<?php echo esc_attr( get_the_date( 'c' ) ); ?>"><?php echo esc_html( get_the_date() ); ?></time>
									</a>
								</article>
							</div>
						<?php endwhile; ?>
					</div>
					<?php mp_pagination(); ?>
				<?php endif; ?>
			</div>

			<aside class="mp-layout__sidebar"><?php get_sidebar(); ?></aside>
		</div>
	</div>
</div>

<?php get_footer(); ?>
