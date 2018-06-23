<?php

/* @var $this \yii\web\View */
/* @var $content string */

use app\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use app\assets\AppAsset;
use app\components\AccessRule;
use app\components\Access;

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
    <link href="https://fonts.googleapis.com/css?family=Work+Sans|Orbitron" rel="stylesheet">
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
    $staff = AccessRule::activeStaff(false);
    NavBar::begin([
        'brandLabel' => $staff ? $staff->name . ' (' . $staff->rpn . ')' : '',
        'brandUrl' => false,
        'options' => [
            'class' => 'navbar-inverse navbar-fixed-top',
        ],
    ]);

    if($staff) {
        echo Nav::widget([
            'options' => ['class' => 'navbar-nav navbar-left'],
            'items'   => [
//                ['label' => $staff->name, 'url' => false],
                ['label' => 'Logout', 'url' => ['user/logout']],
            ],
        ]);
    }

    $accessItems = [];
    Access::addNavItem(['label' => 'Rights', 'url' => ['access-bit/index']], $accessItems);
    Access::addNavItem(['label' => 'Masks', 'url' => ['access-mask/index']], $accessItems);
    Access::addNavItem(['label' => 'Security Areas', 'url' => ['access-security-area/index']], $accessItems);
    Access::addNavItem(['label' => 'Categories', 'url' => ['access-category/index']], $accessItems);
    if(!empty($accessItems)) {
        $navItems[] = ['label' => 'Access', 'items' => $accessItems];
    }

    $adminItems = [];
    Access::addNavItem(['label' => 'Base Categories', 'url' => ['base-category/index']], $adminItems);
    Access::addNavItem(['label' => 'Citizenships', 'url' => ['citizenship/index']], $adminItems);
    Access::addNavItem(['label' => 'Companies', 'url' => ['company/index']], $adminItems);
    Access::addNavItem(['label' => 'Eye Colors', 'url' => ['eye-color/index']], $adminItems);
    Access::addNavItem(['label' => 'Ranks', 'url' => ['rank/index']], $adminItems);
    Access::addNavItem(['label' => 'Special Functions', 'url' => ['special-function/index']], $adminItems);
    Access::addNavItem(['label' => 'Users', 'url' => ['user/index']], $adminItems);
    if(!empty($adminItems)) {
        $navItems[] = ['label' => 'Admin', 'items' => $adminItems];
    }

//    $navItems[] = ['label' => 'Mission Control', 'url' => ['mission/control']];
//    $navItems[] = ['label' => 'Mission Calls', 'url' => ['mission-call/index']];
//    $navItems[] = ['label' => 'Missions', 'url' => ['mission/index']];
    Access::addNavItem(['label' => 'Staff', 'url' => ['staff/index']], $navItems);
    Access::addNavItem(['label' => 'Teams', 'url' => ['team/index']], $navItems);

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
