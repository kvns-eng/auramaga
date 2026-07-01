/**
 * Manga Premium – Chapter Reader JavaScript
 *
 * @package MangaPremium
 */

(function () {
	'use strict';

	var reader = document.getElementById('mp-reader');
	if (!reader) return;

	var toolbarTop = document.getElementById('mp-reader-toolbar-top');
	var toolbarBottom = document.getElementById('mp-reader-toolbar-bottom');
	var content = document.getElementById('mp-reader-content');
	var pagesContainer = document.getElementById('mp-reader-pages');
	var pageIndicator = document.getElementById('mp-page-indicator');
	var settingsBtn = document.getElementById('mp-reader-settings-btn');
	var chaptersBtn = document.getElementById('mp-reader-chapters-btn');
	var settingsModal = document.getElementById('mp-reader-settings-modal');
	var chaptersModal = document.getElementById('mp-reader-chapters-modal');
	var fullscreenBtn = document.getElementById('mp-reader-fullscreen-btn');

	// Reader settings.
	var state = {
		mode: reader.getAttribute('data-default-mode') || 'longstrip',
		bg: reader.getAttribute('data-default-bg') || 'dark',
		fit: reader.getAttribute('data-default-fit') || 'width',
	};

	// Restore from localStorage.
	var saved = localStorage.getItem('mp-reader-prefs');
	if (saved) {
		try {
			var prefs = JSON.parse(saved);
			if (prefs.mode) state.mode = prefs.mode;
			if (prefs.bg) state.bg = prefs.bg;
			if (prefs.fit) state.fit = prefs.fit;
		} catch (e) { /* ignore */ }
	}

	function applySettings() {
		reader.setAttribute('data-bg', state.bg);
		reader.setAttribute('data-fit', state.fit);
		reader.setAttribute('data-mode', state.mode);

		// Update active states in settings modal.
		document.querySelectorAll('[data-setting="mode"]').forEach(function (btn) {
			btn.classList.toggle('mp-settings-btn--active', btn.getAttribute('data-value') === state.mode);
		});
		document.querySelectorAll('[data-setting="bg"]').forEach(function (btn) {
			btn.classList.toggle('mp-settings-btn--active', btn.getAttribute('data-value') === state.bg);
		});
		document.querySelectorAll('[data-setting="fit"]').forEach(function (btn) {
			btn.classList.toggle('mp-settings-btn--active', btn.getAttribute('data-value') === state.fit);
		});

		// Save.
		localStorage.setItem('mp-reader-prefs', JSON.stringify(state));
	}

	applySettings();

	/* ─── Settings Buttons ──────────────────────────────── */
	document.querySelectorAll('.mp-settings-btn').forEach(function (btn) {
		btn.addEventListener('click', function () {
			var setting = btn.getAttribute('data-setting');
			var value = btn.getAttribute('data-value');
			if (setting && value) {
				state[setting] = value;
				applySettings();
			}
		});
	});

	/* ─── Toolbar Show/Hide ─────────────────────────────── */
	var hideTimer;
	var toolbarVisible = true;

	function showToolbars() {
		toolbarVisible = true;
		if (toolbarTop) toolbarTop.classList.remove('hidden');
		if (toolbarBottom) toolbarBottom.classList.remove('hidden');
		resetHideTimer();
	}

	function hideToolbars() {
		toolbarVisible = false;
		if (toolbarTop) toolbarTop.classList.add('hidden');
		if (toolbarBottom) toolbarBottom.classList.add('hidden');
	}

	function resetHideTimer() {
		clearTimeout(hideTimer);
		hideTimer = setTimeout(hideToolbars, 4000);
	}

	// Toggle on content click.
	if (content) {
		content.addEventListener('click', function (e) {
			if (e.target.tagName === 'IMG') return;
			if (toolbarVisible) {
				hideToolbars();
			} else {
				showToolbars();
			}
		});
	}

	document.addEventListener('mousemove', showToolbars);
	document.addEventListener('touchstart', showToolbars, { passive: true });
	resetHideTimer();

	/* ─── Modals ────────────────────────────────────────── */
	function openModal(modal) {
		if (!modal) return;
		modal.classList.add('open');
		modal.setAttribute('aria-hidden', 'false');
	}

	function closeModal(modal) {
		if (!modal) return;
		modal.classList.remove('open');
		modal.setAttribute('aria-hidden', 'true');
	}

	if (settingsBtn && settingsModal) {
		settingsBtn.addEventListener('click', function () {
			openModal(settingsModal);
		});
	}

	if (chaptersBtn && chaptersModal) {
		chaptersBtn.addEventListener('click', function () {
			openModal(chaptersModal);
		});
	}

	// Close modals.
	document.querySelectorAll('.mp-modal__close, .mp-modal__overlay').forEach(function (el) {
		el.addEventListener('click', function () {
			var modal = el.closest('.mp-modal');
			if (modal) closeModal(modal);
		});
	});

	document.addEventListener('keydown', function (e) {
		if (e.key === 'Escape') {
			document.querySelectorAll('.mp-modal.open').forEach(closeModal);
		}
	});

	/* ─── Fullscreen ────────────────────────────────────── */
	if (fullscreenBtn) {
		fullscreenBtn.addEventListener('click', function () {
			if (!document.fullscreenElement) {
				document.documentElement.requestFullscreen().catch(function () {});
			} else {
				document.exitFullscreen().catch(function () {});
			}
		});
	}

	/* ─── Keyboard Navigation ───────────────────────────── */
	document.addEventListener('keydown', function (e) {
		// Don't intercept if modal is open or user is typing.
		if (document.querySelector('.mp-modal.open')) return;
		if (e.target.tagName === 'INPUT' || e.target.tagName === 'TEXTAREA') return;

		var pages = document.querySelectorAll('.mp-reader__page-img');
		if (pages.length === 0) return;

		switch (e.key) {
			case 'ArrowLeft':
				navigatePrev();
				break;
			case 'ArrowRight':
				navigateNext();
				break;
			case 'f':
				fullscreenBtn && fullscreenBtn.click();
				break;
		}
	});

	/* ─── Page Tracking & Navigation ────────────────────── */
	var pages = document.querySelectorAll('.mp-reader__page-img');
	var currentVisiblePage = 1;

	if (pages.length > 0 && pageIndicator) {
		pageIndicator.textContent = '1 / ' + pages.length;

		// Intersection Observer for tracking visible page.
		var observer = new IntersectionObserver(function (entries) {
			entries.forEach(function (entry) {
				if (entry.isIntersecting) {
					var pageNum = parseInt(entry.target.getAttribute('data-page'), 10);
					if (pageNum) {
						currentVisiblePage = pageNum;
						pageIndicator.textContent = pageNum + ' / ' + pages.length;

						// Save progress.
						saveProgress(pageNum);
					}
				}
			});
		}, { threshold: 0.5 });

		pages.forEach(function (page) {
			observer.observe(page);
		});
	}

	function saveProgress(pageNum) {
		if (!window.mpReaderData || !mpReaderData.nonce || !mpReaderData.chapterId) return;

		var formData = new FormData();
		formData.append('action', 'mp_save_progress');
		formData.append('nonce', mpReaderData.nonce);
		formData.append('manga_id', mpReaderData.mangaId);
		formData.append('chapter_id', mpReaderData.chapterId);
		formData.append('page', pageNum);

		fetch(mpReaderData.ajaxUrl || (window.mpData && mpData.ajaxUrl) || '/wp-admin/admin-ajax.php', {
			method: 'POST',
			body: formData,
		}).catch(function () { /* silently fail */ });
	}

	function navigatePrev() {
		if (!window.mpReaderData || !mpReaderData.nav || !mpReaderData.nav.prev) return;
		window.location.href = mpReaderData.nav.prev.url;
	}

	function navigateNext() {
		if (!window.mpReaderData || !mpReaderData.nav || !mpReaderData.nav.next) return;
		window.location.href = mpReaderData.nav.next.url;
	}

})();
