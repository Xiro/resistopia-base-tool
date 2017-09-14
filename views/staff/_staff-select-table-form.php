<?php

use kartik\select2\Select2;
use app\helpers\ValMap;
use app\models\Team;
use yii\helpers\ArrayHelper;
use app\models\Staff;
use app\widgets\Glyphicon;
use app\assets\page\StaffSelectFormAsset;

StaffSelectFormAsset::register($this);

/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \app\models\form\StaffSelectFormInterface */
/* @var $staffSearch \app\models\search\StaffSearch */
/* @var $staffDataProvider \yii\data\ActiveDataProvider */
/* @var $exclude array */

$exclude = !isset($exclude) ? array() : $exclude;
$modelName = (new ReflectionClass($model))->getShortName();
?>

<div class="row">
    <div class="col-md-6">
        <table class="table table-bordered staff-table" id="index-search-table">
            <thead>
            <tr class="animated-label">
                <?php if (!in_array("rpn", $exclude)): ?>
                    <th class="rpn">
                        <?= $form->field($staffSearch, 'rpn')->textInput(["form" => "index-search-form"]) ?>
                    </th>
                <?php endif; ?>
                <?php if (!in_array("name", $exclude)): ?>
                    <th class="name">
                        <?= $form->field($staffSearch, 'name')->textInput(["form" => "index-search-form"]) ?>
                    </th>
                <?php endif; ?>
                <?php if (!in_array("team", $exclude)): ?>
                    <th class="team">
                        <?= $form->field($staffSearch, 'team_id', [
                            'labelOptions' => ['class' => ($staffSearch->team_id ? "move" : "")]
                        ])->widget(Select2::classname(), [
                            'showToggleAll' => false,
                            'data'          => ValMap::model(Team::class, "id", "name"),
                            'options'       => [
                                'placeholder' => '',
                                'form'        => 'index-search-form',
                            ],
                            'pluginOptions' => [
                                'allowClear' => true,
                            ],
                        ])->label("Team") ?>
                    </th>
                <?php endif; ?>
                <?php if (!in_array("call-sign", $exclude)): ?>
                    <th class="call-sign">
                        <?= $form->field($staffSearch, 'call_sign', [
                            'labelOptions' => ['class' => ($staffSearch->call_sign ? "move" : "")]
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
                <th class="actions" style="padding: 8px">
                    <?= Glyphicon::arrow_right(["class" => "list-btn add-all-staff"]) ?>
                </th>
            </tr>
            </thead>
            <tbody>
            <?= $this->render("_staff-list-table-body", [
                "staffModels" => $staffDataProvider->getModels(),
                "exclude"     => $exclude,
                "modelName"   => $modelName,
            ]); ?>
            </tbody>
        </table>
    </div>
    <div class="col-md-6">
        <table class="table table-bordered staff-table" id="staff-selection-table">
            <thead>
            <tr>
                <?php if (!in_array("rpn", $exclude)): ?>
                    <th class="rpn">
                        RPN
                    </th>
                <?php endif; ?>
                <?php if (!in_array("name", $exclude)): ?>
                    <th class="name">
                        Name
                    </th>
                <?php endif; ?>
                <?php if (!in_array("team", $exclude)): ?>
                    <th class="team">
                        Team
                    </th>
                <?php endif; ?>
                <?php if (!in_array("call-sign", $exclude)): ?>
                    <th class="call-sign">
                        Call Sign
                    </th>
                <?php endif; ?>
                <th class="actions">
                    <?= Glyphicon::remove(["class" => "assigned-btn remove-all-staff"]) ?>
                </th>
            </tr>
            </thead>
            <tbody>
            <?= $this->render("_staff-list-table-body", [
                "staffModels" => $model->getCombinedStaffModels(),
                "modelName"   => $modelName,
                "exclude"     => $exclude,
                "checked"     => true,
            ]); ?>
            </tbody>
        </table>
    </div>
</div>