export default class Tabs {

	constructor() {

		document.addEventListener('click', e => {
			var tabs = e.target.closest('._tabs')
			var target = e.target.closest('[data-tab]')

			if (!tabs || !target) return;
			e.preventDefault()
			e.stopPropagation()

			var is_active = target.classList.contains('_active')

			let insetTabsContent = tabs.querySelector('._tabs')
			if (insetTabsContent) insetTabsContent = insetTabsContent.querySelectorAll('[data-content]')
				else insetTabsContent = [];
			let insetTabsTabs = tabs.querySelector('._tabs')
			if (insetTabsTabs) insetTabsTabs = insetTabsTabs.querySelectorAll('[data-tab]')
				else insetTabsTabs = [];

			tabs.querySelectorAll('[data-tab]._active').forEach(el => {
				let belongs = true
				insetTabsTabs.forEach(t => {
					if (el === t) belongs = false
				})
				if (belongs) {
					el.classList.remove('_active')
				}
			})
			tabs.querySelectorAll('[data-content]._active').forEach(el => {
				let belongs = true
				insetTabsContent.forEach(t => {
					if (el === t) belongs = false
				})
				if (belongs) {
					el.classList.remove('_active')
				}
			})

			// if (is_active) {
			// 	tabs.querySelectorAll('[data-tab="'+ target.getAttribute('data-tab') +'"]').forEach(el => { el.classList.remove('_active') })
			// 	tabs.querySelector('[data-content="'+ target.getAttribute('data-tab') +'"]').classList.remove('_active')
			// } else {

				tabs.querySelectorAll('[data-tab="'+ target.getAttribute('data-tab') +'"]').forEach(el => {
					let belongs = true
					insetTabsTabs.forEach(t => {
						if (el === t) belongs = false
					})
					if (belongs) {
						el.classList.add('_active')
					}
				})
				tabs.querySelectorAll('[data-content="'+ target.getAttribute('data-tab') +'"]').forEach(el => {
					let belongs = true
					insetTabsContent.forEach(t => {
						if (el === t) belongs = false
					})
					if (belongs) {
						el.classList.add('_active')
					}
				})
			// }

		})
	}
}