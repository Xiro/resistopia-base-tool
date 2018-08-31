<?php
use yii\widgets\ActiveForm;
use yii\helpers\Url;
use app\models\search\ChangelogSearch;
use kartik\select2\Select2;
use mate\yii\widgets\ValMap;
use mate\yii\widgets\SelectData;
use mate\yii\assets\TableSearchAsset;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var $searchModel ChangelogSearch */
/* @var $searchUrl string */
/* @var $exclude array */

$form = null;
$searchModel = !isset($searchModel) ? null : $searchModel;
$searchUrl = !isset($searchUrl) ? Url::to(["changelog/search"]) : $searchUrl;
$exclude = !isset($exclude) ? array() : $exclude;

if ($searchModel) {
    TableSearchAsset::register($this);
    $form = ActiveForm::begin([
        'id'          => 'changelog-search-form',
        "action"      => $searchUrl,
        "options"     => [
            'clientValidation' => false,
            "class"            => "animated-label table-search-form",
            "data"             => [
                'target-table' => '#changelog-search-table'
            ]
        ],
        "fieldConfig" => ["template" => "{input}\n{label}\n{hint}\n{error}"],
    ]);
    ActiveForm::end();
}
?>

<table class="table table-bordered changelog-table" id="changelog-search-table">
    <thead>
    <?php if ($searchModel): ?>
        <?php $excludeSearchParams = []; ?>
        <tr class="animated-label">
            <?php $model = $searchModel ?>
            <?php if (!in_array("object", $exclude)): ?>
                <?php $excludeSearchParams[] = "object"; ?>
                <th class="object">
                    <?= $form->field($model, 'object')->textInput(['maxlength' => true]) ?>
                </th>
            <?php endif; ?>
            <?php if (!in_array("data", $exclude)): ?>
                <?php $excludeSearchParams[] = "data"; ?>
                <th class="type">
                    <?= $form->field($model, 'data')->textInput(['maxlength' => true]) ?>
                </th>
            <?php endif; ?>
            <?php if (!in_array("user", $exclude)): ?>
                <?php $excludeSearchParams[] = "user"; ?>
                <th class="user">
                    <?= $form->field($model, 'user_id', [
                        'labelOptions' => ['class' => ($model->user_id ? 'move' : '')]
                    ])->widget(Select2::class, [
                        'showToggleAll' => false,
                        'data'          => SelectData::fromModel(
                            app\models\User::class,
                            'id',
                            'identity',
                            true
                        ),
                        'options'       => [
                            'placeholder' => '',
                        ],
                        'pluginOptions' => [
                            'allowClear' => true,
                        ],
                    ])->label('User') ?>
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
            <?php if (!in_array("object", $exclude)): ?>
                <th class="object"><?= 'Object' ?></th>
            <?php endif; ?>
            <?php if (!in_array("data", $exclude)): ?>
                <th class="data"><?= 'Changes' ?></th>
            <?php endif; ?>
            <?php if (!in_array("user", $exclude)): ?>
                <th class="user"><?= 'User' ?></th>
            <?php endif; ?>
            <?php if (!in_array("created", $exclude)): ?>
                <th class="created"><?= 'Time' ?></th>
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