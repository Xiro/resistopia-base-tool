<?php

use app\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\EyeColor */

$this->title = 'Delete Eye Color';
$this->params['breadcrumbs'][] = ['label' => 'Eye Colors', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="eye-color-confirm-delete">

    <div class="container-fluid padding-large-vertical">

        <h2><?= Html::encode($this->title) ?></h2>

        <div class="text-large">
            <p class="padding-large-vertical">
                <?= 'Are you sure you want to delete this entry?' ?>
            </p>
            <div class="row">
                <div class="col-md-6">
                    <?= Html::a(
                        'Yes',
                        ["delete", "id" => $model->id],
                        [
                            "class" => "btn btn-default btn-block",
                            "data" => ["method" => "post"]
                        ]
                    ) ?>
                </div>
                <div class="col-md-6">
                    <?= Html::a(
                        'No',
                        ["index"],
                        ["class" => "btn btn-default btn-block"]
                    ) ?>
                </div>
            </div>
        </div>
    </div>

</div>