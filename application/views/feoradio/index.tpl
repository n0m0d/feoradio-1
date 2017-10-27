		<?php var_dump($this->data['file']);?>
		
		<?php
		$tmpl = new Template('<p>{#row.number#}) is a текст = {#new#}<p>');
		for($i=1;$i<=10;$i++){
			$tmpl->reset();
			$tmpl->setObject('row', [ 'number'	=> $i]);
			$tmpl->setVar('new', $i*$i);
			echo $tmpl->getDom();
		}
		
		$this->includeView('test.html');
		?>
		<section class="section-top">
			<div class="container">
				<div class="row">
					<div class="section-wrap">
						<div class="row no-margins">
							<div class="col-md-9">
								<div class="player-wrap hidden-xs">
									<audio class="main-radio" src="/mp3/M83-Wait.mp3" preload="auto" controls></audio>
									<span class="current-sont"><b>Monody (feat. Laura Brehm)</b> - The fat rat</span>
									<span class="next-song">Следующий трек: Seether – Let You Down</span>
								</div>
								<div class="mini-radio-wrap hidden-lg hidden-md hidden-sm">
									<span class="current-sont"><b>Monody (feat. Laura Brehm)</b> - The fat rat</span>
									<audio class="mini-radio hidden-lg hidden-md hidden-sm" src="/mp3/M83-Wait.mp3" preload="auto" controls></audio>
								</div>
								<div class="news-string hidden-xs">
									<span>Новости одной строкой</span> 200 лет Айвазовскому
								</div>
								<div class="camera-wrap">
									<img class="img-responsive" src="/img/camera.jpg" alt="alt">
									<div class="camera-title">
										<p>Вебкамера в студии</p><span>Наблюдайте за работой наших ведущих в реальном времени</span>
									</div>
								</div>
							</div>
							<div class="col-md-3 col-sm-6">
								<div class="play-list">
									<h2>Плейлист</h2>
									<div class="songs">
										<div class="song listen">
											<span>Andre TAY</span> - Река моя©
										</div>
										<div class="song listen">
											<span>Andre TAY</span> - Река моя©
										</div>
										<div class="song listen">
											<span>Andre TAY</span> - Река моя©
										</div>
										<div class="song current">
											<span class="play-icon"><i class="fa fa-play" aria-hidden="true"></i></span><span>Andre TAY</span> - Река моя©dsadadadasdasdasdasdasdasdasdasdasdasda
										</div>
										<div class="song">
											<span>Andre TAY</span> - Река моя©
										</div>
										<div class="song">
											<span>Andre TAY</span> - Река моя©
										</div>
										<div class="song">
											<span>Andre TAY</span> - Река моя©
										</div>
										<div class="song">
											<span>Andre TAY</span> - Река моя©
										</div>
										<div class="song">
											<span>Andre TAY</span> - Река моя©
										</div>
										<div class="song">
											<span>Andre TAY</span> - Река моя©
										</div>
										<div class="song">
											<span>Andre TAY</span> - Река моя©
										</div>
										<div class="song">
											<span>Andre TAY</span> - Река моя©
										</div>
										<div class="song">
											<span>Andre TAY</span> - Река моя©
										</div>
									</div>
								</div>
							</div>
							<div class="col-sm-6">
								<div class="rekl-wrap hidden-lg hidden-md hidden-xs">
									<img class="img-responsive" src="/img/banner.jpg" alt="alt">
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</section>
		<section class="section-middle">
			<div class="container">
				<div class="row">
					<div class="form-question">
						<form>
							<div class="row">
								<div class="col-md-10 col-sm-9">
									<div class="single-label">
										<label>
											<input placeholder="Задать вопрос..." type="text">
										</label>
									</div>
								</div>
								<div class="col-md-2 col-sm-3">
									<div class="button-wrap">
										<button class="button">Отправить</button>
									</div>
								</div>
							</div>
						</form>
					</div>
				</div>
			</div>
		</section>
		<section class="section-bottom">
			<div class="container">
				<div class="row">
					<div class="section-wrap">
						<div class="row">
							<div class="col-md-4 col-sm-6">
								<div class="news-wrapper">
									<h2>Новости</h2>
									<div class="news">
										<h3><a href="#">Как правильно питаться</a></h3>
										<p>Далеко-далеко за словесными горами в стране гласных и согласных живут рыбные</p>
										<span class="news-time"><span class="icon-time"><i class="fa fa-clock-o" aria-hidden="true"></i></span>Сегодня в 15:35</span>
									</div>
									<div class="news">
										<h3><a href="#">Как правильно питаться</a></h3>
										<p>Далеко-далеко за словесными горами в стране гласных и согласных живут рыбные</p>
										<span class="news-time"><span class="icon-time"><i class="fa fa-clock-o" aria-hidden="true"></i></span>Сегодня в 15:35</span>
									</div>
									<div class="news">
										<h3><a href="#">Как правильно питаться</a></h3>
										<p>Далеко-далеко за словесными горами в стране гласных и согласных живут рыбные</p>
										<span class="news-time"><span class="icon-time"><i class="fa fa-clock-o" aria-hidden="true"></i></span>Сегодня в 15:35</span>
									</div>
									<div class="button-wrap">
										<a class="button" href="#">Больше новостей</a>
									</div>
								</div>
							</div>
							<div class="col-md-5 col-sm-6">
								<div class="progs-wrapper">
									<h2>Программы</h2>
									<div class="prog">
										<div class="top-sect">
											<div class="title">В Феодосии освятили закладной...</div>
										</div>
										<div class="content-sect">
											<audio class="mini-radio" src="/mp3/M83-Wait.mp3" preload="auto" controls></audio>
										</div>
									</div>
									<div class="prog">
										<div class="top-sect">
											<div class="title">В Феодосии освятили закладной...</div>
										</div>
										<div class="content-sect">
											<audio class="mini-radio" src="/mp3/M83-Wait.mp3" preload="auto" controls></audio>
										</div>
									</div>
									<div class="prog">
										<div class="top-sect">
											<div class="title">В Феодосии освятили закладной...</div>
										</div>
										<div class="content-sect">
											<audio class="mini-radio" src="/mp3/M83-Wait.mp3" preload="auto" controls></audio>
										</div>
									</div>
								</div>
							</div>
							<div class="col-md-3 hidden-sm">
								<div class="rekl-wrap">
									<img class="img-responsive" src="/img/banner.jpg" alt="alt">
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</section>
