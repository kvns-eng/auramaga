<?php
/**
 * 404 Page
 *
 * @package MangaPremium
 */

get_header();
?>

<div class="mp-section">
	<div class="mp-container">
		<div class="mp-404">
			<div class="mp-404__visual">
				<div class="mp-404__circle">
					<span class="mp-404__number">404</span>
				</div>
			</div>
			<h1 class="mp-404__title"><?php esc_html_e( 'Page Not Found', 'manga-premium' ); ?></h1>
			<p class="mp-404__text"><?php esc_html_e( 'The page you\'re looking for doesn\'t exist or has been moved.', 'manga-premium' ); ?></p>
			<div class="mp-404__actions">
				<a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="mp-btn mp-btn--primary">
					<svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/><polyline points="9 22 9 12 15 12 15 22"/></svg>
					<?php esc_html_e( 'Return Home', 'manga-premium' ); ?>
				</a>
				<a href="<?php echo esc_url( get_post_type_archive_link( 'manga' ) ); ?>" class="mp-btn mp-btn--secondary">
					<svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><polygon points="16.24 7.76 14.12 14.12 7.76 16.24 9.88 9.88 16.24 7.76"/></svg>
					<?php esc_html_e( 'Browse Manga', 'manga-premium' ); ?>
				</a>
				<a href="<?php echo esc_url( home_url( '/?s=' ) ); ?>" class="mp-btn mp-btn--secondary">
					<svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="11" cy="11" r="8"/><path d="M21 21l-4.35-4.35"/></svg>
					<?php esc_html_e( 'Search', 'manga-premium' ); ?>
				</a>
			</div>
		</div>
	</div>
</div>

<?php get_footer(); ?>
