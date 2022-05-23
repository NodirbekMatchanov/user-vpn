
import './modules/helpers/share.js'

import extend from 'deepmerge'; share(extend, 'extend')

import Swiper, { Navigation, Pagination } from 'swiper';
Swiper.use([Navigation, Pagination]);
share(Swiper, 'Swiper')

import './modules/main/core.js'

import App from './modules/helpers/app.js'; share(App, 'App')
import Check from './modules/helpers/check.js'
import ClickVisible from './modules/helpers/click-visible.js'
import Tabs from './modules/helpers/tabs.js'

import Config from './modules/main/config.js'
import Main from './modules/main/main.js'
import Scroll from './modules/helpers/scroll.js'; share(Scroll, 'Scroll')
// import Submit from './modules/main/submit.js'

import Loader from './modules/includes/loader.js'
import Modal from './modules/includes/modal.js'
import Header from './modules/includes/header.js'
import Faq from './modules/includes/faq.js'
import Feedbacks from './modules/includes/feedbacks.js'
import Menu from './modules/includes/menu.js'

window.appConfig = {
	modules: [
	Config,
	Check,

	Tabs,
	// Submit,
	Menu,
	Main,

	Modal,
	ClickVisible,

	Faq,
	Header,
	Feedbacks,
	Loader
	],
}

new App(appConfig)