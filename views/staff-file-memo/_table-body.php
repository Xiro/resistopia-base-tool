<?php
/* @var $dataProvider \yii\data\ActiveDataProvider */

/* @var $exclude array */

use app\helpers\Html;
use mate\yii\widgets\Glyphicon;
use app\components\Access;

$pagination = $dataProvider->pagination;
if ($pagination) {
    $pagination->totalCount = $dataProvider->totalCount;
}
$exclude = !isset($exclude) ? array() : $exclude;
?>
<tbody data-page="<?= $pagination ? $pagination->page + 1 : 0 ?>"
       data-page-size="<?= $pagination ? $pagination->pageSize : 0 ?>"
       data-page-count="<?= $pagination ? $pagination->pageCount : 0 ?>">
<?php /** @var $model \app\models\StaffFileMemo */ ?>
<?php foreach ($dataProvider->getModels() as $model): ?>
    <?php
    if ($model->access_right_id && !Access::to($model->accessRight->key)) {
        continue;
    }
    ?>
    <tr data-key="<?= $model->id ?>">
        <?php if (!in_array("title", $exclude)): ?>
            <td class="title">
                <?= $model->title ?>
            </td>
        <?php endif; ?>
        <?php if (!in_array("staff_name", $exclude)): ?>
            <td class="staff_name">
                <?= $model->staff ? $model->staff->name : "None" ?>
            </td>
        <?php endif; ?>
        <?php if (!in_array("author_name", $exclude)): ?>
            <td class="author_name">
                <?= $model->author ? $model->author->name : "None" ?>
            </td>
        <?php endif; ?>
        <?php if (!in_array("access_right", $exclude)): ?>
            <td class="access_right">
                <?= $model->access_right_id ? $model->accessRight->name : "None" ?>
            </td>
        <?php endif; ?>
        <?php if (!in_array("created", $exclude)): ?>
            <td class="created">
                <?= date('d.m.Y H:i:s', strtotime($model->created)) ?>
            </td>
        <?php endif; ?>
        <?php if (!in_array("updated", $exclude)): ?>
            <td class="updated">
                <?= date('d.m.Y H:i:s', strtotime($model->updated)) ?>
            </td>
        <?php endif; ?>
        <?php if (!in_array("actions", $exclude)): ?>
            <td class="actions">
                <?php if (!in_array("action-view", $exclude)): ?>
                    <?= Html::a(
                        Glyphicon::eye_open(),
                        ['staff-file-memo/view', 'id' => $model->id],
                        ["class" => "ajax-dialog", "data-size" => "lg"]
                    ) ?>
                <?php endif; ?>
                <?php if (!in_array("action-update", $exclude)): ?>
                    <?= Html::a(
                        Glyphicon::pencil(),
                        ['staff-file-memo/update', 'id' => $model->id]
                    ) ?>
                <?php endif; ?>
                <?php if (!in_array("action-delete", $exclude)): ?>
                    <?= Html::a(
                        Glyphicon::trash(),
                        ['staff-file-memo/confirm-delete', 'id' => $model->id],
                        ["class" => "ajax-dialog", "data-size" => "sm"]
                    ) ?>
                <?php endif; ?>
            </td>
        <?php endif; ?>
    </tr>
<?php endforeach; ?>
</tbody>