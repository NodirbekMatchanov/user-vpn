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

<div class="servers">
	<div class="container">
		<div class="servers-wrap">
			<h3 class="title-3">Cерверы</h3>

			<div class="servers-description">Показаны записи 1-4 из 4</div>

			<div class='servers-table-wrap'>
				<table class='servers-table'>
					<tr>
						<td><span>#</span></td>
						<td><span>ip</span></td>
						<td><span>Страна</span></td>
						<td><span>Город</span></td>
						<td><span>Нагрузка %</span></td>
					</tr>

					<tr>
						<td><span></span></td>
						<td>
							<span>
								<div class="input-2 _min">
									<input type="text">
								</div>
							</span>
						</td>
						<td>
							<span>
								<div class="input-2 _min">
									<input type="text">
								</div>
							</span>
						</td>
						<td>
							<span>
								<div class="input-2 _min">
									<input type="text">
								</div>
							</span>
						</td>
						<td>
							<span>
								<div class="input-2 _min">
									<input type="text">
								</div>
							</span>
						</td>
					</tr>

					<tr>
						<td><span>1</span></td>
						<td><span>5.8.16.55</span></td>
						<td><span>Россия</span></td>
						<td><span>Санкт-Петербург</span></td>
						<td><span></span></td>
					</tr>

					<tr>
						<td><span>2</span></td>
						<td><span>5.8.16.55</span></td>
						<td><span>Россия</span></td>
						<td><span>Санкт-Петербург</span></td>
						<td><span></span></td>
					</tr>

					<tr>
						<td><span>3</span></td>
						<td><span>5.8.16.55</span></td>
						<td><span>Россия</span></td>
						<td><span></span></td>
						<td><span>23 %</span></td>
					</tr>

					<tr>
						<td><span>3</span></td>
						<td><span>5.8.16.55</span></td>
						<td><span>Россия</span></td>
						<td><span></span></td>
						<td><span>3 %</span></td>
					</tr>
				</table>
			</div>

			<div class='servers-table-wrap _mob'>

				<div class="servers-wrap-item">
					<table class='servers-table'>
						<tr>
							<td><span>ip</span></td>
							<td><span>5.8.16.55</span></td>
						</tr>

						<tr>
							<td><span>Страна</span></td>
							<td><span>Россия</span></td>
						</tr>

						<tr>
							<td><span>Город</span></td>
							<td><span>Санкт-Петербург</span></td>
						</tr>

						<tr>
							<td><span>Нагрузка %</span></td>
							<td><span></span></td>
						</tr>
					</table>
				</div>

				<div class="servers-wrap-item">
					<table class='servers-table'>
						<tr>
							<td><span>ip</span></td>
							<td><span>5.1888.16.55</span></td>
						</tr>

						<tr>
							<td><span>Страна</span></td>
							<td><span>Россия</span></td>
						</tr>

						<tr>
							<td><span>Город</span></td>
							<td><span>Москва</span></td>
						</tr>

						<tr>
							<td><span>Нагрузка %</span></td>
							<td><span></span></td>
						</tr>
					</table>
				</div>

				<div class="servers-wrap-item">
					<table class='servers-table'>
						<tr>
							<td><span>ip</span></td>
							<td><span>45.137.152.70</span></td>
						</tr>

						<tr>
							<td><span>Страна</span></td>
							<td><span>Россия</span></td>
						</tr>

						<tr>
							<td><span>Город</span></td>
							<td><span>Москва</span></td>
						</tr>

						<tr>
							<td><span>Нагрузка %</span></td>
							<td><span></span></td>
						</tr>
					</table>
				</div>

			</div>

		</div>
	</div>
</div>

<?php get_part('_parts/footer') ?>