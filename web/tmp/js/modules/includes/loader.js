
export default class Loader {
	constructor(app) {

		app.on('init', () => {
			this.loader = document.querySelector('#loader')
			if (!this.loader) return;

			this.app = app
			this.off()
		})
	}

	on() {
		this.loader.classList.add('active')
		this.loader.classList.add('ready')

		setTimeout(() => {
			this.loader.classList.remove('active')
		}, config.animation.transition)
	}

	off() {
		this.loader.classList.add('active')
		this.loader.classList.add('ready')


		setTimeout(() => {
			this.loader.classList.remove('active')
			this.loader.classList.remove('ready')
			document.documentElement.classList.add('ready')
		}, config.animation.transition)
	}

}