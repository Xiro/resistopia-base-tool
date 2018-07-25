<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\MedicineCheckup */

$this->title = 'Eingangsuntersuchung löschen';
$this->params['breadcrumbs'][] = ['label' => 'Medicine Checkups', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="medicine-checkup-confirm-delete">

    <div class="container-fluid padding-large-vertical">

        <h2><?= Html::encode($this->title) ?></h2>

        <div class="text-large">
            <p class="padding-large-vertical">
                <?= 'Bist du sicher, dass du diesen Bericht löschen willst?' ?>
            </p>
            <div class="row">
                <div class="col-md-6">
                    <?= Html::a(
                        'Ja',
                        ["delete", "id" => $model->id],
                        [
                            "class" => "btn btn-default btn-block",
                            "data" => ["method" => "post"]
                        ]
                    ) ?>
                </div>
                <div class="col-md-6">
                    <?= Html::a(
                        'Nein',
                        ["index"],
                        ["class" => "btn btn-default btn-block"]
                    ) ?>
                </div>
            </div>
        </div>
    </div>

</div>