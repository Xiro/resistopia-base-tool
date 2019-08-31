<?php

use app\helpers\Html;
use kartik\select2\Select2;
use yii\bootstrap\ActiveForm;
use mate\yii\widgets\SelectData;

/* @var $this yii\web\View */
/* @var $staff app\models\forms\StaffForm */
/* @var $background app\models\StaffBackground */

?>

<?php $form = ActiveForm::begin([
    "options"     => ["class" => "animated-label"],
    "fieldConfig" => ["template" => "{input}\n{label}\n{hint}\n{error}"],
]); ?>

    <style>
        .help {
            margin-bottom: 30px;
            margin-top: -10px;
        }

        .help tr td:first-child {
            width: 1px;
            font-weight: bold;
            white-space: nowrap;
            padding-right: 15px;
        }
    </style>

    <h3>Personal Information</h3>

<?php
$personalInfoHelp = [
    "Date of birth:" => "Denk daran, wir sind im Jahr 2022!",
    "Blood Type:"    => "Wenn du außerhalb der Basis startest werden die Mediziner deine Blutgruppe erfassen"
];
?>
    <table class="help">
        <?php foreach ($personalInfoHelp as $label => $value): ?>
            <tr>
                <td><?= $label ?></td>
                <td><?= $value ?></td>
            </tr>
        <?php endforeach; ?>
    </table>

    <div class="row">
        <div class="col-sm-6">
            <?= $form->field($staff, 'forename')->textInput(['maxlength' => true])->label("First Name*") ?>
        </div>
        <div class="col-sm-6">
            <?= $form->field($staff, 'surname')->textInput(['maxlength' => true])->label("Last Name*") ?>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-6">
            <?= $form->field($staff, 'nickname')->textInput(['maxlength' => true]) ?>
        </div>
        <div class="col-sm-6">
            <?= $form->field($staff, 'gender', [
                'labelOptions' => ['class' => ($staff->gender ? 'move' : '')]
            ])->widget(Select2::class, [
                'showToggleAll' => false,
                'data'          => ['m' => 'Male', 'f' => 'Female',],
                'options'       => [
                    'placeholder' => '',
                ],
                'pluginOptions' => [
                    'allowClear' => true,
                ],
            ])->label("Gender*") ?>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-6">
            <?= $form->field($staff, 'date_of_birth')->textInput([
                'class'        => 'form-control mask-date ',
                'autocomplete' => 'off'
            ])->label("Date of Birth*") ?>
        </div>
        <div class="col-sm-6">
            <?= $form->field($staff, 'height')->textInput(['autocomplete' => 'off']) ?>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-6">
            <?= $form->field($staff, 'eye_color_id', [
                'labelOptions' => ['class' => ($staff->eye_color_id ? 'move' : '')]
            ])->widget(Select2::class, [
                'showToggleAll' => false,
                'data'          => SelectData::fromModel(app\models\EyeColor::class),
                'options'       => [
                    'placeholder' => '',
                ],
                'pluginOptions' => [
                    'allowClear' => true,
                ],
            ])->label('Eye Color') ?>
        </div>
        <div class="col-sm-6">
            <?= $form->field($staff, 'profession')->textInput(['maxlength' => true]) ?>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-6">
            <?= $form->field($staff, 'blood_type_id', [
                'labelOptions' => ['class' => ($staff->blood_type_id ? 'move' : '')]
            ])->widget(Select2::class, [
                'showToggleAll' => false,
                'data'          => SelectData::fromModel(app\models\BloodType::class),
                'options'       => [
                    'placeholder' => '',
                ],
                'pluginOptions' => [
                    'allowClear' => true,
                ],
            ])->label('Blood Type') ?>
        </div>
    </div>

    <small>* required</small>


    <h3>Affiliation</h3>

