<?php
/**
 * Chapter Reader Template
 *
 * @package MangaPremium
 */

get_header();

if ( have_posts() ) : while ( have_posts() ) : the_post();

$meta     = mp_get_chapter_meta( get_the_ID() );
$manga_id = $meta['manga_id'];
$manga_title = $manga_id ? get_the_title( $manga_id ) : '';
$manga_url   = $manga_id ? get_permalink( $manga_id ) : '';
$manga_slug  = $manga_id ? get_post_field( 'post_name', $manga_id ) : '';
$ch_num     = $meta['chapter_num'];

// Get chapter images.
$pages = get_post_meta( get_the_ID(), '_mp_pages', true );
if ( ! is_array( $pages ) || empty( $pages ) ) {
	$pages = array();
	if ( preg_match_all( '/<img[^>]+src=["\']([^"\']+)["\']/', get_the_content(), $matches ) ) {
		$pages = $matches[1];
	}
}

// Chapter navigation.
$all_chapters = mp_get_manga_chapters( $manga_id, 'ASC' );
$prev_ch = null;
$next_ch = null;
$all_ch_sorted = array();

foreach ( $all_chapters as $idx => $ch ) {
	$all_ch_sorted[] = array(
		'num' => mp_get_meta( $ch->ID, 'chapter_number', '' ),
		'url' => home_url( '/manga/' . $manga_slug . '/chapter/' . mp_get_meta( $ch->ID, 'chapter_number', '' ) . '/' ),
	);
	if ( $ch->ID === get_the_ID() ) {
		if ( $idx > 0 ) {
			$prev_ch = $all_chapters[ $idx - 1 ];
		}
		if ( $idx < count( $all_chapters ) - 1 ) {
			$next_ch = $all_chapters[ $idx + 1 ];
		}
	}
}

// Default reader settings.
$default_bg   = get_theme_mod( 'mp_reader_bg', 'dark' );
$default_fit  = get_theme_mod( 'mp_reader_image_fit', 'width' );
$default_mode = get_theme_mod( 'mp_reader_mode', 'longstrip' );
?>

