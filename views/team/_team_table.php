<?php

use yii\widgets\ActiveForm;
use yii\helpers\Url;
use app\models\Team;
use app\models\search\TeamSearch;
use kartik\select2\Select2;
use app\helpers\ValMap;
use app\assets\page\IndexSearchAsset;

/* @var $this yii\web\View */
/* @var $models Team[] */
/* @var $search TeamSearch */
/* @var $searchUrl string */
/* @var $exclude array */

$form = null;
$search = !isset($search) ? null : $search;
$searchUrl = !isset($searchUrl) ? Url::to(["team/search"]) : $searchUrl;
$exclude = !isset($exclude) ? array() : $exclude;

if ($search) {
    IndexSearchAsset::register($this);
    $form = ActiveForm::begin([
        'id'          => 'index-search-form',
        "action"      => $searchUrl,
        "options"     => [
            'clientValidation' => false,
            "class"            => "animated-label",
            "data"             => []
        ],
        "fieldConfig" => ["template" => "{input}\n{label}\n{hint}\n{error}"],
    ]);
    ActiveForm::end();
}
?>

<table class="table table-bordered team-table" id="index-search-table">
    <thead>
    <?php if ($search): ?>
        <tr class="animated-label">
            <?php if (!in_array("name", $exclude)): ?>
                <th class="name">
                    <?= $form->field($search, 'name', [
                        'labelOptions' => ['class' => ($search->name ? "move" : "")]
                    ])->widget(Select2::classname(), [
                        'showToggleAll' => false,
                        'data'          => ValMap::model(Team::class, "name", "name"),
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
            <?php if (!in_array("paid", $exclude)): ?>
                <th class="paid">Paid RP</th>
            <?php endif; ?>
            <?php if (!in_array("unpaid", $exclude)): ?>
                <th class="unpaid">Unpaid RP</th>
            <?php endif; ?>
            <?php if (!in_array("members", $exclude)): ?>
                <th class="members">
                    Members
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
            <?php if (!in_array("paid", $exclude)): ?>
                <th class="paid">Paid RP</th>
            <?php endif; ?>
            <?php if (!in_array("unpaid", $exclude)): ?>
                <th class="unpaid">Unpaid RP</th>
            <?php endif; ?>
            <?php if (!in_array("members", $exclude)): ?>
                <th class="members">Members</th>
            <?php endif; ?>
            <?php if (!in_array("actions", $exclude)): ?>
                <th class="actions"></th>
            <?php endif; ?>
        </tr>
    <?php endif; ?>
    </thead>
    <tbody>
    <?= $this->render("_team-table-body", [
        "teamModels" => $models,
        "exclude"    => $exclude
    ]); ?>
    </tbody>
</table>
