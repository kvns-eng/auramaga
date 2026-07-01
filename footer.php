<?php
/**
 * Footer
 *
 * @package MangaPremium
 */
defined( 'ABSPATH' ) || exit;
?>
</main><!-- /.mp-main -->

<footer class="mp-footer" role="contentinfo">
	<div class="mp-container">
		<div class="mp-footer__grid">
			<div class="mp-footer__col">
				<div class="mp-footer__brand">
					<?php if ( has_custom_logo() ) : ?>
						<?php the_custom_logo(); ?>
					<?php else : ?>
						<a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="mp-header__logo-text">
							<svg class="mp-header__logo-icon" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="var(--mp-primary)" stroke-width="2"><path d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20"/><path d="M6.5 2H20v20H6.5A2.5 2.5 0 0 1 4 19.5v-15A2.5 2.5 0 0 1 6.5 2z"/></svg>
							<span><?php echo esc_html( get_bloginfo( 'name' ) ); ?></span>
						</a>
					<?php endif; ?>
				</div>
				<p class="mp-footer__desc"><?php echo esc_html( get_bloginfo( 'description' ) ); ?></p>
			</div>

			<?php if ( is_active_sidebar( 'footer-1' ) ) : ?>
				<div class="mp-footer__col"><?php dynamic_sidebar( 'footer-1' ); ?></div>
			<?php endif; ?>

			<?php if ( is_active_sidebar( 'footer-2' ) ) : ?>
				<div class="mp-footer__col"><?php dynamic_sidebar( 'footer-2' ); ?></div>
			<?php endif; ?>

			<?php if ( is_active_sidebar( 'footer-3' ) ) : ?>
				<div class="mp-footer__col"><?php dynamic_sidebar( 'footer-3' ); ?></div>
			<?php endif; ?>
		</div>

		<div class="mp-footer__bottom">
			<p class="mp-footer__copy">&copy; <?php echo esc_html( date( 'Y' ) ); ?> <?php echo esc_html( get_bloginfo( 'name' ) ); ?>. <?php esc_html_e( 'All rights reserved.', 'manga-premium' ); ?></p>
			<?php if ( has_nav_menu( 'footer' ) ) : ?>
				<nav class="mp-footer__nav" aria-label="<?php esc_attr_e( 'Footer navigation', 'manga-premium' ); ?>">
					<?php
					wp_nav_menu( array(
						'theme_location' => 'footer',
						'menu_class'     => 'mp-footer__menu',
						'container'      => false,
						'depth'          => 1,
						'fallback_cb'    => false,
					) );
					?>
				</nav>
			<?php endif; ?>
		</div>
	</div>
</footer>

<?php wp_footer(); ?>
</body>
</html>
