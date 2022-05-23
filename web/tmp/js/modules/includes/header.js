
export default class Header {
	constructor(app) {

		app.on('init', () => {
			$('.header-langs .header-langs-current').click(function() {
				$(this).closest('.header-langs').toggleClass('_active')
			})
		})
	}
}