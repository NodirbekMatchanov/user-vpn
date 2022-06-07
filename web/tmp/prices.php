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

<?php get_part('_parts/section_prices', [
	'simple' => true
]) ?>

<div class="prices-block-wrap">
	<div class="container">
		<h2 class="title-3">Ваш тариф</h2>

		<div class="prices-block-items">

			<div class="prices-block">
				<div class="prices-block-col">
					<a href='#' class="prices-block-title">Активировать</a>
				</div>
				<div class="prices-block-content">
					<div class="prices-block-text">1 из 1 пользователя</div>
					<div class="prices-block-text">0 из 1 адреса электронной почты</div>
					<div class="prices-block-text">Используется 10 байт из 500.00 МБ</div>
					<div class="prices-block-progress">
						<div class="prices-block-thumb" style="width: 15%"></div>
					</div>
				</div>
			</div>

			<div class="prices-block">
				<div class="prices-block-col">
					<div class="prices-block-title">VPN MAX Plus</div>
				</div>
				<div class="prices-block-content">
					<div class="prices-block-text">12 подключениq к VPN доступно</div>
				</div>
			</div>
		</div>
	</div>
</div>

<div class="prices-gift">
	<div class="container">
		<div class="prices-gift-content">
			<h3 class="title-3">Подарочный код</h3>
			<div class="prices-gift-text">Если у вас есть подарочный код, введите его ниже, чтобы применить скидку</div>

			<form class="prices-gift-form">
				<div class="input-2 _big">
					<input type="text" placeholder='Добавить подарочный код'>
				</div>
					<button class="btn-2">Отправить</button>
			</form>
		</div>
	</div>
</div>

<?php get_part('_parts/footer') ?>