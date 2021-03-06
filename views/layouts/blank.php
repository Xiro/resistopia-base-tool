<?php

/* @var $this \yii\web\View */
/* @var $content string */

use app\assets\AppAsset;
use app\helpers\Html;
use mate\yii\widgets\AlertBoxes;

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
<body class="layout-blank">
<?php $this->beginBody() ?>

<span class="hidden" id="check-lock-url" data-url="<?= \yii\helpers\Url::to(['site/is-locked']) ?>"></span>

<?= $this->render('_alert-boxes') ?>

<div class="wrap">
    <div class="<?= $isAjax ? "" : "" ?>">
        <?= $content ?>
    </div>
</div>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
