
export default class Submit {
	constructor(app) {

		document.addEventListener('submit', e => {
			e.preventDefault();
			var form = e.target

			if (form.tagName !== 'FORM') form = form.closest('form');
			var data = serialize(form)

			data.project_name = config.mail.project_name
			data.form_subject = config.mail.form_subject
			data.admin_email = config.mail.admin_email

			data.page_url = window.location.href

			$.ajax({
				url: config.path.mail_url,
				method: 'GET',
				data,
				success(res) {
					self.app.popup.success()
					// console.log(res);
				}
			})
		})
	}
}