<?php
use yii\widgets\ActiveForm;
use yii\helpers\Url;
use app\models\search\RadioMessageSearch;
use kartik\select2\Select2;
use mate\yii\widgets\ValMap;
use mate\yii\assets\TableSearchAsset;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var $searchModel RadioMessageSearch */
/* @var $searchUrl string */
/* @var $exclude array */

$form = null;
$searchModel = !isset($searchModel) ? null : $searchModel;
$searchUrl = !isset($searchUrl) ? Url::to(["radio-message/search"]) : $searchUrl;
$exclude = !isset($exclude) ? array() : $exclude;

if ($searchModel) {
    TableSearchAsset::register($this);
    $form = ActiveForm::begin([
        'id'          => 'radio-message-search-form',
        "action"      => $searchUrl,
        "options"     => [
            'clientValidation' => false,
            "class"            => "animated-label table-search-form",
            "data"             => [
                'target-table' => '#radio-message-search-table'
            ]
        ],
        "fieldConfig" => ["template" => "{input}\n{label}\n{hint}\n{error}"],
    ]);
    ActiveForm::end();
}
?>

<table class="table table-bordered radio-message-table" id="radio-message-search-table">
    <thead>
    <?php if ($searchModel): ?>
        <?php $excludeSearchParams = []; ?>
        <tr class="animated-label">
            <?php $model = $searchModel ?>
            <?php if (!in_array("callsign", $exclude)): ?>
                <?php $excludeSearchParams[] = "callsign"; ?>
                <th class="callsign">
                    <?= $form->field($model, 'callsign')->textInput(['maxlength' => true]) ?>
                </th>
            <?php endif; ?>
            <?php if (!in_array("message", $exclude)): ?>
                <?php $excludeSearchParams[] = "message"; ?>
                <th class="message">
                    <?= $form->field($model, 'message')->textInput(['maxlength' => true]) ?>
                </th>
            <?php endif; ?>
            <?php if (!in_array("age", $exclude)): ?>
                <?php $excludeSearchParams[] = "age"; ?>
                <th class="age">
                    <div style="position: relative;left: 10px;top:-12px">Age</div>
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
            <?php if (!in_array("callsign", $exclude)): ?>
                <th class="callsign"><?= 'Callsign' ?></th>
            <?php endif; ?>
            <?php if (!in_array("message", $exclude)): ?>
                <th class="message"><?= 'Message' ?></th>
            <?php endif; ?>
            <?php if (!in_array("age", $exclude)): ?>
                <th class="age"><?= 'Age' ?></th>
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