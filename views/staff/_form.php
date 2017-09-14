<?php

use app\helpers\ValMap;
use app\models\BloodType;
use app\models\Category;
use app\models\Company;
use app\models\EyeColor;
use app\models\Rank;
use app\models\Role;
use app\models\Speciality;
use app\models\StaffStatus;
use app\models\Team;
use kartik\select2\Select2;
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\form\StaffForm */
/* @var $form yii\bootstrap\ActiveForm */
?>

<div class="staff-form">

    <?php $form = ActiveForm::begin([
        'id'          => 'staff-form',
        "options"     => ["class" => "animated-label"],
        "fieldConfig" => ["template" => "{input}\n{label}\n{hint}\n{error}"],
    ]); ?>

    <h3>Personal Information</h3>

    <div class="row">
        <div class="col-md-6">
            <?= $form->field($model, 'forename')->textInput(['maxlength' => true]) ?>
        </div>
        <div class="col-md-6">
            <?= $form->field($model, 'surname')->textInput(['maxlength' => true]) ?>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6">
            <?= $form->field($model, 'nickname')->textInput(['maxlength' => true]) ?>
        </div>
        <div class="col-md-6">
            <?= $form->field($model, 'gender', [
                'labelOptions' => ['class' => ($model->gender ? "move" : "")]
            ])->widget(Select2::classname(), [
                'showToggleAll' => false,
                'data'          => ["male" => "male", "female" => "female"],
                'options'       => [
                    'placeholder' => '',
                ],
                'pluginOptions' => [
                    'allowClear' => true,
                ],
            ])->label("Gender") ?>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6">
            <?= $form->field($model, 'height')->textInput() ?>
        </div>
        <div class="col-md-6">
            <?= $form->field($model, 'eye_color_id', [
                'labelOptions' => ['class' => ($model->eye_color_id ? "move" : "")]
            ])->widget(Select2::classname(), [
                'showToggleAll' => false,
                'data'          => ValMap::model(EyeColor::class, "id", "name"),
                'options'       => [
                    'placeholder' => '',
                ],
                'pluginOptions' => [
                    'allowClear' => true,
                ],
            ])->label("Eye Color") ?>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6">
            <?= $form->field($model, 'blood_type_id', [
                'labelOptions' => ['class' => ($model->blood_type_id ? "move" : "")]
            ])->widget(Select2::classname(), [
                'showToggleAll' => false,
                'data'          => ValMap::model(BloodType::class, "id", "name"),
                'options'       => [
                    'placeholder' => '',
                ],
                'pluginOptions' => [
                    'allowClear' => true,
                ],
            ])->label("Blood Type") ?>

            <?= $form->field($model, 'profession')->textInput(['maxlength' => true]) ?>
        </div>
        <div class="col-md-6">
            <?= $form->field($model, 'comment')->textarea([
                'style' => "height: 117px"
            ]) ?>
        </div>
    </div>

    <h3>Affiliation</h3>

    <div class="row">
        <div class="col-md-6">
            <?= $form->field($model, 'company_id', [
                'labelOptions' => ['class' => ($model->company_id ? "move" : "")]
            ])->widget(Select2::classname(), [
                'showToggleAll' => false,
                'data'          => ValMap::model(Company::class, "id", "name"),
                'options'       => [
                    'placeholder' => '',
                ],
                'pluginOptions' => [
                    'tags' => true,
                    'allowClear' => true,
                ],
            ])->label("Company") ?>
        </div>
        <div class="col-md-6">
            <?= $form->field($model, 'category_id', [
                'labelOptions' => ['class' => ($model->category_id ? "move" : "")]
            ])->widget(Select2::classname(), [
                'showToggleAll' => false,
                'data'          => ValMap::model(Category::class, "id", "name"),
                'options'       => [
                    'placeholder' => '',
                ],
                'pluginOptions' => [
                    'allowClear' => true,
                ],
            ])->label("Category") ?>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6">
            <?= $form->field($model, 'speciality_id', [
                'labelOptions' => ['class' => ($model->speciality_id ? "move" : "")]
            ])->widget(Select2::classname(), [
                'showToggleAll' => false,
                'data'          => ValMap::model(Speciality::class, "id", "name"),
                'options'       => [
                    'placeholder' => '',
                ],
                'pluginOptions' => [
                    'allowClear' => true,
                ],
            ])->label("Speciality") ?>
        </div>
        <div class="col-md-6">
            <?= $form->field($model, 'rank_id', [
                'labelOptions' => ['class' => ($model->rank_id ? "move" : "")]
            ])->widget(Select2::classname(), [
                'showToggleAll' => false,
                'data'          => ValMap::model(Rank::class, "id", "name"),
                'options'       => [
                    'placeholder' => '',
                ],
                'pluginOptions' => [
                    'allowClear' => true,
                ],
            ])->label("Rank") ?>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6">
            <?= $form->field($model, 'team_id', [
                'labelOptions' => ['class' => ($model->team_id ? "move" : "")]
            ])->widget(Select2::classname(), [
                'showToggleAll' => false,
                'data'          => ValMap::model(Team::class, "id", "name"),
                'options'       => [
                    'placeholder' => '',
                ],
                'pluginOptions' => [
                    'tags' => true,
                    'allowClear' => true,
                ],
            ])->label("Team") ?>
        </div>
        <div class="col-md-6">
        </div>
    </div>

    <h3>System</h3>

    <div class="row">
        <div class="col-md-6">
            <?= $form->field($model, 'call_sign')->textInput(['maxlength' => true]) ?>
        </div>
        <div class="col-md-6">
            <?= $form->field($model, 'staff_status_id', [
                'labelOptions' => ['class' => ($model->staff_status_id ? "move" : "")]
            ])->widget(Select2::classname(), [
                'showToggleAll' => false,
                'data'          => ValMap::model(StaffStatus::class, "id", "name"),
                'options'       => [
                    'placeholder' => '',
                ],
                'pluginOptions' => [
                    'allowClear' => true,
                ],
            ])->label("Status") ?>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6">
            <?= $form->field($model, 'roleSelect', [
                'labelOptions' => ['class' => ($model->staff_status_id ? "move" : "")]
            ])->widget(Select2::classname(), [
                'showToggleAll' => false,
                'data'          => ValMap::model(Role::class, "id", "name"),
                'options'       => [
                    'placeholder' => '',
                    'multiple' => true,
                ],
                'pluginOptions' => [
                    'allowClear' => true,
                    'closeOnSelect' => false
                ],
            ])->label("Roles") ?>
        </div>
        <div class="col-md-6 checkbox-group">
            <?= $form->field($model, 'isBlocked')
                ->checkbox(["checked" => false])->label("SECURITY BLOCK") ?>
            <?= $form->field($model, 'isIt')
                ->checkbox(["checked" => true])->label("Is In Time") ?>
        </div>
        <div class="col-md-3">
        </div>
    </div>

    <div class="form-group">
        <?= Html::submitButton(
            $model->isNewRecord ? "Create" : "Update",
            ["class" => $model->isNewRecord ? "btn btn-success" : "btn btn-primary"]
        ) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>