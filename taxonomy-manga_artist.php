<?php
/**
 * Manga Artist Taxonomy Template
 *
 * @package MangaPremium
 */

get_header();
$term = get_queried_object();
?>

<div class="mp-section">
	<div class="mp-container">
		<?php mp_breadcrumbs(); ?>
		<div class="mp-archive-header">
			<h1 class="mp-archive-header__title"><?php echo esc_html( $term->name ); ?></h1>
			<p class="mp-archive-header__subtitle"><?php esc_html_e( 'Manga Artist', 'manga-premium' ); ?></p>
			<p class="mp-archive-header__count"><?php echo esc_html( sprintf( __( '%d works', 'manga-premium' ), $term->count ) ); ?></p>
		</div>
		<?php if ( have_posts() ) : ?>
			<div class="mp-grid mp-grid--2col mp-grid--3col-md mp-grid--4col-lg mp-grid--6col-xl">
				<?php while ( have_posts() ) : the_post();
					mp_manga_card( get_the_ID(), true, 'mp-card--sm' );
				endwhile; ?>
			</div>
			<?php mp_pagination(); ?>
		<?php else : ?>
			<div class="mp-empty">
				<h2 class="mp-empty__title"><?php esc_html_e( 'No manga found.', 'manga-premium' ); ?></h2>
			</div>
		<?php endif; ?>
	</div>
</div>

<?php get_footer(); ?>
