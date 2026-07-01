<?php
/**
 * Comment UI
 *
 * @package MangaPremium
 */

defined( 'ABSPATH' ) || exit;

function mp_comment_form() {
	$args = array(
		'comment_field' => '<div class="mp-comment-form__field"><label for="comment" class="mp-comment-form__label">' . esc_html__( 'Comment', 'manga-premium' ) . '</label><textarea id="comment" name="comment" class="mp-comment-form__textarea" rows="4" required></textarea></div>',
		'fields' => array(
			'author' => '<div class="mp-comment-form__field"><label for="author" class="mp-comment-form__label">' . esc_html__( 'Name', 'manga-premium' ) . ' *</label><input id="author" name="author" type="text" class="mp-comment-form__input" required></div>',
			'email'  => '<div class="mp-comment-form__field"><label for="email" class="mp-comment-form__label">' . esc_html__( 'Email', 'manga-premium' ) . ' *</label><input id="email" name="email" type="email" class="mp-comment-form__input" required></div>',
		),
		'class_form'    => 'mp-comment-form',
		'class_submit'  => 'mp-btn mp-btn--primary mp-comment-form__submit',
		'label_submit'  => esc_html__( 'Post Comment', 'manga-premium' ),
		'title_reply'   => esc_html__( 'Leave a Comment', 'manga-premium' ),
		'title_reply_before' => '<h3 class="mp-comment-form__title">',
		'title_reply_after'  => '</h3>',
		'submit_field'  => '<div class="mp-comment-form__field mp-comment-form__submit-wrap">%1$s %2$s</div>',
	);

	comment_form( $args );
}

function mp_comment_template( $comment, $args, $depth ) {
	$tag = ( 'div' === $args['style'] ) ? 'div' : 'li';
	?>
	<<?php echo $tag; ?> id="comment-<?php comment_ID(); ?>" <?php comment_class( 'mp-comment' ); ?>>
		<div class="mp-comment__avatar">
			<?php echo get_avatar( $comment, 40 ); ?>
		</div>
		<div class="mp-comment__body">
			<div class="mp-comment__header">
				<span class="mp-comment__author"><?php echo esc_html( $comment->comment_author ); ?></span>
				<span class="mp-comment__time"><?php echo mp_time_ago( $comment->comment_date ); ?></span>
			</div>
			<div class="mp-comment__content">
				<?php comment_text(); ?>
			</div>
			<div class="mp-comment__actions">
				<?php comment_reply_link( array_merge( $args, array( 'depth' => $depth, 'max_depth' => $args['max_depth'], 'class' => 'mp-comment__reply' ) ) ); ?>
			</div>
		</div>
	<?php
}
