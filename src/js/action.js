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

	const $cards = $('.mainContainer__innerWrapper');
	for (let i = 0; i < $cards.length; i += 1) {
		scrollReveal($cards[i], 2);
	}

	const $voterLinks = $('.voterLinks');
	for (let i = 0; i < $voterLinks.length; i += 1) {
		const href = $($voterLinks[i]).attr('data-href');
		$($voterLinks[i]).on('click', (e) => {
			e.preventDefault();
			window.location = href;
		});
	}
});
