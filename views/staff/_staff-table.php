<?php

use yii\widgets\ActiveForm;
use yii\helpers\Url;
use kartik\select2\Select2;
use app\helpers\ValMap;
use app\assets\page\IndexSearchAsset;
use app\models\Category;
use app\models\Speciality;
use app\models\Team;
use app\models\StaffStatus;
use app\models\Staff;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $staffModels \app\models\Staff[] */
/* @var $search \app\models\search\StaffSearch */
/* @var $searchUrl string */
/* @var $exclude array */

$form = null;
$search = !isset($search) ? null : $search;
$searchUrl = !isset($searchUrl) ? Url::to(["staff/search"]) : $searchUrl;
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

<table class="table table-bordered staff-table" id="index-search-table">
    <thead>
    <?php if ($search): ?>
        <tr class="animated-label">
            <?php if (!in_array("rpn", $exclude)): ?>
                <th class="rpn">
                    <?= $form->field($search, 'rpn')->textInput(["form" => "index-search-form"]) ?>
                </th>
            <?php endif; ?>
            <?php if (!in_array("name", $exclude)): ?>
                <th class="name">
                    <?= $form->field($search, 'name')->textInput(["form" => "index-search-form"]) ?>
                </th>
            <?php endif; ?>
            <?php if (!in_array("category", $exclude)): ?>
                <th class="category">
                    <?= $form->field($search, 'category_id', [
                        'labelOptions' => ['class' => ($search->category_id ? "move" : "")]
                    ])->widget(Select2::classname(), [
                        'showToggleAll' => false,
                        'data'          => ValMap::model(Category::class, "id", "name"),
                        'options'       => [
                            'placeholder' => '',
                            'form'        => 'index-search-form',
                        ],
                        'pluginOptions' => [
                            'allowClear' => true,
                        ],
                    ])->label("Category") ?>
                </th>
            <?php endif; ?>
            <?php if (!in_array("speciality", $exclude)): ?>
                <th class="speciality">
                    <?= $form->field($search, 'speciality_id', [
                        'labelOptions' => ['class' => ($search->speciality_id ? "move" : "")]
                    ])->widget(Select2::classname(), [
                        'showToggleAll' => false,
                        'data'          => ValMap::model(Speciality::class, "id", "name"),
                        'options'       => [
                            'placeholder' => '',
                            'form'        => 'index-search-form',
                        ],
                        'pluginOptions' => [
                            'allowClear' => true,
                        ],
                    ])->label("Speciality") ?>
                </th>
            <?php endif; ?>
            <?php if (!in_array("team", $exclude)): ?>
                <th class="team">
                    <?= $form->field($search, 'team_id', [
                        'labelOptions' => ['class' => ($search->team_id ? "move" : "")]
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
            <?php if (!in_array("staff-status", $exclude)): ?>
                <th class="staff-status">
                    <?= $form->field($search, 'staff_status_id', [
                        'labelOptions' => ['class' => ($search->staff_status_id ? "move" : "")]
                    ])->widget(Select2::classname(), [
                        'showToggleAll' => false,
                        'data'          => ValMap::model(StaffStatus::class, "id", "name"),
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
                <th class="actions">
                </th>
            <?php endif; ?>
        </tr>
    <?php else: ?>
        <tr>
            <?php if (!in_array("rpn", $exclude)): ?>
                <td class="rpn">RPN</td>
            <?php endif; ?>
            <?php if (!in_array("name", $exclude)): ?>
                <td class="name">Name</td>
            <?php endif; ?>
            <?php if (!in_array("category", $exclude)): ?>
                <td class="category">Category</td>
            <?php endif; ?>
            <?php if (!in_array("speciality", $exclude)): ?>
                <td class="speciality">Speciality</td>
            <?php endif; ?>
            <?php if (!in_array("team", $exclude)): ?>
                <td class="team">Team</td>
            <?php endif; ?>
            <?php if (!in_array("staff-status", $exclude)): ?>
                <td class="staff-status">Status</td>
            <?php endif; ?>
            <?php if (!in_array("call-sign", $exclude)): ?>
                <td class="call-sign">Call Sign</td>
            <?php endif; ?>
            <?php if (!in_array("actions", $exclude)): ?>
                <td class="actions"></td>
            <?php endif; ?>
        </tr>
    <?php endif; ?>
    </thead>
    <tbody>
    <?= $this->render("_staff-table-body", [
        "staffModels" => $staffModels,
        "exclude"     => $exclude,
    ]) ?>
    </tbody>
</table>