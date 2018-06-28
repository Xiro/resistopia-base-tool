<?php

use app\helpers\Html;
use app\models\User;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var $searchModel app\models\search\UserSearch */

$this->title = 'Users';
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="user-index">
    <div class="container">

        <h1>
            <?= Html::encode($this->title) ?>

            <span class="heading-btn-group pull-right">
                <?php if (User::find()->where(['approved' => 0])->count() && Yii::$app->controller->action->id != 'approve'): ?>
                    <?= Html::a(
                        'Approve Users',
                        ["user/approve"],
                        ["class" => "btn btn-default"]
                    ); ?>
                <?php endif; ?>
                <?= Html::a(
                    "<span class=\"glyphicon glyphicon-plus\"></span> " . 'Create User',
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