<?php

use yii\helpers\Html;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var $searchModel yii\data\ActiveDataProvider */

$this->title = 'Staff';
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="staff-index">
    <div class="container">

        <h1><?= Html::encode($this->title) ?></h1>

        <div class="">

            <?= \yii\grid\GridView::widget([
                "dataProvider" => $dataProvider,
                "filterModel"  => $searchModel,
                "layout"       => "{items}{pager}",
                "tableOptions" => [
                    "class" => "table table-bordered",
                ],
                "columns"      => [
                    [
                        "attribute" => "rpn",
                    ],
                    [
                        "attribute" => "surname",
                    ],
                    [
                        "attribute" => "category.name",
                        "label"     => "category"
                    ],
                    [
                        "attribute" => "speciality.name",
                        "label"     => "speciality"
                    ],
                    [
                        "attribute" => "team.name",
                        "label"     => "Team"
                    ],
                    [
                        "attribute"      => "staffStatus.name",
                        "label"     => "Status"
                    ],
                    [
                        "attribute" => "call_sign",
                    ],
                    [
                        "class"          => "yii\grid\ActionColumn",
                        "contentOptions" => ["class" => "action-column text-right"],
                        "buttonOptions"  => ["class" => "ajax-dialog"],
                        "template"       => "{update} {confirm-delete}",
                        "buttons"        => [
                            "confirm-delete" => function ($url) {
                                return Html::a('<span class="glyphicon glyphicon-trash"></span>', $url, ["class" => "ajax-dialog"]);
                            }
                        ]
                    ],
                ],

            ]) ?>

            <?= Html::a(
                "<span class=\"glyphicon glyphicon-plus\"></span> Create Staff",
                ["create"],
                ["class" => "btn btn-success ajax-dialog"]
            ); ?>

        </div>
    </div>
</div>