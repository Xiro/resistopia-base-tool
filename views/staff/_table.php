<?php

use app\models\BloodType;
use app\models\Citizenship;
use app\models\EyeColor;
use app\models\ResistanceCell;
use dosamigos\datetimepicker\DateTimePicker;
use mate\yii\widgets\SelectData;
use yii\widgets\ActiveForm;
use yii\helpers\Url;
use app\models\search\StaffSearch;
use kartik\select2\Select2;
use mate\yii\assets\TableSearchAsset;
use app\models\Section;
use app\models\SpecialFunction;
use app\models\Team;
use app\models\Rank;
use app\models\Staff;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var $searchModel StaffSearch */
/* @var $searchUrl string */
/* @var $exclude array */
/* @var $mergeExclude boolean */

$form = null;
$searchModel = !isset($searchModel) ? null : $searchModel;
$searchUrl = !isset($searchUrl) ? Url::to(["staff/search"]) : $searchUrl;
/** @var \mate\yii\components\SelectData $selectData */
$selectData = Yii::$app->selectData;

if ($searchModel) {
    TableSearchAsset::register($this);
    $form = ActiveForm::begin([
        'id'          => 'staff-search-form',
        "action"      => $searchUrl,
        "options"     => [
            'clientValidation' => false,
            "class"            => "animated-label table-search-form",
            "data"             => [
                'target-table' => '#staff-search-table'
            ]
        ],
        "fieldConfig" => ["template" => "{input}\n{label}\n{hint}\n{error}"],
    ]);
    ActiveForm::end();
}
?>

