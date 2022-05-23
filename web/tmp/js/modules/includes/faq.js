
export default class Faq {
	constructor(app) {

		app.on('init', () => {
			$('.faq').on('click', '.faq-header', function() {
				let $item = $(this).closest('.faq-item')
				let $content = $item.find('.faq-content')
				let isActive = $item.hasClass('_open')
				$item.closest('.faq').find('.faq-item').removeClass('_open').find('.faq-content').stop().slideUp(220)

					if (isActive) {
					} else {
						$item.toggleClass('_open')
						$content.stop().slideToggle(220)
					}
			})
		})
	}
}