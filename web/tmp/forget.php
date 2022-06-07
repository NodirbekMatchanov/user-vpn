<?php include_once 'functions.php'; ?>


<?php get_part('_parts/header') ?>
<?php get_part('_parts/header_end') ?>

<div class="form">
	<div class="container">
		<form class="form-content">
			<h1 class="title-3">Сбросить пароль</h1>

			<div class="input-2">
				<label for="" class="input-2-label">Введите ваш e-mail</label>
				<input type="email">
			</div>

			<div class="form-message">
				Введите email, который вы указывали при<br>
				регистрации в VPN MAX, и мы пришлем<br>
				вам письмо с инструкциями
			</div>

			<div class="form-buttons">
				<button class="btn-2">Сбросить пароль</button>
				<a href='#' class="btn-2 _outline">Авторизоваться</a>
			</div>

		</form>
	</div>
</div>

<?php get_part('_parts/footer') ?>