<?php
use yii\widgets\ActiveForm;
use yii\helpers\Url;
use app\models\search\MedicineDrugSearch;
use kartik\select2\Select2;
use mate\yii\widgets\ValMap;
use mate\yii\assets\TableSearchAsset;
use mate\yii\assets\SortableUpdateAsset;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var $searchModel MedicineDrugSearch */
/* @var $searchUrl string */
/* @var $exclude array */

$form = null;
$searchModel = !isset($searchModel) ? null : $searchModel;
$searchUrl = !isset($searchUrl) ? Url::to(["medicine-drug/search"]) : $searchUrl;
$exclude = !isset($exclude) ? array() : $exclude;
SortableUpdateAsset::register($this);

if ($searchModel) {
    TableSearchAsset::register($this);
    $form = ActiveForm::begin([
        'id'          => 'medicine-drug-search-form',
        "action"      => $searchUrl,
        "options"     => [
            'clientValidation' => false,
            "class"            => "animated-label table-search-form",
            "data"             => [
                'target-table' => '#medicine-drug-search-table'
            ]
        ],
        "fieldConfig" => ["template" => "{input}\n{label}\n{hint}\n{error}"],
    ]);
    ActiveForm::end();
}
?>

<table class="table table-bordered sortable medicine-drug-table" id="medicine-drug-search-table" data-sortable-update="<?=Url::to(['medicine-drug/update-order']) ?>">
    <thead>
    <?php if ($searchModel): ?>
        <?php $excludeSearchParams = []; ?>
        <tr class="animated-label">
            <?php $model = $searchModel ?>
            <?php if (!in_array("order", $exclude)): ?>
                <?php $excludeSearchParams[] = "order"; ?>
                <th class="order"></th>
            <?php endif; ?>
            <?php if (!in_array("name", $exclude)): ?>
                <?php $excludeSearchParams[] = "name"; ?>
                <th class="name">
                    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>
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
            <?php if (!in_array("order", $exclude)): ?>
                <?php $excludeSearchParams[] = "order"; ?>
                <th class="order"></th>
            <?php endif; ?>
            <?php if (!in_array("name", $exclude)): ?>
                <th class="name"><?= 'Name' ?></th>
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