jQuery(document).ready(($) => {
	// animation controls
	const controller = new ScrollMagic.Controller();
	function scrollReveal(elem, time) {
		TweenMax.to(elem, 0, { css: { opacity: '0' } });
		new ScrollMagic.Scene({
			triggerElement: elem,
			offset: '-200px',
			reverse: false,
		})
			.setTween(elem, time, { css: { opacity: '1' } })
			.addTo(controller);
	}

	// carousel controls and init
	const $slideshow = $('.carousel__innerWrapper__slider');

	// carousel nav icon control
	const $navIcons = $('.carousel__navIcons');
	function navIconControl() {
		for (let i = 0; i < $navIcons.length; i += 1) {
			$($navIcons[i]).on('click', (e) => {
				e.preventDefault();
				// pass method and index to slick class
				$slideshow.slick('slickGoTo', i, true);
			});
		}
	}
	navIconControl();

	// carousel nav highlighting
	$($navIcons[0]).parent().addClass('active-nav');
	$($slideshow).on('afterChange', function(event, slick, currentSlide) {
		for (let i = 0; i < $navIcons.length; i += 1) {
			if ($($navIcons[i]).parent().hasClass('active-nav')) {
				$($navIcons[i]).parent().removeClass('active-nav');
			}
		}
		$($navIcons[currentSlide]).parent().addClass('active-nav');
	});

	$slideshow.slick({
		dots: true,
		appendDots: '.carousel__innerWrapper__dots',
		arrows: false,
		speed: 500,
		fade: true,
		cssEase: 'linear',
	});

	// Add button controls
	function hrefBtnControl(tag) {
		const $arr = $(tag);
		if ($arr) {
			for (let i = 0; i < $arr.length; i += 1) {
				$($arr[i]).on('click', (e) => {
					e.preventDefault();
					const href = $($arr[i]).attr('data-href');
					window.location = href;
				});
			}
		}
	}
	hrefBtnControl('.duotone-cards__innerWrapper__card');
	hrefBtnControl('.carouselButton');
	hrefBtnControl('.largeCardButton');
	hrefBtnControl('.imageCalloutButton');
});
