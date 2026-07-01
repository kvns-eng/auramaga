/**
 * Manga Premium – Main JavaScript
 *
 * @package MangaPremium
 */

(function () {
	'use strict';

	/* ─── Dark Mode ─────────────────────────────────────── */
	var darkToggle = document.getElementById('mp-dark-toggle');
	var prefersDark = window.matchMedia('(prefers-color-scheme: dark)').matches;
	var storedTheme = localStorage.getItem('mp-theme');

	function setDark(isDark) {
		document.documentElement.classList.toggle('dark', isDark);
		document.body.classList.toggle('dark', isDark);
		localStorage.setItem('mp-theme', isDark ? 'dark' : 'light');
	}

	if (storedTheme === 'dark' || (!storedTheme && prefersDark)) {
		setDark(true);
	}

	if (darkToggle) {
		darkToggle.addEventListener('click', function () {
			var isDark = !document.documentElement.classList.contains('dark');
			setDark(isDark);
		});
	}

	/* ─── Header Scroll ─────────────────────────────────── */
	var header = document.querySelector('.mp-header');
	if (header) {
		var lastScroll = 0;
		window.addEventListener('scroll', function () {
			var scrollY = window.scrollY;
			header.classList.toggle('scrolled', scrollY > 10);
			lastScroll = scrollY;
		}, { passive: true });
	}

	/* ─── Mobile Menu ───────────────────────────────────── */
	var menuToggle = document.getElementById('mp-menu-toggle');
	var mobileMenu = document.getElementById('mp-mobile-menu');

	if (menuToggle && mobileMenu) {
		menuToggle.addEventListener('click', function () {
			var isOpen = mobileMenu.classList.toggle('open');
			menuToggle.classList.toggle('active', isOpen);
			menuToggle.setAttribute('aria-expanded', isOpen);
			mobileMenu.setAttribute('aria-hidden', !isOpen);
			document.body.style.overflow = isOpen ? 'hidden' : '';
		});
	}

	/* ─── Hero Slider ───────────────────────────────────── */
	var slider = document.getElementById('mp-hero-slider');
	if (slider) {
		var track = slider.querySelector('.mp-slider__track');
		var slides = slider.querySelectorAll('.mp-slider__slide');
		var prevBtn = slider.querySelector('.mp-slider__arrow--prev');
		var nextBtn = slider.querySelector('.mp-slider__arrow--next');
		var dotsContainer = slider.querySelector('.mp-slider__dots');
		var current = 0;
		var total = slides.length;
		var autoplayInterval;

		function goTo(index) {
			current = ((index % total) + total) % total;
			track.style.transform = 'translateX(-' + (current * 100) + '%)';
			updateDots();
		}

		function updateDots() {
			if (!dotsContainer) return;
			var dots = dotsContainer.querySelectorAll('.mp-slider__dot');
			dots.forEach(function (dot, i) {
				dot.classList.toggle('active', i === current);
			});
		}

		// Create dots.
		if (dotsContainer && total > 1) {
			for (var i = 0; i < total; i++) {
				var dot = document.createElement('button');
				dot.className = 'mp-slider__dot' + (i === 0 ? ' active' : '');
				dot.setAttribute('aria-label', 'Slide ' + (i + 1));
				dot.addEventListener('click', (function (idx) {
					return function () { goTo(idx); };
				})(i));
				dotsContainer.appendChild(dot);
			}
		}

		if (prevBtn) prevBtn.addEventListener('click', function () { goTo(current - 1); });
		if (nextBtn) nextBtn.addEventListener('click', function () { goTo(current + 1); });

		// Autoplay.
		function startAutoplay() {
			autoplayInterval = setInterval(function () { goTo(current + 1); }, 5000);
		}
		function stopAutoplay() {
			clearInterval(autoplayInterval);
		}

		if (total > 1) {
			startAutoplay();
			slider.addEventListener('mouseenter', stopAutoplay);
			slider.addEventListener('mouseleave', startAutoplay);

			// Touch swipe.
			var touchStartX = 0;
			slider.addEventListener('touchstart', function (e) {
				touchStartX = e.touches[0].clientX;
				stopAutoplay();
			}, { passive: true });
			slider.addEventListener('touchend', function (e) {
				var diff = touchStartX - e.changedTouches[0].clientX;
				if (Math.abs(diff) > 50) {
					diff > 0 ? goTo(current + 1) : goTo(current - 1);
				}
				startAutoplay();
			}, { passive: true });

			// Keyboard.
			document.addEventListener('keydown', function (e) {
				if (e.key === 'ArrowLeft') goTo(current - 1);
				if (e.key === 'ArrowRight') goTo(current + 1);
			});
		}
	}

	/* ─── Bookmark Toggle ───────────────────────────────── */
	var bookmarkBtns = document.querySelectorAll('.mp-bookmark-btn');
	bookmarkBtns.forEach(function (btn) {
		btn.addEventListener('click', function () {
			var mangaId = btn.getAttribute('data-manga-id');
			if (!mangaId || !mpData || !mpData.ajaxUrl) return;

			var formData = new FormData();
			formData.append('action', 'mp_toggle_bookmark');
			formData.append('nonce', mpData.nonce);
			formData.append('manga_id', mangaId);

			fetch(mpData.ajaxUrl, { method: 'POST', body: formData })
				.then(function (r) { return r.json(); })
				.then(function (data) {
					if (data.success) {
						btn.classList.toggle('mp-bookmarked', data.data.bookmarked);
					} else {
						alert(data.data || 'Please log in to bookmark.');
					}
				});
		});
	});

	/* ─── Share Button ──────────────────────────────────── */
	var shareBtn = document.querySelector('.mp-share-btn');
	if (shareBtn) {
		shareBtn.addEventListener('click', function () {
			if (navigator.share) {
				navigator.share({
					title: document.title,
					url: window.location.href,
				});
			} else {
				navigator.clipboard.writeText(window.location.href);
				alert('Link copied to clipboard!');
			}
		});
	}

	/* ─── Live Search ───────────────────────────────────── */
	var searchInputs = document.querySelectorAll('.mp-header__search-input');
	var debounceTimer;

	searchInputs.forEach(function (input) {
		input.addEventListener('input', function () {
			clearTimeout(debounceTimer);
			var q = input.value.trim();

			if (q.length < 2) return;

			debounceTimer = setTimeout(function () {
				if (!mpData || !mpData.ajaxUrl) return;

				var formData = new FormData();
				formData.append('action', 'mp_search');
				formData.append('nonce', mpData.nonce);
				formData.append('q', q);

				fetch(mpData.ajaxUrl, { method: 'POST', body: formData })
					.then(function (r) { return r.json(); })
					.then(function (data) {
						// Live search results would appear in a dropdown.
						// For now, the form submits to the search page.
					});
			}, 350);
		});
	});

})();
