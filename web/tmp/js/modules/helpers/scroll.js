

import { lock, unlock } from 'tua-body-scroll-lock'

export default class Scroll {
	static on() {
		document.html.classList.add('mfp-helper')
		lock(document.body)
	}
	static off() {
		document.html.classList.remove('mfp-helper')
		unlock(document.body)
	}
}