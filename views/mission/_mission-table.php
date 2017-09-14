<?php

use yii\widgets\ActiveForm;
use yii\helpers\Url;
use kartik\select2\Select2;
use app\helpers\ValMap;
use app\assets\page\IndexSearchAsset;
use app\models\MissionStatus;
use app\models\MissionType;
use dosamigos\datetimepicker\DateTimePicker;
use app\models\Staff;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $missionModels \app\models\Mission[] */
/* @var $search \app\models\search\MissionSearch */
/* @var $searchUrl string */
/* @var $exclude array */

$form = null;
$search = !isset($search) ? null : $search;
$searchUrl = !isset($searchUrl) ? Url::to(["mission/search"]) : $searchUrl;
$exclude = !isset($exclude) ? array() : $exclude;
?>

<?php if ($search): ?>
    <?php IndexSearchAsset::register($this); ?>
    <?php $form = ActiveForm::begin([
        'id'          => 'index-search-form',
        "action"      => $searchUrl,
        "options"     => [
            'clientValidation' => false,
            "class"            => "animated-label",
            "data"             => [

            ]
        ],
        "fieldConfig" => ["template" => "{input}\n{label}\n{hint}\n{error}"],
    ]); ?>
    <?php ActiveForm::end(); ?>
<?php endif; ?>

