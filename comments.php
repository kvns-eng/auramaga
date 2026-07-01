<?php
/**
 * Comments Template
 *
 * @package MangaPremium
 */

if ( post_password_required() ) {
	return;
}
?>

<div class="mp-comments" id="comments">
	<?php if ( have_comments() ) : ?>
		<p class="mp-comments__count">
			<?php echo esc_html( sprintf(
				_n( '%d Comment', '%d Comments', get_comments_number(), 'manga-premium' ),
				get_comments_number()
			) ); ?>
		</p>

		<ol class="mp-comments__list">
			<?php
			wp_list_comments( array(
				'style'      => 'ol',
				'short_ping' => true,
				'callback'   => 'mp_comment_template',
			) );
			?>
		</ol>

		<?php the_comments_navigation(); ?>
	<?php endif; ?>

	<?php
	if ( ! comments_open() && get_comments_number() && post_type_supports( get_post_type(), 'comments' ) ) :
	?>
		<p class="mp-comments__closed"><?php esc_html_e( 'Comments are closed.', 'manga-premium' ); ?></p>
	<?php endif; ?>

	<?php mp_comment_form(); ?>
</div>
