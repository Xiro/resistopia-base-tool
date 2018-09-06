<?php

use app\helpers\Html;
use app\models\User;
use mate\yii\widgets\Glyphicon;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var $searchModel app\models\search\StaffSearch */

$this->title = 'Staff';
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="staff-index">
    <div class="container">

        <h1>
            <?= Html::encode($this->title) ?>

            <span class="heading-btn-group pull-right">
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
                            <?= Glyphicon::download_alt()?> Download Table
                        </label>
                    </div>
                </div>
                <?= Html::a(
                    "<span class=\"glyphicon glyphicon-plus\"></span> " . 'Create Staff',
                    ["create"],
                    ["class" => "btn btn-default"]
                ); ?>
            </span>
        </h1>

        <div class="">
            <?= $this->render("_table", [
                "dataProvider" => $dataProvider,
                "searchModel"  => $searchModel,
            ]) ?>
        </div>
    </div>
</div>