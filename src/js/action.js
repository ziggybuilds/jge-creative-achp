jQuery(document).ready(($) => {
	// pop up functionality
	if ($('.popUp')) {
		const $popUp = $('.popUp');
		$popUp.hide();

		$('#popUpTrigger').on('click', () => {
			if ($popUp.is(":visible") === false) {
				$popUp.fadeIn('fast');
			}
		});

		$('#popUpClose').on('click', (e) => {
			e.preventDefault();
			if ($popUp.is(':visible') === true) {
				// reloads the iframe to stop the video
				const iframes = $('iframe');
				if (iframes != null) {
					for (let i = 0; i < iframes.length; i += 1) {
						iframes[i].src = iframes[i].src;
					}
				}
				$popUp.fadeOut('fast');
			}
		});
	}

	// animation controls
	const controller = new ScrollMagic.Controller();
	function scrollReveal(elem) {
		TweenMax.to(elem, 0, { css: { opacity: '0' } });
		new ScrollMagic.Scene({
			triggerElement: elem,
			offset: '-50px',
			reverse: false,
		})
			.setTween(elem, 1, { css: { opacity: '1' } })
			.addTo(controller);
	}

	// feed__articles__article
	(function() {
		const $articles = $('.feed__articles__article');
		for (let i = 0; i < $articles.length; i += 1) {
			scrollReveal($articles[i]);
		}
	})();

	// header animation styling
	// header text
	const $heroTitle = $('.header__titleWrapper__title');
	const $heroSubTitle = $('.header__titleWrapper__subtitle');
	const tl = new TimelineMax()
		.set($heroTitle, { x: -50 })
		.set($heroTitle, { css: { opacity: '0' } })
		.set($heroSubTitle, { x: -50 })
		.set($heroSubTitle, { css: { opacity: '0' } })
		.to($heroTitle, 1, { x: 0 })
		.to($heroTitle, 2, { css: { opacity: '1' } }, '-=0.8')
		.to($heroSubTitle, 1, { x: 0 }, '-=1')
		.to($heroSubTitle, 2, { css: { opacity: '1' } }, '-=.8');
});
