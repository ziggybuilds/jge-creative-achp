'use strict';

jQuery(document).ready(function ($) {
	// pop up functionality
	if ($('.popUp')) {
		var $popUp = $('.popUp');
		$popUp.hide();

		$('#popUpTrigger').on('click', function () {
			if ($popUp.is(":visible") === false) {
				$popUp.fadeIn('fast');
			}
		});

		$('#popUpClose').on('click', function (e) {
			e.preventDefault();
			if ($popUp.is(':visible') === true) {
				// reloads the iframe to stop the video
				var iframes = $('iframe');
				if (iframes != null) {
					for (var i = 0; i < iframes.length; i += 1) {
						iframes[i].src = iframes[i].src;
					}
				}
				$popUp.fadeOut('fast');
			}
		});
	}

	// animation controls
	var controller = new ScrollMagic.Controller();
	function scrollReveal(elem) {
		TweenMax.to(elem, 0, { css: { opacity: '0' } });
		new ScrollMagic.Scene({
			triggerElement: elem,
			offset: '-50px',
			reverse: false
		}).setTween(elem, 1, { css: { opacity: '1' } }).addTo(controller);
	}

	// feed__articles__article
	(function () {
		var $articles = $('.feed__articles__article');
		for (var i = 0; i < $articles.length; i += 1) {
			scrollReveal($articles[i]);
		}
	})();

	// header animation styling
	// header text
	var $heroTitle = $('.header__titleWrapper__title');
	var $heroSubTitle = $('.header__titleWrapper__subtitle');
	var tl = new TimelineMax().set($heroTitle, { x: -50 }).set($heroTitle, { css: { opacity: '0' } }).set($heroSubTitle, { x: -50 }).set($heroSubTitle, { css: { opacity: '0' } }).to($heroTitle, 1, { x: 0 }).to($heroTitle, 2, { css: { opacity: '1' } }, '-=0.8').to($heroSubTitle, 1, { x: 0 }, '-=1').to($heroSubTitle, 2, { css: { opacity: '1' } }, '-=.8');
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