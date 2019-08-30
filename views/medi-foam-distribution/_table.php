<?php
use yii\widgets\ActiveForm;
use yii\helpers\Url;
use app\models\search\MediFoamDistributionSearch;
use kartik\select2\Select2;
use mate\yii\widgets\ValMap;
use mate\yii\assets\TableSearchAsset;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var $searchModel MediFoamDistributionSearch */
/* @var $searchUrl string */
/* @var $exclude array */

$form = null;
$searchModel = !isset($searchModel) ? null : $searchModel;
$searchUrl = !isset($searchUrl) ? Url::to(["medi-foam-distribution/search"]) : $searchUrl;
$exclude = !isset($exclude) ? array() : $exclude;

if ($searchModel) {
    TableSearchAsset::register($this);
    $form = ActiveForm::begin([
        'id'          => 'medi-foam-distribution-search-form',
        "action"      => $searchUrl,
        "options"     => [
            'clientValidation' => false,
            "class"            => "animated-label table-search-form",
            "data"             => [
                'target-table' => '#medi-foam-distribution-search-table'
            ]
        ],
        "fieldConfig" => ["template" => "{input}\n{label}\n{hint}\n{error}"],
    ]);
    ActiveForm::end();
}
?>

<table class="table table-bordered medi-foam-distribution-table" id="medi-foam-distribution-search-table">
    <thead>
    <?php if ($searchModel): ?>
        <?php $excludeSearchParams = []; ?>
        <tr class="animated-label">
            <?php $model = $searchModel ?>
            <?php if (!in_array("recipient_sid", $exclude)): ?>
                <?php $excludeSearchParams[] = "recipient_sid"; ?>
                <th class="recipient_sid">
                    <?= $form->field($model, 'recipient_sid')->textInput(['maxlength' => true]) ?>
                </th>
            <?php endif; ?>
            <?php if (!in_array("mk1_issued", $exclude)): ?>
                <?php $excludeSearchParams[] = "mk1_issued"; ?>
                <th class="mk1_issued">
                    <?= $form->field($model, 'mk1_issued')->textInput() ?>
                </th>
            <?php endif; ?>
            <?php if (!in_array("mk1_returned", $exclude)): ?>
                <?php $excludeSearchParams[] = "mk1_returned"; ?>
                <th class="mk1_returned">
                    <?= $form->field($model, 'mk1_returned')->textInput() ?>
                </th>
            <?php endif; ?>
            <?php if (!in_array("issued_by_sid", $exclude)): ?>
                <?php $excludeSearchParams[] = "issued_by_sid"; ?>
                <th class="issued_by_sid">
                    <?= $form->field($model, 'issued_by_sid')->textInput(['maxlength' => true]) ?>
                </th>
            <?php endif; ?>
            <?php if (!in_array("created", $exclude)): ?>
                <?php $excludeSearchParams[] = "created"; ?>
                <th class="created">
                    <?= $form->field($model, 'created')->textInput() ?>
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
            <?php if (!in_array("recipient_sid", $exclude)): ?>
                <th class="recipient_sid"><?= 'Empfänger' ?></th>
            <?php endif; ?>
            <?php if (!in_array("mk1_issued", $exclude)): ?>
                <th class="mk1_issued"><?= 'Mk1 ausgegeben' ?></th>
            <?php endif; ?>
            <?php if (!in_array("mk1_returned", $exclude)): ?>
                <th class="mk1_returned"><?= 'Mk1 zurückgegeben' ?></th>
            <?php endif; ?>
            <?php if (!in_array("issued_by_sid", $exclude)): ?>
                <th class="issued_by_sid"><?= 'Ausgegeben von' ?></th>
            <?php endif; ?>
            <?php if (!in_array("created", $exclude)): ?>
                <th class="created"><?= 'Erstellt' ?></th>
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