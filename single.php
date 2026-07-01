<?php
/**
 * Single Post Template
 *
 * @package MangaPremium
 */

get_header();
?>

<div class="mp-section">
	<div class="mp-container">
		<?php mp_breadcrumbs(); ?>

		<div class="mp-layout">
			<article class="mp-layout__main">
				<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
					<div class="mp-card-block">
						<?php if ( has_post_thumbnail() ) : ?>
							<div class="mp-post-hero">
								<?php the_post_thumbnail( 'large' ); ?>
							</div>
						<?php endif; ?>
						<h1 class="mp-post-title"><?php the_title(); ?></h1>
						<div class="mp-post-meta">
							<time datetime="<?php echo esc_attr( get_the_date( 'c' ) ); ?>"><?php echo esc_html( get_the_date() ); ?></time>
						</div>
						<div class="mp-post-content mp-synopsis">
							<?php the_content(); ?>
						</div>
					</div>
					<?php if ( comments_open() || get_comments_number() ) : ?>
						<div class="mp-card-block"><?php comments_template(); ?></div>
					<?php endif; ?>
				<?php endwhile; endif; ?>
			</article>

			<aside class="mp-layout__sidebar"><?php get_sidebar(); ?></aside>
		</div>
	</div>
</div>

<?php get_footer(); ?>
