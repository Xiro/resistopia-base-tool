<?php
use yii\widgets\ActiveForm;
use yii\helpers\Url;
use app\models\search\StaffFileMemoSearch;
use kartik\select2\Select2;
use mate\yii\widgets\SelectData;
use mate\yii\assets\TableSearchAsset;
use yii\helpers\ArrayHelper;

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
            <?php if (!in_array("file_memo_number", $exclude)): ?>
                <?php $excludeSearchParams[] = "file_memo_number"; ?>
                <th class="file_memo_number">
                    <?= $form->field($model, 'file_memo_number')->textInput(['maxlength' => true]) ?>
                </th>
            <?php endif; ?>
            <?php if (!in_array("title", $exclude)): ?>
                <?php $excludeSearchParams[] = "title"; ?>
                <th class="title">
                    <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>
                </th>
            <?php endif; ?>
            <?php if (!in_array("staff_name", $exclude)): ?>
                <?php $excludeSearchParams[] = "staff_name"; ?>
                <th class="staff_name">
                    <?= $form->field($model, 'rpn', [
                        'labelOptions' => ['class' => ($model->rpn ? 'move' : '')]
                    ])->widget(Select2::class, [
                        'showToggleAll' => false,
                        'data'          => SelectData::fromModel(
                            app\models\Staff::class,
                            'rpn',
                            'nameWithRpn',
                            true
                        ),
                        'options'       => [
                            'placeholder' => '',
                        ],
                        'pluginOptions' => [
                            'allowClear' => true,
                        ],
                    ])->label('Staff') ?>
                </th>
            <?php endif; ?>
            <?php if (!in_array("author_name", $exclude)): ?>
                <?php $excludeSearchParams[] = "author_name"; ?>
                <th class="author_name">
                    <?= $form->field($model, 'author_rpn', [
                        'labelOptions' => ['class' => ($model->author_rpn ? 'move' : '')]
                    ])->widget(Select2::class, [
                        'showToggleAll' => false,
                        'data'          => SelectData::fromModel(
                            app\models\Staff::class,
                            'rpn',
                            'nameWithRpn',
                            true
                        ),
                        'options'       => [
                            'placeholder' => '',
                        ],
                        'pluginOptions' => [
                            'allowClear' => true,
                        ],
                    ])->label('Author') ?>
                </th>
            <?php endif; ?>
            <?php if (!in_array("access_right", $exclude)): ?>
                <?php $excludeSearchParams[] = "access_right"; ?>
                <th class="access_right">
                    <?= $form->field($model, 'access_right_id', [
                        'labelOptions' => ['class' => ($model->access_right_id ? 'move' : '')]
                    ])->widget(Select2::class, [
                        'showToggleAll' => false,
                        'data'          => ArrayHelper::map(
                            app\models\AccessRight::find()->where(['like', 'key', 'security-level/%', false])->all(),
                            'id',
                            'name'
                        ),
                        'options'       => [
                            'placeholder' => '',
                        ],
                        'pluginOptions' => [
                            'allowClear' => true,
                        ],
                    ])->label('Security Level') ?>
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
            <?php if (!in_array("file_memo_number", $exclude)): ?>
                <th class="file_memo_number"><?= 'File Memo Nr' ?></th>
            <?php endif; ?>
            <?php if (!in_array("title", $exclude)): ?>
                <th class="title"><?= 'Title' ?></th>
            <?php endif; ?>
            <?php if (!in_array("staff_name", $exclude)): ?>
                <th class="staff_name"><?= 'Staff' ?></th>
            <?php endif; ?>
            <?php if (!in_array("author_name", $exclude)): ?>
                <th class="author_name"><?= 'Author' ?></th>
            <?php endif; ?>
            <?php if (!in_array("access_right", $exclude)): ?>
                <th class="access_right"><?= 'Security Level' ?></th>
            <?php endif; ?>
            <?php if (!in_array("created", $exclude)): ?>
                <th class="created"><?= 'Created' ?></th>
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