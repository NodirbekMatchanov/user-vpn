
export default class Feedbacks {
	constructor(app) {

		app.on('init', () => {
			let $slider = $('.feedbacks-slider')
			if (!$slider) return;
			let $prev = $slider.find('.swiper-button-prev')
			let $next = $slider.find('.swiper-button-next')
			let $pagination = $slider.find('.swiper-pagination')

			const swiper = new Swiper($slider.find('.swiper')[0], {
				slidesPerView: 1,
				spaceBetween: 20,

				loop: true,

				 pagination: {
				    el: $pagination[0],
				    type: 'bullets',
				    clickable: true
				  },

			  breakpoints: {
			    1100: {
			      slidesPerView: 3,
			      spaceBetween: 30
			    },
			    768: {
						slidesPerView: 2,
						spaceBetween: 20,
			    },
			  }
			});

			$prev.click(() => {swiper.slidePrev()})
			$next.click(() => {swiper.slideNext()})

		})
	}
}