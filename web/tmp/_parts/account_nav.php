
<?php if (!empty($vars->cabinet)): ?>

<div class="nav-wrap _space">
	<div class="container">
		<div class="_desktop">
			<div class="nav">
				<div class="nav-item _active">Тарифы</div>
				<div class="nav-item">Аккаунт</div>
				<div class="nav-item">Серверы</div>
				<div class="nav-item">Конфигурация</div>
				<div class="nav-item">Справочник</div>
			</div>
		</div>

		<div class="_mob">
			<div class="dropdown">
				<div class="dropdown-header">
					<div class="dropdown-current">Серверы</div>
					<div class="dropdown-icon">
						<img src="img/icons/dropdown-2.svg">
					</div>
				</div>
				<div class="dropdown-content">
					<a href='#' class="dropdown-item">Тарифы</a>
					<a href='#' class="dropdown-item">Аккаунт</a>
					<a href='#' class="dropdown-item">Серверы</a>
					<a href='#' class="dropdown-item">Конфигурация</a>
					<a href='#' class="dropdown-item">Справочник</a>
				</div>
			</div>
		</div>
	</div>
</div>
<?php else: ?>
<div class="nav-wrap _space">
	<div class="container">
		<div class="_desktop">
			<div class="nav">
				<div class="nav-item _active">Windows</div>
				<div class="nav-item">Android</div>
				<div class="nav-item">iOS</div>
				<div class="nav-item">macOS</div>
				<div class="nav-item">Linux</div>
				<div class="nav-item">Роутер</div>
			</div>
		</div>

		<div class="_mob">
			<div class="dropdown">
				<div class="dropdown-header">
					<div class="dropdown-current">Windows</div>
					<div class="dropdown-icon">
						<img src="img/icons/dropdown-2.svg">
					</div>
				</div>
				<div class="dropdown-content">
					<a href='#' class="dropdown-item">Android</a>
					<a href='#' class="dropdown-item">iOS</a>
					<a href='#' class="dropdown-item">macOS</a>
					<a href='#' class="dropdown-item">Linux</a>
					<a href='#' class="dropdown-item">Роутер</a>
				</div>
			</div>
		</div>
	</div>
</div>
<?php endif; ?>