<?php
$affiliationInfoHelp = [
    "Resistance Cell:"    => "Wenn du in der Base startest, wähle Widerstandszelle Mahlwinkel aus.",
    "Section:"            => "Das Spiel außerhalb der Sektion \"Combat\" muss OT abgesprochen sein",
    "Rank:"               => "Wenn nicht IT erspielt, wähle Private aus. Als Teamleiter wähle Corporal oder Sergeant aus. Lass das Feld leer, wenn du keinen Rang hast.",
    "Citizenship & Team:" => "In diesen Feldern können auch neue Werte eingetragen werden, das Eingabefeld ist nicht ausschließlich ein Suchfeld.",
];
?>
    <table class="help">
        <?php foreach ($affiliationInfoHelp as $label => $value): ?>
            <tr>
                <td><?= $label ?></td>
                <td><?= $value ?></td>
            </tr>
        <?php endforeach; ?>
    </table>

    <div class="row">
        <div class="col-sm-6">
            <?= $form->field($staff, 'resistance_cell_id', [
                'labelOptions' => ['class' => ($staff->resistance_cell_id ? 'move' : '')]
            ])->widget(Select2::class, [
                'showToggleAll' => false,
                'data'          => SelectData::fromModel(app\models\ResistanceCell::class),
                'options'       => [
                    'placeholder' => '',
                ],
                'pluginOptions' => [
                    'allowClear' => true,
                    'tags'       => true,
                ],
            ])->label('Resistance Cell*') ?>
        </div>
        <div class="col-sm-6">
            <?= $form->field($staff, 'team_id', [
                'labelOptions' => ['class' => ($staff->team_id ? 'move' : '')]
            ])->widget(Select2::class, [
                'showToggleAll' => false,
                'data'          => SelectData::fromModel(app\models\Team::class),
                'options'       => [
                    'placeholder' => '',
                ],
                'pluginOptions' => [
                    'allowClear' => true,
                    'tags'       => true,
                ],
            ])->label('Team') ?>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-6">
            <?= $form->field($staff, 'section_id', [
                'labelOptions' => ['class' => ($staff->section_id ? 'move' : '')]
            ])->widget(Select2::class, [
                'showToggleAll' => false,
                'data'          => SelectData::fromModel(app\models\Section::class),
                'options'       => [
                    'placeholder' => '',
                ],
                'pluginOptions' => [
                    'allowClear' => true,
                ],
            ])->label('Section*') ?>
        </div>
        <div class="col-sm-6">
            <?= $form->field($staff, 'special_function_id', [
                'labelOptions' => ['class' => ($staff->special_function_id ? 'move' : '')]
            ])->widget(Select2::class, [
                'showToggleAll' => false,
                'data'          => SelectData::fromModel(app\models\SpecialFunction::class),
                'options'       => [
                    'placeholder' => '',
                ],
                'pluginOptions' => [
                    'allowClear' => true,
                ],
            ])->label('Special Function') ?>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-6">
            <?= $form->field($staff, 'rank_id', [
                'labelOptions' => ['class' => ($staff->rank_id ? 'move' : '')]
            ])->widget(Select2::class, [
                'showToggleAll' => false,
                'data'          => SelectData::fromModel(app\models\Rank::class),
                'options'       => [
                    'placeholder' => '',
                ],
                'pluginOptions' => [
                    'allowClear' => true,
                ],
            ])->label('Rank') ?>
        </div>
        <div class="col-sm-6">
            <?= $form->field($staff, 'citizenship_id', [
                'labelOptions' => ['class' => ($staff->citizenship_id ? 'move' : '')]
            ])->widget(Select2::class, [
                'showToggleAll' => false,
                'data'          => SelectData::fromModel(app\models\Citizenship::class),
                'options'       => [
                    'placeholder' => '',
                ],
                'pluginOptions' => [
                    'allowClear' => true,
                    'tags'       => true,
                ],
            ])->label('Citizenship') ?>
        </div>
    </div>

    <small>* required</small>


    <h3>System</h3>

<?php
$systemInfoHelp = [
    "Callsign:"   => "Wird vom CIC vergeben, wenn du Funker bist",
    "Is Alive:"   => "Nur abwählen, wenn dein Charakter gestorben ist",
    "Registered:" => "Der Tag, an dem dein Charakter zum ersten mal in einer Basis registriert wurde. Frühestes Datum ist der 26.02.2022, Spielstart ist am 15.09.202",
];
?>
    <table class="help">
        <?php foreach ($systemInfoHelp as $label => $value): ?>
            <tr>
                <td><?= $label ?></td>
                <td><?= $value ?></td>
            </tr>
        <?php endforeach; ?>
    </table>

    <div class="row">
        <div class="col-sm-6">
            <?= $form->field($staff, 'callsign')->textInput([
                'maxlength' => true,
                'class'     => 'form-control mask-callsign'
            ]) ?>
        </div>
        <div class="col-sm-6">
            <?= $form->field($staff, 'status_alive')->checkbox([
                'template' => '<div class="checkbox">{beginLabel}{input}<span class="cr"><i class="cr-icon glyphicon glyphicon-ok"></i></span>{labelTitle}{endLabel}{error}{hint}</div>',
            ])->label('Is Alive') ?>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-6">
            <?= $form->field($staff, 'registered')->textInput([
                'class'        => 'form-control mask-date ',
                'autocomplete' => 'off'
            ]) ?>
        </div>
        <div class="col-sm-6">
        </div>
    </div>

    <h3>Background</h3>

<?php
$systemInfoHelp = [
    "Career:"          => "Beschreibung deiner Karriere in der Widerstandszelle Mahlwinkel",
    "Characteristics:" => "Charakteristische Merkmale, z.B. Narben oder Tätowierungen",
    "Personality:"     => "Persönlichkeitmerkmale",
    "Awards:"          => "Bisher verdiente Auszeichnungen"
];
?>
    <table class="help">
        <?php foreach ($systemInfoHelp as $label => $value): ?>
            <tr>
                <td><?= $label ?></td>
                <td><?= $value ?></td>
            </tr>
        <?php endforeach; ?>
    </table>

    <div class="row">
        <div class="col-sm-6">
            <?= $form->field($background, 'story_before')->textarea(['rows' => 8]) ?>
        </div>
        <div class="col-sm-6">
            <?= $form->field($background, 'story_during')->textarea(['rows' => 8]) ?>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-6">
            <?= $form->field($background, 'story_after')->textarea(['rows' => 8]) ?>
        </div>
        <div class="col-sm-6">
            <?= $form->field($background, 'career')->textarea(['rows' => 8]) ?>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-6">
            <?= $form->field($background, 'characteristics')->textarea(['rows' => 8]) ?>
        </div>
        <div class="col-sm-6">
            <?= $form->field($background, 'personality')->textarea(['rows' => 8]) ?>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-6">
            <?= $form->field($background, 'awards')->textarea(['rows' => 8]) ?>
        </div>
    </div>

    <div class="form-group">
        <?= Html::submitButton(
            $staff->isNewRecord ? 'Create' : 'Update',
            ["class" => "btn btn-primary"]
        ) ?>
    </div>

<?php ActiveForm::end(); ?>