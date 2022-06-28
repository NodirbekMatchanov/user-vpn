<?php include_once 'functions.php'; ?>


<?php get_part('_parts/header') ?>
<?php get_part('_parts/header_end') ?>


<div class="post">
	<div class="container">
		<div class="post-content">

			<?php get_part('_parts/breadcrumbs') ?>

			<h2 class="title-3">Настройка OpenVPN на Android</h2>

			<p>Пошаговая инструкция по настройке OpenVPN на Android для подключения к Vpn Max</p>

			<p>Подключение к Vpn Max на смартфонах и планшетах под Android производится через приложение OpenVPN. Скачать его можно из <a href="#">Google Play</a> или магазина <a href="#">F-Droid</a> (если на вашем устройстве нет Google Play).</p>

			<h3>Стандартный способ подключения</h3>

			<p>1. Скачайте приложение OpenVPN, получите логин и пароль в боте Vpn Max.</p>

			<img src="img/post-1.jpg" alt="">

			<p>2. Нажмите на файл .ovpn в боте, чтобы загрузить и открыть его. В списке<br>
			предложенных приложений на для открытия выберите OpenVPN.</p>

			<img src="img/post-2.jpg" alt="">

			<p>3. Откроется приложение OpenVPN. Здесь вы сможете настроить конфигурацию.<br>
				Укажите удобное название (например, страну для подключения) и нажмите кнопку<br>
			с галочкой, которая находится в правом верхнем углу.</p>

			<img src="img/post-3.jpg" alt="">

			<p>4. Созданная вами конфигурация появится в приложении OpenVPN на главном экране.<br>
				Чтобы подключиться к VPN, нажмите на неё. Система выдаст предупреждение о<br>
			подключении к VPN, согласитесь с ним. Это нужно будет сделать один раз.</p>

			<p>5. Дальше OpenVPN потребует, чтобы вы ввели логин и пароль от VPN. Скопируйте<br>
				их из бота и вставьте в соответствующие строки. Оставьте галочку около «Сохранить<br>
			пароль», чтобы не пришлось его вводить каждый раз снова, и нажмите «ОК».</p>

			<img src="img/post-4.jpg" alt="">

			<p>6. Через пару секунд VPN-соединение установится.</p>

			<p>
				Об успешном подключении к Vpn Max вы узнаете из уведомления на телефоне со<br>
				словом Success. Также в статусбаре (около часов) появится символ ключа – он тоже<br>
				сигнализирует об успешном подключении.
			</p>

			<img src="img/post-5.jpg" alt="">

			<p>Чтобы отключиться от VPN, откройте OpenVPN и нажмите на название конфигурации.<br>
				Чтобы снова подключиться – также откройте OpenVPN и нажмите на название<br>
			конфигурации.</p>

			<h3>Альтернативный способ подключения</h3>

			<p>Иногда стандартный способ не срабатывает. Ничего страшного.</p>

			<p>1. Скачайте приложение OpenVPN, получите логин и пароль в боте Vpn Max.</p>
			<p>2. Около файла .opvn нажмите кнопку с тремя точками и выберите пункт «Сохранить<br> в загрузки»</p>
			<p>3. Откройте OpenVPN и нажмите кнопку «Импортировать». Она находится в правом<br> верхнем углу и выглядит как ящичек со стрелкой вниз.</p>
			<p>4. Откроется файловый менеджер. В нём перейдите в папку Downloads и выберите<br> загруженный из бота Vpn Max файл .ovpn.</p>

			<img src="img/post-6.jpg" alt="">

			<p>5. Откроется окно с настройками конфигурации. Укажите удобное название<br>
				(например, страну для подключения) и нажмите кнопку с галочкой, которая находится<br>
			в правом верхнем углу.</p>

			<p>6. Созданная вами конфигурация появится в приложении OpenVPN на главном экране.<br>
				Чтобы подключиться к VPN, нажмите на неё. Система выдаст предупреждение о<br>
			подключении к VPN, согласитесь с ним. Это нужно будет сделать один раз.</p>

			<p>7. Дальше OpenVPN потребует, чтобы вы ввели логин и пароль от VPN. Скопируйте их<br>
				из бота и вставьте в соответствующие строки. Оставьте галочку около «Сохранить<br>
			пароль», чтобы не пришлось его вводить каждый раз снова, и нажмите «ОК».</p>

			<p>8. Через пару секунд VPN-соединение установится.</p>

			<p>Об успешном подключении к Vpn Max вы узнаете из уведомления на телефоне со<br>
				словом Success. Также в статусбаре (около часов) появится символ ключа – он тоже<br>
			сигнализирует об успешном подключении.</p>

			<img src="img/post-7.jpg" alt="">

			<p>Чтобы отключиться от VPN, откройте OpenVPN и нажмите на название конфигурации.<br>
				Чтобы снова подключиться – также откройте OpenVPN и нажмите на название<br>
			конфигурации.</p>

			<p>После подключения проверьте, изменился ли ваш IP-адрес. Для этого откройте наш<br>
				сайт <a href="#">vpn-max.com</a> и посмотрите на панель наверху страницы: там будет указан ваш<br>
			новый IP-адрес и локация.</p>

			<img src="img/post-8.jpg" alt="">

			<p>Если возникли сложности или что-то пошло не так – напишите нам в Telegram-бот <a href="#">https://t.me/FCK_RKN_bot</a>, поможем!</p>

			<h3>Дополнительные настройки</h3>
			<h4>Настройка постоянного VPN-подключения</h4>

			<p>Android может автоматически отключать VPN, а также разрывать соединение при<br>
				перезагрузке или переподключению к сети – например, при переходе с Wi-Fi на<br>
				мобильный интернет. Чтобы подключение было постоянным, потребуется<br>
			дополнительная настройка OpenVPN.</p>

			<p>Для этого откройте приложение OpenVPN и перейдите в раздел Settings («Настройки»).<br>
			Проделайте там следующие процедуры:</p>

			<p>1. В разделе Default VPN («VPN по умолчанию») выберите VPN-подключение, которое будете использовать по умолчанию. Например, желаемую страну.</p>

			<p>2. Поставьте галочку около пункта Connect on Boot («Подключаться при запуске»).
			Так VPN будет подключаться при включении телефона.</p>

			<p>3. Поставьте галочку около пункта Reconnect on network change («Повторное<br>
				подключение при смене сети»). Так VPN будет подключаться при смене Wi-Fi<br>
			на мобильную сеть и наоборот.</p>

			<p>При необходимости сохраните настройки. Всё, вы восхитительны!</p>

			<h4>Экономия заряда батареи</h4>

			<p>Чтобы VPN-подключение не расходовало заряд батареи при неиспользовании, необходимо дополнительно настроить OpenVPN. Перейдите в раздел «Настройки»
			и поставьте галочку около пункта Pause VPN connection after screen… («Остановить VPN-соединение после отключения экрана»).</p>

			<p>В последних версиях приложения этот пункт также может называться Battery Saver.</p>

			<p>Всё, теперь VPN-соединение будет приостанавливаться при выключенном экране
			и автоматически возобновляться при включённом. Также оно будет приостанавливаться в периоды, когда вы не пользуетесь интернетом (если за последние 60 секунд передано менее 64 Кб данных).</p>

			<h4>Удаление лишнего уведомления</h4>

			<p>Да, нам тоже не нравится это висящее уведомление</p>
		</div>

	</div>
</div>
</div>

<?php get_part('_parts/footer') ?>