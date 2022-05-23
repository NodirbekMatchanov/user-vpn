

// https://gist.github.com/AnatoliyAkhmatov/a2862794ce5cdbc00ecb88fc3c8e4c86

export default class Menu {
	constructor(app) {
		this.app = app
		var self = this

		app.on('init', () => {
			this.mobMenu = $('.header-mob')
			this.mobMenuBtn = $('#mob-menu-btn')
			this.headerTop = document.querySelector('.header-top')

			this.mobMenuBtn.click(self.toggle.bind(this))

			document.addEventListener('scroll', self.scroll.bind(this))
		})
	}

	toggle() {
		this.mobMenu.hasClass('active') ? this.close() : this.open()
	}

	close() {
		this.mobMenuBtn.find('.hamburger').removeClass('is-active')
		this.mobMenu.removeClass('active')

		Scroll.off()
	}

	open() {
		this.mobMenuBtn.find('.hamburger').addClass('is-active')
		this.mobMenu.addClass('active')

		Scroll.on()
	}

	scroll() {
		this.headerTop.classList[window.pageYOffset >= 40 ? 'add' : 'remove']('_min')
	}
}