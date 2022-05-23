
export default class App {
	constructor(config) {
		this.config = config
		window.app = this

		this.init()
	}

	init() {
		this.modules(this.config.modules)
	}

	on(name, f) {
		switch(name) {
			case 'init': onLoad(f); break;
		}
	}

	modules(modules) {
		modules.forEach(el => {
			this.module(el, true)
		})
	}

	module(module) {
		this[module.name.toLowerCase()] = new module(this)
	}
}