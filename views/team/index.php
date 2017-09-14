<?php

use yii\widgets\ActiveForm;
use yii\helpers\Html;
use yii\helpers\Url;
use app\models\Team;
use kartik\select2\Select2;
use app\helpers\ValMap;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var $search \app\models\search\TeamSearch */

$this->title = 'Teams';
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="team-index">
    <div class="container">

        <h1>
            <?= Html::encode($this->title) ?>

            <span class="heading-btn-group pull-right">
            <?= Html::a(
                "<span class=\"glyphicon glyphicon-plus\"></span> Add Team",
                ["create"],
                ["class" => "btn btn-primary ajax-dialog"]
            ); ?>
            </span>
        </h1>

        <div class="cropped-width-md">
            <?php $form = ActiveForm::begin([
                'id'          => 'index-search-form',
                "action"      => Url::to(["team/search"]),
                "options"     => [
                    'clientValidation' => false,
                    "class"            => "animated-label",
                    "data"             => [

                    ]
                ],
                "fieldConfig" => ["template" => "{input}\n{label}\n{hint}\n{error}"],
            ]); ?>
            <?php ActiveForm::end(); ?>


            <table class="table table-bordered team-table" id="index-search-table">
                <thead>
                <tr class="animated-label">
                    <th class="name">
                        <?= $form->field($search, 'name', [
                            'labelOptions' => ['class' => ($search->name ? "move" : "")]
                        ])->widget(Select2::classname(), [
                            'showToggleAll' => false,
                            'data'          => ValMap::model(Team::class, "name", "name"),
                            'options'       => [
                                'placeholder' => '',
                                'form'        => 'index-search-form',
                            ],
                            'pluginOptions' => [
                                'allowClear' => true,
                            ],
                        ])->label("Team") ?>
                    </th>
                    <th class="members">
                        Members
                    </th>
                    <th class="actions"></th>
                </tr>
                </thead>
                <tbody>
                <?= $this->render("_team-table-body", [
                    "teamModels" => $dataProvider->getModels()
                ]); ?>
                </tbody>

        </div>
    </div>
</div>