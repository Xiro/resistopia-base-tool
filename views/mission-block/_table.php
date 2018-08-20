<?php
use yii\widgets\ActiveForm;
use yii\helpers\Url;
use app\models\search\MissionBlockSearch;
use kartik\select2\Select2;
use mate\yii\widgets\ValMap;
use mate\yii\assets\TableSearchAsset;
use mate\yii\widgets\SelectData;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var $searchModel MissionBlockSearch */
/* @var $searchUrl string */
/* @var $exclude array */

$form = null;
$searchModel = !isset($searchModel) ? null : $searchModel;
$searchUrl = !isset($searchUrl) ? Url::to(["mission-block/search"]) : $searchUrl;
$exclude = !isset($exclude) ? array() : $exclude;

if ($searchModel) {
    TableSearchAsset::register($this);
    $form = ActiveForm::begin([
        'id'          => 'mission-block-search-form',
        "action"      => $searchUrl,
        "options"     => [
            'clientValidation' => false,
            "class"            => "animated-label table-search-form",
            "data"             => [
                'target-table' => '#mission-block-search-table'
            ]
        ],
        "fieldConfig" => ["template" => "{input}\n{label}\n{hint}\n{error}"],
    ]);
    ActiveForm::end();
}
?>

<table class="table table-bordered mission-block-table" id="mission-block-search-table">
    <thead>
    <?php if ($searchModel): ?>
        <?php $excludeSearchParams = []; ?>
        <tr class="animated-label">
            <?php $model = $searchModel ?>
            <?php if (!in_array("blocked_staff_member", $exclude)): ?>
                <?php $excludeSearchParams[] = "blocked_staff_member"; ?>
                <th class="blockedStaffMemberRpn">
                    <?= $form->field($model, 'blocked_staff_member_rpn', [
                        'labelOptions' => ['class' => ($model->blocked_staff_member_rpn ? 'move' : '')]
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
                    ])->label('Blocked Staff') ?>
                </th>
            <?php endif; ?>
            <?php if (!in_array("unblock_time", $exclude)): ?>
                <?php $excludeSearchParams[] = "unblock_time"; ?>
                <th class="unblock_time">
                    <?= $form->field($model, 'unblock_time')->textInput() ?>
                </th>
            <?php endif; ?>
            <?php if (!in_array("blocked_by", $exclude)): ?>
                <?php $excludeSearchParams[] = "blocked_by"; ?>
                <th class="blocked_by">
                    <?= $form->field($model, 'blocked_by_rpn', [
                        'labelOptions' => ['class' => ($model->blocked_by_rpn ? 'move' : '')]
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
                    ])->label('Blocked By') ?>
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
            <?php if (!in_array("blocked_staff_member", $exclude)): ?>
                <th class="blocked_staff_member"><?= 'Blocked Staff Member' ?></th>
            <?php endif; ?>
            <?php if (!in_array("unblock_time", $exclude)): ?>
                <th class="unblock_time"><?= 'Unblock Time' ?></th>
            <?php endif; ?>
            <?php if (!in_array("blocked_by", $exclude)): ?>
                <th class="blocked_by"><?= 'Blocked By' ?></th>
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