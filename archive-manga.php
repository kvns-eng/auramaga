<?php
/**
 * Manga Archive
 *
 * @package MangaPremium
 */

get_header();
?>

<div class="mp-section">
	<div class="mp-container">
		<?php mp_breadcrumbs(); ?>

		<div class="mp-archive-header">
			<h1 class="mp-archive-header__title"><?php esc_html_e( 'Browse Manga', 'manga-premium' ); ?></h1>
			<p class="mp-archive-header__subtitle"><?php esc_html_e( 'Discover your next favorite read from our collection', 'manga-premium' ); ?></p>
		</div>

		<!-- Filters -->
		<div class="mp-filters">
			<div class="mp-filters__row">
				<span class="mp-filters__label"><?php esc_html_e( 'Type:', 'manga-premium' ); ?></span>
				<?php
				$types = get_terms( array( 'taxonomy' => 'manga_type', 'hide_empty' => true ) );
				if ( ! is_wp_error( $types ) ) :
				?>
					<a href="<?php echo esc_url( get_post_type_archive_link( 'manga' ) ); ?>" class="mp-filter-chip mp-filter-chip--active"><?php esc_html_e( 'All', 'manga-premium' ); ?></a>
					<?php foreach ( $types as $type ) : ?>
						<a href="<?php echo esc_url( get_term_link( $type ) ); ?>" class="mp-filter-chip"><?php echo esc_html( $type->name ); ?></a>
					<?php endforeach; ?>
				<?php endif; ?>
			</div>
			<div class="mp-filters__row">
				<span class="mp-filters__label"><?php esc_html_e( 'Status:', 'manga-premium' ); ?></span>
				<?php
				$statuses = get_terms( array( 'taxonomy' => 'manga_status', 'hide_empty' => true ) );
				if ( ! is_wp_error( $statuses ) ) :
					foreach ( $statuses as $status ) :
				?>
						<a href="<?php echo esc_url( get_term_link( $status ) ); ?>" class="mp-filter-chip"><?php echo esc_html( $status->name ); ?></a>
				<?php
					endforeach;
				endif;
				?>
			</div>
		</div>

		<!-- Grid -->
		<div class="mp-layout">
			<div class="mp-layout__main">
				<?php if ( have_posts() ) : ?>
					<div class="mp-grid mp-grid--2col mp-grid--3col-md mp-grid--4col-lg">
						<?php while ( have_posts() ) : the_post();
							mp_manga_card( get_the_ID(), true, 'mp-card--sm' );
						endwhile; ?>
					</div>
					<?php mp_pagination(); ?>
				<?php else : ?>
					<div class="mp-empty">
						<svg class="mp-empty__icon" width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20"/><path d="M6.5 2H20v20H6.5A2.5 2.5 0 0 1 4 19.5v-15A2.5 2.5 0 0 1 6.5 2z"/></svg>
						<h2 class="mp-empty__title"><?php esc_html_e( 'No manga found', 'manga-premium' ); ?></h2>
					</div>
				<?php endif; ?>
			</div>

			<aside class="mp-layout__sidebar">
				<?php get_sidebar(); ?>
			</aside>
		</div>
	</div>
</div>

<?php get_footer(); ?>