<table class="table table-bordered mission-table" id="index-search-table">
    <thead>
    <?php if ($search): ?>
        <tr class="animated-label">
            <?php if (!in_array("name", $exclude)): ?>
                <th class="name">
                    <?= $form->field($search, 'name')->textInput(["form" => "index-search-form"]) ?>
                </th>
            <?php endif; ?>
            <?php if (!in_array("mission-status", $exclude)): ?>
                <th class="mission-status">
                    <?= $form->field($search, 'mission_status_id', [
                        'labelOptions' => ['class' => ($search->mission_status_id ? "move" : "")]
                    ])->widget(Select2::classname(), [
                        'showToggleAll' => false,
                        'data'          => ValMap::model(MissionStatus::class, "id", "name"),
                        'options'       => [
                            'placeholder' => '',
                            'form'        => 'index-search-form',
                        ],
                        'pluginOptions' => [
                            'allowClear' => true,
                        ],
                    ])->label("Status") ?>
                </th>
            <?php endif; ?>
            <?php if (!in_array("mission-type", $exclude)): ?>
                <th class="mission-type">
                    <?= $form->field($search, 'mission_type_id', [
                        'labelOptions' => ['class' => ($search->mission_type_id ? "move" : "")]
                    ])->widget(Select2::classname(), [
                        'showToggleAll' => false,
                        'data'          => ValMap::model(MissionType::class, "id", "name"),
                        'options'       => [
                            'placeholder' => '',
                            'form'        => 'index-search-form',
                        ],
                        'pluginOptions' => [
                            'allowClear' => true,
                        ],
                    ])->label("Type") ?>
                </th>
            <?php endif; ?>
            <?php if (!in_array("zone", $exclude)): ?>
                <th class="zone">
                    <?= $form->field($search, 'zone', [
                        'labelOptions' => ['class' => ($search->zone ? "move" : "")]
                    ])->widget(Select2::classname(), [
                        'showToggleAll' => false,
                        'data'          => [1 => '1', 2 => '2', 3 => '3',],
                        'options'       => [
                            'placeholder' => '',
                            'form'        => 'index-search-form',
                        ],
                        'pluginOptions' => [
                            'allowClear' => true,
                        ],
                    ])->label("Zone") ?>
                </th>
            <?php endif; ?>
            <?php if (!in_array("description", $exclude)): ?>
                <th class="description">
                    <?= $form->field($search, 'description')->textInput(["form" => "index-search-form"]) ?>
                </th>
            <?php endif; ?>
            <?php if (!in_array("debrief-comment", $exclude)): ?>
                <th class="debrief-comment">
                    <?= $form->field($search, 'debrief_comment')->textInput(["form" => "index-search-form"]) ?>
                </th>
            <?php endif; ?>
            <?php if (!in_array("rp", $exclude)): ?>
                <th class="rp">
                    <?= $form->field($search, 'RP')->textInput(["form" => "index-search-form"]) ?>
                </th>
            <?php endif; ?>
            <?php if (!in_array("fp", $exclude)): ?>
                <th class="fp">
                    <?= $form->field($search, 'FP')->textInput(["form" => "index-search-form"]) ?>
                </th>
            <?php endif; ?>
            <?php if (!in_array("started", $exclude)): ?>
                <th class="started">
                    <?= $form->field($search, 'started', [
                        'options'      => ['class' => "form-group date-picker"],
                        'labelOptions' => ['class' => ($search->started ? "move" : "")]
                    ])->widget(DateTimePicker::className(), [
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
                        ],
                        'options'        => [
                            'form' => 'index-search-form',
                        ],
                    ]); ?>
                </th>
            <?php endif; ?>
            <?php if (!in_array("ended", $exclude)): ?>
                <th class="ended">
                    <?= $form->field($search, 'ended', [
                        'options'      => ['class' => "form-group date-picker"],
                        'labelOptions' => ['class' => ($search->ended ? "move" : "")]
                    ])->widget(DateTimePicker::className(), [
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
                        ],
                        'options'        => [
                            'form' => 'index-search-form',
                        ],
                    ]); ?>
                </th>
            <?php endif; ?>
            <?php if (!in_array("call-sign", $exclude)): ?>
                <th class="call-sign">
                    <?= $form->field($search, 'call_sign', [
                        'labelOptions' => ['class' => ($search->call_sign ? "move" : "")]
                    ])->widget(Select2::classname(), [
                        'showToggleAll' => false,
                        'data'          => ArrayHelper::map(
                            Staff::find()->where("call_sign IS NOT NULL")->all(),
                            "call_sign",
                            "call_sign"
                        ),
                        'options'       => [
                            'placeholder' => '',
                            'form'        => 'index-search-form',
                        ],
                        'pluginOptions' => [
                            'allowClear' => true,
                        ],
                    ])->label("CS") ?>
                </th>
            <?php endif; ?>
            <?php if (!in_array("actions", $exclude)): ?>
                <th class="actions"></th>
            <?php endif; ?>
        </tr>
    <?php else: ?>
        <tr>
            <?php if (!in_array("name", $exclude)): ?>
                <th class="name">Name</th>
            <?php endif; ?>
            <?php if (!in_array("mission-status", $exclude)): ?>
                <th class="mission-status">Status</th>
            <?php endif; ?>
            <?php if (!in_array("mission-type", $exclude)): ?>
                <th class="mission-type">Type</th>
            <?php endif; ?>
            <?php if (!in_array("zone", $exclude)): ?>
                <th class="zone">Zone</th>
            <?php endif; ?>
            <?php if (!in_array("description", $exclude)): ?>
                <th class="description">Description</th>
            <?php endif; ?>
            <?php if (!in_array("debrief-comment", $exclude)): ?>
                <th class="debrief-comment">Debrief Comment</th>
            <?php endif; ?>
            <?php if (!in_array("rp", $exclude)): ?>
                <th class="rp">RP</th>
            <?php endif; ?>
            <?php if (!in_array("fp", $exclude)): ?>
                <th class="fp">FP</th>
            <?php endif; ?>
            <?php if (!in_array("started", $exclude)): ?>
                <th class="started">Started</th>
            <?php endif; ?>
            <?php if (!in_array("ended", $exclude)): ?>
                <th class="ended">Ended</th>
            <?php endif; ?>
            <?php if (!in_array("call-sign", $exclude)): ?>
                <th class="call-sign">Call Sign</th>
            <?php endif; ?>
            <?php if (!in_array("actions", $exclude)): ?>
                <th class="actions"></th>
            <?php endif; ?>
        </tr>
    <?php endif; ?>
    </thead>
    <tbody>
    <?= $this->render("_mission-table-body", [
        "missionModels" => $missionModels,
        "exclude"       => $exclude
    ]) ?>
    </tbody>
</table>