<?php include_once 'functions.php'; ?>


<?php get_part('_parts/header') ?>
<?php get_part('_parts/header_end') ?>

<div class="form">
	<div class="container">
		<form class="form-content">
			<h1 class="title-3">Авторизоваться</h1>

			<div class="input-2">
				<label for="" class="input-2-label">E-mail</label>
				<input type="email">
			</div>

			<div class="input-2">
				<label for="" class="input-2-label">Пароль</label>
				<input type="password">
			</div>

			<label class="checkbox">
				<input type="checkbox" hidden>
				<span class="checkbox-content">
					<span class="checkbox-thumb"></span>
					<span class="checkbox-text">Запомнить меня</span>
				</span>
			</label>

			<a href='#' class="form-link">Забыли пароль?</a>

			<div class="form-buttons">
				<button class="btn-2">Авторизоваться</button>
				<a href='#' class="btn-2 _outline">Зарегистрироваться</a>
			</div>

		</form>
	</div>
</div>

<?php get_part('_parts/footer') ?>