
export default class Main {
	constructor(app) {
		this.app = app

		app.on('init', () => {
			this.prevImgDrag()
			this.scrollFpsUp()
			// this.textareaNormalize()
			this.focusNormalize()
			this.scrollToAnchor()
			this.setVh()
			this.checkTouch()
			// this.checkMac()
			this.removeHover()
			this.activeLinks()
			// this.removeEmptyTags()
			this.webp()
		})
	}

	activeLinks() {
		$(`a[href='${config.location}']`).addClass('active')
	}

	// removeEmptyTags() {
	// 	$("[style='position:absolute; top:0; left:-9999px;']").remove()
	// 	$( 'p:empty' ).remove();
	// }

	prevImgDrag() {
		document.addEventListener("dragstart", function(e) {
			"IMG" != e.target.tagName || e.preventDefault()
		});
	}

	scrollFpsUp() {
		var body = document.body,
		timer;
		window.addEventListener('scroll', function() {
			clearTimeout(timer);
			if(!body.classList.contains('disable-hover')) {
				body.classList.add('disable-hover')
			}

			timer = setTimeout(function(){
				body.classList.remove('disable-hover')
			}, 100);
		}, false);
	}

	// textareaNormalize() {
	// 	autosize(document.querySelectorAll('textarea'))
	// }

	focusNormalize() {
		document.body.addEventListener('focusout', function(e) {
			var target = e.target
			if (target.tagName !== 'INPUT' && target.tagName !== 'TEXTAREA') return

				target.value ? target.classList.add('filled') : target.classList.remove('filled')


			let modal = target.closest('.mfp-wrap')
			if (modal) modal.scrollIntoView();
		})
	}

	scrollToAnchor() {
		var self = this
		$(document).on('click', "a[href^='#']", function(e) {
			e.originalEvent.preventDefault();

			var $el = $(this)
			var anchor = $el.attr('href').replace('#', '')
			var $toEl = $("[name='"+ anchor +"']")
			if ($toEl[0]) {
				self.app.menu.close()
				scrollToEl($toEl)
			}
		})

		if (config.location == '/') {
			$(document).on('click', "a[href^='/#']", function(e) {
				e.originalEvent.preventDefault();

				var $el = $(this)
				var anchor = $el.attr('href').replace('/#', '')
				var $toEl = $("[name='"+ anchor +"']")
				if ($toEl[0]) {
					self.app.menu.close()
					scrollToEl($toEl)
				}
			})
		}

		scrollToHash()
	}

	setVh() {
		var setCssVh = () => {
			let vh = window.innerHeight * 0.01;
			document.documentElement.style.setProperty('--vh', `${vh}px`);
		}
		setCssVh()
		window.addEventListener('resize', setCssVh);
	}

	checkTouch() {
		document.html.classList.add(this.app.check.touch() ? 'touched' : 'not-touched')
	}

	// checkMac() {
	// 	if (this.app.check.mac()) document.html.classList.add('mac');
	// 	else document.html.classList.add('not-mac');
	// }

	removeHover() {
		document.addEventListener('visibilitychange', () => {
			if (document.hidden) {
			} else {
				clearHover()
			}
		})
	}

	webp() {
		this.app.check.webp().then(res => {
			if (!res) {
				$("[src*='.webp']").each(el => {
					let src = el.getAttribute('src')
					let ext = el.getAttribute('data-ext') || 'png'
					ext = '.' + ext
					src = src.replace('.webp', ext)
					src = src.replace('/webp/', '/')
					el.setAttribute('src', src)
				})
				$("[data-src*='.webp']").each(el => {
					let src = el.getAttribute('data-src')
					let ext = el.getAttribute('data-ext') || 'png'
					ext = '.' + ext
					src = src.replace('.webp', ext)
					src = src.replace('/webp/', '/')
					el.setAttribute('data-src', src)
				})
				$("[style*='.webp']").each(el => {
					let src = el.getAttribute('style')
					let ext = el.getAttribute('data-ext') || 'png'
					ext = '.' + ext
					src = src.replace('.webp', ext)
					src = src.replace('/webp/', '/')
					el.setAttribute('style', src)
				})
			}
		})
	}
}