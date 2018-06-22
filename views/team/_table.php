<?php
use yii\widgets\ActiveForm;
use yii\helpers\Url;
use app\models\search\TeamSearch;
use kartik\select2\Select2;
use mate\yii\widgets\ValMap;
use mate\yii\assets\TableSearchAsset;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var $searchModel TeamSearch */
/* @var $searchUrl string */
/* @var $exclude array */

$form = null;
$searchModel = !isset($searchModel) ? null : $searchModel;
$searchUrl = !isset($searchUrl) ? Url::to(["team/search"]) : $searchUrl;
$exclude = !isset($exclude) ? array() : $exclude;

if ($searchModel) {
    TableSearchAsset::register($this);
    $form = ActiveForm::begin([
        'id'          => 'team-search-form',
        "action"      => $searchUrl,
        "options"     => [
            'clientValidation' => false,
            "class"            => "animated-label table-search-form",
            "data"             => [
                'target-table' => '#team-search-table'
            ]
        ],
        "fieldConfig" => ["template" => "{input}\n{label}\n{hint}\n{error}"],
    ]);
    ActiveForm::end();
}
?>

<table class="table table-bordered team-table" id="team-search-table">
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
            <?php if (!in_array("created", $exclude)): ?>
                <?php $excludeSearchParams[] = "created"; ?>
                <th class="created">
                    <?= $form->field($model, 'created')->textInput() ?>
                </th>
            <?php endif; ?>
            <?php if (!in_array("updated", $exclude)): ?>
                <?php $excludeSearchParams[] = "updated"; ?>
                <th class="updated">
                    <?= $form->field($model, 'updated')->textInput() ?>
                </th>
            <?php endif; ?>
            <?php if (!in_array("actions", $exclude)): ?>
                <th>
                    <input type="hidden" name="page" value="<?=  $dataProvider->pagination->page ?>">
                    <input type="hidden" name="per-page" value="<?=  $dataProvider->pagination->pageSize ?>">
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
        "exclude"      => $exclude
    ]); ?>
</table>