<?php

use app\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\forms\UserForm */

$this->title = 'Request Account';
$this->params['breadcrumbs'][] = ['label' => 'Users', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-request">
    <div class="row">
        <div class="col-lg-6 col-lg-offset-3 col-md-8 col-md-offset-4 col-sm-10 col-sm-offset-1 content border-light">

            <h2><?= Html::encode($this->title) ?></h2>

            <?= $this->render("_form", [
                "model" => $model,
            ]) ?>

        </div>
    </div>
</div>