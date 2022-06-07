<!DOCTYPE html>
<html lang="ru">

<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" id="metaViewport">

	<title>VPN MAX</title>
	<meta name="twitter:title" content="VPN MAX">
	<meta property="og:title" content="VPN MAX">

	<meta name="description" content="">
	<meta property="og:description" content="">
	<meta property="og:image" content="img/default.png">
	<meta property="vk:image" content="img/default.png">
	<meta name="twitter:image" content="img/default.png">
	<link rel="shortcut icon" href="img/favicon/favicon.ico" type="image/x-icon">

	<link rel="apple-touch-icon" sizes="180x180" href="img/favicon/apple-touch-icon.png">
	<link rel="icon" type="image/png" sizes="32x32" href="img/favicon/favicon-32x32.png">
	<link rel="icon" type="image/png" sizes="16x16" href="img/favicon/favicon-16x16.png">
	<link rel="manifest" href="img/favicon/site.webmanifest">
	<link rel="mask-icon" href="img/favicon/safari-pinned-tab.svg" color="#00bdd7">
	<meta name="msapplication-TileColor" content="#008CF2">

	<meta name="theme-color" content="#008CF2">
	<meta name="msapplication-navbutton-color" content="#008CF2">
	<meta name="apple-mobile-web-app-status-bar-style" content="#008CF2">


	<link rel="preconnect" href="https://fonts.googleapis.com">
	<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

	<link rel="stylesheet" href="css/styles.css">

	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
</head>

<body>
	<div id="app">
		<div id="loader" class='active'></div>

		<header class="header <?php if (isset($vars->full)) echo '_full'; ?>">
			<div class="header-top">
				<div class="container">
					<div class="header-top-content">
						<a href="#" class="header-logo">
							<img src="img/logo.svg">
						</a>

						<div class="header-menu">
							<ul>
								<li><a href="#features">Особенности</a></li>
								<li><a href="#faq">Вопросы</a></li>
								<li><a href="#feedbacks">Отзывы</a></li>
								<li><a href="#prices">Цены</a></li>
							</ul>
						</div>

						<div class="header-actions">
							<div class="header-buttons">
								<a href="#" class="btn">Скачать</a>
								<a href="#" class="btn _outline">Войти</a>
							</div>

							<div class="header-langs">
								<div class="header-langs-current">
									<img src="img/langs-ru.svg">
								</div>
								<div class="header-langs-items">
									<a href="#" class="header-langs-item">
										<img src="img/langs-en.png">
									</a>
								</div>
							</div>

							<div id="mob-menu-btn">
								<button class="hamburger hamburger--elastic" type="button">
									<span class="hamburger-box">
										<span class="hamburger-inner"></span>
									</span>
								</button>
							</div>
						</div>
					</div>
				</div>
			</div>

