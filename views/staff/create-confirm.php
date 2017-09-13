<?php

use yii\helpers\Html;
use app\widgets\Glyphicon;

/* @var $this yii\web\View */
/* @var $model app\models\Staff */

$this->title = 'Added Staff Member';
$this->params['breadcrumbs'][] = ['label' => 'Staff', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="staff-create">

    <div class="row">
        <div class="jumbotron col-md-6 col-md-offset-3">
            <h3><?= Html::encode($this->title) ?></h3>
            <div class="h4">
                <div class="row">
                    <div class="col-sm-2">Name:</div>
                    <div class="col-sm-10"><?= $model->getName() ?></div>
                </div>
            </div>
            <div class="h4">
                <div class="row">
                    <div class="col-sm-2">RPN:</div>
                    <div class="col-sm-10"><?= $model->rpn ?></div>
                </div>
            </div>
            <div class="lead">
                <div class="row">
                    <div class="col-md-6">
                        <?= Html::a(
                            Glyphicon::menu_left() . " Back to index",
                            ["index"],
                            ["class" => "btn btn-primary"]
                        ); ?>
                    </div>
                    <div class="col-md-6 text-right">
                        <?= Html::a(
                            Glyphicon::plus() . " Add Another",
                            ["create"],
                            ["class" => "btn btn-primary"]
                        ); ?>
                    </div>
                </div>
            </div>

        </div>
    </div>

</div>