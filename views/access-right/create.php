<?php

use app\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\forms\AccessRightForm */

$this->title = 'Create Access Right';
$this->params['breadcrumbs'][] = ['label' => 'Access Rights', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="access-right-create">
    <div class="container">
        <h1><?= Html::encode($this->title) ?></h1>

        <?= $this->render("_form", [
        "model" => $model,
    ]) ?>
    </div>
</div>