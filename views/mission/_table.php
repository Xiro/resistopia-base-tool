<?php
use yii\widgets\ActiveForm;
use yii\helpers\Url;
use app\models\search\MissionSearch;
use kartik\select2\Select2;
use mate\yii\widgets\SelectData;
use mate\yii\assets\TableSearchAsset;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var $searchModel MissionSearch */
/* @var $searchUrl string */
/* @var $exclude array */

$form = null;
$searchModel = !isset($searchModel) ? null : $searchModel;
$searchUrl = !isset($searchUrl) ? Url::to(["mission/search"]) : $searchUrl;
$exclude = !isset($exclude) ? ['time_ete', 'mission_type', 'action-status-buttons'] : $exclude;

if ($searchModel) {
    TableSearchAsset::register($this);
    $form = ActiveForm::begin([
        'id'          => 'mission-search-form',
        "action"      => $searchUrl,
        "options"     => [
            'clientValidation' => false,
            "class"            => "animated-label table-search-form",
            "data"             => [
                'target-table' => '#mission-search-table'
            ]
        ],
        "fieldConfig" => ["template" => "{input}\n{label}\n{hint}\n{error}"],
    ]);
    ActiveForm::end();
}
?>

<table class="table table-bordered mission-table" id="mission-search-table">
    <thead>
    <?php if ($searchModel): ?>
        <?php $excludeSearchParams = []; ?>
        <tr class="animated-label">
            <?php $model = $searchModel ?>
            <?php if (!in_array("name", $exclude)): ?>
                <?php $excludeSearchParams[] = "name"; ?>
                <th class="name">
                    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>
                </th>
            <?php endif; ?>
            <?php if (!in_array("operation", $exclude)): ?>
                <?php $excludeSearchParams[] = "operation"; ?>
                <th class="operation">
                    <?= $form->field($model, 'operation_id', [
                        'labelOptions' => ['class' => ($model->operation_id ? 'move' : '')]
                    ])->widget(Select2::class, [
                        'showToggleAll' => false,
                        'data'          => SelectData::fromModel(\app\models\Operation::class),
                        'options'       => [
                            'placeholder' => '',
                        ],
                        'pluginOptions' => [
                            'allowClear' => true,
                        ],
                    ]) ?>
                </th>
            <?php endif; ?>
            <?php if (!in_array("mission_type", $exclude)): ?>
                <?php $excludeSearchParams[] = "mission_type"; ?>
                <th class="mission_type">
                    <?= $form->field($model, 'mission_type_id', [
                        'labelOptions' => ['class' => ($model->mission_type_id ? 'move' : '')]
                    ])->widget(Select2::class, [
                        'showToggleAll' => false,
                        'data'          => SelectData::fromModel(\app\models\MissionType::class),
                        'options'       => [
                            'placeholder' => '',
                        ],
                        'pluginOptions' => [
                            'allowClear' => true,
                        ],
                    ]) ?>
                </th>
            <?php endif; ?>
            <?php if (!in_array("zone", $exclude)): ?>
                <?php $excludeSearchParams[] = "zone"; ?>
                <th class="zone">
                    <?= $form->field($model, 'zone', [
                        'labelOptions' => ['class' => ($model->zone ? 'move' : '')]
                    ])->widget(Select2::class, [
                        'showToggleAll' => false,
                        'data'          => [ 1 => '1', 2 => '2', 3 => '3', ],
                        'options'       => [
                            'placeholder' => '',
                        ],
                        'pluginOptions' => [
                            'allowClear' => true,
                        ],
                    ]) ?>
                </th>
            <?php endif; ?>
            <?php if (!in_array("mission_status", $exclude)): ?>
                <?php $excludeSearchParams[] = "mission_status"; ?>
                <th class="mission_status">
                    <?= $form->field($model, 'mission_status_id', [
                        'labelOptions' => ['class' => ($model->mission_status_id ? 'move' : '')]
                    ])->widget(Select2::class, [
                        'showToggleAll' => false,
                        'data'          => SelectData::fromModel(\app\models\MissionStatus::class),
                        'options'       => [
                            'placeholder' => '',
                        ],
                        'pluginOptions' => [
                            'allowClear' => true,
                        ],
                    ])->label('Status') ?>
                </th>
            <?php endif; ?>
            <?php if (!in_array("time_lst", $exclude)): ?>
                <?php $excludeSearchParams[] = "time_lst"; ?>
                <th class="time_lst">
                    <?= $form->field($model, 'time_lst')->textInput() ?>
                </th>
            <?php endif; ?>
            <?php if (!in_array("time_ete", $exclude)): ?>
                <?php $excludeSearchParams[] = "time_ete"; ?>
                <th class="time_ete">
                    <?= $form->field($model, 'time_ete')->textInput() ?>
                </th>
            <?php endif; ?>
            <?php if (!in_array("time_atf", $exclude)): ?>
                <?php $excludeSearchParams[] = "time_atf"; ?>
                <th class="time_atf">
                    <?= $form->field($model, 'time_atf')->textInput() ?>
                </th>
            <?php endif; ?>
            <?php if (!in_array("callsign", $exclude)): ?>
                <?php $excludeSearchParams[] = "callsign"; ?>
                <th class="callsign">
                    <?= $form->field($model, 'callsign')->textInput([
                        'class'     => 'form-control mask-callsign'
                    ]) ?>
                </th>
            <?php endif; ?>
            <?php if (!in_array("action-status-buttons", $exclude)): ?>
            <th></th>
            <?php endif; ?>
            <?php if (!in_array("actions", $exclude)): ?>
                <th>
                    <?php $pagination = $dataProvider->pagination; ?>
                    <input type="hidden" name="page" value="<?= $pagination ? $pagination->page : 0 ?>">
                    <input type="hidden" name="per-page" value="<?= $pagination ? $pagination->pageSize : 0 ?>">
                    <?php
                    $hiddenAttributes = $searchModel->getAttributes(null, $excludeSearchParams);
                    foreach ($hiddenAttributes as $name => $value) {
                        if($value === null) continue;
                        echo $form->field($searchModel, $name)->hiddenInput(['value' => $value])->label(false);
                    }
                    ?>
                </th>
            <?php endif; ?>
        </tr>
    <?php else: ?>
        <tr>
            <?php if (!in_array("name", $exclude)): ?>
                <th class="name"><?= 'Name' ?></th>
            <?php endif; ?>
            <?php if (!in_array("operation", $exclude)): ?>
                <th class="operation"><?= 'Operation' ?></th>
            <?php endif; ?>
            <?php if (!in_array("mission_type", $exclude)): ?>
                <th class="mission_type"><?= 'Type' ?></th>
            <?php endif; ?>
            <?php if (!in_array("zone", $exclude)): ?>
                <th class="zone"><?= 'Zone' ?></th>
            <?php endif; ?>
            <?php if (!in_array("mission_status", $exclude)): ?>
                <th class="mission_status"><?= 'Status' ?></th>
            <?php endif; ?>
            <?php if (!in_array("time_lst", $exclude)): ?>
                <th class="time_lst"><?= 'LST' ?></th>
            <?php endif; ?>
            <?php if (!in_array("time_ete", $exclude)): ?>
                <th class="time_ete"><?= 'ETE' ?></th>
            <?php endif; ?>
            <?php if (!in_array("time_atf", $exclude)): ?>
                <th class="time_atf"><?= 'ATF' ?></th>
            <?php endif; ?>
            <?php if (!in_array("callsign", $exclude)): ?>
                <th class="callsign"><?= 'CS' ?></th>
            <?php endif; ?>
            <?php if (!in_array("action-status-buttons", $exclude)): ?>
                <th></th>
            <?php endif; ?>
            <?php if (!in_array("actions", $exclude)): ?>
                <th></th>
            <?php endif; ?>
        </tr>
    <?php endif; ?>
    </thead>
    <?= $this->render("_table-body", [
        "dataProvider" => $dataProvider,
        "exclude"      => $exclude
    ]); ?>
</table>