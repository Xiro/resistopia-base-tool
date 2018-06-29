<?php
use yii\widgets\ActiveForm;
use yii\helpers\Url;
use app\models\search\AccessRightSearch;
use kartik\select2\Select2;
use mate\yii\widgets\SelectData;
use mate\yii\assets\TableSearchAsset;
use mate\yii\assets\SortableUpdateAsset;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var $searchModel AccessRightSearch */
/* @var $searchUrl string */
/* @var $exclude array */

$form = null;
$searchModel = !isset($searchModel) ? null : $searchModel;
$searchUrl = !isset($searchUrl) ? Url::to(["access-right/search"]) : $searchUrl;
$exclude = !isset($exclude) ? array() : $exclude;
SortableUpdateAsset::register($this);

if ($searchModel) {
    TableSearchAsset::register($this);
    $form = ActiveForm::begin([
        'id'          => 'access-right-search-form',
        "action"      => $searchUrl,
        "options"     => [
            'clientValidation' => false,
            "class"            => "animated-label table-search-form",
            "data"             => [
                'target-table' => '#access-right-search-table'
            ]
        ],
        "fieldConfig" => ["template" => "{input}\n{label}\n{hint}\n{error}"],
    ]);
    ActiveForm::end();
}
?>

<table class="table table-bordered sortable access-right-table" id="access-right-search-table" data-sortable-update="<?=Url::to(['access-right/update-order']) ?>">
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
            <?php if (!in_array("key", $exclude)): ?>
                <?php $excludeSearchParams[] = "key"; ?>
                <th class="key">
                    <?= $form->field($model, 'key')->textInput(['maxlength' => true]) ?>
                </th>
            <?php endif; ?>
            <?php if (!in_array("access_category", $exclude)): ?>
                <?php $excludeSearchParams[] = "access_category"; ?>
                <th class="access_category">
                    <?= $form->field($model, 'access_category_id', [
                        'labelOptions' => ['class' => ($model->access_category_id ? "move" : "")]
                    ])->widget(Select2::class, [
                        'showToggleAll' => false,
                        'data'          => SelectData::fromModel(\app\models\AccessCategory::class),
                        'options'       => [
                            'placeholder' => ''
                        ],
                        'pluginOptions' => [
                            'allowClear' => true
                        ],
                    ])->label('Category') ?>
                </th>
            <?php endif; ?>
            <?php if (!in_array("comment", $exclude)): ?>
                <?php $excludeSearchParams[] = "comment"; ?>
                <th class="comment">
                    <?= $form->field($model, 'comment')->textInput(['maxlength' => true]) ?>
                </th>
            <?php endif; ?>
            <?php if (!in_array("actions", $exclude)): ?>
                <th>
                    <?php $pagination = $dataProvider->pagination; ?>
                    <input type="hidden" name="page" value="<?=  $pagination ? $pagination->page : 0 ?>">
                    <input type="hidden" name="per-page" value="<?=  $pagination ? $pagination->pageSize : 0 ?>">
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
            <?php if (!in_array("key", $exclude)): ?>
                <th class="key"><?= 'Key' ?></th>
            <?php endif; ?>
            <?php if (!in_array("access_category", $exclude)): ?>
                <th class="access_category"><?= 'Category' ?></th>
            <?php endif; ?>
            <?php if (!in_array("comment", $exclude)): ?>
                <th class="comment"><?= 'Comment' ?></th>
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