<table class="table table-bordered staff-table" id="staff-search-table">
    <thead>
    <?php if ($searchModel): ?>
        <?php $excludeSearchParams = []; ?>
        <tr class="animated-label">
            <?php $model = $searchModel ?>
            <?php if (!in_array("sid", $exclude)): ?>
                <?php $excludeSearchParams[] = "sid"; ?>
                <th class="sid">
                    <?= $form->field($model, 'sid')->textInput([
                        'maxlength' => true,
                        'class'     => 'form-control sergeant'
                    ]) ?>
                </th>
            <?php endif; ?>
            <?php if (!in_array("name", $exclude)): ?>
                <?php $excludeSearchParams[] = "name"; ?>
                <th class="name">
                    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>
                </th>
            <?php endif; ?>
            <?php if (!in_array("gender", $exclude)): ?>
                <?php $excludeSearchParams[] = "gender"; ?>
                <th class="gender">
                    <?= $form->field($model, 'gender', [
                        'labelOptions' => ['class' => ($model->gender ? 'move' : '')]
                    ])->widget(Select2::class, [
                        'showToggleAll' => false,
                        'data'          => ['m' => 'Male', 'f' => 'Female',],
                        'options'       => [
                            'placeholder' => '',
                        ],
                        'pluginOptions' => [
                            'allowClear' => true,
                        ],
                    ]) ?>
                </th>
            <?php endif; ?>
            <?php if (!in_array("date_of_birth", $exclude)): ?>
                <?php $excludeSearchParams[] = "date_of_birth"; ?>
                <th class="date_of_birth">
                    <?= "" /*$form->field($model, 'date_of_birth')->textInput([
                        'class'        => 'form-control mask-date ',
                        'autocomplete' => 'off'
                    ])*/ ?>
                    <div style="position: relative;left: 10px;top:-12px">Date Of Birth</div>
                </th>
            <?php endif; ?>
            <?php if (!in_array("height", $exclude)): ?>
                <?php $excludeSearchParams[] = "height"; ?>
                <th class="height">
                    <?= $form->field($model, 'height')->textInput(['autocomplete' => 'off']) ?>
                </th>
            <?php endif; ?>
            <?php if (!in_array("eye_color", $exclude)): ?>
                <?php $excludeSearchParams[] = "eye_color"; ?>
                <th class="eye_color">
                    <?= $form->field($model, 'eye_color_id', [
                        'labelOptions' => ['class' => ($model->eye_color_id ? 'move' : '')]
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
                </th>
            <?php endif; ?>
            <?php if (!in_array("profession", $exclude)): ?>
                <?php $excludeSearchParams[] = "profession"; ?>
                <th class="profession">
                    <?= $form->field($model, 'profession')->textInput(['maxlength' => true]) ?>
                </th>
            <?php endif; ?>
            <?php if (!in_array("blood_type", $exclude)): ?>
                <?php $excludeSearchParams[] = "blood_type"; ?>
                <th class="blood_type">
                    <?= $form->field($model, 'blood_type_id', [
                        'labelOptions' => ['class' => ($model->blood_type_id ? 'move' : '')]
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
                </th>
            <?php endif; ?>
            <?php if (!in_array("team", $exclude)): ?>
                <?php $excludeSearchParams[] = "team"; ?>
                <th class="team">
                    <?= $form->field($model, 'team_id', [
                        'labelOptions' => ['class' => ($model->team_id ? "move" : "")]
                    ])->widget(Select2::class, [
                        'showToggleAll' => false,
                        'data'          => $selectData->fromModel(Team::class, null, null),
                        'options'       => [
                            'placeholder' => ''
                        ],
                        'pluginOptions' => [
                            'allowClear' => true
                        ],
                    ]) ?>
                </th>
            <?php endif; ?>
            <?php if (!in_array("special_function", $exclude)): ?>
                <?php $excludeSearchParams[] = "special_function"; ?>
                <th class="special_function">
                    <?= $form->field($model, 'special_function_id', [
                        'labelOptions' => ['class' => ($model->special_function_id ? "move" : "")]
                    ])->widget(Select2::class, [
                        'showToggleAll' => false,
                        'data'          => $selectData->fromModel(SpecialFunction::class),
                        'options'       => [
                            'placeholder' => ''
                        ],
                        'pluginOptions' => [
                            'allowClear' => true
                        ],
                    ]) ?>
                </th>
            <?php endif; ?>
            <?php if (!in_array("section", $exclude)): ?>
                <?php $excludeSearchParams[] = "section"; ?>
                <th class="section">
                    <?= $form->field($model, 'section', [
                        'labelOptions' => ['class' => ($model->section ? "move" : "")]
                    ])->widget(Select2::class, [
                        'showToggleAll' => false,
                        'data'          => \yii\helpers\ArrayHelper::map(
                            Section::find()->groupBy('section')->all(),
                            'section',
                            'section'
                        ),
                        'options'       => [
                            'placeholder' => ''
                        ],
                        'pluginOptions' => [
                            'allowClear' => true
                        ],
                    ])->label("Section") ?>
                </th>
            <?php endif; ?>
            <?php if (!in_array("department", $exclude)): ?>
                <?php $excludeSearchParams[] = "department"; ?>
                <th class="department">
                    <?= $form->field($model, 'section_id', [
                        'labelOptions' => ['class' => ($model->section_id ? "move" : "")]
                    ])->widget(Select2::class, [
                        'showToggleAll' => false,
                        'data'          => $selectData->fromModel(Section::class, "id", "department"),
                        'options'       => [
                            'placeholder' => ''
                        ],
                        'pluginOptions' => [
                            'allowClear' => true
                        ],
                    ])->label("Department") ?>
                </th>
            <?php endif; ?>
            <?php if (!in_array("citizenship", $exclude)): ?>
                <?php $excludeSearchParams[] = "citizenship"; ?>
                <th class="citizenship">
                    <?= $form->field($model, 'citizenship_id', [
                        'labelOptions' => ['class' => ($model->citizenship_id ? 'move' : '')]
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
                </th>
            <?php endif; ?>
            <?php if (!in_array("rank", $exclude)): ?>
                <?php $excludeSearchParams[] = "rank"; ?>
                <th class="rank">
                    <?= $form->field($model, 'rank_id', [
                        'labelOptions' => ['class' => ($model->rank_id ? "move" : "")]
                    ])->widget(Select2::class, [
                        'showToggleAll' => false,
                        'data'          => $selectData->fromModel(Rank::class, null, 'short_name'),
                        'options'       => [
                            'placeholder' => ''
                        ],
                        'pluginOptions' => [
                            'allowClear' => true
                        ],
                    ]) ?>
                </th>
            <?php endif; ?>
            <?php if (!in_array("security_level", $exclude)): ?>
                <?php $excludeSearchParams[] = "security_level"; ?>
                <th class="security_level">
                    <?= $form->field($model, 'security_level', [
                        'labelOptions' => ['class' => ($model->security_level ? 'move' : '')]
                    ])->widget(Select2::class, [
                        'showToggleAll' => false,
                        'data'          => [
                                '0' => 'Level 0',
                                '1' => 'Level 1',
                                '2' => 'Level 2',
                                '3' => 'Level 3',
                                '4' => 'Level 4',
                                '5' => 'Level 5',
                                '6' => 'Level 6',
                                '7' => 'Level 7',
                                '8' => 'Level 8',
                                '9' => 'Level 9',
                            ],
                        'options'       => [
                            'placeholder' => '',
                        ],
                        'pluginOptions' => [
                            'allowClear' => true,
                        ],
                    ])->label("Security") ?>
                </th>
            <?php endif; ?>
            <?php if (!in_array("registered", $exclude)): ?>
                <?php $excludeSearchParams[] = "registered"; ?>
                <th class="registered">
                    <?= $form->field($model, 'registered')->textInput([
                        'class'        => 'form-control mask-date ',
                        'autocomplete' => 'off'
                    ])->label("Registered*") ?>
                </th>
            <?php endif; ?>
            <?php if (!in_array("resistance_cell", $exclude)): ?>
                <?php $excludeSearchParams[] = "resistance_cell"; ?>
                <th class="resistance_cell">
                    <?= $form->field($model, 'resistance_cell_id', [
                        'labelOptions' => ['class' => ($model->resistance_cell_id ? 'move' : '')]
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
                    ])->label('First registered at*') ?>
                </th>
            <?php endif; ?>
            <?php if (!in_array("callsign", $exclude)): ?>
                <?php $excludeSearchParams[] = "callsign"; ?>
                <th class="callsign">
                    <?= $form->field($model, 'callsign')->textInput([
                        'maxlength' => true,
                        'class'     => 'form-control mask-callsign'
                    ]) ?>
                </th>
            <?php endif; ?>
            <?php if (!in_array("status_alive", $exclude)): ?>
                <?php $excludeSearchParams[] = "status_alive"; ?>
                <th class="status_alive">
                    <?= $form->field($model, 'status_alive', [
                        'labelOptions' => ['class' => ($model->status_alive ? 'move' : '')]
                    ])->widget(Select2::class, [
                        'showToggleAll' => false,
                        'data'          => ['1' => 'Yes', '0' => 'No',],
                        'options'       => [
                            'placeholder' => '',
                        ],
                        'pluginOptions' => [
                            'allowClear' => true,
                        ],
                    ])->label("Alive") ?>
                </th>
            <?php endif; ?>
            <?php if (!in_array("created", $exclude)): ?>
                <?php $excludeSearchParams[] = "created"; ?>
                <th class="created">
                    <?= $form->field($model, 'created', [
                        'options'      => ['class' => "form-group date-picker"],
                        'labelOptions' => ['class' => ($model->created ? "move" : "")]
                    ])->widget(DateTimePicker::class, [
                        'size'           => 'sm',
                        'template'       => '{input}',
                        'pickButtonIcon' => 'glyphicon glyphicon-time',
                        'clientOptions'  => [
                            'type'       => 'TYPE_BUTTON',
                            'startView'  => 1,
                            'minView'    => 0,
                            'maxView'    => 1,
                            'autoclose'  => true,
                            'linkFormat' => 'HH:ii P', // if inline = true
                            // 'format' => 'HH:ii P', // if inline = false
                            'todayBtn'   => true
                        ]
                    ])->label('Created'); ?>
                </th>
            <?php endif; ?>
            <?php if (!in_array("updated", $exclude)): ?>
                <?php $excludeSearchParams[] = "updated"; ?>
                <th class="updated">
                    <?= $form->field($model, 'updated', [
                        'options'      => ['class' => "form-group date-picker"],
                        'labelOptions' => ['class' => ($model->updated ? "move" : "")]
                    ])->widget(DateTimePicker::class, [
                        'size'           => 'sm',
                        'template'       => '{input}',
                        'pickButtonIcon' => 'glyphicon glyphicon-time',
                        'clientOptions'  => [
                            'type'       => 'TYPE_BUTTON',
                            'startView'  => 1,
                            'minView'    => 0,
                            'maxView'    => 1,
                            'autoclose'  => true,
                            'linkFormat' => 'HH:ii P', // if inline = true
                            // 'format' => 'HH:ii P', // if inline = false
                            'todayBtn'   => true
                        ]
                    ])->label('Updated'); ?>
                </th>
            <?php endif; ?>
            <?php if (!in_array("actions", $exclude)): ?>
                <th>
                    <?php $pagination = $dataProvider->pagination; ?>
                    <input type="hidden" name="page" value="<?= $pagination ? $pagination->page : 0 ?>">
                    <input type="hidden" name="per-page" value="<?= $pagination ? $pagination->pageSize : 0 ?>">
                    <?php
                    $hiddenAttributes = $searchModel->getAttributes(null, $excludeSearchParams);
                    foreach ($hiddenAttributes as $name => $value) {
                        if ($value === null) continue;
                        echo $form->field($searchModel, $name)->hiddenInput(['value' => $value])->label(false);
                    }
                    ?>
                </th>
            <?php endif; ?>
        </tr>
    <?php else: ?>
        <tr>
            <?php if (!in_array("sid", $exclude)): ?>
                <th class="sid"><?= 'SID' ?></th>
            <?php endif; ?>
            <?php if (!in_array("name", $exclude)): ?>
                <th class="name"><?= 'Name' ?></th>
            <?php endif; ?>
            <?php if (!in_array("gender", $exclude)): ?>
                <th class="gender"><?= 'Gender' ?></th>
            <?php endif; ?>
            <?php if (!in_array("date_of_birth", $exclude)): ?>
                <th class="date_of_birth"><?= 'Date Of Birth' ?></th>
            <?php endif; ?>
            <?php if (!in_array("height", $exclude)): ?>
                <th class="height"><?= 'Height' ?></th>
            <?php endif; ?>
            <?php if (!in_array("eye_color", $exclude)): ?>
                <th class="eye_color"><?= 'Eye Color' ?></th>
            <?php endif; ?>
            <?php if (!in_array("profession", $exclude)): ?>
                <th class="profession"><?= 'Profession' ?></th>
            <?php endif; ?>
            <?php if (!in_array("blood_type", $exclude)): ?>
                <th class="blood_type"><?= 'Blood Type' ?></th>
            <?php endif; ?>
            <?php if (!in_array("team", $exclude)): ?>
                <th class="team"><?= 'Team' ?></th>
            <?php endif; ?>
            <?php if (!in_array("special_function", $exclude)): ?>
                <th class="special_function"><?= 'Special Function' ?></th>
            <?php endif; ?>
            <?php if (!in_array("section", $exclude)): ?>
                <th class="section"><?= 'Section' ?></th>
            <?php endif; ?>
            <?php if (!in_array("department", $exclude)): ?>
                <th class="department"><?= 'Department' ?></th>
            <?php endif; ?>
            <?php if (!in_array("citizenship", $exclude)): ?>
                <th class="citizenship"><?= 'Citizenship' ?></th>
            <?php endif; ?>
            <?php if (!in_array("rank", $exclude)): ?>
                <th class="rank"><?= 'Rank' ?></th>
            <?php endif; ?>
            <?php if (!in_array("security_level", $exclude)): ?>
                <th class="security_level"><?= 'Security Level' ?></th>
            <?php endif; ?>
            <?php if (!in_array("registered", $exclude)): ?>
                <th class="registered"><?= 'Registered' ?></th>
            <?php endif; ?>
            <?php if (!in_array("resistance_cell", $exclude)): ?>
                <th class="resistance_cell"><?= 'First Registered At' ?></th>
            <?php endif; ?>
            <?php if (!in_array("callsign", $exclude)): ?>
                <th class="callsign"><?= 'Callsign' ?></th>
            <?php endif; ?>
            <?php if (!in_array("status_alive", $exclude)): ?>
                <th class="status_alive"><?= 'Is Alive' ?></th>
            <?php endif; ?>
            <?php if (!in_array("created", $exclude)): ?>
                <th class="created"><?= 'Created' ?></th>
            <?php endif; ?>
            <?php if (!in_array("updated", $exclude)): ?>
                <th class="updated"><?= 'Updated' ?></th>
            <?php endif; ?>
            <?php if (!in_array("actions", $exclude)): ?>
                <th></th>
            <?php endif; ?>
        </tr>
    <?php endif; ?>
    </thead>
    <?= $this->render("_table-body", [
        "dataProvider" => $dataProvider,
        "exclude"      => $exclude,
        "mergeExclude" => $mergeExclude
    ]); ?>
</table>