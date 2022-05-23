
export default class Check {
	constructor() {
		this.cache = {};
	}

	touch() {
		return 'ontouchstart' in document.documentElement;
	}

	// mac() {
	// 	return /(Mac|iPhone|iPod|iPad)/i.test(navigator.platform);
	// }

	// ios() {
	// 	return /iPad|iPhone|iPod/.test(navigator.platform) || (navigator.platform === 'MacIntel' && navigator.maxTouchPoints > 1)
	// }

	webp() {
		return new Promise(res => {
			const webP = new Image();
			webP.src = 'data:image/webp;base64,UklGRjoAAABXRUJQVlA4IC4AAACyAgCdASoCAAIALmk0mk0iIiIiIgBoSygABc6WWgAA/veff/0PP8bA//LwYAAA';
			webP.onload = webP.onerror = () => {
				res(webP.height === 2);
			};
		})
	}
}