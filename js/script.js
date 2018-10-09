'use strict';

jQuery(document).ready(function ($) {
	// animation controls
	var controller = new ScrollMagic.Controller();
	function scrollReveal(elem, time) {
		TweenMax.to(elem, 0, { css: { opacity: '0' } });
		new ScrollMagic.Scene({
			triggerElement: elem,
			offset: '-200px',
			reverse: false
		}).setTween(elem, time, { css: { opacity: '1' } }).addTo(controller);
	}

	var $cards = $('.mainContainer__innerWrapper');
	for (var i = 0; i < $cards.length; i += 1) {
		scrollReveal($cards[i], 2);
	}

	var $voterLinks = $('.voterLinks');

	var _loop = function _loop(_i) {
		var href = $($voterLinks[_i]).attr('data-href');
		$($voterLinks[_i]).on('click', function (e) {
			e.preventDefault();
			window.location = href;
		});
	};

	for (var _i = 0; _i < $voterLinks.length; _i += 1) {
		_loop(_i);
	}
});

jQuery(document).ready(function ($) {
	'use strict';

	// Select all links with hashes

	$('a[href*="#"]')
	// Remove links that don't actually link to anything
	.not('[href="#"]').not('[href="#0"]').click(function (event) {
		// On-page links
		if (location.pathname.replace(/^\//, '') == this.pathname.replace(/^\//, '') && location.hostname == this.hostname) {
			// Figure out element to scroll to
			var target = $(this.hash);
			target = target.length ? target : $('[name=' + this.hash.slice(1) + ']');
			// Does a scroll target exist?
			if (target.length) {
				// Only prevent default if animation is actually gonna happen
				event.preventDefault();
				$('html, body').animate({
					scrollTop: target.offset().top
				}, 500, function () {
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
				});
			}
		}
	});
});