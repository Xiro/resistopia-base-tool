<?php

/* @var $this \yii\web\View */
/* @var $content string */

use app\helpers\Html;
use app\assets\AppAsset;
use mate\yii\widgets\AlertBoxes;

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
<body class="login">

<?php $this->beginBody() ?>

<?= $this->render('_alert-boxes') ?>

<span class="hidden" id="check-lock-url" data-url="<?= \yii\helpers\Url::to(['site/is-locked']) ?>"></span>

<div class="background content-center">
    <div class="background-overlay"></div>
    <div class="background-content">
        <?= $this->render('../layouts/_icon-rotation') ?>
    </div>
</div>

<div class="content-login content-center">
    <?= $content ?>
</div>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
