<?php
/**
 * Breadcrumbs
 *
 * @package MangaPremium
 */

defined( 'ABSPATH' ) || exit;

function mp_breadcrumbs() {
	if ( is_front_page() ) {
		return;
	}

	echo '<nav class="mp-breadcrumbs" aria-label="' . esc_attr__( 'Breadcrumb', 'manga-premium' ) . '">';
	echo '<ol class="mp-breadcrumbs__list" itemscope itemtype="https://schema.org/BreadcrumbList">';

	// Home.
	echo '<li class="mp-breadcrumbs__item" itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem">';
	echo '<a href="' . esc_url( home_url( '/' ) ) . '" itemprop="item"><span itemprop="name">' . esc_html__( 'Home', 'manga-premium' ) . '</span></a>';
	echo '<meta itemprop="position" content="1" />';
	echo '</li>';

	$position = 2;

	if ( is_singular( 'mp_chapter' ) ) {
		$manga_id = mp_get_meta( get_the_ID(), 'manga_id', '' );
		if ( $manga_id ) {
			echo '<li class="mp-breadcrumbs__item" itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem">';
			echo '<a href="' . esc_url( get_post_type_archive_link( 'manga' ) ) . '" itemprop="item"><span itemprop="name">' . esc_html__( 'Manga', 'manga-premium' ) . '</span></a>';
			echo '<meta itemprop="position" content="' . $position . '" />';
			echo '</li>';
			$position++;

			echo '<li class="mp-breadcrumbs__item" itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem">';
			echo '<a href="' . esc_url( get_permalink( $manga_id ) ) . '" itemprop="item"><span itemprop="name">' . esc_html( get_the_title( $manga_id ) ) . '</span></a>';
			echo '<meta itemprop="position" content="' . $position . '" />';
			echo '</li>';
			$position++;
		}

		echo '<li class="mp-breadcrumbs__item mp-breadcrumbs__item--current" itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem">';
		echo '<span itemprop="name">' . esc_html( get_the_title() ) . '</span>';
		echo '<meta itemprop="position" content="' . $position . '" />';
		echo '</li>';

	} elseif ( is_singular( 'manga' ) ) {
		echo '<li class="mp-breadcrumbs__item" itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem">';
		echo '<a href="' . esc_url( get_post_type_archive_link( 'manga' ) ) . '" itemprop="item"><span itemprop="name">' . esc_html__( 'Manga', 'manga-premium' ) . '</span></a>';
		echo '<meta itemprop="position" content="' . $position . '" />';
		echo '</li>';
		$position++;

		echo '<li class="mp-breadcrumbs__item mp-breadcrumbs__item--current" itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem">';
		echo '<span itemprop="name">' . esc_html( get_the_title() ) . '</span>';
		echo '<meta itemprop="position" content="' . $position . '" />';
		echo '</li>';

	} elseif ( is_post_type_archive( 'manga' ) ) {
		echo '<li class="mp-breadcrumbs__item mp-breadcrumbs__item--current" itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem">';
		echo '<span itemprop="name">' . esc_html__( 'Browse Manga', 'manga-premium' ) . '</span>';
		echo '<meta itemprop="position" content="' . $position . '" />';
		echo '</li>';

	} elseif ( is_tax() ) {
		$tax = get_taxonomy( get_queried_object()->taxonomy );
		echo '<li class="mp-breadcrumbs__item" itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem">';
		echo '<a href="' . esc_url( get_post_type_archive_link( 'manga' ) ) . '" itemprop="item"><span itemprop="name">' . esc_html__( 'Manga', 'manga-premium' ) . '</span></a>';
		echo '<meta itemprop="position" content="' . $position . '" />';
		echo '</li>';
		$position++;

		echo '<li class="mp-breadcrumbs__item mp-breadcrumbs__item--current" itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem">';
		echo '<span itemprop="name">' . esc_html( single_term_title( '', false ) ) . '</span>';
		echo '<meta itemprop="position" content="' . $position . '" />';
		echo '</li>';

	} elseif ( is_search() ) {
		echo '<li class="mp-breadcrumbs__item mp-breadcrumbs__item--current" itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem">';
		echo '<span itemprop="name">' . sprintf( esc_html__( 'Search: %s', 'manga-premium' ), esc_html( get_search_query() ) ) . '</span>';
		echo '<meta itemprop="position" content="' . $position . '" />';
		echo '</li>';

	} elseif ( is_404() ) {
		echo '<li class="mp-breadcrumbs__item mp-breadcrumbs__item--current" itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem">';
		echo '<span itemprop="name">' . esc_html__( 'Page Not Found', 'manga-premium' ) . '</span>';
		echo '<meta itemprop="position" content="' . $position . '" />';
		echo '</li>';
	}

	echo '</ol></nav>';
}
