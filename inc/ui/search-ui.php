<?php
/**
 * Search UI
 *
 * @package MangaPremium
 */

defined( 'ABSPATH' ) || exit;

function mp_search_form() {
	?>
	<form role="search" method="get" action="<?php echo esc_url( home_url( '/' ) ); ?>" class="mp-search-form">
		<div class="mp-search-form__wrap">
			<svg class="mp-search-form__icon" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="11" cy="11" r="8"/><path d="M21 21l-4.35-4.35"/></svg>
			<input type="search" name="s" class="mp-search-form__input" placeholder="<?php esc_attr_e( 'Search manga…', 'manga-premium' ); ?>" value="<?php echo get_search_query(); ?>" aria-label="<?php esc_attr_e( 'Search manga', 'manga-premium' ); ?>">
			<input type="hidden" name="post_type" value="manga">
		</div>
	</form>
	<?php
}
