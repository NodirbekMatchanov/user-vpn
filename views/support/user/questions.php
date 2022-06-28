

<?php foreach ($data as $cayegory => $item):?>

			<div class="questions-items">
				<div class="questions-item">
					<div class="questions-item-img">
						<img src="/web/img/questions-item-img.svg" alt="">
					</div>
					<div class="questions-item-content">
						<h3 class='questions-item-title'><a href="<?=\yii\helpers\Url::to(['/support/categories?category='.$cayegory])?>"><?=$cayegory?></a></h3>
						<div class='questions-item-description'>
							Как настроить OpenVPN для подключения к Vpn Max на Android, iOS, Windows, macOS<br> и других платформах
						</div>
						<div class="spacer"></div>
						<div class="questions-item-count">5 статей в этой коллекции</div>
					</div>
				</div>
			</div>

<?php endforeach;?>