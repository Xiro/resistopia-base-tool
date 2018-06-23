<?php

use app\helpers\Html;
use yii\helpers\Url;
use yii\bootstrap\ActiveForm;
use kartik\select2\Select2;
use mate\yii\widgets\ValMap;
use yii\data\ActiveDataProvider;
use app\models\Staff;
use app\models\search\StaffSearch;

/* @var $this yii\web\View */
/* @var $model \app\models\forms\TeamForm */
/* @var $form yii\bootstrap\ActiveForm */
?>

<div class="team-form">

    <?php $form = ActiveForm::begin([
        "options"     => ["class" => "animated-label"],
        "fieldConfig" => ["template" => "{input}\n{label}\n{hint}\n{error}"],
    ]); ?>

    <div class="row">
        <div class="col-md-6">
            <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6">
            <?= $form->field($model, 'description')->textarea(['rows' => 6]) ?>
        </div>
        <div class="col-md-6">
            <?= $form->field($model, 'comment')->textarea(['rows' => 6]) ?>
        </div>
    </div>

    <?= $this->render('../staff/_table-form', [
        'selectableDataProvider' => new ActiveDataProvider([
            'query' => Staff::find()->where([
                'or',
                ['!=', 'team_id', $model->id],
                ['team_id' => null]
            ]),
        ]),
        'selectedDataProvider'   => new ActiveDataProvider([
            'query' => $model->getStaff(),
        ]),
        'form'                   => $form,
        'model'                  => $model,
        'searchUrl'              => Url::to(['staff/search-team-form', 'teamId' => $model->id]),
        'searchModel'            => new StaffSearch(),
        'exclude'                => ['team'],

    ]) ?>

    <div class="form-group">
        <?= Html::submitButton(
            $model->isNewRecord ? 'Create' : 'Update',
            ["class" => $model->isNewRecord ? "btn btn-success" : "btn btn-primary"]
        ) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>