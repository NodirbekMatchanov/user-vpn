
export default class ConfigModule {
	constructor(app) {
		var loc = window.location.pathname + '';
		loc = loc.substr(1)
		loc = loc.match(/(.+)\?*/)
		try {
			loc = '/' + loc[1]
		} catch(e) {
			loc = '/'
		}


		var config = {
			root: (window.location + '').match(/.+\/\/.+?\//)[0].slice(0, -1),
			location: loc,

			animation: {
				transition: 300
			},

			path: {
				mail_url: 'https://kobido.ru/_tools/mail.php'
			},

			mail: {
				project_name: 'Студия',
				form_subject: 'Лид',
				admin_email: 'anatoliy.akhmatov@gmail.com'
			}
		}

		app.config = extend(app.config, config)
		window.config = app.config
	}
}