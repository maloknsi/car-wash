<?php

/* @var $this \yii\web\View */
/* @var $content string */

use app\assets\BootboxAsset;
use yii\bootstrap\Modal;
use yii\helpers\Html;
use app\assets\AppAsset;
use yii\helpers\Url;

AppAsset::register($this);
BootboxAsset::overrideSystemConfirm();
$this->registerAssetBundle(skinka\widgets\gritter\GritterAsset::className());
$this->title = $this->context->title;

?>
<?php $this->beginPage() ?>
	<!DOCTYPE html>
	<html lang="<?= Yii::$app->language ?>">
	<body>
	<?php $this->beginBody() ?>
	<header id="header" role="banner">
		<div class="main-nav">
			<div class="container">
				<div class="header-top">
					<div class="pull-right social-icons">
						<span id="block_user_guest" style="display:<?= Yii::$app->user->isGuest ? 'block' : 'none' ?>">
						<?= Html::a('<i class="fa fa-sign-in"></i>', '#', [
							'title' => 'Авторизация',
							'class' => 'btn-show-modal-form',
							'data-action-url' => Url::to(['/login']),
						]) ?>
						</span>
						<span id="block_user_authorized" style="display:<?= !Yii::$app->user->isGuest ? 'block' : 'none' ?>">
							<a href="<?= Url::to(["/user"])?>"><i class="fa fa-user-md"></i><span style="margin-left: 5px"><?= !Yii::$app->user->isGuest ? Yii::$app->user->identity->username : '' ?></span></a>
							<?= Html::a('<i class="fa fa-sign-out"></i>', Url::to(['/logout']), [
								'title' => 'Выйти',
							]) ?>
						</span>
					</div>
				</div>
				<div class="row" id="menu">
					<div class="navbar-header">
						<button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
							<span class="sr-only">Toggle navigation</span>
							<span class="icon-bar"></span>
							<span class="icon-bar"></span>
							<span class="icon-bar"></span>
						</button>
						<a class="navbar-brand" href="/">
							<img class="img-responsive" src="/images/logo.png" alt="logo">
						</a>
					</div>
					<div class="collapse navbar-collapse">
						<ul class="nav navbar-nav navbar-right">
							<li class="scroll active"><a href="#home">Главная</a></li>
							<li class="scroll"><a href="#explore">Забронировать</a></li>
							<li class="scroll"><a href="#event">Новости</a></li>
							<li class="scroll"><a href="#about">О нас</a></li>
							<li class="scroll"><a href="#twitter">Отзывы</a></li>
							<li class="scroll"><a href="#sponsor">Услуги</a></li>
							<li class="scroll"><a href="#contact">Контакты</a></li>
						</ul>
					</div>
				</div>
			</div>
		</div>
	</header>
	<!--/#header-->

	<section id="home">
		<div id="main-slider" class="carousel slide" data-ride="carousel">
			<ol class="carousel-indicators">
				<li data-target="#main-slider" data-slide-to="0" class="active"></li>
				<li data-target="#main-slider" data-slide-to="1"></li>
				<li data-target="#main-slider" data-slide-to="2"></li>
			</ol>
			<div class="carousel-inner">
				<div class="item active">
					<img class="img-responsive" src="/images/slider/bg1.jpg" alt="slider">
					<div class="carousel-caption">
						<h2>Комплекс «Стандарт»</h2>
						<h4>мойка авто, воск, сушка, <br>
							пылесос + влажная уборка салона</h4>
						<a href="#sponsor" class="scroll">наши услуги <i class="fa fa-angle-right"></i></a>
					</div>
				</div>
				<div class="item">
					<img class="img-responsive" src="/images/slider/bg2.jpg" alt="slider">
					<div class="carousel-caption">
						<h2>Комплекс «V.I.P»</h2>
						<h4>мойка авто б/к +ручная, полимер, пылесос, <br>
							влажная уборка салона, обезж. стекол, <br>
							чистка колёсных дисков, кондиционер кожи салона,<br>
							полироль пластика салона, чернение резины</h4>
						<a href="#sponsor" class="scroll">наши услуги <i class="fa fa-angle-right"></i></a>
					</div>
				</div>
				<div class="item">
					<img class="img-responsive" src="/images/slider/bg3.jpg" alt="slider">
					<div class="carousel-caption">
						<h2>Комплекс «Люкс»</h2>
						<h4>мойка авто, воск, сушка, пылесос, влажная уборка салона,  <br>
							обезжир. стекол внутри снаружи,  <br>
							обработка пластиковых деталей салона, чернение резины</h4>
						<a href="#sponsor" class="scroll">наши услуги <i class="fa fa-angle-right"></i></a>
					</div>
				</div>
			</div>
		</div>
	</section>
	<!--/#home-->

	<section id="explore">
		<div class="container">
			<div class="row">
				<div class="watch">
					<img class="img-responsive" src="/images/watch.png" alt="">
				</div>
				<div class="col-sm-12 col-md-9">
					<div class="col-sm-3 col-md-3">
						<?= kartik\date\DatePicker::widget([
							'removeButton' => false,
							'name' => 'site_boxes_timetable_date',
							'value' => date('Y-m-d'),
							'type' => kartik\date\DatePicker::TYPE_COMPONENT_APPEND,
							'pluginOptions' => [
								'autoclose' => true,
								'format' => 'yyyy-mm-dd'
							]
						]) ?>
					</div>
