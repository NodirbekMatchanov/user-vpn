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

<div class="files">
	<div class="container">
		<h3 class="title-3">Конфигурационные файлы</h3>

		<div class="_mobile-hide">
		<div class="files-title">Выберите файл конфигурации и скачайте</div>

		<div class="files-checkboxes">
			<label class="checkbox _radio">
				<input type="radio" name='config' hidden>
				<span class="checkbox-content">
					<span class="checkbox-thumb"></span>
					<span class="checkbox-text">Конфигурации стран</span>
				</span>
			</label>

			<label class="checkbox _radio">
				<input type="radio" name='config' hidden>
				<span class="checkbox-content">
					<span class="checkbox-thumb"></span>
					<span class="checkbox-text">Стандартные конфигурации сервера</span>
				</span>
			</label>

			<label class="checkbox _radio">
				<input type="radio" name='config' hidden>
				<span class="checkbox-content">
					<span class="checkbox-thumb"></span>
					<span class="checkbox-text">Конфигурации Secure Core</span>
				</span>
			</label>
		</div>

		<div class="files-description">Установите конфигурационный файл для подключения к определенному серверу в выбранной стране</div>
		</div>

		<div class="files-items">

			<?php for($x = 1; $x < 7; $x++): ?>
			<div class="files-item">
				<div class="files-item-header">
					<div class="files-item-col">
						<div class="files-item-data">
							<div class="files-item-switch">
								<img src="img/icons/dropdown.svg">
							</div>
							<div class="files-item-flag">
								<img src="img/files-flag-1.svg">
							</div>
							Argentina
						</div>
					</div>
					<div class="files-item-col">
						8 серверов
					</div>
					<div class="files-item-col">
						1 город
					</div>

				</div>
				<div class="files-item-content">

					<div class="files-item-row">
						<div class="files-item-col">
							Название
						</div>
						<div class="files-item-col">
							Город
						</div>
						<div class="files-item-col">
							Статус
						</div>
						<div class="files-item-col">
							Действие
						</div>
					</div>

					<?php for($y = 1; $y < 3; $y++): ?>
					<div class="files-item-row">
						<div class="files-item-col">
							BG-FREE#1
						</div>
						<div class="files-item-col">
							Sofia
						</div>
						<div class="files-item-col">

							<div class="circle-percent">
								<div class="circle _green" data-value="45">
									<div class="circle__progress">
										<div class="circle__progress-step circle__progress-step_first">
											<div class="circle__progress-round circle__progress-round_right"></div>
										</div>
										<div class="circle__progress-step circle__progress-step_last">
											<div class="circle__progress-round circle__progress-round_left"></div>
										</div>
									</div>
									<div class="circle__text">
										<div class="circle__text-inner">i</div>
									</div>
								</div>

								<div class="circle-percent-content">
									<div class="circle-percent-text">45%</div>
									<div class="circle-percent-text">P</div>
								</div>
							</div>

						</div>
						<div class="files-item-col">
							<span class="btn-3">
								Скачать
							</span>
						</div>
					</div>

					<div class="files-item-row">
						<div class="files-item-col">
							BG-FREE#1
						</div>
						<div class="files-item-col">
							Sofia
						</div>
						<div class="files-item-col">

							<div class="circle-percent">
								<div class="circle _red" data-value="60">
									<div class="circle__progress">
										<div class="circle__progress-step circle__progress-step_first">
											<div class="circle__progress-round circle__progress-round_right"></div>
										</div>
										<div class="circle__progress-step circle__progress-step_last">
											<div class="circle__progress-round circle__progress-round_left"></div>
										</div>
									</div>
									<div class="circle__text">
										<div class="circle__text-inner">i</div>
									</div>
								</div>

								<div class="circle-percent-content">
									<div class="circle-percent-text">60%</div>
									<div class="circle-percent-text">P</div>
								</div>
							</div>

						</div>
						<div class="files-item-col">
							<span class="btn-3">
								Скачать
							</span>
						</div>
					</div>
				<?php endfor; ?>
				</div>
			</div>
		<?php endfor; ?>

		</div>

	</div>
</div>

<?php get_part('_parts/footer') ?>