<div class="mp-reader" id="mp-reader" data-default-bg="<?php echo esc_attr( $default_bg ); ?>" data-default-fit="<?php echo esc_attr( $default_fit ); ?>" data-default-mode="<?php echo esc_attr( $default_mode ); ?>">
	<!-- Top Toolbar -->
	<div class="mp-reader__toolbar mp-reader__toolbar--top" id="mp-reader-toolbar-top">
		<div class="mp-reader__toolbar-inner">
			<a href="<?php echo esc_url( $manga_url ); ?>" class="mp-reader__back">
				<svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="19" y1="12" x2="5" y2="12"/><polyline points="12 19 5 12 12 5"/></svg>
				<span class="mp-reader__back-title"><?php echo esc_html( $manga_title ); ?></span>
			</a>
			<span class="mp-reader__chapter-label">Ch. <?php echo esc_html( $ch_num ); ?></span>
			<div class="mp-reader__toolbar-actions">
				<button class="mp-reader__btn" id="mp-reader-chapters-btn" aria-label="<?php esc_attr_e( 'Chapters', 'manga-premium' ); ?>">
					<svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="8" y1="6" x2="21" y2="6"/><line x1="8" y1="12" x2="21" y2="12"/><line x1="8" y1="18" x2="21" y2="18"/><line x1="3" y1="6" x2="3.01" y2="6"/><line x1="3" y1="12" x2="3.01" y2="12"/><line x1="3" y1="18" x2="3.01" y2="18"/></svg>
				</button>
				<button class="mp-reader__btn" id="mp-reader-settings-btn" aria-label="<?php esc_attr_e( 'Settings', 'manga-premium' ); ?>">
					<svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="3"/><path d="M19.4 15a1.65 1.65 0 0 0 .33 1.82l.06.06a2 2 0 0 1 0 2.83 2 2 0 0 1-2.83 0l-.06-.06a1.65 1.65 0 0 0-1.82-.33 1.65 1.65 0 0 0-1 1.51V21a2 2 0 0 1-2 2 2 2 0 0 1-2-2v-.09A1.65 1.65 0 0 0 9 19.4a1.65 1.65 0 0 0-1.82.33l-.06.06a2 2 0 0 1-2.83 0 2 2 0 0 1 0-2.83l.06-.06A1.65 1.65 0 0 0 4.68 15a1.65 1.65 0 0 0-1.51-1H3a2 2 0 0 1-2-2 2 2 0 0 1 2-2h.09A1.65 1.65 0 0 0 4.6 9a1.65 1.65 0 0 0-.33-1.82l-.06-.06a2 2 0 0 1 0-2.83 2 2 0 0 1 2.83 0l.06.06A1.65 1.65 0 0 0 9 4.68a1.65 1.65 0 0 0 1-1.51V3a2 2 0 0 1 2-2 2 2 0 0 1 2 2v.09a1.65 1.65 0 0 0 1 1.51 1.65 1.65 0 0 0 1.82-.33l.06-.06a2 2 0 0 1 2.83 0 2 2 0 0 1 0 2.83l-.06.06A1.65 1.65 0 0 0 19.4 9a1.65 1.65 0 0 0 1.51 1H21a2 2 0 0 1 2 2 2 2 0 0 1-2 2h-.09a1.65 1.65 0 0 0-1.51 1z"/></svg>
				</button>
				<button class="mp-reader__btn" id="mp-reader-fullscreen-btn" aria-label="<?php esc_attr_e( 'Fullscreen', 'manga-premium' ); ?>">
					<svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="15 3 21 3 21 9"/><polyline points="9 21 3 21 3 15"/><line x1="21" y1="3" x2="14" y2="10"/><line x1="3" y1="21" x2="10" y2="14"/></svg>
				</button>
			</div>
		</div>
	</div>

	<!-- Reading Area -->
	<div class="mp-reader__content" id="mp-reader-content">
		<div class="mp-reader__pages" id="mp-reader-pages">
			<?php if ( ! empty( $pages ) ) : ?>
				<?php foreach ( $pages as $i => $page_url ) : ?>
					<div class="mp-reader__page">
						<img src="<?php echo esc_url( $page_url ); ?>" alt="<?php echo esc_attr( sprintf( __( 'Page %d', 'manga-premium' ), $i + 1 ) ); ?>" loading="<?php echo $i < 3 ? 'eager' : 'lazy'; ?>" class="mp-reader__page-img" data-page="<?php echo esc_attr( $i + 1 ); ?>">
					</div>
				<?php endforeach; ?>
			<?php else : ?>
				<div class="mp-reader__empty">
					<p><?php esc_html_e( 'No pages found for this chapter.', 'manga-premium' ); ?></p>
				</div>
			<?php endif; ?>
		</div>
	</div>

	<!-- End of Chapter -->
	<div class="mp-reader__end">
		<p class="mp-reader__end-label"><?php echo esc_html( sprintf( __( 'End of Chapter %s', 'manga-premium' ), $ch_num ) ); ?></p>
		<div class="mp-reader__end-nav">
			<?php if ( $prev_ch ) :
				$pnum = mp_get_meta( $prev_ch->ID, 'chapter_number', '' );
			?>
				<a href="<?php echo esc_url( home_url( '/manga/' . $manga_slug . '/chapter/' . $pnum . '/' ) ); ?>" class="mp-btn mp-btn--secondary">
					<svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="15 18 9 12 15 6"/></svg>
					<?php esc_html_e( 'Previous Chapter', 'manga-premium' ); ?>
				</a>
			<?php endif; ?>
			<?php if ( $next_ch ) :
				$nnum = mp_get_meta( $next_ch->ID, 'chapter_number', '' );
			?>
				<a href="<?php echo esc_url( home_url( '/manga/' . $manga_slug . '/chapter/' . $nnum . '/' ) ); ?>" class="mp-btn mp-btn--primary">
					<?php esc_html_e( 'Next Chapter', 'manga-premium' ); ?>
					<svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="9 18 15 12 9 6"/></svg>
				</a>
			<?php endif; ?>
		</div>
	</div>

	<!-- Bottom Toolbar -->
	<div class="mp-reader__toolbar mp-reader__toolbar--bottom" id="mp-reader-toolbar-bottom">
		<div class="mp-reader__toolbar-inner">
			<?php if ( $prev_ch ) :
				$pnum = mp_get_meta( $prev_ch->ID, 'chapter_number', '' );
			?>
				<a href="<?php echo esc_url( home_url( '/manga/' . $manga_slug . '/chapter/' . $pnum . '/' ) ); ?>" class="mp-reader__btn mp-reader__btn--nav">
					<svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="15 18 9 12 15 6"/></svg>
				</a>
			<?php endif; ?>
			<span class="mp-reader__page-indicator" id="mp-page-indicator">1 / <?php echo esc_html( count( $pages ) ); ?></span>
			<?php if ( $next_ch ) :
				$nnum = mp_get_meta( $next_ch->ID, 'chapter_number', '' );
			?>
				<a href="<?php echo esc_url( home_url( '/manga/' . $manga_slug . '/chapter/' . $nnum . '/' ) ); ?>" class="mp-reader__btn mp-reader__btn--nav">
					<svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="9 18 15 12 9 6"/></svg>
				</a>
			<?php endif; ?>
		</div>
	</div>
