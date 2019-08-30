<?php

use app\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\forms\StaffForm */

$this->title = $model->sid . " (" . $model->getName() . ")";
$this->params['breadcrumbs'][] = ['label' => 'Staff', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->sid, 'url' => ['view', 'id' => $model->sid]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="staff-update">
    <div class="container">
        <h1>
            <?= Html::encode($this->title) ?>
            <span class="heading-btn-group pull-right">
        </h1>
        <?= Html::a(
            Html::button(
                'Add File Memo',
                ["class" => "btn btn-default"]
            ),
            [
                'staff-file-memo/create',
                'id' => $model->sid
            ]
        ) ?>
        <?= Html::a(
            Html::button(
                'Edit Rights',
                ["class" => "btn btn-default"]
            ),
            [
                'staff/grant-rights',
                'id' => $model->sid
            ]
        ) ?>
        <?= Html::a(
            Html::button(
                $model->staffBackground ? 'Update Background' : 'Add Background',
                ["class" => "btn btn-default"]
            ),
            [
                $model->staffBackground ? 'staff-background/update' : 'staff-background/create',
                'id' => $model->sid
            ]
        ) ?>
        <?php if ($model->isBlocked): ?>
            <?= Html::a(
                Html::button(
                    'Lift Mission Block',
                    ["class" => "btn btn-default"]
                ),
                ['mission-block/lift', 'id' => $model->sid],
                ['title' => 'Lift Mission Block']
            ) ?>
        <?php else: ?>
            <?= Html::a(
                Html::button(
                    'Add Mission Block',
                    ["class" => "btn btn-default"]
                ),
                ['mission-block/create', 'id' => $model->sid],
                ['title' => 'Add Mission Block']
            ) ?>
        <?php endif; ?>
        </span>

        <?= $this->render("_form", [
            "model" => $model,
        ]) ?>
    </div>
</div>