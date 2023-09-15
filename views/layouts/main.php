<?php

/* @var $this \yii\web\View */
/* @var $content string */

use app\assets\BootboxAsset;
use yii\helpers\Html;
use app\assets\AppAsset;

AppAsset::register($this);
BootboxAsset::overrideSystemConfirm();
$this->registerAssetBundle(skinka\widgets\gritter\GritterAsset::className());
$this->assetManager->bundles['yii\bootstrap\BootstrapAsset']->css = [];
$this->title = $this->context->title;

?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/css/style.css">
    <link rel="stylesheet" href="/css/new.css">
    <link rel="stylesheet" href="/fonts/fonts.css">
    <?php $this->registerCsrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
    <link rel="preload" href="/fonts/Inter-Bold.woff2" as="font" type="font/woff" crossorigin="anonymous">
    <link rel="preload" href="/fonts/Inter-Regular.woff2" as="font" type="font/woff" crossorigin="anonymous">
    <link rel="preload" href="/fonts/Inter-Medium.woff2" as="font" type="font/woff" crossorigin="anonymous">
</head>
<?php $this->beginBody() ?>
<body> <!--  если єто главная страница добавить класс "home" -->
<?= $this->render('main/header')?>
<main>
    <!-- если єто главная Хлебны на главной то не выводим -->
    <ul style="display: none;" class="breadcrumb container">
        <li><span class="icon small_s"><svg><use xlink:href="#down_arow"></use></svg></span><a href="">Главная</a></li>
        <li><span class="icon small_s"><svg><use xlink:href="#down_arow"></use></svg></span>Компьютеры</li>
    </ul>
<div class="header_box container">
    <h1>Шиномонтаж  на Левоневского, круглосуточно</h1>
    <p>Рихтовка литья, подкачка и замена резины </p>
    <div class="home_btn">
        <a href="" class="secondary radius icon_buton">Записаться</a>
        <a href="" class="simple radius" >Показать на карте</a>
    </div>
</div>
<?= app\widgets\SiteServicesWidget::widget(); ?>

<div class="order_list_view container">
    <div class="title_data">
        <div class="title_left_box">
            <div class="title">Записаться <span>на обслуживание</span></div>
            <a href="" class="secondary radius icon_buton">Календарь</a>
            <?= kartik\date\DatePicker::widget([
                'removeButton' => false,
                'name' => 'site_boxes_timetable_date',
                'id' => 'site-boxes_timetable_date',
                'value' => date('Y-m-d'),
                'type' => kartik\date\DatePicker::TYPE_COMPONENT_APPEND,
                'options' => ['class' => 'radius icon_buton'],
                'pluginOptions' => [
                    'autoclose' => true,
                    'format' => 'yyyy-mm-dd'
                ]
            ]) ?>
            <div class="view_data_free">
                <?php for ($i = 0; $i < 4; $i++):?>
                    <div class="js-select-date" data-value="<?=date('Y-m-d', strtotime('+'.$i.' days'))?>"><?= date('Y-m-d', strtotime('+'.$i.' days'))?> <span>3 места ></span></div>
                <?php endfor;?>
            </div>
        </div>
    </div>
    <?php echo app\widgets\SiteBoxesTimetableWidget::widget(); ?>
</div>
</main>
<?= $this->render('main/footer')?>
<!-- <a href="#" class="to-top  arrow secondary"><svg><use xlink:href="#down_arow"></use></svg></a> -->
<!--<script src="/js/jquery.js"></script>-->
<!--<script src="/js/template.js"></script>-->
<!--<script src="/js/select2.min.js"></script>-->
<!-- Если это страница мероприятия подключать эти фалы -->
<!--<script src="/js/fancybox.min.js"></script>-->
<!--<script src="/js/slick.min.js"></script>-->
<!--<link rel="stylesheet" href="/css/fancybox.min.css">-->
</body>
<?php
if (false) {
    yii\bootstrap\Modal::begin([
        'id' => 'modal-form-ajax',
        'header' => '<h4 class="caption-subject bold uppercase font-red-sunglo"></h4>',
        'size' => 'modal-lg',
        'clientOptions' => ['backdrop' => 'static', 'keyboard' => FALSE, 'tabindex' => 1, 'data-focus-on' => 'input:first'],
        'headerOptions' => ['class' => 'bg-primary']
    ]);
    yii\bootstrap\Modal::end();
}
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
<?php $this->endBody();?>
</html>
<?php $this->endPage() ?>