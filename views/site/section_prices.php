
<div class="prices <?php if (isset($vars->space)) echo '_space'; ?>" name='prices'>
	<div class="container">
		<div class="prices-header">
			<?php if (empty($vars->simple)): ?>
				<h2 class="title-2">
					Получите
					<span>
					<span class="accent">анонимный</span><br>
					<span class="accent">доступ</span>
					</span>
					к любым сайтам
				</h2>

				<div class="prices-note">30 дневная гарантия возврата средств</div>
			<?php else: ?>
				<h2 class="title-3 _bold">
					Тарифы
				</h2>
			<?php endif; ?>
		</div>

		<div class="prices-items">
			<div class="prices-item">
				<h3 class="title-3">1 месяц</h3>

				<div class="spacer"></div>

				<div>
					<div class="prices-price">
						449 ₽ / мес
					</div>
					<div class="prices-price-note">
						+НДС
					</div>
				</div>

				<div class="prices-check"></div>
			</div>

			<div class="prices-item">
				<h3 class="title-3">6 месяцев</h3>

				<div class="spacer"></div>

				<div>
					<div class="prices-price">
						2 490 ₽
					</div>
					<div class="prices-price-note">
						+НДС
					</div>
				</div>

				<div class="prices-check"></div>
			</div>

			<div class="prices-item _active">
				<div class="prices-best">
					<div class="prices-best-img">
						<img src="web/img/logo-3.svg">
					</div>
					<div class="prices-best-text">Лучший выбор</div>
				</div>

				<h3 class="title-3">1 год</h3>

				<div class="spacer"></div>

				<div class="prices-sale">
					<div class="prices-sale-text">
						3 490 ₽
					</div>
					<div class="prices-sale-percent">-67%</div>
				</div>

				<div>
					<div class="prices-price">
						3 490 ₽
					</div>
					<div class="prices-price-note">
						+НДС, оплата раз в год
					</div>
				</div>

				<div class="prices-check"></div>
			</div>
		</div>

		<div class="prices-tags">
			<div class="prices-tags-item">Неограниченная скорость</div>
			<div class="prices-tags-item">Все локации</div>
			<div class="prices-tags-item">До 6 устройств</div>
			<div class="prices-tags-item">Безлимитный трафик</div>
		</div>

		<div class="prices-form">

			<div class="input-2 _error">
				<label for="" class="input-2-label">Электронный адрес (отправим на него квитанцию)*</label>
				<input type="email" placeholder='Ваш e-mail'>
				<div class="input-2-message _error">Неправильно введен email</div>
			</div>

			<div class="input-2 _success">
				<label for="" class="input-2-label">Введите промокод</label>
				<input type="email">
				<div class="input-2-message _success">Промокод успешно применен</div>
			</div>

			<div class="prices-form-variant">VPN MAX (1 год): <span>11 864</span> р.</div>

			<div class="prices-form-coupon">Вы применили купон со скидкой <span>67%</span></div>

			<div class="prices-form-total">Итоговая сумма: <span>3 948</span> р.</div>

			<div class="prices-methods">
				<h3 class="title-4">Способы оплаты</h3>
				<div class="prices-methods-items">
					<label class="prices-methods-item">
						<input type="radio" name='method' checked hidden>
						<span class="prices-methods-thumb"></span>
						<span class="prices-methods-img"><img src="web/img/modal-prices-1.png"></span>
					</label>
					<label class="prices-methods-item">
						<input type="radio" name='method' hidden>
						<span class="prices-methods-thumb"></span>
						<span class="prices-methods-img"><img src="web/img/modal-prices-2.png"></span>
					</label>
					<label class="prices-methods-item">
						<input type="radio" name='method' hidden>
						<span class="prices-methods-thumb"></span>
						<span class="prices-methods-img"><img src="web/img/modal-prices-3.png"></span>
					</label>
					<label class="prices-methods-item">
						<input type="radio" name='method' hidden>
						<span class="prices-methods-thumb"></span>
						<span class="prices-methods-img"><img src="web/img/modal-prices-4.png"></span>
					</label>
				</div>
			</div>

			<button class="btn-2">Купить</button>

			<div class="form-politic">
				Нажимая на кнопку, вы даете согласие на обработку персональных<br>
				данных и соглашаетесь c <a href="#">политикой конфиденциальности</a>
			</div>

		</div>

	</div>
</div>