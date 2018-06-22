<?php

/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use app\assets\AppAsset;

$isAjax = Yii::$app->request->isAjax;
AppAsset::register($this);
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

<?php
$flashMessages = [];
foreach (Yii::$app->session->getAllFlashes() as $status => $data) {
    $data = (array)$data;
    foreach ($data as $message) {
        $flashMessages[] = [
            "status"  => $status,
            "message" => $message
        ];
    }
}
?>
<div id="flash-messages" data-messages='<?= json_encode($flashMessages) ?>'>
</div>

<div class="wrap">
    <?php
    NavBar::begin([
//        'brandLabel' => 'My Company',
//        'brandUrl' => Yii::$app->homeUrl,
        'options' => [
            'class' => 'navbar-inverse navbar-fixed-top',
        ],
    ]);
    $navItems[] = ['label' => 'Access', 'items' => [
        ['label' => 'Rights', 'url' => ['access-bit/index']],
        ['label' => 'Masks', 'url' => ['access-mask/index']],
        ['label' => 'Security Areas', 'url' => ['access-security-area/index']],
        ['label' => 'Categories', 'url' => ['access-category/index']],
    ]];
    $navItems[] = ['label' => 'Admin', 'items' => [
        ['label' => 'Users', 'url' => ['user/index']],
        ['label' => 'Ranks', 'url' => ['rank/index']],
    ]];
    $navItems[] = ['label' => 'Mission Control', 'url' => ['mission/control']];
    $navItems[] = ['label' => 'Mission Calls', 'url' => ['mission-call/index']];
    $navItems[] = ['label' => 'Missions', 'url' => ['mission/index']];
    $navItems[] = ['label' => 'Staff', 'url' => ['staff/index']];
    $navItems[] = ['label' => 'Teams', 'url' => ['team/index']];
    echo Nav::widget([
        'options' => ['class' => 'navbar-nav navbar-right'],
        'items'   => $navItems,
    ]);
    NavBar::end();
    ?>

    <div class="<?= $isAjax ? "" : "container" ?>">
        <?= $content ?>
    </div>
</div>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
