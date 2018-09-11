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
use mate\yii\widgets\AlertBoxes;
use app\models\Mission;

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
    <link rel="icon" type="image/png" sizes="32x32" href="/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="96x96" href="/favicon-96x96.png">
    <link rel="icon" type="image/png" sizes="16x16" href="/favicon-16x16.png">
    <meta name="theme-color" content="#ffffff">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body>
<?php $this->beginBody() ?>


<?= AlertBoxes::htmlFromFlashMessages() ?>

<div class="wrap">
    <?php
    $staff = AccessRule::activeStaff(false);
    NavBar::begin([
        'brandLabel' => '',
        'brandUrl'   => false,
        'options'    => [
            'class' => 'navbar-inverse navbar-fixed-top',
        ],
    ]);

    if ($staff) {
        echo Nav::widget([
            'options' => ['class' => 'navbar-nav navbar-left'],
            'items'   => [
                ['label' => $staff->nameWithRpn, 'items' => [
                    ['label' => 'Logout', 'url' => ['user/logout']],
                ]],
            ],
        ]);
    }

    $navItems = [];

    $adminItems = [];
    Access::addNavItem(['label' => 'Base Categories', 'url' => ['base-category/index']], $adminItems);
    Access::addNavItem(['label' => 'Citizenships', 'url' => ['citizenship/index']], $adminItems);
    Access::addNavItem(['label' => 'Companies', 'url' => ['company/index']], $adminItems);
    Access::addNavItem(['label' => 'Eye Colors', 'url' => ['eye-color/index']], $adminItems);
    Access::addNavItem(['label' => 'Ranks', 'url' => ['rank/index']], $adminItems);
    Access::addNavItem(['label' => 'Special Functions', 'url' => ['special-function/index']], $adminItems);
    Access::addNavItem(['label' => 'Users', 'url' => ['user/index']], $adminItems);
    Access::addNavItem(['label' => 'Drugs', 'url' => ['medicine-drug/index']], $adminItems);
    Access::addNavItem(['label' => 'Clear Cache', 'url' => ['site/clear-cache']], $adminItems);
    if (!empty($adminItems)) {
        $navItems[] = ['label' => 'Admin', 'items' => $adminItems];
    }

    $accessItems = [];
    Access::addNavItem(['label' => 'Rights', 'url' => ['access-right/index']], $accessItems);
    Access::addNavItem(['label' => 'Masks', 'url' => ['access-mask/index']], $accessItems);
    Access::addNavItem(['label' => 'Security Areas', 'url' => ['access-security-area/index']], $accessItems);
    Access::addNavItem(['label' => 'Categories', 'url' => ['access-category/index']], $accessItems);
    if (!empty($accessItems)) {
        $navItems[] = ['label' => 'Access', 'items' => $accessItems];
    }

    $medicineItems = [];
    Access::addNavItem(['label' => 'Eingangsuntersuchung A38', 'url' => ['medicine-checkup/index']], $medicineItems);
    Access::addNavItem(['label' => 'Behandlung', 'url' => ['medicine-treatment/index']], $medicineItems);
    Access::addNavItem(['label' => 'Medi Foam Ausgabe', 'url' => ['medi-foam-distribution/index']], $medicineItems);
    if (!empty($medicineItems)) {
        $navItems[] = ['label' => 'Medicine', 'items' => $medicineItems];
    }

    $missionItems = [];
    Access::addNavItem(['label' => 'Show All', 'url' => ['mission/index']], $missionItems);
    Access::addNavItem(['label' => 'Mission Control', 'url' => ['mission/control']], $missionItems);
    Access::addNavItem(['label' => 'Planned', 'url' => ['mission/planned']], $missionItems);
    Access::addNavItem(['label' => 'Called', 'url' => ['mission/called']], $missionItems);
    Access::addNavItem(['label' => 'Active', 'url' => ['mission/active']], $missionItems);
    Access::addNavItem(['label' => 'Archive', 'url' => ['mission/archive']], $missionItems);
    Access::addNavItem(['label' => 'Templates', 'url' => ['mission/templates']], $missionItems);
    Access::addNavItem(['label' => 'Gate', 'url' => ['mission/gate']], $missionItems);
    if(AccessRule::activeStaff()) {
        $statusIds = \app\models\MissionStatus::getStatusIds();
        $leadMissionsCount = Mission::find()->where(['mission_lead_rpn' => AccessRule::activeStaff()->rpn])->count();
        if ($leadMissionsCount) {
            Access::addNavItem(['label' => 'Missions lead by me', 'url' => ['mission/index-lead']], $missionItems);
        }
    }
    if (!empty($missionItems)) {
        $navItems[] = ['label' => 'Missions', 'items' => $missionItems];
    }

    $staffItems = [];
    Access::addNavItem(['label' => 'Show All', 'url' => ['staff/index']], $staffItems);
    Access::addNavItem(['label' => 'Teams', 'url' => ['team/index']], $staffItems);
    Access::addNavItem(['label' => 'File Memos', 'url' => ['staff-file-memo/index']], $staffItems);
    Access::addNavItem(['label' => 'Mission Blocks', 'url' => ['mission-block/index']], $staffItems);
    Access::addNavItem(['label' => 'Approve Users', 'url' => ['user/approve']], $staffItems);
    if (!empty($staffItems)) {
        $navItems[] = ['label' => 'Staff', 'items' => $staffItems];
    }

    echo Nav::widget([
        'options' => ['class' => 'navbar-nav navbar-right'],
        'items'   => $navItems,
    ]);
    NavBar::end();
    ?>

    <div class="<?= $isAjax ? "" : "container" ?>">

        <?php if (YII_ENV === "dev"): ?>
            <div class="container">
                <div class="h4 text-center" style="margin-top: 8px; margin-bottom: -10px">
                    Development System
                </div>
            </div>
        <?php endif; ?>
        <?= $content ?>
    </div>
</div>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
