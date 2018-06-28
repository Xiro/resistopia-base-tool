<?php
use yii\widgets\ActiveForm;
use yii\helpers\Url;
use app\models\search\StaffFileMemoSearch;
use kartik\select2\Select2;
use mate\yii\widgets\SelectData;
use mate\yii\assets\TableSearchAsset;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var $searchModel StaffFileMemoSearch */
/* @var $searchUrl string */
/* @var $exclude array */

$form = null;
$searchModel = !isset($searchModel) ? null : $searchModel;
$searchUrl = !isset($searchUrl) ? Url::to(["staff-file-memo/search"]) : $searchUrl;
$exclude = !isset($exclude) ? array() : $exclude;

if ($searchModel) {
    TableSearchAsset::register($this);
    $form = ActiveForm::begin([
        'id'          => 'staff-file-memo-search-form',
        "action"      => $searchUrl,
        "options"     => [
            'clientValidation' => false,
            "class"            => "animated-label table-search-form",
            "data"             => [
                'target-table' => '#staff-file-memo-search-table'
            ]
        ],
        "fieldConfig" => ["template" => "{input}\n{label}\n{hint}\n{error}"],
    ]);
    ActiveForm::end();
}
?>

<table class="table table-bordered staff-file-memo-table" id="staff-file-memo-search-table">
    <thead>
    <?php if ($searchModel): ?>
        <?php $excludeSearchParams = []; ?>
        <tr class="animated-label">
            <?php $model = $searchModel ?>
            <?php if (!in_array("title", $exclude)): ?>
                <?php $excludeSearchParams[] = "title"; ?>
                <th class="title">
                    <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>
                </th>
            <?php endif; ?>
            <?php if (!in_array("staff_name", $exclude)): ?>
                <?php $excludeSearchParams[] = "staff_name"; ?>
                <th class="staff">
                    <?= $form->field($model, 'staff_name')->textInput(['maxlength' => true])->label('Staff') ?>
                </th>
            <?php endif; ?>
            <?php if (!in_array("author_name", $exclude)): ?>
                <?php $excludeSearchParams[] = "author_name"; ?>
                <th class="author_name">
                    <?= $form->field($model, 'author_name')->textInput(['maxlength' => true])->label('Author') ?>
                </th>
            <?php endif; ?>
            <?php if (!in_array("access_bit", $exclude)): ?>
                <?php $excludeSearchParams[] = "access_bit"; ?>
                <th class="author_name">
                    <?= $form->field($model, 'access_bit_id')->textInput(['maxlength' => true])->label('Security Level') ?>
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
            <?php if (!in_array("title", $exclude)): ?>
                <th class="title"><?= 'Title' ?></th>
            <?php endif; ?>
            <?php if (!in_array("staff_name", $exclude)): ?>
                <th class="staff_name"><?= 'Staff' ?></th>
            <?php endif; ?>
            <?php if (!in_array("author_name", $exclude)): ?>
                <th class="author_name"><?= 'Author' ?></th>
            <?php endif; ?>
            <?php if (!in_array("access_bit", $exclude)): ?>
                <th class="access_bit"><?= 'Security Level' ?></th>
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