<?php include_once 'functions.php'; ?>


<?php get_part('_parts/header') ?>
<?php get_part('_parts/header_end') ?>

<div class="form">
	<div class="container">
		<form class="form-content">
			<h1 class="title-3">Зарегистрироваться</h1>

			<div class="input-2">
				<label for="" class="input-2-label">E-mail</label>
				<input type="email">
			</div>

			<div class="input-2">
				<label for="" class="input-2-label">Телефон</label>
				<input type="tel">
			</div>

			<div class="input-2">
				<label for="" class="input-2-label">Промокод</label>
				<input type="text">
			</div>

			<div class="input-2">
				<label for="" class="input-2-label">Пароль</label>
				<input type="password">
			</div>

			<div class="input-2">
				<label for="" class="input-2-label">Подтвердить</label>
				<input type="password">
			</div>

			<div class="form-buttons">
				<button class="btn-2">Зарегистрироваться</button>
				<a href='#' class="btn-2 _outline">Авторизоваться</a>
			</div>

		</form>
	</div>
</div>

<?php get_part('_parts/footer') ?>