<?php
/**
 * Header
 *
 * @package MangaPremium
 */
defined( 'ABSPATH' ) || exit;
$layout = get_theme_mod( 'mp_header_layout', 'default' );
?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="profile" href="https://gmpg.org/xfn/11">
	<?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

<a href="#main-content" class="mp-skip-link"><?php esc_html_e( 'Skip to content', 'manga-premium' ); ?></a>

<header class="mp-header mp-header--<?php echo esc_attr( $layout ); ?>" role="banner">
	<div class="mp-container">
		<div class="mp-header__inner">
			<!-- Logo -->
			<div class="mp-header__brand">
				<?php if ( has_custom_logo() ) : ?>
					<?php the_custom_logo(); ?>
				<?php else : ?>
					<a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="mp-header__logo-text" aria-label="<?php echo esc_attr( get_bloginfo( 'name' ) ); ?>">
						<svg class="mp-header__logo-icon" width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="var(--mp-primary)" stroke-width="2"><path d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20"/><path d="M6.5 2H20v20H6.5A2.5 2.5 0 0 1 4 19.5v-15A2.5 2.5 0 0 1 6.5 2z"/></svg>
						<span><?php echo esc_html( get_bloginfo( 'name' ) ); ?></span>
					</a>
				<?php endif; ?>
			</div>

			<!-- Navigation -->
			<nav class="mp-nav" role="navigation" aria-label="<?php esc_attr_e( 'Primary navigation', 'manga-premium' ); ?>">
				<?php
				wp_nav_menu( array(
					'theme_location' => 'primary',
					'menu_class'     => 'mp-nav__list',
					'container'      => false,
					'depth'          => 2,
					'fallback_cb'    => false,
					'walker'         => new Manga_Walker_Nav(),
				) );
				?>
			</nav>

			<!-- Actions -->
			<div class="mp-header__actions">
				<!-- Desktop Search -->
				<form role="search" method="get" action="<?php echo esc_url( home_url( '/' ) ); ?>" class="mp-header__search" aria-label="<?php esc_attr_e( 'Search', 'manga-premium' ); ?>">
					<input type="search" name="s" class="mp-header__search-input" placeholder="<?php esc_attr_e( 'Search manga…', 'manga-premium' ); ?>" aria-label="<?php esc_attr_e( 'Search manga', 'manga-premium' ); ?>">
					<input type="hidden" name="post_type" value="manga">
					<svg class="mp-header__search-icon" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="11" cy="11" r="8"/><path d="M21 21l-4.35-4.35"/></svg>
				</form>

				<!-- Dark Mode Toggle -->
				<button class="mp-header__btn mp-dark-toggle" id="mp-dark-toggle" aria-label="<?php esc_attr_e( 'Toggle dark mode', 'manga-premium' ); ?>">
					<svg class="mp-icon-sun" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="5"/><line x1="12" y1="1" x2="12" y2="3"/><line x1="12" y1="21" x2="12" y2="23"/><line x1="4.22" y1="4.22" x2="5.64" y2="5.64"/><line x1="18.36" y1="18.36" x2="19.78" y2="19.78"/><line x1="1" y1="12" x2="3" y2="12"/><line x1="21" y1="12" x2="23" y2="12"/><line x1="4.22" y1="19.78" x2="5.64" y2="18.36"/><line x1="18.36" y1="5.64" x2="19.78" y2="4.22"/></svg>
					<svg class="mp-icon-moon" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 12.79A9 9 0 1 1 11.21 3 7 7 0 0 0 21 12.79z"/></svg>
				</button>

				<!-- Mobile Toggle -->
				<button class="mp-header__btn mp-header__menu-toggle" id="mp-menu-toggle" aria-label="<?php esc_attr_e( 'Toggle menu', 'manga-premium' ); ?>" aria-expanded="false">
					<svg class="mp-icon-menu" width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="3" y1="6" x2="21" y2="6"/><line x1="3" y1="12" x2="21" y2="12"/><line x1="3" y1="18" x2="21" y2="18"/></svg>
					<svg class="mp-icon-close" width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
				</button>
			</div>
		</div>
	</div>

	<!-- Mobile Menu -->
	<div class="mp-mobile-menu" id="mp-mobile-menu" aria-hidden="true">
		<div class="mp-mobile-menu__search">
			<?php mp_search_form(); ?>
		</div>
		<?php
		wp_nav_menu( array(
			'theme_location' => 'primary',
			'menu_class'     => 'mp-mobile-menu__list',
			'container'      => false,
			'depth'          => 2,
			'fallback_cb'    => false,
		) );
		?>
	</div>
</header>

<main id="main-content" class="mp-main" role="main">
