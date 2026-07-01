<?php
/**
 * Sidebar
 *
 * @package MangaPremium
 */

if ( ! is_active_sidebar( 'sidebar-main' ) ) {
	return;
}
?>

<div class="mp-sidebar-widgets">
	<?php dynamic_sidebar( 'sidebar-main' ); ?>
</div>
