<?php
/**
 * Generic Archive Template
 *
 * @package MangaPremium
 */

get_header();
?>

<div class="mp-section">
	<div class="mp-container">
		<?php mp_breadcrumbs(); ?>

		<div class="mp-archive-header">
			<h1 class="mp-archive-header__title"><?php the_archive_title(); ?></h1>
			<?php the_archive_description( '<p class="mp-archive-header__subtitle">', '</p>' ); ?>
		</div>

		<div class="mp-layout">
			<div class="mp-layout__main">
				<?php if ( have_posts() ) : ?>
					<div class="mp-grid mp-grid--2col mp-grid--3col-md mp-grid--4col-lg">
						<?php while ( have_posts() ) : the_post();
							if ( 'manga' === get_post_type() || 'mp_chapter' === get_post_type() ) {
								mp_manga_card( get_the_ID(), true, 'mp-card--sm' );
							} else {
						?>
							<div class="mp-grid__item">
								<article class="mp-post-card">
									<a href="<?php the_permalink(); ?>" class="mp-post-card__link">
										<?php if ( has_post_thumbnail() ) : ?>
											<div class="mp-post-card__thumb"><?php the_post_thumbnail( 'medium' ); ?></div>
										<?php endif; ?>
										<h3 class="mp-post-card__title"><?php the_title(); ?></h3>
										<time class="mp-post-card__date" datetime="<?php echo esc_attr( get_the_date( 'c' ) ); ?>"><?php echo esc_html( get_the_date() ); ?></time>
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
						<h2 class="mp-empty__title"><?php esc_html_e( 'Nothing found', 'manga-premium' ); ?></h2>
					</div>
				<?php endif; ?>
			</div>

			<aside class="mp-layout__sidebar"><?php get_sidebar(); ?></aside>
		</div>
	</div>
</div>

<?php get_footer(); ?>
