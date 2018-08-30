<?php

use app\helpers\Html;

/* @var $this yii\web\View */

$this->title = 'Resistopia Base Tool';
?>
<div class="site-index">

    <?php if (YII_ENV !== 'dev'): ?>
        <div class="jumbotron text-center">
            <h1><?= $this->title ?></h1>

            <p class="lead">This is the test version of the base tool</p>
            <p class="lead">Feel free to go nuts</p>
        </div>
    <?php else: ?>
        <div class="content-container text-center">
            <br><br>
            <br><br>
            <?= $this->render('../layouts/_icon-rotation') ?>
        </div>
    <?php endif; ?>

</div>
</div>
