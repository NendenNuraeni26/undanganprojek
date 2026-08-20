/* =========================================================
   ANIMASI UNDANGAN DIGITAL
   Semua animasi ada di file ini agar mudah diatur.
   ========================================================= */
(function () {
	'use strict';

	const reduceMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;
	const pages = [...document.querySelectorAll('.page')];
	const navButtons = [...document.querySelectorAll('.side-nav button')];

	const animatedSelectors = [
		'.small-title', '.page h1', '.page h2', '.lead', '.save-subtitle',
		'.cover-date', '.hero-button', '.illustration', '.person-block',
		'.event-item', '.gallery-grid img', '.gift-card',
		'.page-rsvp form input', '.page-rsvp form select', '.page-rsvp form textarea'
	];

	function prepareElements() {
		document.body.classList.add('js-ready');
		pages.forEach((page) => {
			animatedSelectors.forEach((selector) => {
				page.querySelectorAll(selector).forEach((element, index) => {
					element.classList.add('reveal-item');
					element.style.setProperty('--reveal-delay', `${Math.min(index * 140, 840)}ms`);
				});
			});
		});
	}

	function showPage(page, replay = false) {
		if (replay) {
			page.classList.remove('is-visible');
			void page.offsetWidth;
		}
		page.classList.add('is-visible');
		const pageIndex = pages.indexOf(page);
		navButtons.forEach((button, index) => {
			button.classList.toggle('active', index === pageIndex || (pageIndex === 7 && index === 7));
		});
	}

	function resetPage(page) {
		if (!page.classList.contains('page-entering') && !page.classList.contains('page-leaving')) {
			page.classList.remove('is-visible');
		}
	}

	function startAnimations() {
		prepareElements();

		if (reduceMotion || !('IntersectionObserver' in window)) {
			pages.forEach(showPage);
			return;
		}

		const observer = new IntersectionObserver((entries) => {
			entries.forEach((entry) => {
				if (entry.isIntersecting) {
					const replay = entry.target.dataset.inViewport === 'false';
					entry.target.dataset.inViewport = 'true';
					showPage(entry.target, replay);
				} else {
					entry.target.dataset.inViewport = 'false';
					resetPage(entry.target);
				}
			});
		}, { threshold: 0.35 });

		pages.forEach((page) => observer.observe(page));
		requestAnimationFrame(() => showPage(pages[0]));
	}

	function addButtonMotion() {
		document.querySelectorAll('.hero-button, .side-nav button, .music').forEach((button) => {
			button.addEventListener('pointerdown', () => button.classList.add('is-pressed'));
			button.addEventListener('pointerup', () => button.classList.remove('is-pressed'));
			button.addEventListener('pointerleave', () => button.classList.remove('is-pressed'));
		});
	}

	function addGalleryMotion() {
		document.querySelectorAll('.gallery-grid img').forEach((image) => {
			image.addEventListener('pointermove', (event) => {
				if (reduceMotion) return;
				const rect = image.getBoundingClientRect();
				const rotateX = ((event.clientY - rect.top) / rect.height - 0.5) * -4;
				const rotateY = ((event.clientX - rect.left) / rect.width - 0.5) * 4;
				image.style.transform = `perspective(500px) rotateX(${rotateX}deg) rotateY(${rotateY}deg) scale(1.025)`;
			});
			image.addEventListener('pointerleave', () => { image.style.transform = ''; });
		});
	}

	function addNavigationMotion() {
		const originalGoTo = window.goTo;
		if (typeof originalGoTo !== 'function') return;

		window.goTo = function (id) {
			const target = document.getElementById(id);
			const current = document.querySelector('.page.is-visible');

			if (!target || target === current || reduceMotion) {
				originalGoTo(id);
				return;
			}

			if (current) current.classList.add('page-leaving');
			target.classList.remove('is-visible', 'page-entering');
			void target.offsetWidth;
			target.classList.add('page-entering');
			originalGoTo(id);

			window.setTimeout(() => {
				target.classList.add('is-visible');
				target.classList.remove('page-entering');
				if (current) current.classList.remove('is-visible', 'page-leaving');
			}, 1150);
		};
	}

	function init() {
		startAnimations();
		addButtonMotion();
		addGalleryMotion();
		addNavigationMotion();
	}

	if (document.readyState === 'loading') {
		document.addEventListener('DOMContentLoaded', init, { once: true });
	} else {
		init();
	}
}());
