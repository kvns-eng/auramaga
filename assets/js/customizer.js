/**
 * Manga Premium – Customizer Live Preview
 *
 * @package MangaPremium
 */

(function ($) {
	'use strict';

	wp.customize('mp_primary_color', function (value) {
		value.bind(function (to) {
			document.documentElement.style.setProperty('--mp-primary', to);
		});
	});

	wp.customize('mp_accent_color', function (value) {
		value.bind(function (to) {
			document.documentElement.style.setProperty('--mp-accent', to);
		});
	});

})(jQuery);