</div>

<!-- Settings Modal -->
<div class="mp-modal" id="mp-reader-settings-modal" aria-hidden="true">
	<div class="mp-modal__overlay"></div>
	<div class="mp-modal__dialog">
		<div class="mp-modal__header">
			<h3 class="mp-modal__title"><?php esc_html_e( 'Reader Settings', 'manga-premium' ); ?></h3>
			<button class="mp-modal__close" aria-label="<?php esc_attr_e( 'Close', 'manga-premium' ); ?>">&times;</button>
		</div>
		<div class="mp-modal__body">
			<div class="mp-settings-group">
				<label class="mp-settings-label"><?php esc_html_e( 'Reading Mode', 'manga-premium' ); ?></label>
				<div class="mp-settings-btn-group">
					<button class="mp-settings-btn mp-settings-btn--active" data-setting="mode" data-value="longstrip">
						<svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="8" y1="6" x2="21" y2="6"/><line x1="8" y1="12" x2="21" y2="12"/><line x1="8" y1="18" x2="21" y2="18"/></svg>
						<?php esc_html_e( 'Long Strip', 'manga-premium' ); ?>
					</button>
					<button class="mp-settings-btn" data-setting="mode" data-value="singlepage">
						<svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="3" width="18" height="18" rx="2" ry="2"/></svg>
						<?php esc_html_e( 'Single Page', 'manga-premium' ); ?>
					</button>
				</div>
			</div>
			<div class="mp-settings-group">
				<label class="mp-settings-label"><?php esc_html_e( 'Background', 'manga-premium' ); ?></label>
				<div class="mp-settings-btn-group">
					<button class="mp-settings-btn mp-settings-btn--active" data-setting="bg" data-value="dark"><?php esc_html_e( 'Dark', 'manga-premium' ); ?></button>
					<button class="mp-settings-btn" data-setting="bg" data-value="light"><?php esc_html_e( 'Light', 'manga-premium' ); ?></button>
					<button class="mp-settings-btn" data-setting="bg" data-value="sepia"><?php esc_html_e( 'Sepia', 'manga-premium' ); ?></button>
				</div>
			</div>
			<div class="mp-settings-group">
				<label class="mp-settings-label"><?php esc_html_e( 'Image Fit', 'manga-premium' ); ?></label>
				<div class="mp-settings-btn-group">
					<button class="mp-settings-btn" data-setting="fit" data-value="contain"><?php esc_html_e( 'Contain', 'manga-premium' ); ?></button>
					<button class="mp-settings-btn mp-settings-btn--active" data-setting="fit" data-value="width"><?php esc_html_e( 'Width', 'manga-premium' ); ?></button>
					<button class="mp-settings-btn" data-setting="fit" data-value="original"><?php esc_html_e( 'Original', 'manga-premium' ); ?></button>
				</div>
			</div>
		</div>
	</div>
</div>

<!-- Chapter List Modal -->
<div class="mp-modal" id="mp-reader-chapters-modal" aria-hidden="true">
	<div class="mp-modal__overlay"></div>
	<div class="mp-modal__dialog">
		<div class="mp-modal__header">
			<h3 class="mp-modal__title"><?php esc_html_e( 'Chapters', 'manga-premium' ); ?></h3>
			<button class="mp-modal__close" aria-label="<?php esc_attr_e( 'Close', 'manga-premium' ); ?>">&times;</button>
		</div>
		<div class="mp-modal__body mp-modal__body--scroll">
			<div class="mp-chapter-select">
				<?php foreach ( array_reverse( $all_chapters ) as $ch ) :
					$cnum = mp_get_meta( $ch->ID, 'chapter_number', '' );
					$is_current = ( $ch->ID === get_the_ID() );
				?>
					<a href="<?php echo esc_url( home_url( '/manga/' . $manga_slug . '/chapter/' . $cnum . '/' ) ); ?>"
					   class="mp-chapter-select__item <?php echo $is_current ? 'mp-chapter-select__item--current' : ''; ?>">
						Ch. <?php echo esc_html( $cnum ); ?>
						<?php if ( $ch->post_title && $ch->post_title !== 'Chapter ' . $cnum ) : ?>
							<span class="mp-chapter-select__title"><?php echo esc_html( $ch->post_title ); ?></span>
						<?php endif; ?>
					</a>
				<?php endforeach; ?>
			</div>
		</div>
	</div>
</div>

<?php endwhile; endif; get_footer(); ?>
