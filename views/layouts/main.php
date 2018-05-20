<?php

/* @var $this \yii\web\View */
/* @var $content string */

use app\assets\BootboxAsset;
use app\widgets\Alert;
use yii\bootstrap\Modal;
use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use app\assets\AppAsset;

AppAsset::register($this);
BootboxAsset::overrideSystemConfirm();
$this->registerAssetBundle(skinka\widgets\gritter\GritterAsset::className());
$this->title = $this->context->title;

?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
	<meta charset="<?= Yii::$app->charset ?>">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<?= Html::csrfMetaTags() ?>
	<title><?= Html::encode($this->title) ?></title>
	<?php $this->head() ?>
</head>
<body>
<?php $this->beginBody() ?>

<div class="wrap">
	<?php
	NavBar::begin([
		'brandLabel' => 'NEXUS',
		'brandUrl' => Yii::$app->homeUrl,
		'innerContainerOptions' => ['class'=>'container-fluid'],
		'options' => [
			'class' => 'navbar-inverse navbar-fixed-top',
		],
	]);
	echo Nav::widget([
		'options' => ['class' => 'navbar-nav navbar-right'],
		'items' => $this->context->menuItems,
	]);
	NavBar::end();
	?>

	<div class="container">
		<?= Breadcrumbs::widget([
			'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : $this->context->breadcrumbs,
		]) ?>
		<?= Alert::widget() ?>
		<?= $content ?>
	</div>
</div>

<footer class="footer">
	<div class="container">
		<p class="pull-left">&copy; My Company <?= date('Y') ?></p>

		<p class="pull-right"><?= Yii::powered() ?></p>
	</div>
</footer>
<?php
yii\bootstrap\Modal::begin([
	'id' => 'modal-form-ajax',
	'header' => '<h4 class="caption-subject bold uppercase font-red-sunglo"></h4>',
	'size' => 'modal-lg',
	'clientOptions' => ['backdrop' => 'static', 'keyboard' => FALSE, 'tabindex'=> 1, 'data-focus-on'=>'input:first'],
	'headerOptions' => ['class'=>'bg-primary']
]);
yii\bootstrap\Modal::end();
?>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
