<?php
/**
 * Theme Options / Customizer
 *
 * @package MangaPremium
 */

defined( 'ABSPATH' ) || exit;

function manga_premium_customize_register( $wp_customize ) {

	/* ─── Theme Options Panel ───────────────────────── */
	$wp_customize->add_panel( 'mp_panel', array(
		'title'    => esc_html__( 'Manga Premium Settings', 'manga-premium' ),
		'priority' => 30,
	) );

	/* ─── General Section ───────────────────────────── */
	$wp_customize->add_section( 'mp_general', array(
		'title' => esc_html__( 'General', 'manga-premium' ),
		'panel' => 'mp_panel',
	) );

	// Primary Color.
	$wp_customize->add_setting( 'mp_primary_color', array(
		'default'           => '#0078d4',
		'sanitize_callback' => 'sanitize_hex_color',
		'transport'         => 'postMessage',
	) );
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'mp_primary_color', array(
		'label'   => esc_html__( 'Primary Color', 'manga-premium' ),
		'section' => 'mp_general',
	) ) );

	// Accent Color.
	$wp_customize->add_setting( 'mp_accent_color', array(
		'default'           => '#6366f1',
		'sanitize_callback' => 'sanitize_hex_color',
		'transport'         => 'postMessage',
	) );
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'mp_accent_color', array(
		'label'   => esc_html__( 'Accent Color', 'manga-premium' ),
		'section' => 'mp_general',
	) ) );

	// Dark Mode Default.
	$wp_customize->add_setting( 'mp_dark_mode_default', array(
		'default'           => '0',
		'sanitize_callback' => 'absint',
	) );
	$wp_customize->add_control( 'mp_dark_mode_default', array(
		'label'   => esc_html__( 'Default to Dark Mode', 'manga-premium' ),
		'section' => 'mp_general',
		'type'    => 'checkbox',
	) );

	/* ─── Header Section ────────────────────────────── */
	$wp_customize->add_section( 'mp_header', array(
		'title' => esc_html__( 'Header', 'manga-premium' ),
		'panel' => 'mp_panel',
	) );

	$wp_customize->add_setting( 'mp_header_layout', array(
		'default'           => 'default',
		'sanitize_callback' => 'sanitize_text_field',
	) );
	$wp_customize->add_control( 'mp_header_layout', array(
		'label'   => esc_html__( 'Header Layout', 'manga-premium' ),
		'section' => 'mp_header',
		'type'    => 'select',
		'choices' => array(
			'default'  => esc_html__( 'Default', 'manga-premium' ),
			'centered' => esc_html__( 'Centered', 'manga-premium' ),
			'minimal'  => esc_html__( 'Minimal', 'manga-premium' ),
		),
	) );

	/* ─── Homepage Section ──────────────────────────── */
	$wp_customize->add_section( 'mp_homepage', array(
		'title' => esc_html__( 'Homepage', 'manga-premium' ),
		'panel' => 'mp_panel',
	) );

	$wp_customize->add_setting( 'mp_slider_layout', array(
		'default'           => 'hero',
		'sanitize_callback' => 'sanitize_text_field',
	) );
	$wp_customize->add_control( 'mp_slider_layout', array(
		'label'   => esc_html__( 'Slider Layout', 'manga-premium' ),
		'section' => 'mp_homepage',
		'type'    => 'select',
		'choices' => array(
			'hero'    => esc_html__( 'Hero Banner', 'manga-premium' ),
			'carousel' => esc_html__( 'Carousel', 'manga-premium' ),
			'compact'  => esc_html__( 'Compact', 'manga-premium' ),
		),
	) );

	$wp_customize->add_setting( 'mp_featured_count', array(
		'default'           => '6',
		'sanitize_callback' => 'absint',
	) );
	$wp_customize->add_control( 'mp_featured_count', array(
		'label'       => esc_html__( 'Featured Manga Count', 'manga-premium' ),
		'section'     => 'mp_homepage',
		'type'        => 'number',
		'input_attrs' => array( 'min' => 3, 'max' => 12 ),
	) );

	/* ─── Reader Section ────────────────────────────── */
	$wp_customize->add_section( 'mp_reader', array(
		'title' => esc_html__( 'Reader Defaults', 'manga-premium' ),
		'panel' => 'mp_panel',
	) );

	$wp_customize->add_setting( 'mp_reader_mode', array(
		'default'           => 'longstrip',
		'sanitize_callback' => 'sanitize_text_field',
	) );
	$wp_customize->add_control( 'mp_reader_mode', array(
		'label'   => esc_html__( 'Default Reading Mode', 'manga-premium' ),
		'section' => 'mp_reader',
		'type'    => 'select',
		'choices' => array(
			'longstrip'  => esc_html__( 'Long Strip (Webtoon)', 'manga-premium' ),
			'singlepage' => esc_html__( 'Single Page', 'manga-premium' ),
		),
	) );

	$wp_customize->add_setting( 'mp_reader_bg', array(
		'default'           => 'dark',
		'sanitize_callback' => 'sanitize_text_field',
	) );
	$wp_customize->add_control( 'mp_reader_bg', array(
		'label'   => esc_html__( 'Default Reader Background', 'manga-premium' ),
		'section' => 'mp_reader',
		'type'    => 'select',
		'choices' => array(
			'dark'  => esc_html__( 'Dark', 'manga-premium' ),
			'light' => esc_html__( 'Light', 'manga-premium' ),
			'sepia' => esc_html__( 'Sepia', 'manga-premium' ),
		),
	) );

	$wp_customize->add_setting( 'mp_reader_image_fit', array(
		'default'           => 'width',
		'sanitize_callback' => 'sanitize_text_field',
	) );
	$wp_customize->add_control( 'mp_reader_image_fit', array(
		'label'   => esc_html__( 'Default Image Fit', 'manga-premium' ),
		'section' => 'mp_reader',
		'type'    => 'select',
		'choices' => array(
			'contain'  => esc_html__( 'Contain', 'manga-premium' ),
			'width'    => esc_html__( 'Fit to Width', 'manga-premium' ),
			'original' => esc_html__( 'Original Size', 'manga-premium' ),
		),
	) );
}
add_action( 'customize_register', 'manga_premium_customize_register' );

