<?php

use app\helpers\Html;
use app\models\User;
use mate\yii\widgets\Glyphicon;
use yii\helpers\Url;
use app\models\StaffColumnDisplay;
use yii\bootstrap\ActiveForm;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var $searchModel app\models\search\StaffSearch */
/* @var $columnDisplay StaffColumnDisplay */

$this->title = 'Staff';
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="staff-index">
    <div class="container">

        <h1>
            <?= Html::encode($this->title) ?>

            <span class="heading-btn-group pull-right" style="margin-top: -5px;">
                <div class="animated-label">
                    <div class="form-group">
                        <?php
                        echo \kartik\select2\Select2::widget([
                            'showToggleAll' => false,
                            'name'          => 'download',
                            'data'          => [
                                Url::to(['staff/download-callsigns'])     => 'Callsigns',
                                Url::to(['staff/download-combat-medics']) => 'Combat Medics',
                            ],
                            'options'       => [
                                'placeholder' => '',
                                'class'       => 'form-control',
                                'onchange'    => 'location = this.value;',
                            ],
                        ]);
                        ?>
                        <label for="download">
                            <?= Glyphicon::download_alt() ?> Download Table
                        </label>
                    </div>
                </div>
                <?= Html::a(
                    Html::button(Glyphicon::plus() . ' Create Staff', ["class" => "btn btn-default"]),
                    ["create"]
                ); ?>
                <?= Html::button(
                    Glyphicon::menu_hamburger(),
                    [
                        "class" => "btn btn-default accordion-toggle",
                        "data"  => [
                            "toggle" => "#staff-column-select"
                        ]
                    ]
                ); ?>
            </span>
        </h1>

        <div id="staff-column-select" style="display: none">
            <?= $this->render('../staff-column-display/_form', [
                'model' => $columnDisplay
            ]) ?>
        </div>

        <div class="">
            <?= $this->render("_table", [
                "dataProvider" => $dataProvider,
                "searchModel"  => $searchModel,
                "exclude"      => $columnDisplay->getExcludeArray(),
                "mergeExclude" => false,
            ]) ?>
        </div>
    </div>
</div>