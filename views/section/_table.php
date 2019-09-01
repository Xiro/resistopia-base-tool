<?php
use yii\widgets\ActiveForm;
use yii\helpers\Url;
use app\models\search\SectionSearch;
use kartik\select2\Select2;
use mate\yii\widgets\ValMap;
use mate\yii\assets\TableSearchAsset;
use mate\yii\assets\SortableUpdateAsset;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var $searchModel SectionSearch */
/* @var $searchUrl string */
/* @var $exclude array */

$form = null;
$searchModel = !isset($searchModel) ? null : $searchModel;
$searchUrl = !isset($searchUrl) ? Url::to(["section/search"]) : $searchUrl;
$exclude = !isset($exclude) ? array() : $exclude;
SortableUpdateAsset::register($this);

if ($searchModel) {
    TableSearchAsset::register($this);
    $form = ActiveForm::begin([
        'id'          => 'section-search-form',
        "action"      => $searchUrl,
        "options"     => [
            'clientValidation' => false,
            "class"            => "animated-label table-search-form",
            "data"             => [
                'target-table' => '#section-search-table'
            ]
        ],
        "fieldConfig" => ["template" => "{input}\n{label}\n{hint}\n{error}"],
    ]);
    ActiveForm::end();
}
?>

<table class="table table-bordered sortable section-table" id="section-search-table" data-sortable-update="<?=Url::to(['section/update-order']) ?>">
    <thead>
    <?php if ($searchModel): ?>
        <?php $excludeSearchParams = []; ?>
        <tr class="animated-label">
            <?php $model = $searchModel ?>
            <?php if (!in_array("order", $exclude)): ?>
                <?php $excludeSearchParams[] = "order"; ?>
                <th class="order"></th>
            <?php endif; ?>
            <?php if (!in_array("section", $exclude)): ?>
                <?php $excludeSearchParams[] = "section"; ?>
                <th class="section">
                    <?= $form->field($model, 'section')->textInput(['maxlength' => true]) ?>
                </th>
            <?php endif; ?>
            <?php if (!in_array("department", $exclude)): ?>
                <?php $excludeSearchParams[] = "department"; ?>
                <th class="department">
                    <?= $form->field($model, 'department')->textInput(['maxlength' => true]) ?>
                </th>
            <?php endif; ?>
            <?php if (!in_array("group", $exclude)): ?>
                <?php $excludeSearchParams[] = "group"; ?>
                <th class="group">
                    <?= $form->field($model, 'group')->textInput(['maxlength' => true]) ?>
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
            <?php if (!in_array("section", $exclude)): ?>
                <th class="section"><?= 'Section' ?></th>
            <?php endif; ?>
            <?php if (!in_array("department", $exclude)): ?>
                <th class="department"><?= 'Department' ?></th>
            <?php endif; ?>
            <?php if (!in_array("group", $exclude)): ?>
                <th class="group"><?= 'Group' ?></th>
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