<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\AccessSecurityArea */

$this->title = 'Create Access Security Area';
$this->params['breadcrumbs'][] = ['label' => 'Access Security Areas', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="access-security-area-create">
    <div class="container">
        <h1><?= Html::encode($this->title) ?></h1>

        <?= $this->render("_form", [
        "model" => $model,
    ]) ?>
    </div>
</div>