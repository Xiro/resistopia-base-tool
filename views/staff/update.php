<?php

use app\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\forms\StaffForm */

$this->title = $model->rpn . " (" . $model->getName() . ")";
$this->params['breadcrumbs'][] = ['label' => 'Staff', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->rpn, 'url' => ['view', 'id' => $model->rpn]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="staff-update">
    <div class="container">
        <h1>
            <?= Html::encode($this->title) ?>
            <span class="heading-btn-group pull-right">
                <?= Html::a(
                    Html::button(
                        'Add File Memo',
                        ["class" => "btn btn-primary"]
                    ),
                    [
                        'staff-file-memo/create',
                        'id' => $model->rpn
                    ]
                ) ?>
                <?= Html::a(
                    Html::button(
                        'Edit Rights',
                        ["class" => "btn btn-primary"]
                    ),
                    [
                        'staff/grant-rights',
                        'id' => $model->rpn
                    ]
                ) ?>
                <?= Html::a(
                    Html::button(
                        $model->staffBackground ? 'Update Background' : 'Add Background',
                        ["class" => "btn btn-primary"]
                    ),
                    [
                        $model->staffBackground ? 'staff-background/update' : 'staff-background/create',
                        'id' => $model->rpn
                    ]
                ) ?>
            </span>
        </h1>

        <?= $this->render("_form", [
            "model" => $model,
        ]) ?>
    </div>
</div>