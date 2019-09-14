<?php

use mate\yii\widgets\Glyphicon;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var $searchModel app\models\search\RadioMessageSearch */

$this->title = 'Radio Messages';
$this->params['breadcrumbs'][] = $this->title;

?>
<?php if (!Yii::$app->request->isAjax): ?>
<div class="radio-message-index">
    <div class="container">
        <h1>
            <?= Html::encode($this->title) ?>

            <span class="heading-btn-group">
                    <?= Glyphicon::refresh(['class' => 'btn-auto-reload active']) ?>
            </span>

            <span class="heading-btn-group pull-right">
            <?= Html::a(
                "<span class=\"glyphicon glyphicon-plus\"></span> " . 'Create Radio Message',
                ["create"],
                ["class" => "btn btn-primary"]
            ); ?>
            </span>
        </h1>
        <?php endif; ?>
        <div class="reload-target">
            <div class="">
                <?= $this->render("_table", [
                    "dataProvider" => $dataProvider,
//                    "searchModel"  => $searchModel,
                ]) ?>
            </div>
        </div>
        <?php if (!Yii::$app->request->isAjax): ?>
    </div>
</div>
<?php endif; ?>