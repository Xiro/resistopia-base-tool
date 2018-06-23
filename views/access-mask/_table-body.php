<?php
/* @var $dataProvider \yii\data\ActiveDataProvider */
/* @var $exclude array */

use yii\helpers\Html;
use mate\yii\widgets\Glyphicon;

$pagination = $dataProvider->pagination;
$pagination->totalCount = $dataProvider->totalCount;
$exclude = !isset($exclude) ? array() : $exclude;
?>
<tbody data-page="<?= $pagination->page + 1 ?>"
       data-page-size="<?= $pagination->pageSize ?>"
       data-page-count="<?= $pagination->pageCount ?>">
<?php /** @var $model \app\models\AccessMask */ ?>
<?php foreach ($dataProvider->getModels() as $model): ?>
    <tr data-key="<?= $model->id ?>">
        <?php if (!in_array("name", $exclude)): ?>
            <td class="name">
                <?= $model->name ?>
            </td>
        <?php endif; ?>
        <?php if (!in_array("protected", $exclude)): ?>
            <td class="protected">
                <?= $model->protected ? 'Yes' : 'No' ?>
            </td>
        <?php endif; ?>
        <?php if (!in_array("actions", $exclude)): ?>
            <td class="actions">
                <?php /*if (!in_array("action-view", $exclude)): ?>
                    <?= Html::a(
                        Glyphicon::eye_open(),
                        ['access-mask/view', 'id' => $model->id],
                        ["class" => "ajax-dialog", "data-size" => "lg"]
                    ) ?>
                <?php endif; */?>
                <?php if (!in_array("action-update", $exclude)): ?>
                    <?= Html::a(
                        Glyphicon::pencil(),
                        ['access-mask/update', 'id' => $model->id]
                    ) ?>
                <?php endif; ?>
                <?php if (!$model->protected && !in_array("action-delete", $exclude)): ?>
                    <?= Html::a(
                        Glyphicon::trash(),
                        ['access-mask/confirm-delete', 'id' => $model->id],
                        ["class" => "ajax-dialog", "data-size" => "sm"]
                    ) ?>
                <?php endif; ?>
            </td>
        <?php endif; ?>
    </tr>
<?php endforeach; ?>
</tbody>