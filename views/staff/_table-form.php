<?php

use yii\widgets\ActiveForm;
use yii\helpers\Url;
use app\models\search\StaffSearch;
use kartik\select2\Select2;
use mate\yii\widgets\ValMap;
use mate\yii\assets\TableSearchAsset;
use app\models\BaseCategory;
use app\models\SpecialFunction;
use app\models\Team;
use mate\yii\widgets\Glyphicon;
use app\assets\page\StaffSelectFormAsset;

/* @var $this yii\web\View */
/* @var $selectableDataProvider yii\data\ActiveDataProvider */
/* @var $selectedDataProvider yii\data\ActiveDataProvider */
/* @var $form \yii\bootstrap\ActiveForm */
/* @var $searchModel StaffSearch */
/* @var $searchUrl string */
/* @var $exclude array */

$searchUrl = !isset($searchUrl) ? Url::to(["staff/search-form"]) : $searchUrl;
$exclude = !isset($exclude) ? array() : $exclude;
$modelName = (new ReflectionClass($model))->getShortName();
/** @var \mate\yii\components\SelectData $selectData */
$selectData = Yii::$app->selectData;

TableSearchAsset::register($this);
StaffSelectFormAsset::register($this);
?>
<div id="staff-search-form"
      action="<?= $searchUrl ?>"
      class="animated-label table-search-form"
      data-target-table="#staff-search-table">
</div>

<div class="row table-form">
    <div class="col-sm-6">
        <table class="table table-bordered staff-table table-form-selectable" id="staff-search-table">
            <thead>
                <?php $excludeSearchParams = []; ?>
                <tr class="animated-label">
                    <?php $model = $searchModel ?>
                    <?php if (!in_array("rpn", $exclude)): ?>
                        <?php $excludeSearchParams[] = "rpn"; ?>
                        <th class="rpn">
                            <?= $form->field($model, 'rpn')->textInput(['maxlength' => true]) ?>
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
                    <?php if (!in_array("callsign", $exclude)): ?>
                        <?php $excludeSearchParams[] = "callsign"; ?>
                        <th class="callsign">
                            <?= $form->field($model, 'callsign')->textInput(['maxlength' => true]) ?>
                        </th>
                    <?php endif; ?>
                    <th class="actions" style="padding: 8px!important">
                        <input type="hidden" name="page" value="<?= $selectableDataProvider->pagination->page ?>">
                        <input type="hidden" name="per-page"
                               value="<?= $selectableDataProvider->pagination->pageSize ?>">
                        <?php
                        $hiddenAttributes = $searchModel->getAttributes(null, $excludeSearchParams);
                        foreach ($hiddenAttributes as $name => $value) {
                            if ($value === null) continue;
                            echo $form->field($searchModel, $name)->hiddenInput(['value' => $value])->label(false);
                        }
                        ?>

                        <?= Glyphicon::arrow_right(["class" => "list-btn add-all-rows"]) ?>
                    </th>
                </tr>
            </thead>
            <?= $this->render("_table-form-body", [
                "dataProvider" => $selectableDataProvider,
                "modelName"   => $modelName,
                "exclude"      => $exclude
            ]); ?>
        </table>
    </div>
    <div class="col-sm-6">

        <table class="table table-bordered staff-table table-form-selected">
            <thead>
            <tr>
                <?php if (!in_array("rpn", $exclude)): ?>
                    <th class="rpn"><?= 'RPN' ?></th>
                <?php endif; ?>
                <?php if (!in_array("name", $exclude)): ?>
                    <th class="name"><?= 'Name' ?></th>
                <?php endif; ?>
                <?php if (!in_array("team", $exclude)): ?>
                    <th class="team"><?= 'Team' ?></th>
                <?php endif; ?>
                <?php if (!in_array("callsign", $exclude)): ?>
                    <th class="callsign"><?= 'Callsign' ?></th>
                <?php endif; ?>
                <th class="actions" style="padding: 8px!important">
                    <?= Glyphicon::remove(["class" => "assigned-btn remove-all-rows"]) ?>
                </th>
            </tr>
            </thead>
            <?php
            $selectedDataProvider->setPagination(false);
            ?>
            <?= $this->render("_table-form-body", [
                "dataProvider" => $selectedDataProvider,
                "modelName"   => $modelName,
                "exclude"      => $exclude,
                "checked"     => true,
            ]); ?>
        </table>
    </div>
</div>
