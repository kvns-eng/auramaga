<?php
/**
 * Custom Navigation Walker
 *
 * @package MangaPremium
 */

defined( 'ABSPATH' ) || exit;

class Manga_Walker_Nav extends Walker_Nav_Menu {

	public function start_lvl( &$output, $depth = 0, $args = null ) {
		$indent  = str_repeat( "\t", $depth );
		$output .= "\n{$indent}<ul class=\"mp-nav__submenu\">\n";
	}

	public function start_el( &$output, $item, $depth = 0, $args = null, $id = 0 ) {
		$indent = str_repeat( "\t", $depth );
		$classes   = array( 'mp-nav__item' );
		$classes[] = 'menu-item-' . $item->ID;

		if ( $item->current ) {
			$classes[] = 'mp-nav__item--current';
		}
		if ( in_array( 'menu-item-has-children', $item->classes, true ) ) {
			$classes[] = 'mp-nav__item--has-children';
		}

		$class_names = implode( ' ', array_filter( $classes ) );
		$output     .= "{$indent}<li class=\"" . esc_attr( $class_names ) . '">';

		$atts = array(
			'title'  => $item->attr_title,
			'target' => $item->target,
			'rel'    => $item->xfn,
			'href'   => $item->url,
			'class'  => 'mp-nav__link',
		);

		$output .= '<a';
		foreach ( $atts as $attr => $value ) {
			if ( ! empty( $value ) ) {
				$output .= ' ' . $attr . '="' . esc_attr( $value ) . '"';
			}
		}
		$output .= '>';
		$output .= esc_html( $item->title );
		$output .= '</a>';
	}
}
