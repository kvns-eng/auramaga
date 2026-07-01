<?php
/**
 * Search UI Component
 *
 * Renders search forms and components.
 *
 * @package Auramaga
 * @since 2.0.0
 */

defined( 'ABSPATH' ) || exit;

/**
 * Display Search Form
 *
 * @since 2.0.0
 */
function auramaga_search_form() {
	?>
	<form role="search" method="get" action="<?php echo esc_url( home_url( '/' ) ); ?>" class="search-form">
		<input
			type="search"
			name="s"
			class="search-input"
			placeholder="<?php esc_attr_e( 'Search manga…', 'auramaga' ); ?>"
			aria-label="<?php esc_attr_e( 'Search manga', 'auramaga' ); ?>"
		>
		<input type="hidden" name="post_type" value="manga">
		<button type="submit" class="search-button" aria-label="<?php esc_attr_e( 'Search', 'auramaga' ); ?>">
			<svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="11" cy="11" r="8"></circle><path d="M21 21l-4.35-4.35"></path></svg>
		</button>
	</form>
	<?php
}