/* ─── Customizer Live Preview JS ──────────────────────── */
function manga_premium_customize_preview_js() {
	wp_enqueue_script(
		'manga-premium-customizer',
		MP_URI . '/assets/js/customizer.js',
		array( 'customize-preview' ),
		MP_VERSION,
		true
	);
}
add_action( 'customize_preview_init', 'manga_premium_customize_preview_js' );

/* ─── Output CSS Variables ────────────────────────────── */
function manga_premium_css_variables() {
	$primary = get_theme_mod( 'mp_primary_color', '#0078d4' );
	$accent  = get_theme_mod( 'mp_accent_color', '#6366f1' );

	$css = ":root {\n";
	$css .= "  --mp-primary: " . esc_attr( $primary ) . ";\n";
	$css .= "  --mp-primary-hover: " . esc_attr( mp_darken_hex( $primary, 10 ) ) . ";\n";
	$css .= "  --mp-primary-active: " . esc_attr( mp_darken_hex( $primary, 20 ) ) . ";\n";
	$css .= "  --mp-primary-light: " . esc_attr( mp_hex_to_rgba( $primary, 0.1 ) ) . ";\n";
	$css .= "  --mp-accent: " . esc_attr( $accent ) . ";\n";
	$css .= "}\n";

	echo '<style id="mp-dynamic-css">' . $css . '</style>' . "\n";
}
add_action( 'wp_head', 'manga_premium_css_variables', 15 );

/* ─── Hex Helpers ─────────────────────────────────────── */
function mp_darken_hex( $hex, $percent ) {
	$hex = ltrim( $hex, '#' );
	$r   = max( 0, hexdec( substr( $hex, 0, 2 ) ) - ( 255 * $percent / 100 ) );
	$g   = max( 0, hexdec( substr( $hex, 2, 2 ) ) - ( 255 * $percent / 100 ) );
	$b   = max( 0, hexdec( substr( $hex, 4, 2 ) ) - ( 255 * $percent / 100 ) );
	return '#' . sprintf( '%02x%02x%02x', $r, $g, $b );
}

function mp_hex_to_rgba( $hex, $alpha ) {
	$hex = ltrim( $hex, '#' );
	$r   = hexdec( substr( $hex, 0, 2 ) );
	$g   = hexdec( substr( $hex, 2, 2 ) );
	$b   = hexdec( substr( $hex, 4, 2 ) );
	return "rgba($r, $g, $b, $alpha)";
}
