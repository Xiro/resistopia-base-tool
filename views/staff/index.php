<?php

use app\helpers\Html;
use app\models\User;

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
                <?= Html::a(
                    'Callsigns',
                    ["staff/download-callsigns"],
                    [
                        "class"  => "btn btn-default",
                        "target" => "_blank"
                    ]
                ); ?>
                <?php if (User::find()->where(['approved' => 0])->count()): ?>
                    <?= Html::a(
                        'Approve Users',
                        ["user/approve"],
                        ["class" => "btn btn-default"]
                    ); ?>
                <?php endif; ?>
                <?= Html::a(
                    'File Memos',
                    ["staff-file-memo/index"],
                    ["class" => "btn btn-default"]
                ); ?>
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