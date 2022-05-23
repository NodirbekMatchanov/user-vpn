
export default class ClickVisible {
	constructor() {
		// app.on('init', () => {
			this.init()
		// })
	}

	init() {
		function hand() {
			document.removeEventListener('mouseup', onUp)
			document.removeEventListener('touchend', onUp)
		}

		function onUp() {
			setTimeout(() => {
				$('.mouse-down').removeClass('mouse-down')
				hand()
			}, 100)
		}

		$(document).on('mousedown', '[data-click-v], button, .t-btn', function() {
			var $el = $(this)
			$el.addClass('mouse-down')
			document.addEventListener('mouseup', onUp)
			document.addEventListener('touchend', onUp)
		})

		$(document).on('touchstart', '[data-click-v], button, .t-btn', function() {
			var $el = $(this)
			$el.addClass('mouse-down')
			document.addEventListener('mouseup', onUp)
			document.addEventListener('touchend', onUp)
		})
	}
}