<!--					<h2>our next event in</h2>-->
					<div class="col-sm-9 col-md-9">
					<?php echo app\widgets\SiteBoxesTimetableWidget::widget(); ?>
					</div>
				</div>
			</div>
		</div>
	</section><!--/#box_record-->

	<section id="event">
		<div class="container">
			<div class="row">
				<div class="col-sm-12 col-md-9">
					<div id="event-carousel" class="carousel slide" data-interval="false">
						<h2 class="heading">Новости</h2>
						<a class="even-control-left" href="#event-carousel" data-slide="prev"><i class="fa fa-angle-left"></i></a>
						<a class="even-control-right" href="#event-carousel" data-slide="next"><i class="fa fa-angle-right"></i></a>
						<div class="carousel-inner">
							<?php echo app\widgets\SiteNewsWidget::widget(); ?>
						</div>
					</div>
				</div>
				<div class="guitar">
					<img class="img-responsive" src="/images/guitar.png" alt="guitar">
				</div>
			</div>
		</div>
	</section><!--/#news-->

	<section id="about">
		<div class="guitar2">
			<img class="img-responsive" src="/images/guitar2.png" alt="guitar">
		</div>
			<?php echo app\widgets\SiteAboutWidget::widget() ?>
	</section><!--/#about-->

	<section id="twitter">
		<div id="twitter-feed" class="carousel slide" data-interval="false">
			<div class="twit">
				<img class="img-responsive" src="/images/twit.png" alt="twit">
			</div>
			<div class="row">
				<div class="col-sm-6 col-sm-offset-3">
					<div class="text-center carousel-inner center-block">
						<?php echo app\widgets\SiteReviewsWidget::widget(); ?>
					</div>
					<a class="twitter-control-left" href="#twitter-feed" data-slide="prev"><i class="fa fa-angle-left"></i></a>
					<a class="twitter-control-right" href="#twitter-feed" data-slide="next"><i class="fa fa-angle-right"></i></a>
				</div>
			</div>
		</div>
	</section><!--/#twitter-feed-->

	<section id="sponsor">
		<div id="sponsor-carousel" class="carousel slide" data-interval="false">
			<div class="container">
				<div class="row">
					<div class="col-sm-10">
						<h2>Наши услуги</h2>
						<a class="sponsor-control-left" href="#sponsor-carousel" data-slide="prev"><i class="fa fa-angle-left"></i></a>
						<a class="sponsor-control-right" href="#sponsor-carousel" data-slide="next"><i class="fa fa-angle-right"></i></a>
						<div class="carousel-inner">
							<?php echo app\widgets\SiteServicesWidget::widget(); ?>
						</div>
					</div>
				</div>
			</div>
			<div class="light">
				<img class="img-responsive" src="/images/light.png" alt="">
			</div>
		</div>
	</section><!--/#services-->

	<section id="contact">
		<div id="map">
			<div id="gmap-wrap">
				<div id="gmap">
				</div>
			</div>
		</div><!--/#map-->
		<div class="contact-section">
			<div class="ear-piece">
				<img class="img-responsive" src="/images/ear-piece.png" alt="">
			</div>
			<div class="container">
				<div class="row">

					<div class="col-sm-3 col-sm-offset-4">
						<?php echo app\widgets\SiteContactsWidget::widget(); ?>
					</div>
					<div class="col-sm-5">
						<div id="contact-section">
							<?php echo app\widgets\SiteReviewSendWidget::widget(); ?>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>
	<!--/#contact-->

	<footer id="footer">
		<div class="container">
			<div class="text-center">
				<p> Powered by <a target="_blank" href="#"> Yii </a>&copy;2018 <br> Designed by <a target="_blank" href="http://shapebootstrap.net/">ShapeBootstrap</a>
				</p>
			</div>
		</div>
	</footer>
	<!--/#footer-->
	<script>
		function initMap() {
			var uluru = {lat: 50.925958, lng: 34.7889299};
			var map = new google.maps.Map(document.getElementById('gmap'), {
				zoom: 16,
				center: uluru
			});
			var marker = new google.maps.Marker({
				position: uluru,
				map: map
			});
		}
	</script>
	<script type="text/javascript" src="/js/jquery.js"></script>
	<script type="text/javascript" src="/js/bootstrap.min.js"></script>
	<script type="text/javascript" async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyA62G2yM4Q0p3_nvEbKR_OhSfKB1AgIO9M&callback=initMap"></script>
	<!--<script type="text/javascript" src="/js/smoothscroll.js"></script>-->
	<script type="text/javascript" src="/js/jquery.parallax.js"></script>
	<script type="text/javascript" src="/js/coundown-timer.js"></script>
	<script type="text/javascript" src="/js/jquery.scrollTo.js"></script>
	<script type="text/javascript" src="/js/jquery.nav.js"></script>
	<script type="text/javascript" src="/js/site.js"></script>

	</body>
	<?php
	yii\bootstrap\Modal::begin([
		'id' => 'modal-form-ajax',
		'header' => '<h4 class="caption-subject bold uppercase font-red-sunglo"></h4>',
		'size' => 'modal-lg',
		'clientOptions' => ['backdrop' => 'static', 'keyboard' => FALSE, 'tabindex' => 1, 'data-focus-on' => 'input:first'],
		'headerOptions' => ['class' => 'bg-primary']
	]);
	yii\bootstrap\Modal::end();
	?>

	<?php
	$session = Yii::$app->session;
	$flashes = $session->getAllFlashes();
	foreach ($flashes as $type => $flash) {
		if (!isset($this->alertTypes[$type])) {
			continue;
		}
		foreach ((array)$flash as $i => $message) {
			echo "<script> gritterAdd('Ошибка!', {$message}, 'gritter-success'); </script>";
		}
		$session->removeFlash($type);
	}
	?>

	<?php $this->endBody() ?>
	<head>
		<meta charset="<?= Yii::$app->charset ?>">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<?= Html::csrfMetaTags() ?>
		<title><?= Html::encode($this->title) ?></title>
		<?php $this->head() ?>
		<meta name="description" content="">
		<meta name="author" content="">
		<link href="/css/bootstrap.min.css" rel="stylesheet">
		<link href="/css/font-awesome.min.css" rel="stylesheet">
		<link href="/css/site.css" rel="stylesheet">
		<link href="/css/animate.css" rel="stylesheet">
		<link href="/css/responsive.css" rel="stylesheet">

		<!--[if lt IE 9]>
		<script src="/js/html5shiv.js"></script>
		<script src="/js/respond.min.js"></script>
		<![endif]-->
		<link rel="shortcut icon" href="/images/ico/favicon.ico">
		<link rel="apple-touch-icon-precomposed" sizes="144x144" href="/images/ico/apple-touch-icon-144-precomposed.png">
		<link rel="apple-touch-icon-precomposed" sizes="114x114" href="/images/ico/apple-touch-icon-114-precomposed.png">
		<link rel="apple-touch-icon-precomposed" sizes="72x72" href="/images/ico/apple-touch-icon-72-precomposed.png">
		<link rel="apple-touch-icon-precomposed" href="/images/ico/apple-touch-icon-57-precomposed.png">
	</head><!--/head-->
	</html>
<?php $this->endPage() ?>