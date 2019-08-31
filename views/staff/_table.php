<?php

use yii\widgets\ActiveForm;
use yii\helpers\Url;
use app\models\search\StaffSearch;
use kartik\select2\Select2;
use mate\yii\assets\TableSearchAsset;
use app\models\Section;
use app\models\SpecialFunction;
use app\models\Team;
use app\models\Rank;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var $searchModel StaffSearch */
/* @var $searchUrl string */
/* @var $exclude array */

$form = null;
$searchModel = !isset($searchModel) ? null : $searchModel;
$searchUrl = !isset($searchUrl) ? Url::to(["staff/search"]) : $searchUrl;
$exclude = !isset($exclude) ? array() : $exclude;
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
            <?php if (!in_array("section", $exclude)): ?>
                <?php $excludeSearchParams[] = "section"; ?>
                <th class="section">
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
            <?php if (!in_array("callsign", $exclude)): ?>
                <?php $excludeSearchParams[] = "callsign"; ?>
                <th class="callsign">
                    <?= $form->field($model, 'callsign')->textInput([
                            'maxlength' => true,
                            'class'     => 'form-control mask-callsign'
                    ]) ?>
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
                        if($value === null) continue;
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
            <?php if (!in_array("team", $exclude)): ?>
                <th class="team"><?= 'Team' ?></th>
            <?php endif; ?>
            <?php if (!in_array("rank", $exclude)): ?>
                <th class="rank"><?= 'Rank' ?></th>
            <?php endif; ?>
            <?php if (!in_array("section", $exclude)): ?>
                <th class="section"><?= 'section' ?></th>
            <?php endif; ?>
            <?php if (!in_array("special_function", $exclude)): ?>
                <th class="special_function"><?= 'Special Function' ?></th>
            <?php endif; ?>
            <?php if (!in_array("callsign", $exclude)): ?>
                <th class="callsign"><?= 'Callsign' ?></th>
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