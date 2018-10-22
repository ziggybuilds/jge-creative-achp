jQuery(document).ready(function($) {
	'use strict';
	function mobileMenu() {
		const $mobileBtn = $('#menuBtn');
		if ($mobileBtn != undefined) {
			const $menu = $('.menu-header-container');
			$menu.addClass('inactive');
			$mobileBtn.on('click', (e) => {
				e.preventDefault();
				if ($menu.hasClass('active')) {
					$mobileBtn.removeClass('active');
					$menu.addClass('inactive');
					$menu.removeClass('active');
					TweenMax.to($menu, 0, { css: {opacity: 0} });
				} else {
					$mobileBtn.addClass('active');
					$menu.removeClass('inactive');
					$menu.addClass('active');
					TweenMax.to($menu, 0.2, { css: {opacity: 1} });
				}
			});
		}
	}
	mobileMenu();

	// Select all links with hashes
	$('a[href*="#"]')
		// Remove links that don't actually link to anything
		.not('[href="#"]')
		.not('[href="#0"]')
		.click(function(event) {
			// On-page links
			if (
				location.pathname.replace(/^\//, '') ==
					this.pathname.replace(/^\//, '') &&
				location.hostname == this.hostname
			) {
				// Figure out element to scroll to
				var target = $(this.hash);
				target = target.length
					? target
					: $('[name=' + this.hash.slice(1) + ']');
				// Does a scroll target exist?
				if (target.length) {
					// Only prevent default if animation is actually gonna happen
					event.preventDefault();
					$('html, body').animate(
						{
							scrollTop: target.offset().top,
						},
						500,
						function() {
							// Callback after animation
							// Must change focus!
							var $target = $(target);
							$target.focus();
							if ($target.is(':focus')) {
								// Checking if the target was focused
								return false;
							} else {
								$target.attr('tabindex', '-1'); // Adding tabindex for elements not focusable
								$target.focus(); // Set focus again
							}
						},
					);
				}
			}
		});
});
