<?php include_once 'functions.php'; ?>


<?php get_part('_parts/header') ?>
<div class="container">
	<div class="header-intro _min">
		<div class="header-intro-img">
			<img src="img/header-intro-img-2.svg">
		</div>

		<h1 class="title-1">
			Мой аккаунт
		</h1>

	</div>
</div>
<?php get_part('_parts/header_end') ?>

<?php get_part('_parts/account_nav', [
	'cabinet' => true
]) ?>

<div class="settings">
	<div class="container">
		<h3 class="title-3">Имя пользователя OpenVPN / IKEv2</h3>

		<div class="settings-text">
			Используйте следующие учетные данные для подключения к VPN MAX через сторонние <br>
			приложения, например, Tunnelblick на MacOS или OpenVPN на GNU/Linux.
		</div>

		<div class="settings-text">
			Do not use the OpenVPN / IKEv2 credentials in VPN MAX applications or on the VPN MAX <br>
			dashboard. Узнать больше
		</div>

		<div class="info">
			<div class="info-row">
				<div class="info-col">Имя пользователя OpenVPN / IKEv2</div>
				<div class="info-col">
					<div class="info-wrap">
						<div class="info-value">ZXAr86Bmj0hk5nd0</div>
						<div class="info-actions">
							<div class="info-btn" data-copy="ZXAr86Bmj0hk5nd01">
								<div class="copy-text">Успешно скопировано</div>
								<img src="img/icons/copy.svg">
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="info-row">
				<div class="info-col">Пароль OpenVPN / IKEv2</div>
				<div class="info-col">
					<div class="info-wrap">
						<div class="info-value _password" data-value='ZXAr86Bmj0hk5nd0'>************</div>
						<div class="info-actions">
							<div class="info-btn" data-copy="ZXAr86Bmj0hk5nd0">
								<div class="copy-text">Успешно скопировано</div>
								<img src="img/icons/copy.svg">
							</div>
							<div class="info-btn _show-pass"><img src="img/icons/eye.svg"></div>
						</div>
					</div>
				</div>
			</div>
		</div>

		<button class="btn-2">Сбросить учетные данные</button>

	</div>
</div>


<div class="settings">
	<div class="container">
		<h3 class="title-3">Настройки аккаунта</h3>

		<div class="settings-block">
			<div class="settings-block-row">
				<div class="settings-block-label">Vpn login:</div>
				<div class="settings-block-value">A3InSb9OJmyN2-bt</div>
			</div>

			<div class="settings-block-row">
				<div class="settings-block-label">Vpn password:</div>
				<div class="settings-block-value">d76a4f91cc8226048fd9d132ddc346da</div>
			</div>

			<div class="settings-block-row">
				<div class="settings-block-label">Тариф:</div>
				<div class="settings-block-value">VIP</div>
			</div>

			<div class="settings-block-row">
				<div class="settings-block-label">Дейстует до:</div>
				<div class="settings-block-value">06.04.2023</div>
			</div>
		</div>

		<div class="settings-block">
			<div class="settings-block-row">
				<div class="settings-block-label">Email</div>
				<div class="settings-block-value">
					<div class="input-2">
						<input type="text">
					</div>
				</div>
			</div>
			<div class="settings-block-row">
				<div class="settings-block-label">Имя пользователя</div>
				<div class="settings-block-value">
					<div class="input-2">
						<input type="text">
					</div>
				</div>
			</div>
			<div class="settings-block-row">
				<div class="settings-block-label">Новый пароль</div>
				<div class="settings-block-value">
					<div class="input-2">
						<input type="text">
					</div>
				</div>
			</div>
			<div class="settings-block-row">
				<div class="settings-block-label">Текущий пароль</div>
				<div class="settings-block-value">
					<div class="input-2">
						<input type="text">
					</div>
				</div>
			</div>
			<div class="settings-block-row">
				<div class="settings-block-label"></div>
				<div class="settings-block-value">
					<button class="btn-2">Сохранить</button>
				</div>
			</div>
		</div>

	</div>
</div>


<div class="settings">
	<div class="container">
		<h3 class="title-3">Восстановление</h3>

		<div class="settings-text">
			В случае, если вы потеряете информацию для входа, мы отправим вам инструкцию<br>
			на электронную почту
		</div>

		<div class="settings-email">
			<div class="settings-email-title">
				Электронная почта<br>
				для восстановления
			</div>
			<div class="settings-email-content">
				<form class="settings-email-form">
					<div class="input-2">
						<input type="email" name='email' checked>
					</div>
					<button class="btn-2" disabled>Сохранить</button>
				</form>
				<div class="settings-email-status">
					<span class='settings-email-thumb'></span>
					<span>Разрешить восстановление по эл. почте</span>
				</div>

				<div class="switch-wrap">
					<label  class="switch">
						<input type="checkbox">
						<span class="slider round"></span>
					</label>

					<div class="switch-text">Разрешить восстановление по эл. почте</div>
				</div>
			</div>
		</div>
	</div>
</div>


<div class="settings">
	<div class="container">
		<h3 class="title-3">Подписки на рассылки</h3>

		<div class="settings-text">
			Чтобы быть в курсе последних разработок продуктов Proton, вы можете подписаться<br>
			на наши различные рассылки и время от времени посещать наш блог
		</div>

		<div class="switch-wrap">
			<label  class="switch">
				<input type="checkbox">
				<span class="slider round"></span>
			</label>

			<div class="switch-text">Объявления компании VPN MAX (1 письмо в квартал)</div>
		</div>

		<div class="switch-wrap">
			<label  class="switch">
				<input type="checkbox">
				<span class="slider round"></span>
			</label>

			<div class="switch-text">Объявления о продукте VPN MAX (1-2 письма в месяц)</div>
		</div>

		<div class="switch-wrap">
			<label  class="switch">
				<input type="checkbox">
				<span class="slider round"></span>
			</label>

			<div class="switch-text">Новостная рассылка VPN MAX для бизнеса (1 письмо в месяц)</div>
		</div>

		<div class="switch-wrap">
			<label  class="switch">
				<input type="checkbox" checked>
				<span class="slider round"></span>
			</label>

			<div class="switch-text">Новостная рассылка VPN MAX (1 письмо в месяц)</div>
		</div>

		<div class="switch-wrap">
			<label  class="switch">
				<input type="checkbox">
				<span class="slider round"></span>
			</label>

			<div class="switch-text">Объявления о VPN MAX beta (1-2 письма в месяц)</div>
		</div>

		<div class="switch-wrap">
			<label  class="switch">
				<input type="checkbox">
				<span class="slider round"></span>
			</label>

			<div class="switch-text">Предложения и акции VPN MAX (1 письмо в квартал)</div>
		</div>

	</div>
</div>


<div class="settings">
	<div class="container">
		<h3 class="title-3">Удалить</h3>

		<div class="settings-text">
			Это навсегда удалит ваш аккаунт и все его данные. Вы не сможете восстановить<br>
			эту учетную запись.
		</div>

		<button class="btn-2 _outline _danger">
			Удалить аккаунт
		</button>
	</div>
</div>

<?php get_part('_parts/footer') ?>